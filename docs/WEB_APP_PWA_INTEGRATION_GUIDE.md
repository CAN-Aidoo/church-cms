# Web App & PWA Integration Guide

## Overview

This guide explains how the web application (desktop admin interface) connects with the Mobile PWA APIs and shares data seamlessly.

---

## Architecture Overview

```
┌────────────────────────────────────────────────────────────┐
│                     Laravel Backend                         │
│                                                             │
│  ┌──────────────────┐         ┌──────────────────┐        │
│  │   Web Routes     │         │   API Routes     │        │
│  │  (Desktop UI)    │         │  (Mobile PWA)    │        │
│  │                  │         │                  │        │
│  │  /members        │         │  /api/mobile/v1/ │        │
│  │  /attendance     │         │    /dashboard    │        │
│  │  /finance        │         │    /profile      │        │
│  │  ...             │         │    /check-in     │        │
│  └────────┬─────────┘         └────────┬─────────┘        │
│           │                            │                   │
│           └──────────┬─────────────────┘                   │
│                      │                                     │
│           ┌──────────▼─────────┐                          │
│           │    Controllers     │                          │
│           │  - Member          │                          │
│           │  - Attendance      │                          │
│           │  - Mobile*         │                          │
│           └──────────┬─────────┘                          │
│                      │                                     │
│           ┌──────────▼─────────┐                          │
│           │    Repositories    │                          │
│           │  (Shared Logic)    │                          │
│           └──────────┬─────────┘                          │
│                      │                                     │
│           ┌──────────▼─────────┐                          │
│           │       Models       │                          │
│           │    (Database)      │                          │
│           └────────────────────┘                          │
└────────────────────────────────────────────────────────────┘
```

---

## Shared Data Layer

### 1. Common Database

Both web app and PWA use the **same database** through Laravel's Eloquent ORM:

**Models** (app/Models/):
```
├── User.php          # Shared by both
├── Member.php        # Shared by both
├── Attendance.php    # Shared by both
├── Transaction.php   # Shared by both
├── Visitor.php       # Shared by both
└── ...               # All models shared
```

**Example - Member Model Used by Both**:
```php
// Web route: Display member list
Route::get('/members', function() {
    $members = Member::with('user')->get();
    return view('members.index', compact('members'));
});

// API route: Return member list
Route::get('/api/mobile/v1/members', function() {
    $members = Member::with('user')->get();
    return response()->json($members);
});

// Same data source, different presentation
```

---

### 2. Shared Repositories

**Repository Pattern** ensures both web and mobile use the same data access logic:

**Example - AttendanceRepository.php**:
```php
class AttendanceRepository
{
    // Used by web dashboard
    public function getTodayAttendance()
    {
        return Attendance::whereDate('service_date', today())
            ->with('member')
            ->get();
    }

    // Used by mobile check-in
    public function recordCheckIn($memberId, $serviceType)
    {
        return Attendance::create([
            'member_id' => $memberId,
            'service_date' => today(),
            'service_type' => $serviceType,
            'checked_in_at' => now()
        ]);
    }

    // Used by both web reports and mobile history
    public function getAttendanceStats($memberId, $startDate, $endDate)
    {
        return Attendance::where('member_id', $memberId)
            ->whereBetween('service_date', [$startDate, $endDate])
            ->count();
    }
}
```

**Usage**:
```php
// Web Controller
class AttendanceController extends Controller
{
    public function __construct(private AttendanceRepository $repo) {}

    public function index()
    {
        $attendance = $this->repo->getTodayAttendance();
        return view('attendance.index', compact('attendance'));
    }
}

// Mobile API Controller
class MobileCheckInController extends Controller
{
    public function __construct(private AttendanceRepository $repo) {}

    public function checkIn(Request $request)
    {
        $attendance = $this->repo->recordCheckIn(
            $request->member_id,
            $request->service_type
        );
        return response()->json($attendance);
    }
}
```

---

## Real-Time Data Synchronization

### Scenario 1: Admin Adds Member (Web) → Visible in Mobile

**Flow**:
```
1. Admin adds member via web interface
   └─> POST /members
       └─> MemberController@store
           └─> Member::create(...)
               └─> Saves to database

2. Member logs into mobile app
   └─> GET /api/mobile/v1/profile
       └─> Returns newly created member data
           └─> Reads from same database

3. Result: Instant sync (no delay)
```

