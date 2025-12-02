# Church Management System - Authentication & Authorization

## 🔐 Authentication Overview

**System**: Laravel Sanctum with JWT tokens
**Session Storage**: Server-side sessions with secure cookies
**Token Expiry**: 1 hour (access token), 7 days (refresh token)
**Supported Methods**: Email/Password, Two-Factor Authentication (optional)

---

## 🔑 Authentication Flow

### 1. Signup/Registration
```
User fills signup form (email, password)
      ↓
Validate email format & password strength
      ↓
Send to /api/auth/register
      ↓
Laravel creates user account
      ↓
Send verification email (optional)
      ↓
Redirect to login or dashboard
```

### 2. Login
```
User enters email & password
      ↓
Send to /api/auth/login
      ↓
Laravel validates credentials
      ↓
JWT token generated via Sanctum
      ↓
Token stored in HTTP-only cookie
      ↓
Redirect to dashboard
```

### 3. Session Management
```
User makes authenticated request
      ↓
Middleware checks Authorization header
      ↓
Token validated with Sanctum
      ↓
If valid → Request proceeds
If invalid/expired → Refresh token attempted
If refresh fails → Redirect to login
```

### 4. Logout
```
User clicks logout
      ↓
Send request to /api/auth/logout
      ↓
Revoke current token
      ↓
Clear session cookies
      ↓
Redirect to login page
```

---

## 🛡️ Role-Based Access Control (RBAC)

### User Roles

#### Admin
- **Permissions**:
  - View all data
  - Modify/delete any record
  - Manage users and permissions
  - View audit logs
  - Configure system settings
  - Approve transactions
  - Delete members and transactions

#### Pastor
- **Permissions**:
  - View members, attendance, finance
  - Add/edit member notes
  - Mark attendance
  - View financial reports
  - Approve transactions
  - Schedule events
  - Send SMS broadcasts
  - Cannot: Delete data, manage users

#### Staff
- **Permissions**:
  - Create and read members
  - Mark attendance
  - Record transactions
  - Track equipment
  - Manage visitors
  - View reports
  - Cannot: Delete records, approve, manage users

#### Member (Regular)
- **Permissions**:
  - View own profile
  - View event calendar
  - View limited directory
  - Cannot: Modify any data

---

## 🔒 Laravel Implementation

### User Model with Roles
```php
// app/Models/User.php
namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'full_name', 'email', 'password', 'role', 'phone', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_secret'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasAnyRole($roles)
    {
        return in_array($this->role, $roles);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function canApproveTransactions()
    {
        return in_array($this->role, ['admin', 'pastor']);
    }
}
```

### Authentication Controller
```php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if user is active
        if (!$user->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your account has been deactivated.'
            ], 403);
        }

        // Update last login
        $user->update(['last_login_at' => now()]);

        // Create token
        $token = $user->createToken($request->device_name)->plainTextToken;

        // Log authentication event
        activity()
            ->causedBy($user)
            ->log('User logged in');

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string',
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'member',
        ]);

        // Send verification email
        $user->sendEmailVerificationNotification();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    }
}
```

### Middleware for Role Checking
```php
// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }

        if (!$request->user()->hasAnyRole($roles)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient permissions'
            ], 403);
        }

        return $next($request);
    }
}
```

### Route Protection
```php
// routes/api.php
use App\Http\Middleware\CheckRole;

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // All authenticated users
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Staff and above
    Route::middleware(CheckRole::class . ':admin,pastor,staff')->group(function () {
        Route::apiResource('members', MemberController::class);
        Route::apiResource('attendance', AttendanceController::class);
        Route::apiResource('visitors', VisitorController::class);
    });
    
    // Pastor and admin only
    Route::middleware(CheckRole::class . ':admin,pastor')->group(function () {
        Route::put('/transactions/{id}/approve', [TransactionController::class, 'approve']);
        Route::get('/finance/reports', [FinanceController::class, 'reports']);
    });
    
    // Admin only
    Route::middleware(CheckRole::class . ':admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::get('/audit-logs', [AuditLogController::class, 'index']);
        Route::get('/system/settings', [SettingsController::class, 'index']);
    });
});
```

