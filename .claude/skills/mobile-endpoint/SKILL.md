---
name: mobile-endpoint
description: Add a new mobile API endpoint to the Church CMS PWA. Use when adding a new route + controller method + mobile view interaction. Knows the mobile auth model, response format, and Alpine.js patterns.
---

Add a new mobile API endpoint for: `$ARGUMENTS`

Follow this exact process:

## 1. Add the Route
In `routes/api.php`, inside `Route::prefix('mobile/v1')->middleware(['auth:sanctum'])`:

```php
Route::get('/my/resource', [MobileXxxController::class, 'methodName']);
// or POST/PUT/DELETE as appropriate
```

## 2. Add the Controller Method
In the appropriate `app/Http/Controllers/Mobile/Mobile{Domain}Controller.php`:

```php
public function methodName(Request $request)
{
    $validated = $request->validate([
        // typed validation rules
    ]);

    $member = $request->user()->member;

    if (! $member) {
        return response()->json([
            'success' => false,
            'message' => 'Member profile not linked to this account.',
        ], 404);
    }

    // Business logic here

    return response()->json([
        'success' => true,
        'message' => 'Action completed.',
        'data' => [
            // response payload
        ],
    ]);
}
```

Rules:
- Always check `$request->user()->member` is not null
- Return `['success' => bool, 'message' => string, 'data' => array]`
- Use 422 for validation errors, 400 for business rule violations, 404 for not found

## 3. Wire the View
In the relevant `resources/views/mobile/*.blade.php`:

```javascript
async function callNewEndpoint() {
    const response = await fetch(`${window.MOBILE_API_BASE_URL}/my/resource`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
        body: JSON.stringify(payload),
    });

    const json = await response.json();

    if (json.success) {
        // Handle success
    } else {
        // Show json.message as error
    }
}
```

## 4. Verify
- Check the route is accessible: `php artisan route:list --path=mobile/v1`
- Use the `test-writer` agent to write a feature test for the new endpoint
