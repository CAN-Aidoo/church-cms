# 🚀 Church CMS - Next Steps After GitHub Push

## ✅ Completed
- [x] Code pushed to GitHub: https://github.com/CAN-Aidoo/church-cms

---

## 📋 Deploy to Production (10 Minutes Remaining)

### Step 1: Deploy on Railway.app (5 minutes)

#### 1.1 Sign Up & Login
1. Go to: **https://railway.app**
2. Click **"Login"**
3. Select **"Login with GitHub"**
4. Authorize Railway to access your GitHub account

#### 1.2 Create New Project
1. Click **"New Project"**
2. Select **"Deploy from GitHub repo"**
3. Choose: **CAN-Aidoo/church-cms**
4. Railway will automatically detect it's a Laravel app and start building

#### 1.3 Add MySQL Database
1. In your Railway project dashboard, click **"+ New"**
2. Select **"Database"**
3. Choose **"Add MySQL"**
4. MySQL service will be provisioned automatically
5. Database credentials are auto-configured as environment variables

#### 1.4 Configure Environment Variables
1. Click on your **web service** (church-cms)
2. Go to **"Variables"** tab
3. Click **"RAW Editor"**
4. Paste this configuration:

```env
APP_NAME=Church CMS
APP_ENV=production
APP_KEY=base64:qUn0J/n1pfI+HJlKfSZhmcdhpIkLn8pPiOJJLUN/AzA=
APP_DEBUG=false
APP_URL=https://church-cms-production.up.railway.app

# Database (Railway MySQL - These are Railway's variable references)
DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

# Cache & Session
CACHE_DRIVER=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Queue
QUEUE_CONNECTION=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Broadcasting
BROADCAST_DRIVER=log

# Filesystem
FILESYSTEM_DISK=public

# Mail
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@churchcms.com
MAIL_FROM_NAME="${APP_NAME}"

# Vite
VITE_APP_NAME="${APP_NAME}"
```

5. Click **"Save"** or it auto-saves
6. Railway will automatically redeploy with new variables

#### 1.5 Wait for Deployment
- Go to **"Deployments"** tab
- Watch the build logs
- Wait for **"SUCCESS"** status (3-5 minutes)
- You'll get a URL like: `https://church-cms-production-xxxx.up.railway.app`

---

### Step 2: Run Database Migrations (2 minutes)

#### Option A: Using Railway CLI (Recommended)

1. **Install Railway CLI:**
   ```bash
   npm install -g @railway/cli
   ```

2. **Login to Railway:**
   ```bash
   railway login
   ```
   - Browser will open
   - Authorize the CLI

3. **Link to Your Project:**
   ```bash
   cd C:\xampp\htdocs\church-cms-docs
   railway link
   ```
   - Select your project: **church-cms**

4. **Run Migrations:**
   ```bash
   railway run php artisan migrate --force
   ```

5. **Verify Migration:**
   ```bash
   railway run php artisan migrate:status
   ```

#### Option B: Using Railway Dashboard

1. Go to your Railway project
2. Click on **web service**
3. Go to **"Settings"** tab
4. Find **"Custom Start Command"**
5. Temporarily change to:
   ```bash
   php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
   ```
6. Save and wait for redeploy
7. After success, change back to:
   ```bash
   php artisan serve --host=0.0.0.0 --port=$PORT
   ```

---

### Step 3: Create Admin Account (1 minute)

Using Railway CLI:

```bash
railway run php artisan tinker
```

Then paste this code:

```php
$user = new App\Models\User();
$user->full_name = 'Admin';
$user->email = 'admin@churchcms.com';
$user->password = Hash::make('Admin@2024!');
$user->role = 'admin';
$user->is_active = true;
$user->save();

echo "Admin created successfully!\n";
echo "Email: admin@churchcms.com\n";
echo "Password: Admin@2024!\n";

exit
```

**Save these credentials!** You'll need them to login.

---

### Step 4: Test Your Deployment (1 minute)

#### 4.1 Test Main Site
Visit your Railway URL: `https://church-cms-production-xxxx.up.railway.app`

You should see the homepage.

#### 4.2 Test Admin Login
1. Go to: `https://church-cms-production-xxxx.up.railway.app/login`
2. Login with:
   - Email: `admin@churchcms.com`
   - Password: `Admin@2024!`
3. Should redirect to admin dashboard

#### 4.3 Test Mobile App
1. Go to: `https://church-cms-production-xxxx.up.railway.app/mobile`
2. Should redirect to mobile login
3. Can test visitor registration

---

### Step 5: Get Free Domain from Freenom (4 minutes)

#### 5.1 Register Domain
1. Go to: **https://www.freenom.com**
2. Click **"Get a domain"** or search box
3. Search for your church name (e.g., "gracechurch")
4. Select a **FREE** TLD:
   - `.tk` (Tokelau)
   - `.ml` (Mali)
   - `.ga` (Gabon)
   - `.cf` (Central African Republic)
   - `.gq` (Equatorial Guinea)

5. Click **"Get it now!"**
6. Click **"Checkout"**
7. Select **Period: 12 Months @ FREE**
8. Click **"Continue"**

#### 5.2 Complete Registration
1. Enter your email address
2. Verify email (check inbox)
3. Complete your details
4. Accept terms and complete order

**You now have a free domain for 12 months!**

Example domains:
- `gracechurch.tk`
- `hopechurch.ml`
- `faithchurch.ga`

---

### Step 6: Connect Domain to Railway (3 minutes)

