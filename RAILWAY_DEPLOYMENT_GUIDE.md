# 🚂 Railway Deployment Guide - Church CMS

Complete guide to deploy your Church CMS to Railway from GitHub with MySQL database.

---

## 📋 Prerequisites

- [x] Railway account (https://railway.app)
- [x] GitHub repository with your code
- [x] Railway project created

---

## ✅ Why Railway is Better for This Project

- ✅ **Native MySQL Support** - No need for external database
- ✅ **Free Tier** - $5 free credit monthly
- ✅ **Automatic SSL** - HTTPS out of the box
- ✅ **Simple Setup** - One-click MySQL deployment
- ✅ **Great for Laravel** - Built-in PHP/Node.js support

---

## 🚀 Step 1: Create Railway Project

### 1.1 Create New Project

1. Go to https://railway.app
2. Sign in with GitHub
3. Click **"New Project"**
4. Select **"Deploy from GitHub repo"**
5. Choose your `church-cms-docs` repository
6. Railway will detect it as a PHP/Laravel project

### 1.2 Add MySQL Database

1. In your Railway project dashboard
2. Click **"+ New"** → **"Database"** → **"Add MySQL"**
3. Railway automatically creates a MySQL database
4. Database credentials are auto-injected as environment variables:
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

---

## 🔧 Step 2: Configure Environment Variables

Railway automatically provides MySQL variables, but you need to add Laravel-specific ones.

### 2.1 Click on Your Web Service → Variables Tab

Add these variables:

#### Essential Laravel Variables:

```env
# App Configuration
APP_NAME=Church CMS
APP_ENV=production
APP_DEBUG=false

# IMPORTANT: Generate this locally first!
# Run: php artisan key:generate --show
APP_KEY=base64:YOUR_GENERATED_KEY_HERE

# URLs (Railway provides PUBLIC_URL automatically)
# Set these after first deployment when you get your Railway URL
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}
ASSET_URL=${{RAILWAY_PUBLIC_DOMAIN}}

# Database - Use Railway's provided variables
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

# Session & Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Production Settings
APP_TIMEZONE=UTC
TRUSTED_PROXIES=*
LOG_CHANNEL=stack
LOG_LEVEL=error
```

#### Optional Variables (Payment Gateways):

```env
# Paystack (Card Payments)
PAYSTACK_PUBLIC_KEY=pk_live_xxxxxxxxxxxxx
PAYSTACK_SECRET_KEY=sk_live_xxxxxxxxxxxxx

# Hubtel (Ghana Mobile Money)
HUBTEL_CLIENT_ID=xxxxxxxxxxxxx
HUBTEL_CLIENT_SECRET=xxxxxxxxxxxxx
HUBTEL_MERCHANT_ID=xxxxxxxxxxxxx

# Twilio (SMS)
TWILIO_SID=xxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=xxxxxxxxxxxxx
TWILIO_PHONE_NUMBER=+1234567890
```

---

## 📝 Step 3: Generate APP_KEY Locally

**CRITICAL:** You MUST generate APP_KEY locally before deploying.

### On Your Local Machine:

```bash
# Navigate to your project
cd C:\xampp\htdocs\church-cms-docs

# Generate the key
php artisan key:generate --show
```

Copy the output (looks like `base64:xxxxxxxxxxxxxxx`) and add it to Railway variables as `APP_KEY`.

---

## 🔄 Step 4: Deploy

### 4.1 Automatic Deployment

Railway automatically deploys when you push to GitHub!

```bash
# Commit any changes
git add .
git commit -m "chore: Configure for Railway deployment"
git push origin master
```

Railway will:
1. ✅ Detect your repository changes
2. ✅ Build using Nixpacks (reads `nixpacks.toml`)
3. ✅ Install Composer dependencies
4. ✅ Install NPM dependencies
5. ✅ Build frontend assets
6. ✅ Run `start.sh` startup script
7. ✅ Run database migrations automatically
8. ✅ Start Laravel server

### 4.2 Watch the Build Logs

1. Go to your Railway project
2. Click on the web service
3. Click **"Deployments"** tab
4. Watch the build logs in real-time

---

## ✅ Step 5: Verify Deployment

### 5.1 Test the Application

Visit your Railway URL and check:

- [ ] ✅ Homepage loads without errors
- [ ] ✅ CSS and JavaScript load correctly
- [ ] ✅ Login page works
- [ ] ✅ Can login with admin credentials (check logs for seeded password)
- [ ] ✅ Dashboard loads
- [ ] ✅ Mobile app accessible at `/mobile`

### 5.2 Check Default Admin Credentials

Look in Railway logs for:
```
Admin user created: admin@church.local
Password: [generated-password]
```

**IMPORTANT:** Change this password immediately after first login!

---

## 🔐 Step 6: Security Checklist

After deployment:

- [ ] Change default admin password
- [ ] Verify `APP_DEBUG=false`
- [ ] Verify `APP_ENV=production`
- [ ] Check SSL/HTTPS is working (automatic on Railway)
- [ ] Test payment gateways with test credentials first
- [ ] Set up database backups (Railway Settings → Backups)

---

## 🎯 Step 7: Custom Domain (Optional)

### 7.1 Add Custom Domain

1. Railway service → **Settings** → **Domains**
2. Click **"Add Domain"**
3. Enter your domain: `churchapp.com`
4. Follow Railway's DNS setup instructions

### 7.2 Update Environment Variables

```env
APP_URL=https://churchapp.com
ASSET_URL=https://churchapp.com
```

---

## 🛠️ Troubleshooting

### Build Fails

**Check:**
- `composer.json` and `composer.lock` are committed
- `package.json` and `package-lock.json` are committed
- `nixpacks.toml` exists in repository
- Build logs for specific errors

### Database Connection Errors

**Check:**
- MySQL service is running in Railway
- Railway's MySQL variables are injected correctly
- DB_HOST uses `${{MYSQLHOST}}` not hardcoded value
- Database has been created

### 500 Errors After Deploy

**Check:**
- APP_KEY is set correctly
- APP_DEBUG=false
- Check Railway logs: Service → Logs
- Storage directories have correct permissions (handled by start.sh)

### Assets Not Loading (CSS/JS)

**Check:**
- ASSET_URL is set to `${{RAILWAY_PUBLIC_DOMAIN}}`
- APP_URL matches ASSET_URL
- `npm run build` succeeded in build logs
- `public/build` directory exists

### Migrations Failed

**Check logs:**
```bash
# Railway automatically runs migrations in start.sh
# Check deployment logs for migration errors
```

**Manual migration (if needed):**
1. Railway service → Settings
2. Add one-time command: `php artisan migrate --force`

---

## 📊 Monitoring Your App

### View Logs

Railway → Your service → **Logs** tab

Real-time logs show:
- Application errors
- Database queries (if LOG_LEVEL=debug)
- Request/response cycles

### Resource Usage

Railway → Your service → **Metrics** tab

Monitor:
- CPU usage
- Memory usage
- Network traffic
- Request volume

---

## 💰 Railway Pricing

### Free Tier ($5/month credit)
- Perfect for testing and small churches
- Includes:
  - 512 MB RAM
  - Shared CPU
  - MySQL database

### Hobby Plan ($5/month + usage)
- For production use
- Includes:
  - Better performance
  - More resources
  - Usage-based pricing

---

## 🔄 Redeploying After Changes

### Automatic Redeployment

```bash
# Make your changes
git add .
git commit -m "feat: Add new feature"
git push origin master

# Railway automatically redeploys!
```

### Manual Redeployment

Railway → Your service → **Deployments** → **Deploy** (top right)

---

## 📁 Important Files for Railway

These files in your repository configure Railway deployment:

### `railway.json`
- Defines build and deploy configuration
- Specifies Nixpacks builder
- Sets healthcheck endpoint

### `nixpacks.toml`
- Configures PHP version and extensions
- Sets up Node.js for asset building
- Defines build phases

### `start.sh`
- Startup script that runs on deploy
- Creates directories and sets permissions
- Runs migrations automatically
- Starts Laravel server

---

## 🎓 Next Steps

After successful deployment:

1. **Add Test Data**
   - Create test members
   - Create test events
   - Test check-in flow

2. **Configure Payment Gateways**
   - Add Paystack credentials (test mode first)
   - Add Hubtel credentials (test mode first)
   - Test small transactions

3. **Set Up SMS (Optional)**
   - Add Twilio credentials
   - Test SMS sending

4. **User Training**
   - Train staff on web dashboard
   - Create mobile app tutorial
   - Share mobile URL with congregation

5. **Backup Strategy**
   - Enable Railway database backups
   - Test restore process
   - Document backup procedures

---

## 🆘 Getting Help

### Railway Support
- Documentation: https://docs.railway.app
- Discord: https://discord.gg/railway
- Twitter: @railway

### Laravel Support
- Documentation: https://laravel.com/docs
- Forums: https://laracasts.com/discuss

---

## ✅ Deployment Complete!

Your Church CMS is now live on Railway! 🎉

**Your app is accessible at:** `https://[your-app].up.railway.app`

**Admin login:**
- URL: `https://[your-app].up.railway.app/login`
- Email: Check Railway logs for admin credentials
- **Don't forget to change the password!**

---

**Built with Laravel • Deployed on Railway • Made with ❤️ for your church**
