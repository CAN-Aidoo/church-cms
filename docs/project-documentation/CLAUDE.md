# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a comprehensive Church Management System (CMS) built for church administrators to manage all aspects of church operations. The system handles member management, attendance tracking, financial transactions, SMS communications, equipment inventory, visitor management, and much more.

**Target Users**: Church administrators, pastors, staff members, and regular members (view-only)
**Tech Stack**: Laravel 10.x (PHP 8.2+), MySQL 8.0+, Tailwind CSS, Alpine.js/Vanilla JS
**Authentication**: Laravel Sanctum with JWT tokens
**Theme Colors**: Gradient blue, gold, and white

## Architecture Principles

### Layered Architecture
The application follows a strict layered architecture pattern:

1. **Controllers** (`app/Http/Controllers/`): Handle HTTP requests, delegate to services, return responses
2. **Services** (`app/Services/`): Business logic layer - all complex operations live here
3. **Repositories** (`app/Repositories/`): Data access layer - database queries abstracted here
4. **Models** (`app/Models/`): Eloquent ORM models with relationships and basic queries only
5. **Events & Listeners** (`app/Events/`, `app/Listeners/`): Event-driven architecture for decoupled operations

**Critical**: Never put business logic in Controllers or Models. Controllers should be thin, Models should only contain relationships and basic scopes. All business logic belongs in Services.

### Service Layer Pattern
Services are the heart of business logic:

```php
// Example: FinanceService handles all financial calculations
app/Services/FinanceService.php
  - calculateBalance()
  - generateReport()
  - approveTransaction()

// Used in controller:
class TransactionController extends Controller
{
    public function __construct(private FinanceService $financeService) {}

    public function approve($id)
    {
        $result = $this->financeService->approveTransaction($id);
        return response()->json($result);
    }
}
```

### Repository Pattern
All database queries are abstracted through repositories:

```php
// app/Repositories/MemberRepository.php
public function findActive() { /* ... */ }
public function findByShepherd($shepherdId) { /* ... */ }
public function getAttendanceStats($memberId) { /* ... */ }
```

Controllers never query the database directly - always go through repositories.

### Role-Based Access Control (RBAC)
Four user roles with strict permissions:
- **Admin**: Full system access, user management, audit logs, system settings
- **Pastor**: View/edit members, mark attendance, view/approve finances, send SMS
- **Staff**: Create/read members, mark attendance, record transactions, manage equipment
- **Member**: View own profile, event calendar, limited directory only

Role checking is enforced via middleware:
```php
Route::middleware(['auth:sanctum', CheckRole::class . ':admin,pastor'])->group(function () {
    // Only admin and pastor can access
});
```

## Key Domain Concepts

### Member Lifecycle Management
Members progress through stages:
1. **Visitor** (5-visit rule): Tracked in `visitors` table until 5 visits
2. **Conversion**: Automatic prompt after 5th visit to become member
3. **Pending Member**: In `members` table with status='pending', assigned to onboarding
4. **Active Member**: Completed foundations class, status='active'
5. **Inactive/Suspended**: Status changes tracked with reasons

### Shepherd System
Members are organized into small groups (12-15 per shepherd):
- Each member assigned to exactly one shepherd
- Shepherds track visitation, flock meetings, attendance
- Flock assignment considers geography and family units
- Weekly/monthly reporting structure

### Service Units
Members serve in ministry units:
- Multiple service units (Ushering, Choir, Technical, Protocol, etc.)
- Duty roster rotation system
- Skills inventory tracking
- Unit leadership hierarchy

### Attendance Tracking
Multiple attendance methods supported:
1. **QR Code Check-in**: Members scan unique QR codes
2. **Mobile Self Check-in**: GPS-verified mobile app
3. **Kiosk Check-in**: Touch screen name search with photo verification
4. **Manual Entry**: Staff bulk-mark attendance

Automated absence follow-up:
- 2 consecutive absences → SMS reminder
- 3 consecutive absences → Pastoral notification
- Return after absence → Welcome back message

