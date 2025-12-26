# 📋 Church CMS - Complete Deployment Checklist

Use this checklist to track your deployment progress from start to finish.

---

## ✅ Phase 1: Pre-Deployment (Completed)

- [x] Application code prepared
- [x] Database migrations created (29 migrations)
- [x] Authentication system fixed
- [x] Mobile app working
- [x] Deployment configuration files created
- [x] Documentation completed
- [x] Code committed to Git
- [x] Code pushed to GitHub

**Status**: ✅ COMPLETE

---

## 📦 Phase 2: Railway.app Setup

### Step 1: Account & Project Setup
- [ ] Create Railway.app account
- [ ] Login with GitHub
- [ ] Create new project
- [ ] Deploy from GitHub repository: `CAN-Aidoo/church-cms`
- [ ] Wait for initial build (3-5 minutes)

### Step 2: Database Setup
- [ ] Click "+ New" in Railway
- [ ] Select "Database" → "MySQL"
- [ ] Wait for MySQL provisioning
- [ ] Verify MySQL service shows as "Active"

### Step 3: Environment Configuration
- [ ] Click on web service
- [ ] Go to "Variables" tab
- [ ] Click "RAW Editor"
- [ ] Copy variables from `.env.production.example`
- [ ] Update `APP_KEY` (from local .env)
- [ ] Update `APP_URL` (Railway URL)
- [ ] Verify `DB_*` variables use `${{MYSQL_*}}` syntax
- [ ] Save variables
- [ ] Wait for auto-redeploy

### Step 4: Deployment Verification
- [ ] Check "Deployments" tab
- [ ] Wait for "SUCCESS" status
- [ ] Copy deployment URL
- [ ] Visit URL in browser
- [ ] Verify homepage loads

**Estimated Time**: 10 minutes
**Status**: ⏳ Pending

---

## 🗄️ Phase 3: Database Setup

### Option A: Using Auto-Deploy Script (Recommended)
- [ ] Run: `auto-deploy.bat`
- [ ] Complete Railway login in browser
- [ ] Select your project
- [ ] Wait for migrations to complete

### Option B: Manual Railway CLI
- [ ] Install Railway CLI: `npm install -g @railway/cli`
- [ ] Login: `railway login`
- [ ] Link project: `railway link`
- [ ] Run migrations: `railway run php artisan migrate --force`
- [ ] Verify: `railway run php artisan migrate:status`

### Option C: Via Railway Dashboard
- [ ] Go to Settings → Custom Start Command
- [ ] Set: `php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT`
- [ ] Wait for redeploy
- [ ] Restore start command to: `php artisan serve --host=0.0.0.0 --port=$PORT`

**Estimated Time**: 5 minutes
**Status**: ⏳ Pending

---

## 👤 Phase 4: Create Admin Account

### Option A: Using Automated Script
- [ ] Run: `create-admin.bat`
- [ ] Enter admin email (or use default)
- [ ] Enter admin password (or use default)
- [ ] Enter admin name (or use default)
- [ ] Save credentials securely

### Option B: Using Seeder Script
- [ ] Run: `seed-initial-data.bat`
- [ ] Creates 4 default accounts (admin, pastor, staff, member)
- [ ] Note all default credentials
- [ ] Plan to change passwords after first login

### Option C: Manual Creation
- [ ] Run: `railway run php artisan tinker`
- [ ] Create user with code from NEXT_STEPS.md
- [ ] Exit tinker
- [ ] Save credentials

**Default Credentials** (if using seeder):
- Admin: admin@churchcms.com / Admin@2024!
- Pastor: pastor@churchcms.com / Pastor@2024!
- Staff: staff@churchcms.com / Staff@2024!
- Member: member@churchcms.com / Member@2024!

**Estimated Time**: 2 minutes
**Status**: ⏳ Pending

---

## 🌐 Phase 5: Free Domain Setup

### Step 1: Register Domain
- [ ] Go to https://www.freenom.com
- [ ] Search for church name
- [ ] Select FREE TLD (.tk, .ml, .ga, .cf, or .gq)
- [ ] Add to cart
- [ ] Select "12 Months @ FREE"
- [ ] Checkout