**Code Example**:
```php
// Web: Admin creates member
public function store(Request $request)
{
    $member = Member::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        // ...
    ]);

    // Also create user account
    $user = User::create([
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'member'
    ]);

    $member->update(['user_id' => $user->id]);

    return redirect()->route('members.index');
}

// Mobile: Member logs in immediately
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'member' => $user->member // Same data!
        ]);
    }
}
```

---

### Scenario 2: Member Checks In (Mobile) → Updates Web Dashboard

**Flow**:
```
1. Member scans QR code on mobile
   └─> POST /api/mobile/v1/attendance/check-in
       └─> MobileCheckInController@checkIn
           └─> Attendance::create(...)
               └─> Saves to database

2. Admin viewing live attendance dashboard (web)
   └─> GET /attendance/live (auto-refresh every 10s)
       └─> AttendanceController@live
           └─> Queries latest attendance
               └─> Includes new check-in

3. Result: Appears in web dashboard within 10 seconds
```

**Code Example**:
```php
// Mobile: Check-in
public function checkIn(Request $request)
{
    $attendance = Attendance::create([
        'member_id' => auth()->id(),
        'service_date' => today(),
        'service_type' => $request->service_type,
        'check_in_method' => 'qr_code',
        'checked_in_at' => now()
    ]);

    return response()->json([
        'success' => true,
        'attendance' => $attendance
    ]);
}

// Web: Live dashboard (auto-refreshes)
public function live()
{
    $todayAttendance = Attendance::with('member')
        ->whereDate('service_date', today())
        ->orderBy('checked_in_at', 'desc')
        ->get();

    return view('attendance.live', compact('todayAttendance'));
}
```

**Web View** (resources/views/attendance/live.blade.php):
```blade
<div x-data="liveAttendance()" x-init="startPolling()">
    <div class="attendance-list">
        <template x-for="record in attendanceRecords">
            <div class="attendance-item">
                <span x-text="record.member.name"></span>
                <span x-text="record.checked_in_at"></span>
            </div>
        </template>
    </div>
</div>

<script>
function liveAttendance() {
    return {
        attendanceRecords: [],
        startPolling() {
            this.fetchAttendance();
            setInterval(() => this.fetchAttendance(), 10000); // Every 10s
        },
        async fetchAttendance() {
            const response = await fetch('/api/attendance/today');
            this.attendanceRecords = await response.json();
        }
    }
}
</script>
```

---

### Scenario 3: Member Updates Profile (Mobile) → Visible in Web

**Flow**:
```
1. Member updates phone number on mobile
   └─> PUT /api/mobile/v1/profile
       └─> Validates and updates Member record
           └─> Member::find(id)->update(['phone' => ...])

2. Admin views member list on web
   └─> GET /members
       └─> Displays updated phone number

3. Result: Instant sync
```

---

## API Endpoints Used by Both

### Shared API Endpoints

Many API endpoints are used by **BOTH** web (via JavaScript) and mobile:

**Example - Dashboard Statistics**:
```php
// API Route (routes/api.php)
Route::get('/api/dashboard/stats', [DashboardController::class, 'stats'])
    ->middleware('auth:sanctum');

// Controller
public function stats()
{
    return response()->json([
        'total_members' => Member::where('status', 'active')->count(),
        'today_attendance' => Attendance::whereDate('service_date', today())->count(),
        'monthly_giving' => Transaction::whereMonth('date', now())->sum('amount'),
        'active_programs' => Program::where('status', 'ongoing')->count()
    ]);
}

// Used by Web Dashboard (JavaScript)
fetch('/api/dashboard/stats')
    .then(r => r.json())
    .then(data => {
        document.getElementById('total-members').textContent = data.total_members;
        // ...
    });

// Used by Mobile PWA (JavaScript)
ChurchApp.apiCall('/api/dashboard/stats', 'GET')
    .then(data => {
        // Update mobile dashboard
    });
```

---

## Authentication Sharing

### Web Session vs API Token

**Web Application**:
- Uses Laravel's session-based authentication
- Login: POST /login → Creates session
- Protected routes use `auth` middleware

**Mobile PWA**:
- Uses Laravel Sanctum token authentication
- Login: POST /api/mobile/v1/login → Returns JWT token
- Protected routes use `auth:sanctum` middleware