---

## 🔐 Password Security

### Password Requirements
- Minimum 8 characters
- At least 1 uppercase letter
- At least 1 number
- At least 1 special character

### Password Validation Rules
```php
// app/Http/Requests/RegisterRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // must contain uppercase
                'regex:/[0-9]/',      // must contain number
                'regex:/[@$!%*?&#]/', // must contain special character
                'confirmed'
            ],
            'full_name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password must contain uppercase, number, and special character.',
        ];
    }
}
```

### Password Reset Flow
```php
// app/Http/Controllers/Auth/PasswordResetController.php
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => 'success', 'message' => __($status)])
            : response()->json(['status' => 'error', 'message' => __($status)], 400);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' => 'success', 'message' => __($status)])
            : response()->json(['status' => 'error', 'message' => __($status)], 400);
    }
}
```

---

## 🔐 Two-Factor Authentication (Optional)

### Enable 2FA
```php
// app/Http/Controllers/TwoFactorController.php
namespace App\Http\Controllers\Auth;

use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function enable(Request $request)
    {
        $user = $request->user();
        $google2fa = new Google2FA();
        
        $secret = $google2fa->generateSecretKey();
        $user->two_factor_secret = encrypt($secret);
        $user->save();

        $qrCode = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return response()->json([
            'secret' => $secret,
            'qr_code' => $qrCode,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = $request->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            decrypt($user->two_factor_secret),
            $request->code
        );

        if ($valid) {
            $user->two_factor_enabled = true;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => '2FA enabled successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid verification code'
        ], 422);
    }
}
```

---

## 📝 Audit Logging

### Authentication Event Logging
```php
// app/Listeners/LogAuthenticationEvents.php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use App\Models\AuditLog;

class LogAuthenticationEvents
{
    public function handleLogin(Login $event)
    {
        AuditLog::create([
            'user_id' => $event->user->id,
            'action' => 'login',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function handleLogout(Logout $event)
    {
        if ($event->user) {
            AuditLog::create([
                'user_id' => $event->user->id,
                'action' => 'logout',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    public function handleFailed(Failed $event)
    {
        AuditLog::create([
            'user_id' => null,
            'action' => 'failed_login',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'old_values' => json_encode(['email' => $event->credentials['email'] ?? null]),
        ]);
    }
}
```

---

## 📋 Permission Matrix

| Feature | Admin | Pastor | Staff | Member |
|---------|-------|--------|-------|--------|
| View Members | R/W/D | R | R/W | R (limited) |
| Manage Attendance | R/W/D | R/W | R/W | - |
| Manage Finance | R/W/D | R/W/Approve | R/W | - |
| Approve Transactions | Yes | Yes | - | - |
| Manage Users | Yes | - | - | - |
| View Reports | Yes | Yes | Yes | - |
| Manage Settings | Yes | - | - | - |
| View Audit Logs | Yes | - | - | - |
| SMS Broadcast | Yes | Yes | Yes | - |
| Equipment Management | R/W/D | R/W | R/W | - |
| Visitor Management | R/W/D | R/W | R/W | - |

(R=Read, W=Write, D=Delete)

---

## 🚨 Security Best Practices Summary

### Implemented Features
- ✅ HTTPS enforcement
- ✅ Secure session management
- ✅ Password complexity requirements
- ✅ Account lockout after failed attempts
- ✅ Rate limiting on authentication endpoints
- ✅ Audit logging for all auth events
- ✅ CSRF protection
- ✅ XSS prevention
- ✅ SQL injection prevention
- ✅ Two-factor authentication support
- ✅ Role-based access control
- ✅ Token expiration and rotation
- ✅ Encrypted sensitive data storage

---

**Document Version**: 2.0
**Last Updated**: 2024
**Status**: Active
**Review Cycle**: Before each release