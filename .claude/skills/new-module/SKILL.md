---
name: new-module
description: Scaffold a complete new CMS module following the project's architecture (controller, service, repository, model, migration, form request, policy, routes, and feature test). Use when adding a new top-level feature to the admin webapp.
---

Scaffold a new module named `$ARGUMENTS` for the Sonlife City Church CMS.

Follow these steps exactly:

## 1. Model + Migration
- Create: `app/Models/{Name}.php`
  - Extend `Model`, use `HasFactory`, `SoftDeletes`
  - Define `$fillable`, `$casts`, and relationships
- Create migration: `database/migrations/YYYY_MM_DD_create_{name}s_table.php`
  - Must include `id()`, `timestamps()`, `softDeletes()`
  - All foreign keys use `constrained()->cascadeOnDelete()`

## 2. Form Request
- Create: `app/Http/Requests/Store{Name}Request.php`
- Create: `app/Http/Requests/Update{Name}Request.php`
- Both must include `authorize()` returning `true` and `rules()` with typed constraints

## 3. Repository
- Create: `app/Repositories/{Name}Repository.php`
- Must implement these methods: `all()`, `find(int $id)`, `create(array $data)`, `update(int $id, array $data)`, `delete(int $id)`
- Use Eloquent in the repository, never in the controller

## 4. Service
- Create: `app/Services/{Name}Service.php`
- Inject `{Name}Repository` via constructor DI
- Implement business logic methods that call the repository

## 5. Policy
- Create: `app/Policies/{Name}Policy.php`
- Methods: `viewAny`, `view`, `create`, `update`, `delete`
- Admin/Pastor roles get full access; others get restricted access

## 6. Controller
- Create: `app/Http/Controllers/{Name}Controller.php`
- Standard resource methods: `index`, `show`, `create`, `store`, `edit`, `update`, `destroy`
- Inject `{Name}Service` via constructor
- Call `$this->authorize()` using the Policy in every method
- Use Form Request classes for validation in `store`/`update`
- Never query Eloquent directly

## 7. Routes
- Add to `routes/web.php`: `Route::resource('{names}', {Name}Controller::class);`
- Place inside the `admin` middleware group

## 8. Views (if applicable)
- Create: `resources/views/{names}/index.blade.php`
- Create: `resources/views/{names}/create.blade.php`
- Create: `resources/views/{names}/edit.blade.php`
- Extend `layouts.app`

## 9. Feature Test
- Use the `test-writer` agent to generate `tests/Feature/{Name}Test.php`

## 10. Final Check
- Run `vendor/bin/phpunit tests/Feature/{Name}Test.php` to confirm tests pass
- Run `vendor/bin/pint app/Http/Controllers/{Name}Controller.php app/Services/{Name}Service.php app/Repositories/{Name}Repository.php` to format