### Financial Transaction Flow
```
Transaction Created (status='pending')
    ↓
Staff Records (created_by=staff_id)
    ↓
Pastor/Admin Reviews
    ↓
Approval (status='completed', approved_by=pastor_id)
    ↓
Reconciliation (status='reconciled')
```

Approval workflow:
- Transactions >GHS 5,000 require dual approval
- Budget vs actual tracking per department
- Automatic overspending alerts

### Birthday & Anniversary Automation
Fully automated milestone tracking:
- Birthdays: Auto-SMS at 12am, pastor notification, service announcement
- Wedding anniversaries: 25th, 50th special recognition
- Membership anniversaries: 1yr, 5yr, 10yr certificates
- Ministry milestones: Ordination, service anniversaries

## Database Schema Critical Points

### Foreign Key Cascade Rules
- `members.user_id` → CASCADE on user deletion creates orphan member records (intentional)
- `attendance.member_id` → CASCADE deletes attendance when member deleted
- `transactions.member_id` → SET NULL preserves transaction history
- Always check cascade behavior before deleting related records

### Unique Constraints
- `attendance`: Unique on (member_id, service_date, service_type) - prevents duplicate check-ins
- `members`: Email not required but must be unique if provided
- Phone OR email required for members (CHECK constraint)

### Stored Procedures
Financial operations use stored procedures for performance:
- `GetFinancialSummary(start_date, end_date)`: Returns income/expense breakdown
- `GetAttendanceReport(member_id, start_date, end_date)`: Attendance percentage calculations

Call from Laravel:
```php
DB::select('CALL GetFinancialSummary(?, ?)', [$startDate, $endDate]);
```

### Audit Logging
All CUD operations automatically logged via triggers and Eloquent events:
- Who made the change (user_id)
- What changed (old_values, new_values as JSON)
- When (created_at with microsecond precision)
- Where from (ip_address, user_agent)

Never manually create audit logs - use the Auditable trait on models.

## Frontend Architecture

### Blade Component System
Reusable components in `resources/views/components/`:
```blade
{{-- Usage --}}
<x-member-card :member="$member" />

{{-- Component file: components/member-card.blade.php --}}
@props(['member'])
<div class="bg-white rounded-lg shadow-md">
    {{-- Component template --}}
</div>
```

### Alpine.js Reactive Components
Used for interactive UI without full JavaScript framework:
```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open" x-transition>Content</div>
</div>
```

For complex interactions, see `resources/js/components/` modules.

### API Service Layer
All AJAX requests go through the API service (`resources/js/services/api.js`):
```javascript
import api from '@/services/api.js';

// GET request
const members = await api.get('/members?status=active');

// POST with data
const result = await api.post('/members', memberData);
```

Automatically includes CSRF token and authentication headers.

## Critical Business Rules

### Visitor to Member Conversion (5-Visit Rule)
- System automatically tracks visitor attendance
- After 5th visit, system prompts staff to convert
- Membership form pre-filled from visitor data
- Conversion creates user account + member record
- Original visitor record linked via `converted_member_id`

### SMS Broadcast Restrictions
- Max 160 characters per standard SMS
- Multi-part SMS allowed up to 1600 characters (10 SMS segments)
- Rate limiting: 10 requests per hour
- Cost estimation shown before sending
- Scheduled sends queue in Laravel queue system
- Failed messages automatically retry once

### Financial Approval Thresholds
- <GHS 1,000: Staff can record, no approval needed
- GHS 1,000-5,000: Single approval (Pastor or Admin)
- >GHS 5,000: Dual approval required (Pastor + Admin)
- Expenses >10% over budget: Automatic alert to Admin

### Attendance Patterns & Alerts
Automated engagement tracking:
- 80%+ attendance: "Committed" status
- 50-79% attendance: "Regular" status
- <50% attendance: "At Risk" status, shepherd notified
- Zero attendance 30 days: Auto-flag for follow-up

### Data Privacy & GDPR Compliance
- Member data encrypted at rest (database level)
- Session notes in counselling module use additional encryption
- Right to be forgotten: Soft delete, anonymize after 7 years
- Consent forms required for photo/video usage
- Audit trail for all data access (admin can review)

