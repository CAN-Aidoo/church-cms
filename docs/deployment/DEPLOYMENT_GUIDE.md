# Sonlife Church CMS - Render Deployment Guide

Complete guide for deploying to Render.

---

## Prerequisites

- GitHub account with this repository pushed
- Render account (https://render.com)
- External MySQL database (PlanetScale, Railway, or other provider)

> **Note**: Render natively supports PostgreSQL. For MySQL, you'll need an external provider.

---

## Quick Deploy with render.yaml

The easiest way to deploy is using the included `render.yaml` blueprint:

1. Push your code to GitHub
2. Go to https://dashboard.render.com
3. Click **New** > **Blueprint**
4. Connect your GitHub repository
5. Render will detect `render.yaml` and create your service
6. Fill in the secret environment variables when prompted

---

## Manual Deployment Steps

### Step 1: Push to GitHub

```bash
git add .
git commit -m "Ready for Render deployment"
git push origin master
```

### Step 2: Set Up MySQL Database

Since Render doesn't have native MySQL, use one of these providers:

**Option A: PlanetScale (Recommended - Free tier available)**
1. Go to https://planetscale.com
2. Create a database
3. Get your connection credentials

**Option B: Railway**
1. Go to https://railway.app
2. Create a new MySQL database
3. Get your connection credentials

**Option C: Other MySQL providers**
- Aiven, DigitalOcean, AWS RDS, etc.

### Step 3: Create Web Service on Render

1. Go to https://dashboard.render.com
2. Click **New** > **Web Service**
3. Connect your GitHub repository
4. Configure:
   - **Name**: `church-cms`
   - **Runtime**: `PHP`
   - **Build Command**:
     ```bash
     composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link || true
     ```
   - **Start Command**:
     ```bash
     php artisan serve --host=0.0.0.0 --port=$PORT
     ```

### Step 4: Configure Environment Variables

In your web service > **Environment** tab, add these variables:

#### Required Variables

| Variable | Value | Notes |
|----------|-------|-------|
| `APP_NAME` | `Sonlife Church CMS` | |
| `APP_ENV` | `production` | |
| `APP_DEBUG` | `false` | |
| `APP_KEY` | `base64:...` | Generate with `php artisan key:generate --show` |
| `APP_URL` | `https://church-cms.onrender.com` | Your Render URL |

#### Database Variables

| Variable | Value | Notes |
|----------|-------|-------|
| `DB_CONNECTION` | `mysql` | |
| `DB_HOST` | Your database host | From your MySQL provider |
| `DB_PORT` | `3306` | |
| `DB_DATABASE` | Your database name | |
| `DB_USERNAME` | Your database user | |
| `DB_PASSWORD` | Your database password | |

#### Session & Cache Variables

| Variable | Value |
|----------|-------|
| `SESSION_DRIVER` | `database` |
| `CACHE_DRIVER` | `database` |
| `QUEUE_CONNECTION` | `database` |

#### Logging Variables

| Variable | Value | Notes |
|----------|-------|-------|
| `LOG_CHANNEL` | `stderr` | Required for Render logs |
| `LOG_LEVEL` | `error` | Or `warning` for more detail |

#### Mail Variables (Optional)

| Variable | Value |
|----------|-------|
| `MAIL_MAILER` | `smtp` |
| `MAIL_HOST` | Your SMTP host |
| `MAIL_PORT` | `587` |
| `MAIL_USERNAME` | Your SMTP username |
| `MAIL_PASSWORD` | Your SMTP password |
| `MAIL_ENCRYPTION` | `tls` |
| `MAIL_FROM_ADDRESS` | `noreply@yourchurch.com` |
| `MAIL_FROM_NAME` | `Sonlife Church` |

### Step 5: Deploy

1. Click **Create Web Service**
2. Wait for the build to complete (5-10 minutes first time)
3. Check the logs for any errors

### Step 6: Run Migrations

After the first successful deployment:

**Option A: Using Render Shell**
1. Go to your service > **Shell** tab
2. Run:
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=AdminUserSeeder --force
   ```

**Option B: One-time Job**
1. Go to **New** > **Job**
2. Connect same repository
3. Set command: `php artisan migrate --force && php artisan db:seed --force`
4. Run once and delete

### Step 7: Verify Deployment

1. Visit your app URL: `https://church-cms.onrender.com`
2. Test login at `/login`
3. Test mobile interface at `/mobile`

---

## Default Admin Credentials

After seeding, login with:
- **Email**: `admin@sonlifechurch.com`
- **Password**: `password`

> **Important**: Change this password immediately after first login!

---

## Custom Domain Setup

1. Go to your service > **Settings**
2. Scroll to **Custom Domains**
3. Click **Add Custom Domain**
4. Enter your domain (e.g., `cms.yourchurch.com`)
5. Add the DNS records shown to your domain provider
6. Wait for SSL certificate provisioning

---

## Automatic Deployments

By default, Render auto-deploys when you push to your connected branch.

To disable:
1. Go to **Settings** > **Build & Deploy**
2. Toggle off **Auto-Deploy**

---

## Environment-Specific Notes

### Free Tier Limitations

- Service spins down after 15 minutes of inactivity
- Cold starts take 30-60 seconds
- 750 hours/month of free usage

### Upgrading for Production

For production use, consider:
- **Starter plan** ($7/month): Always-on, no spin-down
- **Standard plan** ($25/month): More resources, better performance

---

## Troubleshooting

### Build Fails

**Check:**
- `composer.json` and `package.json` are committed
- No syntax errors in PHP files
- Check build logs for specific errors

**Common fixes:**
```bash
# Locally, run:
composer install
npm install
npm run build
# Fix any errors before pushing
```

### 500 Server Error

**Check:**
- `APP_KEY` is set correctly
- Database credentials are correct
- Run `php artisan config:clear` in Render shell

**View logs:**
1. Go to service > **Logs** tab
2. Look for PHP errors

### Database Connection Errors

**Check:**
- Database allows external connections
- Credentials are correct
- SSL mode if required (add `?sslmode=require` to connection)

For PlanetScale, add to your `.env`:
```
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
```

### Slow Performance / Timeouts

**For free tier:**
- First request after inactivity will be slow (cold start)
- Consider upgrading to Starter plan for production

**For all tiers:**
- Enable caching in production
- Optimize database queries
- Check for N+1 queries in logs

### Storage/File Upload Issues

Render uses ephemeral storage. For persistent file storage:
1. Use a cloud storage provider (AWS S3, Cloudflare R2)
2. Update `FILESYSTEM_DISK` to `s3`
3. Add S3 credentials to environment

---

## Useful Commands

Run these in Render Shell:

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Re-cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Check application status
php artisan about

# View logs
php artisan log:tail
```

---

## Support Resources

- **Render Docs**: https://render.com/docs
- **Laravel Docs**: https://laravel.com/docs
- **PlanetScale Docs**: https://planetscale.com/docs
