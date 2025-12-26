# Railway Database Setup - Complete ✅

## Problem Solved
Your Church CMS was failing to connect to the database because the MySQL service wasn't linked to the web service.

## What Was Fixed

### 1. Database Status ✅
- **MySQL Database**: Already provisioned in Railway
- **Database Name**: `railway`
- **Host**: `mysql.railway.internal`
- **Port**: `3306`
- **User**: `root`

### 2. Environment Variables Linked ✅
Connected the MySQL service to your web service by setting these variables:

```bash
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}        # → mysql.railway.internal
DB_PORT=${{MySQL.MYSQLPORT}}        # → 3306
DB_DATABASE=${{MySQL.MYSQLDATABASE}} # → railway
DB_USERNAME=${{MySQL.MYSQLUSER}}    # → root
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}} # → (secure password)
```

### 3. Current Railway Configuration

**Project**: alluring-reflection
**Environment**: production
**Services**:
- `web` - Your Laravel application
- `MySQL` - Database service

**Public URL**: https://sonlifecms.up.railway.app

---

## Next Steps to Complete Deployment

### Option 1: Trigger Deployment via Git (Recommended)

```bash
# Make a small change to trigger deployment
git commit --allow-empty -m "Trigger deployment with database connection"
git push origin master
```

### Option 2: Redeploy in Railway Dashboard

1. Go to https://railway.app/dashboard
2. Open your project "alluring-reflection"
3. Click on the "web" service
4. Click "Deploy" → "Redeploy"

### Option 3: Use Railway CLI

```bash
railway up
```

---

## What Happens During Deployment

When you deploy, Railway will:

1. **Build Phase** (from `railway.json`):
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan config:cache
   php artisan route:cache
   ```

2. **Start Phase** (migrations run here):
   ```bash
   php artisan migrate --force        # ← Database migrations
   php artisan storage:link
   php artisan serve --host=0.0.0.0 --port=$PORT
   ```

---

## Verification Checklist

After deployment completes, verify everything works:

### 1. Check Deployment Logs
```bash
railway logs
```

Look for:
- ✅ "Migration table created successfully"
- ✅ "Migrated: [migration files]"
- ✅ "Server started on [PORT]"

### 2. Test Database Connection

Visit your app at: https://sonlifecms.up.railway.app

Try to:
- [ ] Access the login page
- [ ] Create a test account (if registration is enabled)
- [ ] Log in with admin credentials
- [ ] View dashboard

### 3. Verify Tables Created

Check if tables exist:
```bash
railway connect MySQL
```

Then in MySQL shell:
```sql
USE railway;
SHOW TABLES;
DESCRIBE users;
EXIT;
```

Expected tables:
- users
- roles
- permissions
- members
- attendance
- programs
- finance_transactions
- etc.

---

## Common Issues & Solutions

### Issue 1: "No migration files found"

**Solution**: Ensure migrations exist in `database/migrations/`

```bash
ls database/migrations/
```

### Issue 2: "SQLSTATE[42000]: Syntax error"

**Solution**: Check migration files for syntax errors

```bash
php artisan migrate --pretend  # (run locally to test)
```

### Issue 3: "Table already exists"

**Solution**: Reset migrations (⚠️ This deletes data!)

```bash
railway run php artisan migrate:fresh --force  # ← Won't work from local
```

Instead, connect to MySQL and drop tables manually:
```bash
railway connect MySQL
DROP DATABASE railway;
CREATE DATABASE railway;
EXIT;
```

Then redeploy to run migrations fresh.

### Issue 4: Deployment Stuck/Failed

**Solution**: Check logs for errors

```bash
railway logs --error
```

Common causes:
- Missing environment variables
- PHP version mismatch
- Composer dependency issues

---

## Environment Variables Reference

### Required for Database
```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

### Required for Laravel
```env
APP_NAME="Church CMS"
APP_ENV=production
APP_KEY=base64:... (your key)
APP_DEBUG=false
APP_URL=https://sonlifecms.up.railway.app
```

### Recommended Settings
```env
# Logging
LOG_LEVEL=error
LOG_CHANNEL=stack

# Sessions & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Security
FILESYSTEM_DISK=public
BROADCAST_DRIVER=log
```

---

## Useful Railway Commands

### View Current Configuration
```bash
railway status                    # Check project status
railway variables                 # List all variables
railway variables --service MySQL # MySQL variables only
```

### Deployment Commands
```bash
railway up                        # Deploy current code
railway logs                      # View deployment logs
railway logs --follow             # Stream logs in real-time
```

### Database Commands
```bash
railway connect MySQL             # Connect to MySQL shell
railway run php artisan tinker    # Laravel Tinker (won't work)
```

**Note**: `railway run` executes locally, so database commands won't work because `mysql.railway.internal` is only accessible within Railway's network.

---

## Database Connection Details

### Internal Connection (from web service)
```
Host: mysql.railway.internal
Port: 3306
Database: railway
User: root
Password: gxztDifsESEuvHZZsPCxAsFYAsPQtFFz
```

### External Connection (from your computer)
```
Host: interchange.proxy.rlwy.net
Port: 19569
Database: railway
User: root
Password: gxztDifsESEuvHZZsPCxAsFYAsPQtFFz
```

**Connection String**:
```
mysql://root:gxztDifsESEuvHZZsPCxAsFYAsPQtFFz@interchange.proxy.rlwy.net:19569/railway
```

Use this to connect from tools like:
- MySQL Workbench
- TablePlus
- DBeaver
- phpMyAdmin

---

## Security Recommendations

### 1. Update APP_URL
```bash
railway variables --set APP_URL="https://sonlifecms.up.railway.app"
```

### 2. Disable Debug Mode
```bash
railway variables --set APP_DEBUG="false"
railway variables --set LOG_LEVEL="error"
```

### 3. Add Custom Domain (Optional)

1. Go to Railway Dashboard → web service → Settings
2. Click "Generate Domain" or "Add Custom Domain"
3. Update `APP_URL` to match your domain

---

## Ready to Deploy! 🚀

Choose your deployment method above and watch the magic happen!

**After deployment**: Check the logs to confirm migrations ran successfully.

```bash
railway logs
```

Look for: ✅ "Migration table created successfully"