## Module Dependencies

### Module Interaction Map
```
Members (Core)
  ├── Attendance (tracks member attendance)
  ├── Finance (member giving history)
  ├── Shepherds (member assignments)
  ├── Service Units (member ministry)
  └── Visitors (conversion source)

Attendance
  ├── Members (attendance records)
  ├── Notifications (absence alerts)
  └── Reports (attendance statistics)

Finance
  ├── Members (donor tracking)
  ├── Transactions (income/expense)
  ├── Pledges (commitment tracking)
  └── Reports (financial statements)

SMS Broadcast
  ├── Members (recipient lists)
  ├── Service Units (unit broadcasts)
  ├── Shepherds (flock communications)
  └── Birthdays (automated wishes)
```

### Cross-Module Data Flow
Example: Birthday SMS workflow
1. **Birthday Module** identifies today's birthdays
2. Queries **Members Module** for member details
3. Calls **SMS Broadcast Module** to send messages
4. **Notification Module** logs delivery status
5. **Audit Module** records the communication

## Testing Strategy

### Service Layer Testing
All business logic must have unit tests:
```php
// tests/Unit/Services/FinanceServiceTest.php
public function test_calculate_balance_excludes_pending_transactions()
{
    // Arrange: Create test data
    // Act: Call service method
    // Assert: Verify correct calculation
}
```

### Repository Testing
Database queries tested with in-memory SQLite:
```php
// tests/Unit/Repositories/MemberRepositoryTest.php
public function test_find_active_returns_only_active_members()
{
    // Uses RefreshDatabase trait
}
```

### Integration Testing
Full request/response cycles:
```php
// tests/Feature/MemberControllerTest.php
public function test_admin_can_create_member()
{
    $this->actingAs($admin)
         ->post('/api/members', $data)
         ->assertStatus(201);
}
```

## Performance Optimization

### Caching Strategy
- Dashboard stats: 5 minutes (300 seconds)
- Member demographics: 1 hour (3600 seconds)
- Financial summaries: 10 minutes (600 seconds)
- Reports: Cache until next data change

Use cache tags for selective invalidation:
```php
Cache::tags(['members', 'statistics'])->put('stats', $data, 300);
// Invalidate when member data changes:
Cache::tags(['members'])->flush();
```

### Query Optimization
Always eager load relationships to avoid N+1:
```php
// BAD: N+1 queries
$members = Member::all();
foreach ($members as $member) {
    echo $member->shepherd->name; // Query per member!
}

// GOOD: Single query with join
$members = Member::with('shepherd')->get();
```

### Queue Processing
Long-running tasks must be queued:
- SMS broadcasts
- Report generation (PDF/Excel)
- Email campaigns
- Birthday notifications
- Data imports/exports

```php
SendBirthdayWishes::dispatch($members)->onQueue('notifications');
```

## Security Considerations

### Input Validation
All user input validated via Form Requests:
```php
// app/Http/Requests/StoreMemberRequest.php
public function rules() {
    return [
        'email' => 'required|email|unique:members',
        'phone' => 'required|regex:/^[+][0-9]{10,15}$/',
        // ... more validation rules
    ];
}
```

### SQL Injection Prevention
- Always use Eloquent ORM or query builder (parameterized queries)
- Never concatenate user input into raw SQL
- If raw queries necessary, use parameter binding: `DB::select($sql, [$param])`

### XSS Prevention
- Blade templates auto-escape: `{{ $var }}` is safe
- Raw output only for trusted content: `{!! $trustedHtml !!}`
- Sanitize rich text editor content before storage

### Authentication Token Management
- Access tokens expire after 1 hour
- Refresh tokens valid for 7 days
- Tokens revoked on logout (not just forgotten client-side)
- Failed login attempts tracked, account locked after 5 attempts

## Configuration & Environment

### Required Environment Variables
```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=church_management
DB_USERNAME=root
DB_PASSWORD=

# SMS (Twilio)
TWILIO_SID=your_sid
TWILIO_TOKEN=your_token
TWILIO_PHONE=+233XXXXXXXXX

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525

# Cache & Queue
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

# App
APP_URL=http://localhost
APP_DEBUG=false (production)
```