### Step 2: Complete Registration
- [ ] Enter email address
- [ ] Verify email
- [ ] Complete profile
- [ ] Accept terms
- [ ] Complete order

### Step 3: Note Domain Details
- [ ] Write down your domain: _______________
- [ ] Note registration date: _______________
- [ ] Set renewal reminder (11 months from now)

**Estimated Time**: 5 minutes
**Status**: ⏳ Pending

---

## 🔗 Phase 6: Connect Domain to Railway

### Step 1: Add Domain in Railway
- [ ] Go to Railway project
- [ ] Click web service
- [ ] Settings → Domains
- [ ] Click "+ Custom Domain"
- [ ] Enter your Freenom domain
- [ ] Note DNS instructions from Railway

### Step 2: Configure DNS
Choose one method:

**Method A: Nameservers (Recommended)**
- [ ] In Freenom: Services → My Domains
- [ ] Click "Manage Domain"
- [ ] Management Tools → Nameservers
- [ ] Select "Use custom nameservers"
- [ ] Add: ns1.railway.app
- [ ] Add: ns2.railway.app
- [ ] Save changes

**Method B: CNAME Record**
- [ ] In Freenom: Manage Freenom DNS
- [ ] Add CNAME record
- [ ] Name: @ or leave blank
- [ ] Target: Railway URL
- [ ] TTL: 3600
- [ ] Save

### Step 3: Wait for Propagation
- [ ] Check DNS at: https://dnschecker.org
- [ ] Wait 10-30 minutes
- [ ] Verify domain resolves to Railway
- [ ] Confirm SSL certificate auto-provisioned

**Estimated Time**: 15-45 minutes
**Status**: ⏳ Pending

---

## ⚙️ Phase 7: Update Configuration

### Update Environment Variables
- [ ] In Railway → Variables
- [ ] Update `APP_URL` to your domain
- [ ] Add `SESSION_DOMAIN=.yourdomain.tk`
- [ ] Add `SANCTUM_STATEFUL_DOMAINS=yourdomain.tk,www.yourdomain.tk`
- [ ] Save (auto-redeploys)

### Clear Caches
- [ ] Run: `railway run php artisan config:clear`
- [ ] Run: `railway run php artisan cache:clear`
- [ ] Run: `railway run php artisan route:clear`

**Estimated Time**: 3 minutes
**Status**: ⏳ Pending

---

## 🧪 Phase 8: Testing & Verification

### Automated Testing
- [ ] Run: `verify-production.bat`
- [ ] Enter your production URL
- [ ] Review all test results
- [ ] Fix any failing tests

### Manual Testing
- [ ] Visit: https://yourdomain.tk
- [ ] Homepage loads correctly
- [ ] No SSL warnings in browser
- [ ] Navigate to /login
- [ ] Login with admin credentials
- [ ] Dashboard loads
- [ ] Navigate to /mobile
- [ ] Mobile app loads
- [ ] Test mobile login
- [ ] Test visitor registration
- [ ] Logout works

### API Testing
- [ ] Test login API endpoint
- [ ] Test mobile registration
- [ ] Test visitor registration
- [ ] Check error responses

**Estimated Time**: 10 minutes
**Status**: ⏳ Pending

---

## 🔒 Phase 9: Security & Configuration

### Change Default Passwords
- [ ] Login as admin
- [ ] Go to Profile/Settings
- [ ] Change admin password
- [ ] Change pastor password (if created)
- [ ] Change staff password (if created)
- [ ] Change member password (if created)

### Configure Church Information
- [ ] Update church name
- [ ] Add church address
- [ ] Add church phone
- [ ] Add church email
- [ ] Upload church logo (if available)
- [ ] Set timezone

### Review Security Settings
- [ ] Verify APP_DEBUG=false
- [ ] Verify APP_ENV=production
- [ ] Check HTTPS is enforced
- [ ] Review user roles
- [ ] Test password requirements

