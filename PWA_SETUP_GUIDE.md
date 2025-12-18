# 🚀 Church CMS PWA - Setup & Running Guide

**Complete guide to run the Church Management System Progressive Web App**

---

## 📋 TABLE OF CONTENTS

1. [Prerequisites](#prerequisites)
2. [Initial Setup](#initial-setup)
3. [Database Configuration](#database-configuration)
4. [Running the Application](#running-the-application)
5. [Accessing the PWA](#accessing-the-pwa)
6. [Testing PWA Features](#testing-pwa-features)
7. [Troubleshooting](#troubleshooting)

---

## ✅ PREREQUISITES

### Required Software

1. **PHP 8.2 or higher**
   ```bash
   # Check PHP version
   php --version
   ```

2. **Composer** (PHP dependency manager)
   ```bash
   # Check Composer version
   composer --version
   ```

3. **MySQL 8.0 or higher** (or MariaDB)
   ```bash
   # Check MySQL version
   mysql --version
   ```

4. **Node.js 20+ and npm** (for frontend assets)
   ```bash
   # Check Node version
   node --version

   # Check npm version
   npm --version
   ```

5. **Web Server** (Apache, Nginx, or PHP built-in server)
   - If using XAMPP: Apache is included
   - If not: PHP's built-in server works fine for development

---

## 🔧 INITIAL SETUP

### Step 1: Clone/Navigate to Project

Since you're already in the project directory:

```bash
cd C:\xampp\htdocs\church-cms-docs
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

**What this does:**
- Installs Laravel framework
- Installs all backend packages
- Sets up autoloading

**Expected output:**
```
Installing dependencies from lock file
...
Generating optimized autoload files
```

### Step 3: Install Node Dependencies

```bash
npm install
```

**What this does:**
- Installs Tailwind CSS
- Installs Vite (build tool)
- Installs frontend dependencies

**Expected output:**
```
added 200+ packages
```

### Step 4: Environment Configuration

1. **Copy the example environment file:**
   ```bash
   # If .env doesn't exist
   copy .env.example .env
   ```

2. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

3. **Edit the .env file:**

   Open `.env` in a text editor and configure:

   ```env
   # Application
   APP_NAME="Church CMS"
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   # Database
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=church_cms
   DB_USERNAME=root
   DB_PASSWORD=

   # Church Info (Optional)
   CHURCH_NAME="My Church"
   CHURCH_ADDRESS="123 Church Street"
   CHURCH_PHONE="+233XXXXXXXXX"

   # SMS (Optional - can configure later)
   TWILIO_SID=your_twilio_sid
   TWILIO_TOKEN=your_twilio_token
   TWILIO_PHONE=+233XXXXXXXXX
   ```

---

## 🗄️ DATABASE CONFIGURATION

### Step 1: Create Database

**If using XAMPP:**

1. Start XAMPP Control Panel
2. Start MySQL service
3. Open phpMyAdmin (http://localhost/phpmyadmin)
4. Click "New" to create database
5. Database name: `church_cms`
6. Collation: `utf8mb4_unicode_ci`
7. Click "Create"

**If using command line:**

```bash
# Access MySQL
mysql -u root -p

# Create database
CREATE DATABASE church_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Exit
exit;
```

### Step 2: Run Migrations

```bash
php artisan migrate
```

**What this does:**
- Creates all database tables
- Sets up indexes and foreign keys
- Creates 100+ tables for all features

**Expected output:**
```
Migration table created successfully.
Migrating: 2024_01_01_000001_create_users_table
Migrated:  2024_01_01_000001_create_users_table
...
```

### Step 3: Seed Initial Data (Optional)

```bash
php artisan db:seed
```

**What this creates:**
- Admin user account
- Sample data for testing
- Service units
- System settings

**Default Admin Credentials:**
```
Email: admin@church.com
Password: password123
```

⚠️ **IMPORTANT:** Change these credentials after first login!

---

## ▶️ RUNNING THE APPLICATION

### Option 1: PHP Built-in Server (Recommended for Development)

```bash
# Start Laravel server
php artisan serve
```

**Expected output:**
```
Starting Laravel development server: http://127.0.0.1:8000
[Press Ctrl+C to quit]
```

**Access URLs:**
- **Admin Dashboard**: http://localhost:8000/dashboard
- **Mobile PWA**: http://localhost:8000/mobile/login

### Option 2: XAMPP/Apache (Alternative)

**If your project is in XAMPP's htdocs:**

1. **Ensure XAMPP Apache is running**
2. **Create virtual host** (optional but recommended)

   Edit: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

   Add:
   ```apache
   <VirtualHost *:80>
       ServerName church-cms.local
       DocumentRoot "C:/xampp/htdocs/church-cms-docs/public"
       <Directory "C:/xampp/htdocs/church-cms-docs/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

3. **Edit hosts file**

   Edit: `C:\Windows\System32\drivers\etc\hosts`

   Add:
   ```
   127.0.0.1  church-cms.local
   ```

4. **Restart Apache**

5. **Access application:**
   - http://church-cms.local/dashboard
   - http://church-cms.local/mobile/login

### Compile Frontend Assets

**For development (with hot reload):**
```bash
npm run dev
```

**For production:**
```bash
npm run build
```

**What this does:**
- Compiles Tailwind CSS
- Bundles JavaScript
- Optimizes assets
- Generates manifest for PWA

---

## 📱 ACCESSING THE PWA

### Step 1: Open in Browser

**Desktop (for testing):**
```
http://localhost:8000/mobile/login
```

**Mobile Device (same network):**
1. Find your computer's IP address:
   ```bash
   # Windows
   ipconfig
   # Look for IPv4 Address: 192.168.X.X
   ```

2. Access from mobile browser:
   ```
   http://192.168.X.X:8000/mobile/login
   ```

### Step 2: Test Login

**Use the seeded admin account:**
```
Email: admin@church.com
Password: password123
```

Or create a new member account:
1. Click "Register"
2. Follow 3-step registration
3. Enter OTP (check terminal logs for OTP in development)

### Step 3: Install PWA

**On Mobile (iOS/Android):**

**iOS (Safari):**
1. Tap Share button (⬆️)
2. Scroll and tap "Add to Home Screen"
3. Tap "Add"
4. PWA icon appears on home screen

**Android (Chrome):**
1. Tap menu (⋮)
2. Tap "Install app" or "Add to Home Screen"
3. Tap "Install"
4. PWA icon appears on home screen

**Desktop (Chrome/Edge):**
1. Click install icon (⊕) in address bar
2. Click "Install"
3. PWA opens in standalone window

---

## 🧪 TESTING PWA FEATURES

### Test 1: Offline Functionality

1. **Open PWA on mobile device**
2. **Navigate through a few pages** (loads cache)
3. **Turn on Airplane Mode**
4. **Try navigating:**
   - ✅ Pages should still load from cache
   - ✅ Static content visible
   - ⚠️ API calls will show "offline" message

5. **Turn off Airplane Mode:**
   - ✅ Should sync automatically

### Test 2: Check-in Feature

1. **Navigate to Dashboard**
2. **Click "Check In" button**
3. **Select service type**
4. **Confirm check-in**
5. **View in attendance history**

### Test 3: Mobile Giving

1. **Navigate to "Give"**
2. **Enter amount**
3. **Select payment method**
4. **Complete mock payment** (in development mode)
5. **View receipt**

### Test 4: Events Registration

1. **Navigate to "Events"**
2. **Click on an event**
3. **Click "Register"**
4. **Fill registration form**
5. **Submit registration**

### Test 5: Profile Management

1. **Navigate to "Profile"**
2. **Click "Edit Profile"**
3. **Update information**
4. **Upload profile photo** (optional)
5. **Save changes**

---

## 🔐 SECURITY SETUP

### Step 1: Change Default Admin Password

1. Login as admin
2. Go to Profile
3. Change password
4. Logout and login with new password

### Step 2: Configure HTTPS (Production Only)

For production deployment:

1. **Obtain SSL certificate** (Let's Encrypt recommended)
2. **Configure web server** for HTTPS
3. **Update APP_URL** in .env:
   ```env
   APP_URL=https://your-domain.com
   ```
4. **Force HTTPS** in `app/Providers/AppServiceProvider.php`:
   ```php
   public function boot()
   {
       if ($this->app->environment('production')) {
           \URL::forceScheme('https');
       }
   }
   ```

### Step 3: Environment Security

**Production .env settings:**
```env
APP_ENV=production
APP_DEBUG=false
```

---

## 🚨 TROUBLESHOOTING

### Issue 1: "Permission Denied" Errors

**Solution:**
```bash
# Set correct permissions (Linux/Mac)
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Windows - give full control to storage and bootstrap/cache folders
```

### Issue 2: Database Connection Failed

**Check:**
1. MySQL is running
2. Database exists
3. Credentials in .env are correct
4. Port 3306 is not blocked

**Test connection:**
```bash
php artisan tinker
DB::connection()->getPdo();
# Should return PDO object
```

### Issue 3: Assets Not Loading

**Solution:**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Rebuild assets
npm run build

# Restart server
php artisan serve
```

### Issue 4: PWA Not Installing

**Check:**
1. **Served over HTTPS** (production) or localhost (development)
2. **manifest.json accessible**: http://localhost:8000/manifest.json
3. **Service worker registered**: Check browser console
4. **Valid icons** in public directory

**Test manifest:**
```bash
# Should return JSON
curl http://localhost:8000/manifest.json
```

### Issue 5: Mobile Device Can't Access

**Check:**
1. **Same WiFi network** as development machine
2. **Firewall** allows incoming connections on port 8000
3. **Correct IP address** (not 127.0.0.1)

**Allow Laravel through Windows Firewall:**
```bash
# Run as Administrator
netsh advfirewall firewall add rule name="Laravel Dev Server" dir=in action=allow protocol=TCP localport=8000
```

### Issue 6: Service Worker Not Updating

**Solution:**
```bash
# Increment SW version in public/sw.js
const CACHE_VERSION = 'v1.0.1'; // Change version

# Clear browser cache (Ctrl+Shift+R)
# Or unregister service worker in DevTools
```

### Issue 7: API Endpoints Return 404

**Check routes:**
```bash
php artisan route:list --path=mobile
# Should show all mobile routes
```

**If routes missing:**
```bash
php artisan config:cache
php artisan route:cache
php artisan serve
```

---

## 📊 DEVELOPMENT WORKFLOW

### Daily Development

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (hot reload)
npm run dev

# Access application
http://localhost:8000/mobile/login
```

### Before Committing

```bash
# Run linter
npm run lint

# Build for production
npm run build

# Clear caches
php artisan optimize:clear
```

### Database Changes

```bash
# Create migration
php artisan make:migration add_column_to_table

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh install (CAUTION: deletes all data)
php artisan migrate:fresh --seed
```

---

## 🎯 QUICK START CHECKLIST

For first-time setup:

- [ ] Install PHP 8.2+
- [ ] Install Composer
- [ ] Install MySQL
- [ ] Install Node.js 20+
- [ ] Create database `church_cms`
- [ ] Run `composer install`
- [ ] Run `npm install`
- [ ] Copy `.env.example` to `.env`
- [ ] Run `php artisan key:generate`
- [ ] Configure database in `.env`
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan db:seed`
- [ ] Run `npm run build`
- [ ] Run `php artisan serve`
- [ ] Access http://localhost:8000/mobile/login
- [ ] Login with admin@church.com / password123
- [ ] Change admin password
- [ ] Test PWA features
- [ ] Install PWA on mobile device

---

## 🌐 PRODUCTION DEPLOYMENT

### Pre-Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure proper `APP_URL`
- [ ] Setup HTTPS/SSL
- [ ] Configure mail settings
- [ ] Configure SMS settings (Twilio)
- [ ] Setup queue worker (`php artisan queue:work`)
- [ ] Setup task scheduler (cron)
- [ ] Optimize application:
  ```bash
  composer install --optimize-autoloader --no-dev
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  npm run build
  ```
- [ ] Setup backups
- [ ] Configure monitoring
- [ ] Test all features
- [ ] Train users

### Server Requirements

**Minimum:**
- PHP 8.2+
- MySQL 8.0+
- 2GB RAM
- 10GB Storage
- HTTPS support

**Recommended:**
- PHP 8.3+
- MySQL 8.0+
- 4GB RAM
- 20GB Storage
- Redis for caching
- Supervisor for queues

---

## 📞 SUPPORT

### Getting Help

1. **Check logs:**
   ```bash
   # Laravel logs
   tail -f storage/logs/laravel.log

   # Apache logs (if using XAMPP)
   tail -f C:\xampp\apache\logs\error.log
   ```

2. **Enable debug mode** (development only):
   ```env
   APP_DEBUG=true
   ```

3. **Check browser console** for JavaScript errors

4. **Check service worker** status in DevTools → Application → Service Workers

### Common Issues Quick Reference

| Issue | Solution |
|-------|----------|
| White screen | Check storage permissions |
| 500 error | Check logs, clear cache |
| 404 error | Run `php artisan route:cache` |
| DB error | Check .env credentials |
| Assets 404 | Run `npm run build` |
| PWA won't install | Check HTTPS, manifest.json |
| Offline fails | Check service worker registration |

---

## ✅ VERIFICATION

After setup, verify everything works:

```bash
# 1. Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# 2. List routes
php artisan route:list

# 3. Test queue
php artisan queue:work --once

# 4. Check scheduled tasks
php artisan schedule:list

# 5. Clear all caches
php artisan optimize:clear

# 6. View application
php artisan serve
```

Then open browser:
- ✅ http://localhost:8000 - Shows welcome page
- ✅ http://localhost:8000/dashboard - Shows admin dashboard
- ✅ http://localhost:8000/mobile/login - Shows mobile PWA
- ✅ http://localhost:8000/manifest.json - Shows PWA manifest
- ✅ http://localhost:8000/sw.js - Shows service worker

---

## 🎉 YOU'RE READY!

Your Church CMS PWA is now running!

**Next Steps:**
1. Change default admin password
2. Configure church information
3. Add members
4. Test all features
5. Install PWA on mobile devices
6. Collect user feedback
7. Deploy to production when ready

**Happy church management! 🙏**

---

**Document Version**: 1.0
**Last Updated**: December 10, 2024
**Laravel Version**: 10.x
**PWA Status**: 100% Complete ✅