### Church-Specific Configuration
Create `config/church.php` for church-specific settings:
```php
return [
    'name' => env('CHURCH_NAME', 'My Church'),
    'address' => env('CHURCH_ADDRESS', ''),
    'max_flock_size' => 15, // Members per shepherd
    'attendance_threshold' => 0.80, // 80% = committed
    'dual_approval_amount' => 5000, // GHS
    'financial_year_start' => '01-01', // January 1st
];
```

## Documentation Structure

The seven documentation files contain complete specifications:
1. `01_PROJECT_OVERVIEW.md`: Vision, goals, roles, features, timeline
2. `02_TECH_STACK.md`: Technology decisions, architecture patterns, code examples
3. `03_DATABASE_DESIGN.md`: Complete schema, relationships, stored procedures, triggers
4. `04_API_DOCUMENTATION.md`: All API endpoints, request/response formats, authentication
5. `05_FRONTEND_ARCHITECTURE.md`: Component structure, JavaScript architecture, Tailwind setup
6. `06_AUTHENTICATION_COMPLETE.md`: Auth flow, RBAC, password security, 2FA, audit logging
7. `07_FEATURE_MODULES_UPDATED_3.md`: Detailed specifications for all 26 feature modules

When implementing features, always reference the relevant documentation file for complete specifications and business rules.

## Common Patterns & Anti-Patterns

### ✅ DO: Use Service Layer for Business Logic
```php
class MemberService {
    public function convertVisitorToMember(Visitor $visitor) {
        DB::transaction(function() use ($visitor) {
            $user = $this->createUserAccount($visitor);
            $member = $this->createMemberRecord($visitor, $user);
            $this->assignToShepherd($member);
            $this->sendWelcomeMessage($member);
            $visitor->markAsConverted($member);
        });
    }
}
```

### ❌ DON'T: Put Business Logic in Controllers
```php
// BAD - Controller doing too much
class MemberController {
    public function convertVisitor($id) {
        $visitor = Visitor::find($id);
        $user = User::create([...]); // Should be in service
        $member = Member::create([...]); // Should be in service
        // ... more business logic in controller
    }
}
```

### ✅ DO: Use Events for Decoupled Operations
```php
// Trigger event
event(new MemberRegistered($member));

// Multiple listeners respond independently
class SendWelcomeEmail { ... }
class AssignToShepherd { ... }
class NotifyPastor { ... }
```

### ❌ DON'T: Chain Method Calls in Controllers
```php
// BAD - Tight coupling
public function register(Request $request) {
    $member = $this->memberService->create($request->all());
    $this->emailService->sendWelcome($member);
    $this->smsService->sendWelcome($member);
    $this->shepherdService->assign($member);
    // Use events instead!
}
```

## Implementation Status

### ✅ Backend Implementation: 100% COMPLETE

All 12 core feature modules have been fully implemented with complete backend architecture:

1. ✅ **Programs Module** - Event management, registration, attendance tracking
2. ✅ **Service Planning Module** - Service schedules, worship sets, volunteer coordination
3. ✅ **Prayer Request System** - Submission, assignment, tracking, testimonies
4. ✅ **Settings Module** - System configuration, email templates, backups, audit logs
5. ✅ **Reports Module** - Custom report builder, analytics, scheduled reports, exports
6. ✅ **Members Module Enhancement** - Families, children, documents, lifecycle events
7. ✅ **Children's Ministry Module** - Secure check-in/out, curriculum, events
8. ✅ **Counselling Module** - Sessions, cases, encrypted notes, resources
9. ✅ **Welfare Module** - Case management, programs, fund tracking, impact assessment
10. ✅ **Internal Messaging Module** - Direct/group chat, file sharing, reactions
11. ✅ **Media Team Module** - Content library, live streaming, equipment tracking
12. ✅ **Partnerships Module** - Partner management, agreements, financials

### Implementation Statistics

- **100+ database tables** across 24 migration files
- **50+ Eloquent models** with comprehensive relationships
- **12 repositories** with 200+ data access methods
- **12 controllers** with 250+ actions
- **250+ routes** with role-based access control
- **~25,000+ lines of production-ready code**