**Same User Table**:
```php
// users table shared by both
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', ['admin', 'pastor', 'staff', 'member']);
    $table->timestamps();
});

// Web login creates session
Auth::attempt($credentials); // Session stored in browser

// Mobile login creates token
$token = $user->createToken('mobile')->plainTextToken; // Token returned to app
```

---

## Data Consistency Patterns

### 1. Single Source of Truth

**Database is the single source of truth** - no separate data stores.

```
✅ CORRECT:
Web writes → Database ← Mobile reads
Mobile writes → Database ← Web reads

❌ WRONG:
Web → Web DB
Mobile → Mobile DB (sync nightmare)
```

---

### 2. Optimistic Updates

**Mobile PWA** uses optimistic updates for better UX:

```javascript
// Mobile: Optimistic check-in
async function checkIn() {
    // 1. Update UI immediately (optimistic)
    showCheckInSuccess();

    // 2. Send to backend
    try {
        await ChurchApp.apiCall('/api/mobile/v1/attendance/check-in', 'POST', data);
        // Success - UI already updated
    } catch (error) {
        // Failed - rollback UI
        showCheckInError();
    }
}
```

---

### 3. Cache Strategy

**Web Dashboard**:
```php
// Cache for 5 minutes
Cache::remember('dashboard_stats', 300, function() {
    return [
        'members' => Member::count(),
        'attendance' => Attendance::whereDate('service_date', today())->count(),
        // ...
    ];
});
```

**Mobile PWA**:
```javascript
// Service worker caches static assets
// API responses cached for offline access
```

---

## Integration Examples

### Example 1: Giving/Donations

**Desktop Flow**:
1. Admin views giving dashboard: GET /finance/giving
2. Sees all contributions (including mobile ones)
3. Approves large transactions
4. Generates reports

**Mobile Flow**:
1. Member gives via mobile: POST /api/mobile/v1/giving
2. Creates Transaction record
3. Immediately visible in web dashboard
4. Pastor approves via web interface

**Shared Transaction Model**:
```php
// Both use same model
class Transaction extends Model
{
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}

// Web: Approve transaction
$transaction = Transaction::find($id);
$transaction->update([
    'status' => 'approved',
    'approved_by' => auth()->id(),
    'approved_at' => now()
]);

// Mobile: Transaction now shows as approved
```

---

### Example 2: Attendance Tracking

**Desktop Flow**:
1. Admin views live attendance: GET /attendance/live
2. Sees real-time check-ins
3. Marks bulk attendance
4. Generates reports

**Mobile Flow**:
1. Member scans QR: POST /api/mobile/v1/attendance/check-in
2. GPS location captured
3. Instantly appears in web live view
4. Both stored in same `attendance` table

**API Endpoint**:
```php
// routes/api.php - Used by mobile
Route::post('/api/mobile/v1/attendance/check-in', [MobileCheckInController::class, 'checkIn']);

// routes/api.php - Used by web (JavaScript)
Route::get('/api/attendance/today', [AttendanceController::class, 'today']);

// Both query same table
class AttendanceRepository
{
    public function getTodayAttendance()
    {
        return Attendance::with('member')
            ->whereDate('service_date', today())
            ->orderBy('checked_in_at', 'desc')
            ->get();
    }
}
```

---

### Example 3: Events/Programs

**Desktop Flow**:
1. Admin creates event: POST /programs
2. Sets capacity, dates, etc.
3. Views registrations
4. Marks attendance

**Mobile Flow**:
1. Member browses events: GET /api/mobile/v1/events
2. Registers: POST /api/mobile/v1/events/{id}/register
3. Checks in via QR code
4. All updates visible in web dashboard

**Shared Repository**:
```php
class ProgramRepository
{
    // Used by both web and mobile
    public function getUpcomingEvents()
    {
        return Program::where('status', 'published')
            ->where('start_date', '>=', today())
            ->orderBy('start_date')
            ->get();
    }

    public function registerMember($programId, $memberId)
    {
        return ProgramRegistration::create([
            'program_id' => $programId,
            'member_id' => $memberId,
            'registered_at' => now(),
            'status' => 'registered'
        ]);
    }
}
```

---

## API Versioning

### Current Structure

```
/api/v1/             # Web API endpoints (admin operations)
/api/mobile/v1/      # Mobile PWA endpoints (public + member)
```

### Why Separate?

1. **Different use cases**:
   - Web API: Admin operations, bulk actions, reports
   - Mobile API: Self-service, simplified responses

