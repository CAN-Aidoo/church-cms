# ✅ Koyeb Deployment Checklist

Use this checklist to ensure your Church CMS deploys successfully to Koyeb.

---

## 📝 Pre-Deployment Checklist

### 1. Code Preparation
- [ ] All changes committed to Git
- [ ] Code pushed to GitHub repository
- [ ] Branch is `main` or your deployment branch
- [ ] No `.env` file in repository (should be in `.gitignore`)

### 2. Configuration Files
- [ ] `Dockerfile` exists and is configured
- [ ] `docker-entrypoint.sh` exists and is executable
- [ ] `.dockerignore` exists
- [ ] `.koyeb.yaml` exists (optional but recommended)
- [ ] `.env.example` updated with Koyeb-specific settings

### 3. Database Preparation
- [ ] MySQL/PostgreSQL database created
- [ ] Database credentials noted down
- [ ] Database accepts external connections
- [ ] Test database connection works

### 4. Generate APP_KEY

Run locally to generate your application key:

```bash
php artisan key:generate --show
```

Copy the output (should look like: `base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`)

---

## 🚀 Koyeb Setup Checklist

### 1. Account & Service
- [ ] Koyeb account created
- [ ] GitHub connected to Koyeb
- [ ] New service created
- [ ] Repository selected
- [ ] Branch selected (usually `main`)

### 2. Build Configuration
- [ ] Builder: Docker
- [ ] Dockerfile path: `Dockerfile` (or `/Dockerfile`)
- [ ] Build command: (leave empty)

### 3. Environment Variables Set

#### Essential (REQUIRED):
- [ ] `APP_NAME` = Church CMS
- [ ] `APP_ENV` = production
- [ ] `APP_DEBUG` = false
- [ ] `APP_KEY` = base64:your-generated-key
- [ ] `APP_URL` = https://your-app-name.koyeb.app
- [ ] `ASSET_URL` = https://your-app-name.koyeb.app

#### Database (REQUIRED):
- [ ] `DB_CONNECTION` = mysql
- [ ] `DB_HOST` = your-database-host
- [ ] `DB_PORT` = 3306
- [ ] `DB_DATABASE` = church_cms
- [ ] `DB_USERNAME` = your-username
- [ ] `DB_PASSWORD` = your-password

#### Session & Cache (REQUIRED):
- [ ] `SESSION_DRIVER` = database
- [ ] `SESSION_LIFETIME` = 120
- [ ] `CACHE_DRIVER` = database
- [ ] `QUEUE_CONNECTION` = database

#### Logging (REQUIRED):
- [ ] `LOG_CHANNEL` = stack
- [ ] `LOG_LEVEL` = error

#### Mail (Optional but recommended):
- [ ] `MAIL_MAILER` = smtp
- [ ] `MAIL_HOST` = your-smtp-host
- [ ] `MAIL_PORT` = 587
- [ ] `MAIL_USERNAME` = your-username
- [ ] `MAIL_PASSWORD` = your-password
- [ ] `MAIL_ENCRYPTION` = tls
- [ ] `MAIL_FROM_ADDRESS` = noreply@yourchurch.com
- [ ] `MAIL_FROM_NAME` = Church CMS

#### Payment Gateways (Optional):
- [ ] `PAYSTACK_PUBLIC_KEY` = pk_live_xxx (if using card payments)
- [ ] `PAYSTACK_SECRET_KEY` = sk_live_xxx
- [ ] `HUBTEL_CLIENT_ID` = xxx (if using mobile money)
- [ ] `HUBTEL_CLIENT_SECRET` = xxx
- [ ] `HUBTEL_MERCHANT_ID` = xxx

#### SMS/Twilio (Optional):
- [ ] `TWILIO_SID` = your-sid
- [ ] `TWILIO_AUTH_TOKEN` = your-token
- [ ] `TWILIO_PHONE_NUMBER` = +1234567890

### 4. Service Configuration
- [ ] Instance type selected (Nano for testing, Small for production)
- [ ] Region selected (closest to your users)
- [ ] Port: 80 (should be auto-configured)
- [ ] Health check path: `/`
- [ ] Auto-deploy enabled

---

## 🔄 During Deployment

### Watch the Logs
- [ ] Build logs show success
- [ ] No errors in deployment logs
- [ ] Database migrations run successfully
- [ ] Admin user seeded
- [ ] Storage link created
- [ ] Application starts without errors