### File Structure

```
app/
├── Http/Controllers/
│   ├── ProgramController.php
│   ├── ServicePlanningController.php
│   ├── PrayerController.php
│   ├── SettingsController.php
│   ├── ReportController.php
│   ├── ChildrensMinistryController.php
│   ├── CounsellingController.php
│   ├── WelfareController.php
│   ├── MessagingController.php
│   ├── MediaController.php
│   └── PartnershipController.php
├── Models/
│   ├── [50+ models with relationships and business logic]
└── Repositories/
    ├── ProgramRepository.php
    ├── ServicePlanningRepository.php
    ├── PrayerRepository.php
    ├── SettingsRepository.php
    ├── ReportRepository.php
    ├── ChildrensMinistryRepository.php
    ├── CounsellingRepository.php
    ├── WelfareRepository.php
    ├── MessagingRepository.php
    ├── MediaRepository.php
    └── PartnershipRepository.php

database/migrations/
├── 2024_01_16_000012_create_programs_tables.php
├── 2024_01_17_000013_create_service_planning_tables.php
├── 2024_01_18_000014_create_prayer_request_tables.php
├── 2024_01_22_000015_create_settings_tables.php
├── 2024_01_23_000017_create_reports_tables.php
├── 2024_01_24_000018_enhance_members_tables.php
├── 2024_01_25_000019_create_childrens_ministry_tables.php
├── 2024_01_26_000020_create_counselling_tables.php
├── 2024_01_27_000021_create_welfare_tables.php
├── 2024_01_28_000022_create_messaging_tables.php
├── 2024_01_29_000023_create_media_team_tables.php
└── 2024_01_30_000024_create_partnerships_tables.php
```

### Key Implementation Highlights

#### Auto-Generation Features
- Program codes (PROG-YYYYMMDD-XXXXXX)
- Welfare case numbers (WF-YYYY-XXXXXXXX)
- Counselling case numbers (CASE-YYYY-XXXXXXXX)
- Security codes for children check-in/out
- Transaction codes for financial tracking
- Stream keys and access codes

#### State Management
- Programs: draft → published → ongoing → completed → cancelled
- Prayer Requests: submitted → praying → answered
- Counselling Sessions: scheduled → confirmed → in_progress → completed
- Welfare Cases: submitted → under_review → approved → disbursed → closed
- Live Streams: scheduled → live → ended

#### Encrypted Data
- Counselling session notes (using Laravel Crypt facade)
- Stream keys for live streaming
- Sensitive welfare case information

#### Smart Algorithms
- Auto-priority scoring for welfare cases
- Counsellor matching by specialization and availability
- Slot generation for counselling schedules
- Unread message counting
- Report scheduling calculations

### Next Steps (Frontend Development)

1. **Create Blade Views**
   - Dashboard with statistics widgets
   - CRUD views for all modules
   - List/index views with filtering
   - Detail/show views
   - Forms with validation

2. **Apply Tailwind CSS Styling**
   - Gradient blue, gold, white theme
   - Responsive design
   - Component library
   - Custom UI components

3. **Add Alpine.js Interactivity**
   - Modal dialogs
   - Dropdown menus
   - Form validations
   - Dynamic filtering
   - Real-time updates

4. **Implement Testing**
   - Unit tests for repositories
   - Feature tests for controllers
   - Integration tests for workflows

5. **Performance Optimization**
   - Implement caching strategies
   - Queue setup for background jobs
   - Asset compilation
   - Database indexing review

## Development Workflow

When continuing development:

1. ✅ Backend is complete - all models, controllers, repositories, routes implemented
2. Reference `07_FEATURE_MODULES_UPDATED_3.md` for frontend view specifications
3. Follow the gradient blue, gold, and white theme colors throughout
4. Ensure all features are accessible only to authorized roles (already enforced via middleware)
5. Use Laravel's built-in features (validation, authorization, queues)
6. See `FINAL_IMPLEMENTATION_SUMMARY.md` for complete implementation details
