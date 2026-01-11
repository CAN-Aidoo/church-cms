# 🔧 Railway Healthcheck Failure - Troubleshooting Guide

## Issue: "Deployment failed during network process - Healthcheck failure"

This guide addresses the specific error you're seeing in Railway where the healthcheck at `/up` is failing.

---

## ✅ Quick Fix Checklist

### 1. Verify Environment Variables Are Set

In Railway → Your Service → **Variables** tab, ensure these are ALL set:

#### CRITICAL Variables (must be set):
```env
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_ENV=production
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}
ASSET_URL=${{RAILWAY_PUBLIC_DOMAIN}}
```

#### Database Variables (must use Railway references):
```env
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}
```

**Common mistake:** Using `${{MySQL.MYSQLHOST}}` instead of `${{MYSQLHOST}}`

---

### 2. Verify MySQL Service Is Linked

1. Railway → Your Project
2. You should see TWO services:
   - `church-cms` (your app)
   - `MySQL` (database)
3. The MySQL service should show **"Online"** (green dot)
4. If not linked, click MySQL → **Connect** → Link to your app service

---

### 3. Generate and Set APP_KEY

If you haven't set `APP_KEY`, the app WILL fail:

```bash
# On your local machine:
cd C:\xampp\htdocs\church-cms-docs
php artisan key:generate --show
```

Copy the output (including `base64:`) and set it in Railway Variables as `APP_KEY`.

---

### 4. Check Deployment Logs

Railway → Your Service → **Deployments** → Click the failed deployment → **View logs**

Look for these indicators:

#### ✅ Good signs (should see these):
```
Church CMS - Railway Startup
Environment check:
- PORT: 8080 (or another number)
- APP_ENV: production
- DB_HOST: (should show a host, not NOT_SET)
Creating storage directories...
Database connected successfully!
Starting Laravel server...
```

#### ❌ Bad signs (problems to fix):
```
- PORT: NOT_SET
- APP_ENV: NOT_SET
- DB_HOST: NOT_SET
```
→ **Fix:** Set environment variables in Railway

```
WARNING: Could not connect to database
```
→ **Fix:** Check MySQL service is running and variables are correct

```
SQLSTATE[HY000] [1045] Access denied
```
→ **Fix:** Database credentials are wrong, verify `${{MYSQLUSER}}` and `${{MYSQLPASSWORD}}`

```
SQLSTATE[HY000] [2002] Connection refused
```
→ **Fix:** MySQL service not running or `DB_HOST` is wrong

---

## 🔍 Step-by-Step Debugging

### Step 1: Check Variables Are Injected

1. Railway → church-cms service → **Variables**
2. Look at the "Raw Editor" view
3. Verify you see Railway's auto-injected variables:
   ```
   MYSQLHOST=...
   MYSQLPORT=3306
   MYSQLDATABASE=railway
   MYSQLUSER=root
   MYSQLPASSWORD=...
   ```

If you DON'T see these:
- Your MySQL service isn't properly linked
- Go to MySQL service → **Connect** → Select your app

### Step 2: Check Build Succeeds

The build should succeed (you showed it does in your screenshot ✓):
- Initialization ✓
- Build ✓
- Deploy ✓

If build fails, check:
- `composer.json` is valid
- `package.json` is valid
- All files are committed to GitHub

### Step 3: Check Server Starts

In deployment logs, you should see:
```
Starting Laravel server...
PORT: 8080
```

If you see this but healthcheck still fails:
- The server is starting but crashing after
- Check for PHP errors in the logs
- Verify `APP_KEY` is set

### Step 4: Manual Healthcheck Test

After fixing variables and redeploying:

1. Wait for deployment to complete
2. Get your Railway URL (looks like: `church-cms-production-09ee.up.railway.app`)
3. Open browser: `https://[your-url]/up`
4. Should see: **"OK"**

If you get:
- **502 Bad Gateway** → Server didn't start
- **504 Gateway Timeout** → Server is hanging
- **Connection refused** → Server crashed

---

## 🛠️ Common Fixes

### Fix 1: APP_KEY Not Set

**Symptom:** Logs show encryption errors or "APP_KEY not set"

**Solution:**
```bash
php artisan key:generate --show
```
Copy output to Railway Variables as `APP_KEY`

---

### Fix 2: Database Variables Not Set Correctly

**Symptom:** Logs show "DB_HOST: NOT_SET" or database connection errors

**Solution in Railway Variables:**
```env
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}
```

**NOT:**
```env
DB_HOST=${{MySQL.MYSQLHOST}}  # ❌ WRONG
DB_HOST=mysql  # ❌ WRONG
DB_HOST=127.0.0.1  # ❌ WRONG
```

---

### Fix 3: MySQL Service Not Running

**Symptom:** MySQL shows "Crashed" or "Stopped"

**Solution:**
1. Railway → MySQL service
2. Click **Restart**
3. Wait for "Online" status
4. Redeploy your app

---

### Fix 4: PORT Variable Missing

**Symptom:** Logs show "PORT: NOT_SET"

**Solution:**
Railway should auto-inject `PORT`. If not:
1. Check Railway service is set to "Web"
2. Redeploy
3. If still missing, manually add: `PORT=8080`

---

## 🚀 After Fixing - Redeploy

Once you've fixed the issues:

### Option A: Automatic Redeploy (if using GitHub)
```bash
git push origin master
# Railway automatically redeploys
```

### Option B: Manual Redeploy
1. Railway → Your Service
2. Click **Deployments** tab
3. Click **Deploy** button (top right)
4. Select latest commit
5. Watch logs for success

---

## ✅ Success Indicators

When deployment succeeds, you'll see:

1. **Deployment Status:** "Deployed" (not "Failed")
2. **Healthcheck:** ✓ passed (not ✗ failed)
3. **Logs show:**
   ```
   Database connected successfully!
   Migrations completed successfully!
   Starting Laravel server...
   PORT: 8080
   ```
4. **Can access your app:** `https://[your-app].up.railway.app`
5. **Can access healthcheck:** `https://[your-app].up.railway.app/up` shows "OK"

---

## 📞 Still Having Issues?

### Check These:

1. **Is APP_KEY exactly as generated?** (including `base64:` prefix)
2. **Are database variables using `${{MYSQLHOST}}` syntax?** (not MySQL.MYSQLHOST)
3. **Is MySQL service showing "Online"?**
4. **Did you link MySQL to your app?**
5. **Are you using Railway references, not hardcoded values?**

### Get More Help:

1. Check Railway logs in detail (copy full logs)
2. Railway Discord: https://discord.gg/railway
3. Railway Support: support@railway.app

---

## 📝 Quick Reference: Required Variables

Copy this to Railway Variables (customize values):

```env
# App Core
APP_NAME=Church CMS
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY_FROM_ARTISAN_GENERATE
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}
ASSET_URL=${{RAILWAY_PUBLIC_DOMAIN}}

# Database (use Railway references)
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Production
APP_TIMEZONE=UTC
TRUSTED_PROXIES=*
LOG_CHANNEL=stack
LOG_LEVEL=error
```

---

**Last Updated:** After fixing healthcheck hanging issues in start.sh

**Next:** After fixing, push to GitHub and watch Railway automatically deploy successfully! 🎉
