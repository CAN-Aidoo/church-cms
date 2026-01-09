<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // If coming from mobile route or URL path contains 'mobile', redirect to mobile login
        $intendedUrl = url()->previous();
        if (str_contains($intendedUrl, '/mobile/') || $request->is('mobile/*')) {
            return redirect('/mobile/login');
        }

        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $lockoutKey = "login_attempts:{$email}";

        // Check for account lockout (5 failed attempts = 15 minute lockout)
        $failedAttempts = Cache::get($lockoutKey, 0);
        if ($failedAttempts >= 5) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again in 15 minutes.'],
            ]);
        }

        $user = User::where('email', $email)->first();

        // Check if user exists and password is correct
        if (! $user || ! Hash::check($request->password, $user->password)) {
            // Increment failed attempts
            Cache::put($lockoutKey, $failedAttempts + 1, now()->addMinutes(15));

            // Log failed login attempt (hash email for privacy)
            $hashedEmail = substr($email, 0, 3).'***@'.substr(strrchr($email, '@'), 1);
            AuditLog::create([
                'user_id' => null,
                'action' => 'failed_login',
                'table_name' => 'users',
                'old_values' => ['email' => $hashedEmail],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if user is active
        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated. Please contact the administrator.'],
            ]);
        }

        // Clear failed attempts on successful login
        Cache::forget($lockoutKey);

        // Login user
        Auth::login($user, $request->boolean('remember'));

        // Update last login
        $user->updateLastLogin();

        // Log successful login
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'table_name' => 'users',
            'record_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Welcome back, '.$user->full_name.'!');
    }

    /**
     * Handle API/Mobile login request.
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $lockoutKey = "login_attempts:{$email}";

        // Check for account lockout
        $failedAttempts = Cache::get($lockoutKey, 0);
        if ($failedAttempts >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Too many login attempts. Please try again in 15 minutes.',
            ], 429);
        }

        $user = User::where('email', $email)->first();

        // Check credentials
        if (! $user || ! Hash::check($request->password, $user->password)) {
            Cache::put($lockoutKey, $failedAttempts + 1, now()->addMinutes(15));

            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        // Check if user is active
        if (! $user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated. Please contact the administrator.',
            ], 403);
        }

        // Clear failed attempts
        Cache::forget($lockoutKey);

        // Create API token
        $token = $user->createToken('mobile-app')->plainTextToken;

        // Update last login
        $user->updateLastLogin();

        // Log successful login
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'api_login',
            'table_name' => 'users',
            'record_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar_url' => $user->avatar_url,
                ],
            ],
        ]);
    }

    /**
     * Handle mobile web login request (session-based).
     */
    public function mobileLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $lockoutKey = "login_attempts:{$email}";

        // Check for account lockout
        $failedAttempts = Cache::get($lockoutKey, 0);
        if ($failedAttempts >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Too many login attempts. Please try again in 15 minutes.',
            ], 429);
        }

        $user = User::where('email', $email)->first();

        // Check credentials
        if (! $user || ! Hash::check($request->password, $user->password)) {
            Cache::put($lockoutKey, $failedAttempts + 1, now()->addMinutes(15));

            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        // Check if user is active
        if (! $user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated. Please contact the administrator.',
            ], 403);
        }

        // Clear failed attempts
        Cache::forget($lockoutKey);

        // Login user with session
        Auth::login($user, $request->boolean('remember', false));

        // Update last login
        $user->updateLastLogin();

        // Log successful login
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'mobile_web_login',
            'table_name' => 'users',
            'record_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Regenerate session
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar_url' => $user->avatar_url,
                ],
            ],
        ]);
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',      // must contain uppercase
                'regex:/[0-9]/',      // must contain number
                'regex:/[@$!%*?&#]/', // must contain special character
            ],
            'phone' => 'nullable|string|max:20',
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'member', // Default role
        ]);

        // Log registration
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'register',
            'table_name' => 'users',
            'record_id' => $user->id,
            'new_values' => ['email' => $user->email, 'role' => $user->role],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Auto login after registration
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registration successful! Welcome to '.config('app.name'));
    }

    /**
     * Handle logout request (works for both web and API/mobile).
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log logout
        if ($user) {
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'logout',
                'table_name' => 'users',
                'record_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return JSON for API/mobile requests, redirect for web
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ]);
        }

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Use Laravel's built-in password reset
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Always return success message to prevent user enumeration
        return back()->with('success', 'If an account exists with that email, a password reset link has been sent.');

        // Log password reset request
        AuditLog::create([
            'user_id' => null,
            'action' => 'password_reset_requested',
            'table_name' => 'users',
            'old_values' => ['email' => substr($request->email, 0, 3).'***'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Show password reset form.
     */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Clear failed login attempts
                Cache::forget("login_attempts:{$user->email}");

                // Log password reset
                AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'password_reset',
                    'table_name' => 'users',
                    'record_id' => $user->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Your password has been reset successfully. You can now login.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
