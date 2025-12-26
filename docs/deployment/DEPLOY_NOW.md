# 🚀 Deploy Church CMS to Railway - Quick Start

## Database is Ready! ✅

Your MySQL database is now properly linked to your web service.

---

## Deploy Now (Choose One Method)

### Method 1: Git Push (Recommended) ⭐

```bash
# Trigger deployment
git add .
git commit -m "Database configured - ready for deployment"
git push origin master
```

Railway will automatically deploy when it detects the push.

---

### Method 2: Railway CLI

```bash
railway up
```

---

### Method 3: Railway Dashboard

1. Go to https://railway.app/dashboard
2. Open project "alluring-reflection"
3. Click "web" service
4. Click "Deploy" → "Redeploy"

---

## Watch Deployment Progress

```bash
railway logs --follow
```

**Look for these success messages:**
```
✓ Migration table created successfully
✓ Migrated: 2024_..._create_users_table
✓ Migrated: 2024_..._create_roles_table
✓ Server started on port ...
```

---

## After Deployment

### 1. Test Your App
Visit: **https://sonlifecms.up.railway.app**

### 2. Verify Database
```bash
railway connect MySQL
```

Then:
```sql
USE railway;
SHOW TABLES;
EXIT;
```

### 3. Check Logs for Errors
```bash
railway logs --error
```

---

## If Deployment Fails

Check the detailed guide:
```
docs/deployment/RAILWAY_DATABASE_SETUP_COMPLETE.md
```

Or view logs:
```bash
railway logs
```

---

## Database Connection Info

**Your App (Internal)**:
- Host: `mysql.railway.internal`
- Port: `3306`
- Database: `railway`

**External Tools** (MySQL Workbench, etc):
- Host: `interchange.proxy.rlwy.net`
- Port: `19569`
- User: `root`
- Password: `gxztDifsESEuvHZZsPCxAsFYAsPQtFFz`

---

## Quick Reference

| Command | Description |
|---------|-------------|
| `railway up` | Deploy current code |
| `railway logs` | View deployment logs |
| `railway logs --follow` | Stream logs |
| `railway status` | Check project status |
| `railway variables` | List all env vars |
| `railway connect MySQL` | MySQL shell |

---

## Ready? Let's Deploy! 🎉

Choose a deployment method above and execute!
