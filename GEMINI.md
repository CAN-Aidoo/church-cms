# Church Management System - Gemini Context

## Project Overview
**Church Management System (CMS)** is a comprehensive Laravel-based application designed for church administration. It handles members, attendance, finance, SMS, equipment, visitors, and more.

- **Backend**: Laravel 10.x (PHP 8.2+)
- **Database**: MySQL 8.0+
- **Frontend**: Tailwind CSS 3.x, Alpine.js, Blade templates (implied)
- **Authentication**: Laravel Sanctum with JWT tokens
- **Current Status**: Backend is **100% Complete** (12/12 modules implemented). Frontend is **Ready for Development**.

## Key Architecture & Patterns
The project follows a strict **Layered Architecture**:
1.  **Controllers** (`app/Http/Controllers/`): Thin layer, handles HTTP requests, delegates to Services.
2.  **Services** (`app/Services/`): **Business Logic Layer**. All complex logic resides here.
3.  **Repositories** (`app/Repositories/`): Data Access Layer. Database queries are abstracted here.
4.  **Models** (`app/Models/`): Eloquent ORM. Relationships and basic scopes only.
5.  **Events/Listeners**: Decoupled operations (e.g., sending emails after registration).

**Strict Rule**: Never put business logic in Controllers or Models. Use Services.

## Development Conventions
- **Roles**: Admin, Pastor, Staff, Member. Enforced via Middleware.
- **Styling**: Tailwind CSS. Theme: Gradient Blue (`#2563eb` to `#1d4ed8`), Gold (`#eab308`), White.
- **Database**: Uses Soft Deletes, JSON columns for flexible data, and Encrypted columns for sensitive data (counselling notes).
- **Testing**: `php artisan test`. Tests are located in `tests/Feature` and `tests/Unit`.

## Building & Running
- **Install PHP Dependencies**: `composer install`
- **Install Node Dependencies**: `npm install`
- **Setup Environment**: `cp .env.example .env && php artisan key:generate`
- **Database Setup**: `php artisan migrate --seed`
- **Run Server**: `php artisan serve`
- **Build Assets**: `npm run dev` (dev) or `npm run build` (prod)

## Key Directories
- `app/Http/Controllers`: Request handlers (12 controllers implemented).
- `app/Services`: Business logic (Core implementation).
- `app/Repositories`: Database interaction.
- `app/Models`: Eloquent models (50+ models).
- `database/migrations`: Database schema definitions.
- `resources/views`: Frontend templates (To be developed).
- `routes/web.php` & `routes/api.php`: Application routes.

## Useful Commands
- **Run Tests**: `php artisan test`
- **Clear Cache**: `php artisan optimize:clear`
- **Code Style**: `./vendor/bin/pint`
- **Queue Worker**: `php artisan queue:work`

## Documentation References
- `README.md`: Getting started and overview.
- `CLAUDE.md`: Detailed architectural guidelines and development rules.
- `FINAL_IMPLEMENTATION_SUMMARY.md`: Detailed status of implemented modules.