#### 6.1 Add Custom Domain in Railway
1. Go to Railway project
2. Click your **web service**
3. Go to **"Settings"** tab
4. Scroll to **"Domains"** section
5. Click **"+ Custom Domain"**
6. Enter your Freenom domain (e.g., `gracechurch.tk`)
7. Click **"Add"**

Railway will show you DNS configuration needed.

#### 6.2 Configure DNS in Freenom

**Method 1: Using Nameservers (Recommended)**

1. In Freenom, go to **"Services"** → **"My Domains"**
2. Click **"Manage Domain"** next to your domain
3. Go to **"Management Tools"** → **"Nameservers"**
4. Select **"Use custom nameservers"**
5. Add Railway's nameservers:
   ```
   Nameserver 1: ns1.railway.app
   Nameserver 2: ns2.railway.app
   ```
6. Click **"Change Nameservers"**

**Method 2: Using CNAME (Alternative)**

1. Go to **"Manage Freenom DNS"**
2. Add CNAME record:
   - **Name**: Leave blank (for root) or use `@`
   - **Type**: CNAME
   - **Target**: Your Railway URL (e.g., `church-cms-production-xxxx.up.railway.app`)
   - **TTL**: 3600
3. Save changes

#### 6.3 Wait for DNS Propagation
- DNS changes take **10-30 minutes** (sometimes up to 48 hours)
- Check status at: https://dnschecker.org
- Railway will auto-provision SSL certificate when DNS resolves

---

### Step 7: Update APP_URL (1 minute)

Once your domain is working:

1. In Railway, go to **Variables**
2. Update:
   ```env
   APP_URL=https://gracechurch.tk
   SESSION_DOMAIN=.gracechurch.tk
   SANCTUM_STATEFUL_DOMAINS=gracechurch.tk,www.gracechurch.tk
   ```
3. Railway will auto-redeploy

---

## 🎉 Deployment Complete!

Your Church Management System is now live!

### Your Production URLs:
- **Website**: https://gracechurch.tk
- **Admin Panel**: https://gracechurch.tk/login
- **Mobile App**: https://gracechurch.tk/mobile

### Admin Credentials:
- **Email**: admin@churchcms.com
- **Password**: Admin@2024!

**⚠️ IMPORTANT**: Change your admin password immediately after first login!

---

## 📊 Deployment Checklist

- [ ] Railway account created
- [ ] Project deployed from GitHub
- [ ] MySQL database added
- [ ] Environment variables configured
- [ ] Database migrations run
- [ ] Admin account created
- [ ] Deployment tested
- [ ] Freenom domain registered
- [ ] Domain connected to Railway
- [ ] DNS propagated
- [ ] APP_URL updated
- [ ] Admin password changed
- [ ] Mobile app tested
- [ ] **GO LIVE!** 🚀

---

## 🐛 Troubleshooting

### "Build Failed" in Railway
**Solution:**
- Check build logs in Railway
- Ensure `composer.json` has all dependencies
- Verify PHP version (8.2+)

### "Database Connection Failed"
**Solution:**
- Verify MySQL service is running
- Check that `DB_*` variables use Railway references: `${{MYSQL_*}}`
- Run: `railway run php artisan config:clear`

### "500 Error" on Site
**Solution:**
```bash
railway run php artisan config:clear
railway run php artisan cache:clear
railway run php artisan route:clear
```

### "Domain Not Resolving"
**Solution:**
- Wait 30 minutes for DNS propagation
- Check at: https://dnschecker.org
- Verify DNS records in Freenom
- Clear browser cache (Ctrl+Shift+Del)

### "SSL Certificate Not Working"
**Solution:**
- Wait for DNS to fully propagate
- Railway auto-provisions SSL when domain resolves
- Can take up to 1 hour after DNS propagates

---

## 📞 Support Resources

- **Railway Docs**: https://docs.railway.app
- **Railway Discord**: https://discord.gg/railway
- **Freenom Support**: https://freenom.com/support
- **DNS Checker**: https://dnschecker.org
- **SSL Test**: https://www.ssllabs.com/ssltest/

---

## 🔄 Future Updates

To deploy updates:

```bash
# 1. Make changes locally
# 2. Commit changes
git add .
git commit -m "Your update description"

# 3. Push to GitHub
git push origin master

# 4. Railway auto-deploys! ✨
```

---

## 💡 Tips

1. **Backup Database Weekly**
   ```bash
   railway run mysqldump -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > backup.sql
   ```

2. **Monitor Application Logs**
   - Railway Dashboard → Deployments → View Logs
   - Check for errors and warnings

3. **Renew Freenom Domain**
   - Set reminder 15 days before 12-month expiration
   - Renew for free in Freenom dashboard

4. **Upgrade if Needed**
   - Railway free tier: 500 hours/month
   - For larger churches, consider Pro plan ($20/month)

---

## 🎓 Next Steps After Launch

1. **Customize Church Info**
   - Update church name, logo, address
   - Add contact information
   - Configure SMS settings (Twilio)

2. **Add Initial Data**
   - Import or manually add members
   - Create service units
   - Set up programs and events

3. **Train Staff**
   - Conduct admin training session
   - Create user guides
   - Set up roles and permissions

4. **Launch Mobile App**
   - Share URL with members
   - Create QR codes for check-in
   - Test on various devices

5. **Monitor & Iterate**
   - Gather user feedback
   - Monitor usage patterns
   - Make improvements

---

**Ready to deploy? Follow the steps above!** 🚀

If you need help, refer to the comprehensive `DEPLOYMENT_GUIDE.md` for detailed instructions.
