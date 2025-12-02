# 🚀 Quick Start Guide

This is a condensed version for those who want to get up and running fast. For detailed explanations, see **[BEGINNER_INSTALLATION_GUIDE.md](BEGINNER_INSTALLATION_GUIDE.md)**.

## Prerequisites Checklist

- [ ] **XAMPP** installed (provides PHP, MySQL, Apache)
- [ ] **Composer** installed ([download](https://getcomposer.org/download/))
- [ ] **Node.js & NPM** installed ([download](https://nodejs.org/))
- [ ] XAMPP Control Panel: **Apache** and **MySQL** are running

## Automated Setup (Windows)

Double-click **`setup-windows.bat`** to run the automated setup script.

This will:
- Install PHP dependencies
- Install Node.js dependencies  
- Create `.env` file
- Generate application key
- Create storage link

**Then continue with manual steps below.**

## Manual Setup Steps

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Create Environment File

```bash
copy .env.example .env
php artisan key:generate
```

**Or** if `.env.example` doesn't exist, the setup script will create a basic `.env` for you.

### 3. Configure Database

1. Open **phpMyAdmin**: http://localhost/phpmyadmin
2. Click **"New"** → Create database: `church_management`
3. Collation: `utf8mb4_unicode_ci`
4. Click **"Create"**

### 4. Edit `.env` File

Open `.env` and set:

```env
DB_DATABASE=church_management
DB_USERNAME=root
DB_PASSWORD=                    # Leave empty for XAMPP default

CHURCH_NAME="Your Church Name"
CHURCH_ADDRESS="Your Address"
CHURCH_PHONE="+1234567890"
```

### 5. Setup Database

```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Frontend

```bash
npm run build
```

**For development** (auto-rebuild on changes):
```bash
npm run dev
```

### 7. Start Server

```bash
php artisan serve
```

### 8. Access Application

Open browser: **http://localhost:8000**

**Default Login:**
- Email: `admin@churchcms.com`
- Password: `password`

---

## Daily Startup

1. Start **XAMPP** (Apache + MySQL)
2. Open terminal in project folder
3. Run: `php artisan serve`
4. Open: http://localhost:8000

**If working on frontend**, also run in separate terminal:
```bash
npm run dev
```

---

## Troubleshooting

### "Composer not found"
- Install Composer from https://getcomposer.org/download/
- Restart terminal

### "PHP not found"  
- Add PHP to PATH: `C:\xampp\php`
- Or use full path: `C:\xampp\php\php.exe artisan`

### Database connection error
- Check MySQL is running in XAMPP
- Verify database exists in phpMyAdmin
- Check `.env` database settings

### Port 8000 already in use
```bash
php artisan serve --port=8001
```

### CSS/JS not loading
```bash
npm run build
# OR
npm run dev
```

### Clear all caches
```bash
php artisan optimize:clear
```

---

## Next Steps

- Read **[BEGINNER_INSTALLATION_GUIDE.md](BEGINNER_INSTALLATION_GUIDE.md)** for detailed explanations
- Check **[README.md](README.md)** for feature overview
- Explore the system with admin login
- Start adding your church data!

---

**Need help?** Check the troubleshooting section in BEGINNER_INSTALLATION_GUIDE.md



