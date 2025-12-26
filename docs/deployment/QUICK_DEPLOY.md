# ⚡ Quick Deploy - Church CMS to Production (15 Minutes)

## 🎯 What You'll Get
- Live production website with SSL
- Free custom domain (e.g., mychurch.tk)
- MySQL database
- Mobile-ready application
- **Total Cost: $0**

---

## 📋 Prerequisites (2 minutes)
- [ ] GitHub account → https://github.com/signup
- [ ] Railway account → https://railway.app (sign up with GitHub)
- [ ] Freenom account → https://freenom.com (for free domain)

---

## 🚀 Deployment Steps

### 1️⃣ Push to GitHub (3 minutes)

```bash
cd C:\xampp\htdocs\church-cms-docs

# Initialize git (if not already done)
git init

# Add all files
git add .

# Commit
git commit -m "Church CMS - Ready for production"

# Create GitHub repo at: https://github.com/new
# Name it: church-cms

# Add remote and push
git remote add origin https://github.com/YOUR_USERNAME/church-cms.git
git branch -M main
git push -u origin main
```

---

### 2️⃣ Deploy on Railway (5 minutes)

1. **Go to Railway**: https://railway.app
2. **Login** with GitHub
3. **New Project** → **Deploy from GitHub repo**
4. **Select** `church-cms`
5. **Add MySQL**:
   - Click "+ New"
   - Select "Database" → "MySQL"
6. **Add Environment Variables**:
   - Click on web service → "Variables"
   - Click "RAW Editor"
   - Paste this:

```env
APP_NAME=Church CMS
APP_ENV=production
APP_KEY=base64:YOUR_KEY_FROM_LOCAL_ENV
APP_DEBUG=false
APP_URL=https://church-cms-production.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_DRIVER=database

LOG_CHANNEL=stack
LOG_LEVEL=error

BROADCAST_DRIVER=log
FILESYSTEM_DISK=public

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@churchcms.com
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

7. **Update APP_KEY**:
   - Run locally: `php artisan key:generate --show`
   - Copy the key
   - Replace `YOUR_KEY_FROM_LOCAL_ENV` with your key

8. **Wait for deployment** (3-5 minutes)
   - Watch "Deployments" tab
   - Wait for ✅ SUCCESS

9. **Run migrations**:
   - Install Railway CLI: `npm i -g @railway/cli`
   - Login: `railway login`
   - Link: `railway link` (select your project)
   - Migrate: `railway run php artisan migrate --force`

---

### 3️⃣ Get Free Domain (4 minutes)

1. **Go to Freenom**: https://www.freenom.com
2. **Search domain**: Enter your church name (e.g., "gracechurch")
3. **Select TLD**: Choose `.tk`, `.ml`, `.ga`, `.cf`, or `.gq` (all FREE)
4. **Get it**: Click "Get it now!"
5. **Checkout**:
   - Period: 12 Months @ FREE
   - Click "Continue"
6. **Complete registration**:
   - Enter email
   - Verify email
   - Complete order

---

### 4️⃣ Connect Domain to Railway (3 minutes)

#### In Railway:
1. Click web service → "Settings" → "Domains"
2. Click "Custom Domain"
3. Enter: `yourdomain.tk` (your Freenom domain)
4. Copy the CNAME target (looks like: `xxx.up.railway.app`)

#### In Freenom:
1. Go to "Services" → "My Domains"
2. Click "Manage Domain"
3. Go to "Management Tools" → "Nameservers"
4. Select "Use custom nameservers (below)"
5. Add Railway's DNS:
   ```
   Nameserver 1: ns1.railway.app
   Nameserver 2: ns2.railway.app
   ```
6. Click "Change Nameservers"

**OR** use CNAME method:
1. Go to "Manage Freenom DNS"
2. Add record:
   - Name: (leave blank for root, or use `www`)
   - Type: CNAME
   - Target: `your-app.up.railway.app`
   - TTL: 3600
3. Save

---

### 5️⃣ Update App URL (1 minute)

In Railway → Variables:
```env
APP_URL=https://yourdomain.tk
```

Redeploy (Railway → Deployments → click latest → "Redeploy")

---

### 6️⃣ Create Admin Account (1 minute)

```bash
railway run php artisan tinker

# Then paste this:
$user = new App\Models\User();
$user->full_name = 'Admin';
$user->email = 'admin@yourdomain.tk';
$user->password = Hash::make('Admin@123!');
$user->role = 'admin';
$user->is_active = true;
$user->save();
exit
```

---

## ✅ Done! Access Your Site

### Your Production URLs:
- **Website**: `https://yourdomain.tk`
- **Admin Login**: `https://yourdomain.tk/login`
- **Mobile App**: `https://yourdomain.tk/mobile`

### Admin Credentials:
- **Email**: admin@yourdomain.tk
- **Password**: Admin@123!

---

## 🔥 Bonus: One-Command Deploy

For future updates:

```bash
git add .
git commit -m "Update description"
git push origin main
```

Railway auto-deploys! 🎉

---

## 🐛 Common Issues

### "500 Error"
- Check Railway logs
- Ensure APP_KEY is set
- Run: `railway run php artisan config:clear`

### "Database Connection Error"
- Verify MySQL service is running
- Check DB variables use `${{MYSQL_*}}` syntax

### "Domain Not Working"
- Wait 10-30 minutes for DNS
- Check: https://dnschecker.org
- Clear browser cache (Ctrl+Shift+R)

### "Assets Not Loading"
- Verify APP_URL matches your domain
- Run: `railway run php artisan storage:link`

---

## 📞 Support

**Need help?**
- Railway Docs: https://docs.railway.app
- DNS Check: https://dnschecker.org
- Freenom Help: https://freenom.com/support

---

## 🎉 Congratulations!

Your Church Management System is LIVE!

**What's Next?**
1. Change admin password (Settings → Profile)
2. Add church logo and information
3. Create staff accounts
4. Import/add members
5. Share mobile app with congregation
6. Configure SMS (Twilio) if needed

**Cost Breakdown:**
- Hosting: $0 (Railway free tier)
- Domain: $0 (Freenom .tk)
- Database: $0 (Included)
- SSL Certificate: $0 (Auto)
- **Total: $0/month**

---

**Full deployment guide**: See `DEPLOYMENT_GUIDE.md` for detailed documentation.
