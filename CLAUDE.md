# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Sonlife Church CMS - A comprehensive Laravel 10 church management platform with 26+ modules including member management, QR-based attendance, financial tracking, SMS broadcasting, and a mobile PWA.

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

# Code Quality
composer pint             # Format code (Laravel Pint / PSR-12)

# Production Build
npm run build
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## Architecture

### Layer Pattern
- **Controllers** (`app/Http/Controllers/`) - Handle HTTP requests, delegate to services
- **Services** (`app/Services/`) - Business logic (11 services: Attendance, Member, QR, SMS, Finance, etc.)
- **Repositories** (`app/Repositories/`) - Data access layer (19 repositories)
- **Models** (`app/Models/`) - Eloquent models with relationships (50+ models)

### Authentication & Authorization
- **Web routes**: Session-based, restricted to Admin/Pastor roles via `RestrictWebToAdminPastor` middleware
- **API routes**: Laravel Sanctum tokens, defined in `routes/api.php`
- **Roles**: Admin (full access), Pastor (administrative), Worker/Leader (operational), Member (self-service)
- **Permissions**: Spatie Laravel Permission package

### Route Structure
- `routes/web.php` (~720 lines) - Admin dashboard, all CRUD operations
- `routes/api.php` (~430 lines) - Public auth, Sanctum-protected API, mobile endpoints
- Mobile API: `/api/mobile/v1/*` routes
- QR scanning: `/api/qr-scan/*` routes

### Key Modules
| Module | Controller | Repository | Key Features |
|--------|-----------|------------|--------------|
| Members | `MemberController` | `MemberRepository` | Profiles, documents, families, QR codes |
| Attendance | `AttendanceController` | `AttendanceRepository` | QR check-in, GPS verification, reports |
| Finance | `TransactionController` | `TransactionRepository` | Multi-level approvals, Paystack/Flutterwave |
| Shepherds | `ShepherdController` | `ShepherdRepository` | Small groups (12-15 members), visitations |
| Children | `ChildrensMinistryController` | `ChildrensMinistryRepository` | Secure check-in with 4-digit codes |
| SMS | `SmsBroadcastController` | - | Twilio integration, templates, delivery tracking |

### Mobile PWA
- Views: `resources/views/mobile/`
- Controllers: `app/Http/Controllers/Mobile/`
- Features: Offline support, QR scanning, self-service portal

### Database
- MySQL 8.0+ (SQLite for tests)
- 36 migrations in `database/migrations/`
- Soft deletes where appropriate
- Timestamps on all models

## Scheduled Tasks

Defined in `app/Console/Kernel.php`:
- Daily birthday processing (12:00 AM)
- Monday attendance alerts (9:00 AM)
- Hourly scheduled report checks
- Daily backups (2:00 AM)
- QR code generation (Sunday 6 AM, Wednesday 4 PM)

## Testing

- Framework: PHPUnit with SQLite in-memory database
- Test files in `tests/Feature/` (13 test files covering main modules)
- Run specific test: `vendor/bin/phpunit --filter testMethodName`

## Third-Party Integrations

- **SMS**: Twilio (via `SmsService`)
- **Payments**: Paystack, Flutterwave (via `PaymentGatewayService`)
- **QR Codes**: SimpleSoftwareIO/simple-qrcode
- **Exports**: Maatwebsite Excel, DOMPDF

## Frontend Stack

- Tailwind CSS 3.x with custom config (`tailwind.config.js`)
- Alpine.js for interactivity
- Vite 5.x for bundling
- Chart.js and ApexCharts for visualizations
- Views in `resources/views/` (Blade templates)

## Coding Conventions

- PSR-12 compliance (enforced via Pint)
- Repository pattern for all data access
- Form Request classes for validation (`app/Http/Requests/`)
- Policy classes for authorization (`app/Policies/`)
- Controllers should delegate business logic to Services
- Use type hints and PHPDoc comments
