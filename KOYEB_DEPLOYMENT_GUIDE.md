# 🚀 Koyeb Deployment Guide - Church CMS

Complete guide to deploy your Church CMS to Koyeb from GitHub.

---

## 📋 Prerequisites

- [x] Koyeb account (https://koyeb.com)
- [x] GitHub repository with your code
- [x] **External MySQL database** (PlanetScale, Railway, Aiven, etc.)
  - **IMPORTANT:** Koyeb's database service only supports PostgreSQL
  - You MUST use an external MySQL provider for this Laravel app

---

## 🔧 Step 1: Prepare Your Repository

### 1.1 Commit All Changes

```bash
git add .
git commit -m "feat: Add Koyeb deployment configuration"
git push origin main
```

### 1.2 Required Files for Buildpack Deployment

✅ `Procfile` - Defines how to run your Laravel app (uses Apache)
✅ `.koyeb.yaml` - Koyeb service configuration (optional but recommended)
✅ `composer.json` & `composer.lock` - PHP dependencies

**Note:** Koyeb uses **buildpack** (NOT Docker) for automatic PHP/Laravel detection.

---

## 🗄️ Step 2: Set Up External MySQL Database

**CRITICAL:** Koyeb's managed database service **ONLY supports PostgreSQL**, NOT MySQL.
Since this Laravel app requires MySQL, you **MUST** use an external MySQL provider.

### Recommended External MySQL Providers:

#### Option A: PlanetScale (Recommended - Free Tier Available)
1. Go to https://planetscale.com
2. Create free account
3. Create new database
4. Get connection string (host, username, password)
5. **Benefits:** Serverless, auto-scaling, generous free tier

#### Option B: Railway MySQL
1. Go to https://railway.app
2. Create new project
3. Add MySQL database
4. Copy connection details
5. **Benefits:** Simple setup, good free tier

#### Option C: Aiven MySQL
1. Go to https://aiven.io
2. Create MySQL service
3. Note connection details
4. **Benefits:** Managed, reliable, multiple regions

### Save These Database Credentials:
- Host (e.g., `us-east.connect.psdb.cloud`)
- Port (usually `3306`)
- Database name
- Username
- Password

---

## 🚢 Step 3: Deploy to Koyeb

### 3.1 Create New Service

1. **Login to Koyeb**: https://app.koyeb.com
2. **Click**: "Create Service"
3. **Select**: "GitHub" as source

### 3.2 Configure GitHub Connection

1. **Authorize** Koyeb to access your GitHub
2. **Select** your church-cms repository
3. **Branch**: `main` (or your production branch)

### 3.3 Build Settings

- **Builder**: **Buildpack** (NOT Docker!)
- **Buildpack**: Automatic detection (Koyeb will detect PHP/Laravel)
- **Build command**: Leave as default or use:
  ```
  composer install --no-dev --optimize-autoloader && php artisan config:cache
  ```
- **Run command**: Defined in `Procfile` (auto-detected)

### 3.4 Environment Variables

Click "Add Environment Variable" and add these:

#### Required Variables:

```env
APP_NAME=Church CMS
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.koyeb.app
ASSET_URL=https://your-app-name.koyeb.app  # REQUIRED for CSS/JS loading

# Generate this with: php artisan key:generate --show
APP_KEY=base64:GENERATE_THIS_KEY_LOCALLY

# External MySQL Database (from PlanetScale, Railway, etc.)
DB_CONNECTION=mysql
DB_HOST=us-east.connect.psdb.cloud  # Your external MySQL host
DB_PORT=3306
DB_DATABASE=church_cms
DB_USERNAME=your-mysql-username
DB_PASSWORD=your-mysql-password

# Session & Cache (using database driver for simplicity)
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Production Settings
APP_TIMEZONE=UTC  # or your church timezone
TRUSTED_PROXIES=*  # Required for Koyeb proxy detection

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Mail (for password resets, notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourchurch.com
MAIL_FROM_NAME="Church CMS"

# Asset URL (for proper CSS/JS loading)
ASSET_URL=https://your-app-name.koyeb.app
```

#### Optional - Payment Gateway:

```env
# Paystack (Card Payments)
PAYSTACK_PUBLIC_KEY=pk_live_xxxxxxxxxxxxx
PAYSTACK_SECRET_KEY=sk_live_xxxxxxxxxxxxx

# Hubtel (Ghana Mobile Money)
HUBTEL_CLIENT_ID=xxxxxxxxxxxxx
HUBTEL_CLIENT_SECRET=xxxxxxxxxxxxx
HUBTEL_MERCHANT_ID=xxxxxxxxxxxxx
```

#### Optional - SMS (Twilio):

```env
TWILIO_SID=your-twilio-sid
TWILIO_AUTH_TOKEN=your-twilio-token
TWILIO_PHONE_NUMBER=+1234567890
```

### 3.5 Service Configuration

- **Instance Type**: Nano (for testing) or Small (production)
- **Regions**: Choose closest to your users (e.g., Frankfurt - `fra`)
- **Scaling**:
  - Min instances: 1
  - Max instances: 1 (increase for auto-scaling)
- **Port**: 80 (auto-configured)
- **Health Check Path**: `/`

### 3.6 Deploy!

1. **Click**: "Deploy Service"
2. **Wait**: 5-10 minutes for build and deployment
3. **Monitor**: Check the logs for any errors

---

## ✅ Step 4: Post-Deployment Setup

### 4.1 Verify Deployment

Once deployed, you'll get a URL like: `https://your-app-name.koyeb.app`

**Test:**
1. Visit your URL
2. You should see the Church CMS login page
3. Login with default credentials:
   - Email: `admin@church.com`
   - Password: `admin123`

⚠️ **IMPORTANT**: Change default password immediately!

### 4.2 Update APP_URL

If your assigned URL is different:

1. Go to Koyeb Dashboard → Your Service → Settings
2. Update `APP_URL` environment variable
3. Redeploy the service

### 4.3 Set Up Custom Domain (Optional)

1. **Koyeb Dashboard** → Your Service → Domains
2. **Click**: "Add Domain"
3. **Enter**: your-church.com
4. **Add DNS records** as shown by Koyeb
5. **Wait**: for DNS propagation (5-30 minutes)

### 4.4 Enable HTTPS (Automatic)

Koyeb automatically provides SSL certificates for:
- ✅ `.koyeb.app` domains
- ✅ Custom domains

---

## 🔍 Step 5: Verify Mobile Features

Test all mobile features work on Koyeb:

### 5.1 Visit Mobile App

```
https://your-app-name.koyeb.app/mobile
```

### 5.2 Test Checklist

- [ ] Login works
- [ ] Mobile dashboard shows all 8 icons
- [ ] Check-In feature loads
- [ ] Give/Payment page loads
- [ ] Events page works
- [ ] Equipment Management accessible
- [ ] Service Units accessible
- [ ] Children's Ministry accessible
- [ ] Shepherd Dashboard accessible

### 5.3 Add Test Data

Login to web dashboard and add:
1. **Events** - Create 2-3 test events
2. **Equipment** - Add equipment items
3. **Service Units** - Create and assign units
4. **Children** - Add test child records
5. **Shepherds** - Assign shepherds and flock

---

## 🐛 Troubleshooting

### Issue: "Application Error" or 500 Error

**Check:**
1. **Environment variables** are set correctly
2. **APP_KEY** is generated (not empty)
3. **Database credentials** are correct

**View logs:**
```
Koyeb Dashboard → Your Service → Logs
```

### Issue: Database Connection Failed

**Solutions:**
1. Verify database host/port/credentials
2. Check database is running
3. Ensure database accepts connections from Koyeb IPs
4. Test connection with a MySQL client

### Issue: Assets Not Loading (CSS/JS missing)

**Fix:**
1. Set `ASSET_URL` environment variable
2. Set `APP_URL` to your Koyeb domain
3. Redeploy service

### Issue: Migrations Not Running

**Manual migration:**
1. Koyeb Dashboard → Your Service → Console
2. Run: `php artisan migrate --force`
3. Run: `php artisan db:seed --class=AdminUserSeeder --force`

### Issue: Storage/Cache Errors

**Clear cache:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

**Set permissions:**
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📊 Monitoring & Maintenance

### View Logs

```
Koyeb Dashboard → Your Service → Logs
```

Filter by:
- All logs
- Build logs
- Runtime logs
- Errors only

### Performance Metrics

Monitor in Koyeb Dashboard:
- CPU usage
- Memory usage
- Request count
- Response time

### Auto-Scaling

For high traffic, enable auto-scaling:

```yaml
scaling:
  min: 1
  max: 3  # Scale up to 3 instances
```

---

## 🔄 Continuous Deployment

### Auto-Deploy on Git Push

Koyeb automatically redeploys when you push to your branch!

```bash
# Make changes
git add .
git commit -m "feat: Add new feature"
git push origin main

# Koyeb will automatically detect and redeploy!
```

### Manual Redeploy

If needed:
1. Koyeb Dashboard → Your Service
2. Click "Redeploy"

---

## 💰 Pricing Estimate

### Nano Instance (Testing)
- **Cost**: $0/month (Free tier)
- **Memory**: 512MB RAM
- **CPU**: 0.5 vCPU
- **Good for**: Development/Testing

### Small Instance (Production)
- **Cost**: ~$7/month
- **Memory**: 2GB RAM
- **CPU**: 1 vCPU
- **Good for**: Small churches (100-500 members)

### Medium Instance (High Traffic)
- **Cost**: ~$25/month
- **Memory**: 4GB RAM
- **CPU**: 2 vCPU
- **Good for**: Large churches (500+ members)

**Add-ons:**
- Database (if using Koyeb managed): ~$10/month
- Custom domain: Free
- SSL certificate: Free (automatic)

---

## 🔐 Security Checklist

- [ ] Change default admin password
- [ ] Set strong APP_KEY
- [ ] Set APP_DEBUG=false in production
- [ ] Use strong database password
- [ ] Enable HTTPS (automatic on Koyeb)
- [ ] Regular backups of database
- [ ] Keep Laravel updated
- [ ] Monitor logs for suspicious activity

---

## 📞 Support

### Koyeb Support
- Docs: https://www.koyeb.com/docs
- Discord: https://discord.gg/koyeb
- Email: support@koyeb.com

### Church CMS Issues
- GitHub Issues: Your repository issues page
- Documentation: Check `MOBILE_FEATURES_STATUS.md`

---

## 🎉 Success!

Your Church CMS is now live on Koyeb!

**Next Steps:**
1. ✅ Login and change admin password
2. ✅ Configure payment gateways
3. ✅ Add church members
4. ✅ Set up service units
5. ✅ Train staff on mobile app

**Mobile App URL:**
```
https://your-app-name.koyeb.app/mobile
```

Share this URL with your church members to get started!

---

## 📱 Quick Reference

| Feature | Status | Setup Required |
|---------|--------|----------------|
| Web Dashboard | ✅ Ready | None |
| Mobile App | ✅ Ready | None |
| Authentication | ✅ Ready | None |
| Payments | ⚠️ Needs Config | Add gateway credentials |
| SMS Notifications | ⚠️ Needs Config | Add Twilio credentials |
| Email | ⚠️ Needs Config | Configure SMTP |
| Events | ✅ Ready | Add events via dashboard |
| Check-In | ✅ Ready | None |
| Equipment | ✅ Ready | Add equipment via dashboard |
| Service Units | ✅ Ready | Create units via dashboard |
| Children's Ministry | ✅ Ready | Add children via dashboard |
| Shepherd Dashboard | ✅ Ready | Assign shepherds via dashboard |

**All core features are functional!** Just add your specific data and configure optional services.