**Estimated Time**: 15 minutes
**Status**: ⏳ Pending

---

## 📱 Phase 10: Launch Preparation

### Create Initial Data
- [ ] Add at least 3 test members
- [ ] Create 2-3 service units
- [ ] Add upcoming events
- [ ] Create sample announcement
- [ ] Set up service times

### Mobile App Setup
- [ ] Test on different devices
- [ ] Create QR codes for check-in
- [ ] Test QR code scanning
- [ ] Test mobile registration
- [ ] Verify mobile payments (if configured)

### Staff Training
- [ ] Schedule training session
- [ ] Prepare user guides
- [ ] Create quick reference
- [ ] Set up staff accounts
- [ ] Assign roles and permissions

**Estimated Time**: 30 minutes
**Status**: ⏳ Pending

---

## 🚀 Phase 11: Go Live!

### Pre-Launch Checklist
- [ ] All tests passing
- [ ] Default passwords changed
- [ ] Church info updated
- [ ] SSL certificate working
- [ ] Mobile app tested
- [ ] Staff trained
- [ ] Backup procedure established
- [ ] Support plan ready

### Launch Day
- [ ] Announce to church members
- [ ] Share mobile app URL
- [ ] Monitor for issues
- [ ] Collect initial feedback
- [ ] Address any problems

### Post-Launch
- [ ] Monitor application logs
- [ ] Check database size
- [ ] Review user registrations
- [ ] Gather staff feedback
- [ ] Plan improvements

**Status**: ⏳ Pending

---

## 📊 Progress Tracking

### Overall Progress

**Phase Status**:
- Phase 1: ✅ Complete (100%)
- Phase 2: ⏳ Pending (0%)
- Phase 3: ⏳ Pending (0%)
- Phase 4: ⏳ Pending (0%)
- Phase 5: ⏳ Pending (0%)
- Phase 6: ⏳ Pending (0%)
- Phase 7: ⏳ Pending (0%)
- Phase 8: ⏳ Pending (0%)
- Phase 9: ⏳ Pending (0%)
- Phase 10: ⏳ Pending (0%)
- Phase 11: ⏳ Pending (0%)

**Total Progress**: 9% (1/11 phases complete)

---

## 🎯 Quick Reference

### Important URLs
- **Production**: https://yourdomain.tk
- **Admin**: https://yourdomain.tk/login
- **Mobile**: https://yourdomain.tk/mobile
- **API**: https://yourdomain.tk/api/v1

### Important Credentials
- **Admin Email**: _______________
- **Admin Password**: _______________ (changed from default)

### Important Commands
```bash
# Deploy updates
git push origin master

# Run migrations
railway run php artisan migrate --force

# Clear caches
railway run php artisan cache:clear

# View logs
railway logs

# Check status
railway status
```

### Support Resources
- Railway Docs: https://docs.railway.app
- Freenom Support: https://freenom.com/support
- DNS Checker: https://dnschecker.org
- SSL Checker: https://www.ssllabs.com/ssltest/

---

## 📝 Notes & Issues

Track any issues or notes during deployment:

```
Date: _______________
Issue: _______________
Resolution: _______________

Date: _______________
Issue: _______________
Resolution: _______________
```

---

## ✅ Final Verification

Before marking deployment complete:

- [ ] Application accessible at custom domain
- [ ] HTTPS working (SSL certificate)
- [ ] Admin can login
- [ ] Mobile app accessible
- [ ] Database migrations complete
- [ ] All default passwords changed
- [ ] Church information updated
- [ ] Staff trained
- [ ] Members can register
- [ ] QR check-in working
- [ ] Backups scheduled
- [ ] Monitoring in place

**Deployment Date**: _______________
**Deployed By**: _______________
**Production URL**: _______________

---

## 🎉 Congratulations!

Once all checkboxes are complete, your Church Management System is fully deployed and ready to use!

**Estimated Total Time**: 1.5 - 2 hours
**Total Cost**: $0/month

---

*Last Updated: December 20, 2025*
*Version: 1.0.0 - Production Ready*