### Common Build Issues

**If build fails:**
1. Check Dockerfile syntax
2. Verify all files are committed
3. Check build logs for specific error
4. Ensure composer.json is valid

**If deployment fails:**
1. Check environment variables are set
2. Verify database credentials
3. Ensure APP_KEY is set
4. Check docker-entrypoint.sh is executable

---

## ✅ Post-Deployment Verification

### 1. Basic Functionality
- [ ] Homepage loads (https://your-app.koyeb.app)
- [ ] Login page accessible
- [ ] Can login with admin credentials
- [ ] Web dashboard loads
- [ ] No 500 errors in logs

### 2. Mobile App Testing
- [ ] Mobile app accessible (/mobile)
- [ ] Can login on mobile
- [ ] All 8 dashboard icons visible
- [ ] No console errors in browser

### 3. Database Verification
- [ ] Can create users
- [ ] Can create events
- [ ] Data persists after page refresh
- [ ] Sessions work correctly

### 4. Security Check
- [ ] HTTPS is working (automatic on Koyeb)
- [ ] APP_DEBUG is false
- [ ] Default admin password changed
- [ ] Strong database password used

---

## 🎯 Feature Testing Checklist

Test each mobile feature works:

### Core Features:
- [ ] **Check-In** - QR code loads and works
- [ ] **Give** - Payment form loads (test with small amount)
- [ ] **Events** - Can view and register for events
- [ ] **My QR** - Personal QR code displays

### Ministry Features:
- [ ] **Equipment** - Can view equipment (after adding test data)
- [ ] **My Unit** - Service unit dashboard loads
- [ ] **Children** - Children's ministry loads
- [ ] **Shepherd** - Shepherd dashboard loads

### Admin Features:
- [ ] Can add members via web dashboard
- [ ] Can create events
- [ ] Can manage service units
- [ ] Can assign shepherds

---

## 📊 Performance Verification

### Load Times:
- [ ] Homepage loads < 3 seconds
- [ ] Dashboard loads < 5 seconds
- [ ] API responses < 2 seconds

### Resource Usage:
- [ ] Memory usage stable (check Koyeb metrics)
- [ ] CPU usage normal
- [ ] No memory leaks

---

## 🔐 Security Final Check

- [ ] All sensitive data in environment variables (not in code)
- [ ] `.env` file NOT in repository
- [ ] HTTPS enabled
- [ ] Strong passwords used
- [ ] Default credentials changed
- [ ] APP_DEBUG=false in production
- [ ] Error reporting disabled for users

---

## 📱 User Acceptance Testing

Before announcing to church:

### Test with Real Users:
- [ ] Have 2-3 people test login
- [ ] Test check-in flow
- [ ] Test giving/payment (small amounts)
- [ ] Test event registration
- [ ] Gather feedback on mobile UX

### Admin Training:
- [ ] Train staff on web dashboard
- [ ] Show how to add members
- [ ] Demonstrate event creation
- [ ] Explain service unit management

---

## 🎉 Ready to Launch!

When all checkboxes are checked:

1. **Announce to Church**
   - Share mobile app URL
   - Provide simple instructions
   - Create tutorial videos

2. **Monitor First Week**
   - Check logs daily
   - Watch for errors
   - Respond to user feedback
   - Make adjustments as needed

3. **Backup Database**
   - Set up automatic backups
   - Test restore process
   - Document backup procedures

---

## 📞 If Something Goes Wrong

### Emergency Contacts:
- Koyeb Support: support@koyeb.com
- GitHub Issues: Your repository

### Quick Fixes:

**Site Down:**
```bash
# Check Koyeb status
# View deployment logs
# Verify database is running
# Check environment variables
```

**Can't Login:**
```bash
# Reset admin password via database
# Clear application cache
# Check session driver is 'database'
```

**Database Errors:**
```bash
# Verify database credentials
# Check database is accepting connections
# Run migrations manually if needed
```

---

## 📚 Documentation References

- **Koyeb Docs**: https://www.koyeb.com/docs
- **Laravel Docs**: https://laravel.com/docs
- **Mobile Features**: See `MOBILE_FEATURES_STATUS.md`
- **Deployment Guide**: See `KOYEB_DEPLOYMENT_GUIDE.md`

---

**Good luck with your deployment! 🚀**

Your church will soon have a fully functional, mobile-ready Church Management System!