2. **Different authentication**:
   - Web API: Session-based (web middleware)
   - Mobile API: Token-based (Sanctum)

3. **Different response formats**:
   - Web API: May include extra metadata for admin
   - Mobile API: Optimized for mobile bandwidth

**Example**:
```php
// Web API: Full member details
GET /api/v1/members/{id}
Response: {
    id, name, email, phone, address, shepherd, service_units,
    attendance_history, giving_history, documents, notes, ...
}

// Mobile API: Essential member details
GET /api/mobile/v1/profile
Response: {
    id, name, email, phone, profile_photo,
    attendance_percentage, upcoming_events
}
```

---

## Data Synchronization Scenarios

### Scenario Matrix

| Action | Where | Synced To | Delay |
|--------|-------|-----------|-------|
| Member added | Web | Mobile immediately | 0s (same DB) |
| Profile updated | Mobile | Web immediately | 0s (same DB) |
| Check-in | Mobile | Web dashboard | <10s (polling) |
| Transaction approved | Web | Mobile history | 0s (same DB) |
| Event created | Web | Mobile events list | 0s (same DB) |
| Event registration | Mobile | Web registrations | 0s (same DB) |
| SMS sent | Web | Mobile notifications | <30s (queue) |

---

## Integration Checklist

### For Developers

✅ **Database**:
- [x] Single database for both web and mobile
- [x] All models shared
- [x] Relationships properly defined

✅ **Authentication**:
- [x] Web: Session-based (middleware: auth)
- [x] Mobile: Token-based (middleware: auth:sanctum)
- [x] Same users table

✅ **Repositories**:
- [x] Shared data access logic
- [x] Used by both web and mobile controllers
- [x] Consistent query patterns

✅ **API Endpoints**:
- [x] Web API: /api/v1/*
- [x] Mobile API: /api/mobile/v1/*
- [x] Documented in 04_API_DOCUMENTATION.md

✅ **Real-Time Updates**:
- [x] Web dashboard polling (10s interval)
- [x] Mobile optimistic updates
- [x] Queue for async operations

✅ **Caching**:
- [x] Web: Laravel cache (Redis)
- [x] Mobile: Service worker cache
- [x] Cache invalidation on updates

---

## Testing Integration

### Test Data Flow

```php
// Test: Web creates, mobile reads
public function test_web_creates_member_visible_in_mobile()
{
    // 1. Admin creates member via web
    $this->actingAs($admin)
        ->post('/members', $memberData)
        ->assertRedirect();

    // 2. Verify in database
    $this->assertDatabaseHas('members', ['email' => $memberData['email']]);

    // 3. Mobile API returns member
    $response = $this->actingAs($member, 'sanctum')
        ->getJson('/api/mobile/v1/profile');

    $response->assertStatus(200)
        ->assertJson(['email' => $memberData['email']]);
}

// Test: Mobile updates, web reads
public function test_mobile_updates_profile_visible_in_web()
{
    // 1. Member updates via mobile
    $this->actingAs($member, 'sanctum')
        ->putJson('/api/mobile/v1/profile', ['phone' => '+233123456789'])
        ->assertStatus(200);

    // 2. Verify in database
    $this->assertDatabaseHas('members', ['phone' => '+233123456789']);

    // 3. Web shows updated data
    $this->actingAs($admin)
        ->get('/members/' . $member->id)
        ->assertSee('+233123456789');
}
```

---

## Conclusion

The Web App and Mobile PWA are **fully integrated** through:

1. ✅ **Shared Database** - Single source of truth
2. ✅ **Shared Models** - Same Eloquent models
3. ✅ **Shared Repositories** - Consistent data access
4. ✅ **Real-Time Sync** - Instant updates (0s delay)
5. ✅ **Unified Authentication** - Same users table
6. ✅ **API Architecture** - RESTful, versioned
7. ✅ **Event-Driven** - Laravel events for cross-component updates

**Result**: Seamless experience where web admins and mobile users work with the same data in real-time.

---

## Additional Resources

- **API Documentation**: docs/project-documentation/04_API_DOCUMENTATION.md
- **Database Design**: docs/project-documentation/03_DATABASE_DESIGN.md
- **Mobile PWA Guide**: docs/user-guides/MOBILE_LOGIN_GUIDE.md
- **Complete Implementation Report**: docs/COMPLETE_IMPLEMENTATION_REPORT.md
