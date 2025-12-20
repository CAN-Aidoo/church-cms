# Church CMS - Production Deployment Guide

## 🚀 Deployment to Railway.app with Free Domain

This guide will walk you through deploying your Church CMS to production using Railway.app (free tier) and connecting a free custom domain from Freenom.

---

## Prerequisites

- Git installed on your computer
- GitHub account
- Railway.app account (sign up at https://railway.app)
- Freenom account (for free domain at https://freenom.com)

---

## Step 1: Prepare Your Application

### 1.1 Update Environment Configuration

The application is already configured for production. Key files created:
- `Procfile` - Process configuration
- `railway.json` - Railway deployment settings
- `nixpacks.toml` - Build configuration

### 1.2 Set APP_KEY

Make sure your `.env` file has an APP_KEY. If not, generate one:

```bash
php artisan key:generate
```

Copy this key - you'll need it for production environment variables.

---

## Step 2: Push to GitHub

### 2.1 Initialize Git Repository (if not done)

```bash
cd C:\xampp\htdocs\church-cms-docs
git init
git add .
git commit -m "Initial commit - Church CMS ready for deployment"
```

### 2.2 Create GitHub Repository

1. Go to https://github.com/new
2. Create a new repository named `church-cms`
3. Don't initialize with README (we already have files)
4. Copy the repository URL

### 2.3 Push to GitHub

```bash
git remote add origin https://github.com/YOUR_USERNAME/church-cms.git
git branch -M main
git push -u origin main
```

---

## Step 3: Deploy to Railway.app

### 3.1 Sign Up for Railway

1. Go to https://railway.app
2. Click "Login" → Sign in with GitHub
3. Authorize Railway to access your GitHub account

### 3.2 Create New Project

1. Click "New Project"
2. Select "Deploy from GitHub repo"
3. Choose your `church-cms` repository
4. Railway will automatically detect it's a Laravel app

### 3.3 Add MySQL Database

1. In your Railway project, click "+ New"
2. Select "Database" → "Add MySQL"
3. Railway will provision a MySQL database
4. Database credentials will be automatically available as environment variables

### 3.4 Configure Environment Variables

Click on your web service → "Variables" tab → Add the following:

```env
APP_NAME="Church CMS"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_DRIVER=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@churchcms.com
MAIL_FROM_NAME="${APP_NAME}"

# SMS Configuration (Optional - configure later)
TWILIO_SID=your_twilio_sid
TWILIO_TOKEN=your_twilio_token
TWILIO_PHONE=+233XXXXXXXXX

# Church Configuration
CHURCH_NAME="My Church"
CHURCH_ADDRESS="123 Church Street"
CHURCH_PHONE="+233XXXXXXXXX"
CHURCH_EMAIL="info@mychurch.com"
```

**Important Variables to Update:**
- `APP_KEY` - Use the key from your local `.env`
- `APP_URL` - Will update after getting custom domain
- Database variables - Use Railway's MySQL variables (shown above)

### 3.5 Deploy

1. Railway will automatically deploy after you set variables
2. Watch the deployment logs in the "Deployments" tab
3. Wait for "SUCCESS" status (usually 3-5 minutes)
4. You'll get a URL like: `https://church-cms-production-xxxx.up.railway.app`

---

## Step 4: Run Database Migrations

### 4.1 Access Railway CLI (Option 1 - Recommended)

Install Railway CLI:
```bash
npm i -g @railway/cli
```

Login and link to your project:
```bash
railway login
railway link
```

Run migrations:
```bash
railway run php artisan migrate --force
railway run php artisan db:seed --force
```

### 4.2 Use Railway Dashboard (Option 2)

1. Go to your Railway project
2. Click on your web service
3. Go to "Settings" tab
4. Scroll to "Custom Start Command"
5. Temporarily set: `php artisan migrate --force && php artisan db:seed && php artisan serve --host=0.0.0.0 --port=$PORT`
6. Redeploy
7. After deployment succeeds, remove the migration commands

---

## Step 5: Get Free Custom Domain from Freenom

### 5.1 Register Domain

1. Go to https://www.freenom.com
2. Search for your desired domain name (e.g., `mychurch`)
3. Select a free TLD: `.tk`, `.ml`, `.ga`, `.cf`, or `.gq`
4. Click "Get it now" and proceed to checkout
5. Sign up/login to Freenom
6. Complete domain registration (FREE for 12 months)

**Example:** `mychurch.tk`, `gracechurch.ml`, `hopechurch.ga`

### 5.2 Configure DNS Settings

1. In Freenom, go to "Services" → "My Domains"
2. Click "Manage Domain" next to your new domain
3. Go to "Management Tools" → "Nameservers"
4. Select "Use custom nameservers"
5. We'll add Railway's nameservers in next step

---

## Step 6: Connect Domain to Railway

### 6.1 Add Custom Domain in Railway

1. Go to your Railway project
2. Click on your web service
3. Go to "Settings" tab
4. Scroll to "Domains"
5. Click "Add Custom Domain"
6. Enter your Freenom domain (e.g., `mychurch.tk`)
7. Railway will provide DNS settings

### 6.2 Update Freenom DNS

Railway will show you either:

**Option A: CNAME Record**
- Go back to Freenom DNS settings
- Add CNAME record:
  - Name: `www` or `@`
  - Target: `your-app.up.railway.app`
  - TTL: 3600

**Option B: A Record**
- Add A record with Railway's IP address
- Set TTL to 3600

### 6.3 Wait for DNS Propagation

- DNS changes take 5 minutes to 48 hours (usually 10-30 minutes)
- Check status at: https://dnschecker.org
- Railway will automatically provision SSL certificate once DNS resolves

---

## Step 7: Update Application URL

### 7.1 Update Environment Variable

1. In Railway → Your service → Variables
2. Update `APP_URL` to your custom domain:
   ```env
   APP_URL=https://mychurch.tk
   ```
3. Redeploy the service

### 7.2 Update Session Cookie Domain

Add to Railway environment variables:
```env
SESSION_DOMAIN=.mychurch.tk
SANCTUM_STATEFUL_DOMAINS=mychurch.tk,www.mychurch.tk
```

---

## Step 8: Create Admin User

### 8.1 Using Railway CLI

```bash
railway run php artisan tinker
```

Then run:
```php
$user = new App\Models\User();
$user->full_name = 'Admin User';
$user->email = 'admin@mychurch.tk';
$user->password = Hash::make('SecurePassword123!');
$user->role = 'admin';
$user->is_active = true;
$user->save();
exit
```

### 8.2 Or Create Seeder Command

Add this to environment variables in Railway:
```env
ADMIN_EMAIL=admin@mychurch.tk
ADMIN_PASSWORD=SecurePassword123!
```

Then run via CLI:
```bash
railway run php artisan db:seed --class=AdminUserSeeder
```

---

## Step 9: Test Your Production Site

### 9.1 Access Your Site

Visit: `https://mychurch.tk` (or your chosen domain)

### 9.2 Test Key Features

- ✅ Homepage loads
- ✅ Admin login works (`/login`)
- ✅ Mobile app works (`/mobile/login`)
- ✅ Database connections work
- ✅ SSL certificate is active (🔒 in browser)

### 9.3 Test Admin Panel

1. Login at: `https://mychurch.tk/login`
2. Use admin credentials created in Step 8
3. Verify dashboard loads
4. Test creating a member
5. Test attendance marking

### 9.4 Test Mobile App

1. Go to: `https://mychurch.tk/mobile/login`
2. Login with test member account
3. Test registration flow
4. Test visitor registration

---

## Step 10: Production Optimizations

### 10.1 Enable Caching

Add to Railway variables:
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

Then add Redis to your Railway project:
1. Click "+ New" → "Database" → "Add Redis"
2. Redis credentials auto-configure

### 10.2 Set Up Queue Worker

Add a new service in Railway:
1. Click "+ New" → "Empty Service"
2. Link same GitHub repo
3. Set start command: `php artisan queue:work --sleep=3 --tries=3 --max-time=3600`
4. Use same environment variables

### 10.3 Enable Scheduled Tasks (Cron)

Add another service for scheduler:
1. Click "+ New" → "Empty Service"
2. Link same GitHub repo
3. Set start command: `while true; do php artisan schedule:run; sleep 60; done`

---

## Step 11: Monitoring & Maintenance

### 11.1 Monitor Logs

- Railway Dashboard → Your service → "Deployments" → Click deployment → View logs
- Check for errors and warnings

### 11.2 Database Backups

Railway doesn't auto-backup on free tier. Set up manual backups:

```bash
# Download database backup
railway run mysqldump -u \$MYSQL_USER -p\$MYSQL_PASSWORD \$MYSQL_DATABASE > backup.sql
```

Schedule weekly backups locally or use a cron job.

### 11.3 Update Application

When you make changes:

```bash
git add .
git commit -m "Update description"
git push origin main
```

Railway auto-deploys on every push to main branch.

---

## Alternative Free Domain Options

If Freenom is unavailable:

### Option 1: Subdomain Providers
- **is-a.dev** (developers subdomain) - https://is-a.dev
- **eu.org** (free .eu.org domains) - https://nic.eu.org
- **Afraid.org** (free DNS service) - https://freedns.afraid.org

### Option 2: Use Railway's Free Domain
- Keep using `your-app.up.railway.app`
- Add custom subdomain via Railway's domain settings

---

## Troubleshooting

### Issue: "500 Internal Server Error"

**Solution:**
1. Check Railway logs for specific error
2. Ensure `APP_KEY` is set correctly
3. Verify database credentials
4. Run: `railway run php artisan config:clear`

### Issue: "Database Connection Failed"

**Solution:**
1. Verify MySQL service is running in Railway
2. Check `DB_*` environment variables match MySQL service
3. Ensure Railway references are correct: `${{MYSQL_HOST}}`

### Issue: "Assets Not Loading (CSS/JS)"

**Solution:**
1. Ensure `APP_URL` matches your domain
2. Check `public` folder is accessible
3. Run: `railway run php artisan storage:link`

### Issue: "Domain Not Resolving"

**Solution:**
1. Wait 30 minutes for DNS propagation
2. Check DNS at: https://dnschecker.org
3. Verify CNAME points to correct Railway URL
4. Clear browser cache (Ctrl+Shift+R)

### Issue: "Free Domain Expired"

**Solution:**
- Freenom free domains expire after 12 months
- Renew 15 days before expiration in Freenom dashboard
- Set calendar reminder to renew annually

---

## Security Checklist

Before going live:

- [ ] `APP_DEBUG=false` in production
- [ ] Strong `APP_KEY` generated and set
- [ ] `APP_ENV=production`
- [ ] Database credentials secure
- [ ] Admin password is strong
- [ ] HTTPS enabled (automatic with Railway)
- [ ] CSRF protection enabled (Laravel default)
- [ ] Rate limiting configured (Laravel default)
- [ ] File upload validation in place
- [ ] Session timeout configured
- [ ] Regular backups scheduled

---

## Cost Breakdown

### Free Tier Limits (Railway.app)

- **Hobby Plan**: $5/month worth of resources FREE
- **Includes**:
  - 500 hours/month execution time
  - Shared CPU (1GB RAM)
  - Shared MySQL database
  - Custom domain + SSL
  - 100GB outbound bandwidth

**Note**: Perfect for small to medium churches (100-500 members). For larger churches, upgrade to Pro plan ($20/month).

### Domain Cost

- **Freenom**: FREE for 12 months (.tk, .ml, .ga, .cf, .gq)
- **Renewal**: FREE if renewed before expiration
- **Alternative**: Buy custom .com domain for $10-15/year (Namecheap, Google Domains)

**Total First Year Cost**: $0 (completely free!)

---

## Production Checklist

Before announcing to church members:

- [ ] Application deployed and accessible
- [ ] Custom domain connected and working
- [ ] SSL certificate active (HTTPS)
- [ ] Admin account created
- [ ] Test member accounts created
- [ ] Sample data added (for demo)
- [ ] Mobile app tested on real devices
- [ ] Email notifications working
- [ ] SMS integration configured (optional)
- [ ] Database backed up
- [ ] User documentation prepared
- [ ] Training session planned for staff

---

## Support & Resources

- **Railway Documentation**: https://docs.railway.app
- **Laravel Deployment**: https://laravel.com/docs/deployment
- **Freenom Help**: https://www.freenom.com/en/support.html
- **DNS Checker**: https://dnschecker.org

---

## Next Steps After Deployment

1. **Customize Church Info**: Update church name, logo, contact details
2. **Add Initial Members**: Import or manually add church members
3. **Configure SMS**: Set up Twilio account for SMS notifications
4. **Set Up Email**: Configure email provider (SendGrid, Mailgun)
5. **Train Staff**: Conduct training for pastors and staff
6. **Launch Mobile App**: Share mobile app URL with members
7. **Monitor Usage**: Check logs and usage patterns
8. **Gather Feedback**: Collect user feedback and iterate

---

## Congratulations! 🎉

Your Church Management System is now live in production with a custom domain, completely free!

**Your Production URLs:**
- Admin Panel: `https://mychurch.tk/login`
- Mobile App: `https://mychurch.tk/mobile`
- Public Website: `https://mychurch.tk`

**Credentials:**
- Admin Email: admin@mychurch.tk
- Password: [Set during Step 8]

---

**Need Help?** Create an issue on GitHub or contact your developer.
