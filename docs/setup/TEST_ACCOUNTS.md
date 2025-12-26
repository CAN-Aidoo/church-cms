# Test Accounts for Church CMS

## 📱 Mobile App Test Account

### Member Account (For Mobile Testing)

```
Email: member@test.com
Password: password
Role: member
User ID: 38
Phone: 0241234567
Status: Active
```

**Mobile Features Access:**
- ✅ View own profile
- ✅ View attendance history
- ✅ View giving history
- ✅ View upcoming events
- ✅ Register for programs
- ✅ View ministry involvement
- ✅ Access member portal
- ✅ View announcements
- ✅ Check-in to services (QR/GPS)
- ✅ Mobile giving

**Mobile App Login:**
1. Open mobile app
2. Tap "Login"
3. Enter email: `member@test.com`
4. Enter password: `password`
5. Tap "Sign In"

---

## 💻 Web Admin Test Accounts

### Admin Account (Full Access)

To create an admin account, run:
```sql
INSERT INTO users (full_name, email, password, role, phone, is_active, created_at, updated_at)
VALUES (
    'Admin User',
    'admin@test.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    '0241234568',
    1,
    NOW(),
    NOW()
);
```

**Credentials:**
```
Email: admin@test.com
Password: password
Role: admin
```

**Admin Features Access:**
- ✅ Full system access
- ✅ User management
- ✅ QR code management
- ✅ Financial approvals
- ✅ System settings
- ✅ Audit logs
- ✅ Backup management
- ✅ All reports

### Pastor Account (Leadership Access)

To create a pastor account, run:
```sql
INSERT INTO users (full_name, email, password, role, phone, is_active, created_at, updated_at)
VALUES (
    'Pastor User',
    'pastor@test.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'pastor',
    '0241234569',
    1,
    NOW(),
    NOW()
);
```

**Credentials:**
```
Email: pastor@test.com
Password: password
Role: pastor
```

**Pastor Features Access:**
- ✅ View/edit members
- ✅ Mark attendance
- ✅ View/approve finances
- ✅ Send SMS broadcasts
- ✅ QR code generation
- ✅ Shepherding dashboard
- ✅ Counselling module
- ✅ Prayer requests

### Staff Account (Operations Access)

To create a staff account, run:
```sql
INSERT INTO users (full_name, email, password, role, phone, is_active, created_at, updated_at)
VALUES (
    'Staff User',
    'staff@test.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'staff',
    '0241234570',
    1,
    NOW(),
    NOW()
);
```

**Credentials:**
```
Email: staff@test.com
Password: password
Role: staff
```

**Staff Features Access:**
- ✅ Create/read members
- ✅ Mark attendance
- ✅ Record transactions
- ✅ Manage equipment
- ✅ Visitor registration
- ✅ Event management
- ✅ Basic reports

---

## 🔐 Quick Account Creation Commands

### Create All Test Accounts at Once

Run this in MySQL or via Tinker:

```sql
-- Admin
INSERT INTO users (full_name, email, password, role, phone, is_active, created_at, updated_at)
VALUES ('Admin User', 'admin@test.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '0241234568', 1, NOW(), NOW());

-- Pastor
INSERT INTO users (full_name, email, password, role, phone, is_active, created_at, updated_at)
VALUES ('Pastor User', 'pastor@test.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pastor', '0241234569', 1, NOW(), NOW());

-- Staff
INSERT INTO users (full_name, email, password, role, phone, is_active, created_at, updated_at)
VALUES ('Staff User', 'staff@test.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', '0241234570', 1, NOW(), NOW());
```

### Or via Artisan Tinker:

```bash
php artisan tinker
```

Then paste:
```php
// Admin
\App\Models\User::create([
    'full_name' => 'Admin User',
    'email' => 'admin@test.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'phone' => '0241234568',
    'is_active' => true,
]);

// Pastor
\App\Models\User::create([
    'full_name' => 'Pastor User',
    'email' => 'pastor@test.com',
    'password' => bcrypt('password'),
    'role' => 'pastor',
    'phone' => '0241234569',
    'is_active' => true,
]);

// Staff
\App\Models\User::create([
    'full_name' => 'Staff User',
    'email' => 'staff@test.com',
    'password' => bcrypt('password'),
    'role' => 'staff',
    'phone' => '0241234570',
    'is_active' => true,
]);
```

---

## 📊 Account Summary

| Role | Email | Password | Phone | Features |
|------|-------|----------|-------|----------|
| **Member** | member@test.com | password | 0241234567 | Mobile app, self-service |
| **Staff** | staff@test.com | password | 0241234570 | Operations, transactions |
| **Pastor** | pastor@test.com | password | 0241234569 | Leadership, approvals |
| **Admin** | admin@test.com | password | 0241234568 | Full system access |

---

## 🧪 Testing Scenarios

### Mobile App Testing

**Login Flow:**
1. Use member@test.com / password
2. Test profile view
3. Test attendance history
4. Test event registration
5. Test mobile giving
6. Test QR code scanning

**Features to Test:**
- [ ] Login/Logout
- [ ] View profile
- [ ] Update profile picture
- [ ] View attendance history
- [ ] View giving history
- [ ] View upcoming events
- [ ] Register for event
- [ ] View ministries
- [ ] Scan QR code (attendance)
- [ ] Mobile giving
- [ ] View announcements

### Web Admin Testing

**Admin Login Flow:**
1. Use admin@test.com / password
2. Test dashboard access
3. Test user management
4. Test QR code generation
5. Test financial approvals

**Features to Test:**
- [ ] Dashboard stats
- [ ] Create QR code
- [ ] Approve transactions
- [ ] Manage users
- [ ] View audit logs
- [ ] Generate reports
- [ ] System settings

---

## 🔒 Security Notes

**IMPORTANT:**
- ⚠️ These are TEST accounts only
- ⚠️ Password is 'password' - NOT secure for production
- ⚠️ Change all passwords before production deployment
- ⚠️ Disable/delete test accounts in production

**For Production:**
```
Use strong passwords like: Xk9$mP2#nQ7@wL5!
- Minimum 12 characters
- Mix of upper/lower case
- Numbers and special characters
- No dictionary words
```

---

## 📱 Mobile API Token Generation

For mobile app API access, generate a token:

```bash
php artisan tinker
```

```php
$user = \App\Models\User::where('email', 'member@test.com')->first();
$token = $user->createToken('mobile-app')->plainTextToken;
echo "API Token: " . $token;
```

Save this token for mobile app testing.

---

## ✅ Verification

Check if accounts exist:

```bash
php artisan tinker
```

```php
\App\Models\User::whereIn('email', [
    'member@test.com',
    'admin@test.com',
    'pastor@test.com',
    'staff@test.com'
])->get(['id', 'full_name', 'email', 'role']);
```

---

## 🆘 Troubleshooting

### Can't Login?

1. **Check account exists:**
   ```sql
   SELECT * FROM users WHERE email = 'member@test.com';
   ```

2. **Check account is active:**
   ```sql
   UPDATE users SET is_active = 1 WHERE email = 'member@test.com';
   ```

3. **Reset password:**
   ```sql
   UPDATE users
   SET password = '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
   WHERE email = 'member@test.com';
   ```

4. **Check role:**
   ```sql
   UPDATE users SET role = 'member' WHERE email = 'member@test.com';
   ```

---

**Document Version:** 1.0
**Last Updated:** December 18, 2024
**Status:** ✅ Test Member Account Active
