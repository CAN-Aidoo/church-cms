# Railway Deployment Guide for Church CMS

This guide walks you through deploying the Church CMS Laravel application to Railway.

## Prerequisites

- A [Railway](https://railway.app) account
- Git repository connected to Railway
- PHP application key (generate with `php artisan key:generate --show`)

## Quick Deployment Steps

### 1. Create Railway Project

1. Log in to Railway and click **New Project**
2. Select **Deploy from GitHub repo** and authorize Railway
3. Choose this repository

### 2. Add MySQL Database

1. In your Railway project, click **New** → **Database** → **MySQL**
2. Railway will automatically provision a MySQL instance
3. Link the MySQL service to your app

### 3. Configure Environment Variables

In your app's **Variables** tab, add these required variables:

| Variable | Value | Notes |
|----------|-------|-------|
| `APP_ENV` | `production` | Required |
| `APP_KEY` | `base64:...` | Generate with `php artisan key:generate --show` |
| `APP_DEBUG` | `false` | Required for production |
| `APP_URL` | `https://your-app.up.railway.app` | Replace with your Railway URL |
| `ASSET_URL` | `https://your-app.up.railway.app` | Same as APP_URL |
| `LOG_LEVEL` | `error` | Recommended for production |

### 4. Database Variables (Auto-Injected)

When you link the MySQL service, Railway automatically provides these variables. You need to map them in your variables:

```
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

Or use Railway's reference syntax directly in the Variables section.

### 5. Optional Variables

| Variable | Description |
|----------|-------------|
| `TWILIO_SID` | Twilio Account SID (for SMS) |
| `TWILIO_AUTH_TOKEN` | Twilio Auth Token |
| `TWILIO_PHONE_NUMBER` | Twilio phone number |
| `PAYSTACK_SECRET_KEY` | Paystack secret key (for payments) |
| `HUBTEL_CLIENT_ID` | Hubtel client ID (for mobile money) |

## Build & Deployment

Railway uses **Nixpacks** to build your app. The configuration is in `nixpacks.toml`:

- Installs PHP 8.2 with required extensions
- Runs `composer install`
- Caches Laravel config and routes
- Builds frontend assets with `npm run build`

The start command in `railway.json`:
- Creates required storage directories
- Runs database migrations
- Seeds the admin user
- Creates storage symlink
- Starts the Laravel development server

## Verifying Deployment

1. Go to your Railway project dashboard
2. Click on the deployed service
3. Check the **Deployments** tab for build logs
4. If successful, click the public URL to access your app

### Default Admin Credentials

After first deployment:
- **Email:** `admin@church.com`  
- **Password:** `password123`

> ⚠️ **Important:** Change these credentials immediately after first login!

## Troubleshooting

### Build Fails with "APP_KEY not set"

Make sure you've added the `APP_KEY` environment variable:
```bash
php artisan key:generate --show
```
Copy the output (including `base64:`) to Railway variables.

### Database Connection Failed

1. Ensure MySQL service is linked to your app
2. Verify database variables are correctly mapped
3. Check that `DB_CONNECTION=mysql` is set

### Assets Not Loading (CSS/JS missing)

Set `ASSET_URL` to match your Railway public URL:
```
ASSET_URL=https://your-app.up.railway.app
```

### Storage Permission Errors

The start command automatically creates and sets permissions for storage directories. If issues persist, check the deployment logs for errors.

## Useful Railway CLI Commands

```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link local project
railway link

# View logs
railway logs

# Open shell
railway run bash
```

## Configuration Files

| File | Purpose |
|------|---------|
| `railway.json` | Railway-specific build and start commands |
| `nixpacks.toml` | Nixpacks build configuration |
| `Procfile` | Process definition (fallback) |
| `Dockerfile` | Docker build (alternative deployment method) |

## Need Help?

- [Railway Documentation](https://docs.railway.app/)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- Check `DEPLOYMENT_CHECKLIST.md` for general deployment steps
