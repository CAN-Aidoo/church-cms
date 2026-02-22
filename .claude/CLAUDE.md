# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Sonlife City Church CMS - A comprehensive Laravel 10 church management platform with 26+ modules including member management, QR-based attendance, financial tracking, SMS broadcasting, and a mobile PWA.

## Development Commands

```bash
# Setup
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed

# Development
php artisan serve          # Laravel server at localhost:8000
npm run dev               # Vite dev server with HMR

# Testing
composer test             # Run all PHPUnit tests
vendor/bin/phpunit tests/Feature/AttendanceTest.php  # Single test file
vendor/bin/phpunit --filter testMethodName           # Single test method

# Code Quality
composer pint             # Format code (Laravel Pint / PSR-12)

# Production Build
npm run build
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## Architecture

### Layer Pattern
- **Controllers** (`app/Http/Controllers/`) - Handle HTTP requests, delegate to services
- **Services** (`app/Services/`) - Business logic (11 services: AttendanceService, MemberService, QrCodeService, QRManagementService, QRSecurityService, SmsService, FinanceService, NotificationService, PaymentGatewayService, BirthdayAutomationService, FileUploadService)
- **Repositories** (`app/Repositories/`) - Data access layer (19 repositories)
- **Models** (`app/Models/`) - Eloquent models with relationships (90+ models)
- **Events/Listeners** (`app/Events/`, `app/Listeners/`) - 14 domain events, 8 listeners for async side-effects (birthday wishes, SMS confirmations, transaction receipts, etc.)

### Authentication & Authorization
- **Web routes**: Session-based, restricted to Admin/Pastor roles via `RestrictWebToAdminPastor` middleware
- **API routes**: Laravel Sanctum tokens, defined in `routes/api.php`
- **Roles**: Admin (full access), Pastor (administrative), Worker/Leader (operational), Member (self-service via `/api/v1/my/*`)
- **Permissions**: Spatie Laravel Permission package
- **Policies**: `ShepherdPolicy`, `ServiceUnitPolicy`, `PartnerPolicy`, `PartnershipAgreementPolicy`

### Route Structure
- `routes/web.php` (~720 lines) - Admin dashboard, all CRUD operations
- `routes/api.php` (~430 lines) - Public auth, Sanctum-protected API, mobile endpoints
- Mobile API: `/api/v1/mobile/*` routes (controllers in `app/Http/Controllers/Mobile/`)
- QR scanning: `/api/v1/qr-scan/*` routes
- Member self-service: `/api/v1/my/*` routes

### Key Modules
| Module | Controller | Repository | Key Features |
|--------|-----------|------------|--------------|
| Members | `MemberController` | `MemberRepository` | Profiles, documents, families, QR codes |
| Attendance | `AttendanceController` | `AttendanceRepository` | QR check-in, GPS verification, reports |
| Finance | `TransactionController` | `TransactionRepository` | Multi-level approvals, Paystack/Hubtel |
| Shepherds | `ShepherdController` | `ShepherdRepository` | Small groups (max 15 members), visitations |
| Children | `ChildrensMinistryController` | `ChildrensMinistryRepository` | Secure check-in with 4-digit codes |
| SMS | `SmsBroadcastController` | — | Twilio integration, templates, delivery tracking |

### Mobile PWA
- Views: `resources/views/mobile/`
- Controllers: `app/Http/Controllers/Mobile/` (8 controllers: CheckIn, Children, Content, Equipment, Payment, Registration, ServiceUnit, Shepherd)
- Features: Offline support (IndexedDB via `idb`), QR scanning (`html5-qrcode`), self-service portal

### Database
- MySQL 8.0+ (SQLite for tests); TiDB Cloud and Railway supported via env var fallbacks in `config/database.php`
- 36 migrations in `database/migrations/`
- Soft deletes where appropriate; timestamps on all models

## Scheduled Tasks

All tasks use `Africa/Accra` timezone. Defined in `app/Console/Kernel.php`:

| Command | Schedule | Purpose |
|---------|----------|---------|
| `birthdays:process` | Daily 12:00 AM | Send birthday wishes |
| `attendance:alerts` | Mondays 9:00 AM | Alert on absent members |
| `reports:scheduled` | Hourly | Process scheduled report queue |
| `backup:database` | Daily 2:00 AM | Database backup |
| `backup:clean` | Sundays 3:00 AM | Remove old backups |
| `qr:generate-scheduled` | Sun 6 AM, Wed 4 PM, Fri 4 PM | Pre-generate service QR codes |

## Testing

- Framework: PHPUnit with SQLite in-memory database
- Test files in `tests/Feature/` (15 test files covering all major modules)
- Database seeded from `database/seeders/` (AdminUserSeeder, InitialChurchDataSeeder)

## Third-Party Integrations

- **SMS**: Twilio (via `SmsService`) — env: `TWILIO_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_PHONE_NUMBER`
- **Payments**: Paystack (cards) + Hubtel (Ghana mobile money: MTN, Vodafone, AirtelTigo) via `PaymentGatewayService`
- **QR Codes**: SimpleSoftwareIO/simple-qrcode (generation); html5-qrcode (PWA scanning)
- **Exports**: Maatwebsite Excel, DOMPDF
- **Activity Logging**: Spatie Laravel Activity Log

## Frontend Stack

- Tailwind CSS 3.x with custom config (`tailwind.config.js`) — custom color palette (Electric Blue primary, Amber accent), fonts (Inter, Outfit)
- Alpine.js for interactivity
- Vite 5.x for bundling
- Chart.js and ApexCharts for visualizations
- Views in `resources/views/` (Blade templates)

## Key Business Configuration (`.env`)

```
CHURCH_NAME=                    # Org name used in templates
CURRENCY=GHS                    # Default currency
MAX_FLOCK_SIZE=15               # Max members per shepherd group
DUAL_APPROVAL_THRESHOLD=5000    # Amount requiring dual approval
ATTENDANCE_COMMITTED_THRESHOLD=0.80
ENABLE_SMS_BROADCASTS=true
ENABLE_ONLINE_GIVING=true
ENABLE_TWO_FACTOR_AUTH=false
```

## Deployment

- `Dockerfile` + `docker-entrypoint.sh` — PHP 8.2/Apache image, dynamic PORT env var for Render/Railway
- Production caching: `php artisan config:cache && route:cache && view:cache`
- Scheduler: `php artisan schedule:run` via cron; queue worker via supervisor in production

## Documentation

Comprehensive docs in `docs/`:
- `docs/project-documentation/` — architecture, API, DB design, auth, feature modules, UI/UX guide
- `docs/setup/` — beginner installation and quick-start guides
- `docs/mobile-pwa/` — PWA setup, testing, and mobile login guides
- `docs/features/qr-system/` — QR implementation details
- `docs/deployment/` — deployment guide
- `docs/DEFAULT_CREDENTIALS.md` — default login credentials

## Coding Conventions

- PSR-12 compliance (enforced via Pint)
- Repository pattern for all data access — never query models directly from controllers
- Form Request classes for all validation (`app/Http/Requests/`)
- Policy classes for authorization (`app/Policies/`)
- Controllers should delegate business logic to Services
- Use type hints and PHPDoc comments
