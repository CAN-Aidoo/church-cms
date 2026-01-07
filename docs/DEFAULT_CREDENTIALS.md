# Default Credentials & User Accounts

## ⚠️ SECURITY WARNING
**ALL DEFAULT PASSWORDS MUST BE CHANGED IMMEDIATELY AFTER FIRST LOGIN!**

---

## Current Seeder Configuration

### Active Seeder (DatabaseSeeder.php)
The main database seeder **only** calls `AdminUserSeeder`, which creates:

**ONE Default Account:**
- **Email**: `admin@church.com`
- **Password**: `password`
- **Role**: Admin
- **Full Name**: System Administrator
- **Phone**: +233200000000

---

## Additional Available Seeder (Not Auto-Run)

### InitialChurchDataSeeder
This seeder is **NOT** called by default in `DatabaseSeeder.php`, but can be manually run with:
```bash
php artisan db:seed --class=InitialChurchDataSeeder
```

It creates **4 demo accounts**:

| Role | Email | Password | Full Name |
|------|-------|----------|-----------|
| Admin | admin@churchcms.com | Admin@2024! | System Administrator |
| Pastor | pastor@churchcms.com | Pastor@2024! | Lead Pastor |
| Staff | staff@churchcms.com | Staff@2024! | Church Staff |
| Member | member@churchcms.com | Member@2024! | Demo Member |

---

## 🔍 Account Verification

### Check What Accounts Exist
Run this SQL query to see all users:
```sql
SELECT id, full_name, email, role, is_active, created_at
FROM users
ORDER BY created_at;
```

Or using Artisan Tinker:
```bash
php artisan tinker
>>> \App\Models\User::select('id', 'full_name', 'email', 'role')->get()
```

---

## 🛡️ Security Recommendations

### 1. Change Default Password Immediately
```php
// Via Tinker
php artisan tinker
>>> $admin = \App\Models\User::where('email', 'admin@church.com')->first();
>>> $admin->password = \Hash::make('YourSecurePassword123!@#');
>>> $admin->save();
```

### 2. Delete Unused Demo Accounts
If you used `InitialChurchDataSeeder` for testing, delete the demo accounts:
```php
php artisan tinker
>>> \App\Models\User::whereIn('email', [
    'pastor@churchcms.com',
    'staff@churchcms.com',
    'member@churchcms.com'
])->delete();
```

### 3. Update Email Address
Change the admin email to your actual church email:
```php
php artisan tinker
>>> $admin = \App\Models\User::where('email', 'admin@church.com')->first();
>>> $admin->email = 'your-actual-admin@yourchurch.com';
>>> $admin->save();
```

### 4. Enable Two-Factor Authentication
After changing password, enable 2FA in the admin settings.

---

## 📝 Documentation Discrepancies Found

### ❌ Incorrect Information in README.md
**Line 253-254** states:
- Email: `admin@churchcms.com`
- Password: `Admin@123456`

**ACTUAL DEFAULT (from AdminUserSeeder):**
- Email: `admin@church.com`
- Password: `password`

### ⚠️ Action Required
The README.md file needs to be updated to reflect the correct default credentials.

---

## 🔒 Production Deployment Checklist

- [ ] Change default admin password
- [ ] Update admin email to actual church email
- [ ] Delete any demo/test accounts
- [ ] Enable two-factor authentication
- [ ] Review all user accounts in database
- [ ] Set strong password policy in settings
- [ ] Enable password expiration if needed
- [ ] Review user roles and permissions
- [ ] Disable database seeding in production (`.env`: `APP_ENV=production`)
- [ ] Ensure `.env` file is not publicly accessible

---

## 🔧 How to Prevent Unknown Accounts

### 1. Disable Seeders in Production
In `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

### 2. Regular Audit
Run monthly checks:
```bash
php artisan tinker
>>> \App\Models\User::all()->map(fn($u) => [
    'email' => $u->email,
    'role' => $u->role,
    'created' => $u->created_at->format('Y-m-d'),
    'last_login' => $u->last_login_at?->format('Y-m-d')
])
```

### 3. Monitor User Creation
Check the audit logs for unauthorized user creation:
```sql
SELECT * FROM audit_logs
WHERE auditable_type = 'App\Models\User'
AND event = 'created'
ORDER BY created_at DESC;
```

---

## 📞 Support

If you discover any unauthorized accounts or security concerns:
1. Immediately change all admin passwords
2. Review audit logs
3. Contact your system administrator
4. Document the findings

---

**Last Updated**: 2026-01-02
**Review Date**: Monthly
