# 🏛️ Church Management System

**A comprehensive, modern, and secure church management platform built with Laravel 10**

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-purple.svg)](https://php.net)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](CONTRIBUTING.md)

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Screenshots](#screenshots)
- [Technology Stack](#technology-stack)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Mobile PWA](#mobile-pwa)
- [Contributing](#contributing)
- [License](#license)
- [Support](#support)

---

## 🎯 Overview

The Church Management System is a complete digital solution for modern churches, designed to streamline operations, enhance member engagement, and provide powerful tools for church leadership. Built with enterprise-grade security and mobile-first architecture.

### Why Choose This System?

- ✅ **100% Complete** - All 26+ modules fully implemented
- ✅ **Mobile-First** - Progressive Web App for iOS & Android
- ✅ **QR Code Everything** - Eliminate 95% of manual data entry
- ✅ **Enterprise Security** - Military-grade encryption, 2FA, audit trails
- ✅ **Offline Capable** - Service worker for reliability
- ✅ **Self-Service Portal** - Members manage their own data
- ✅ **Admin Control** - No backdoors, invitation-only system

---

## ✨ Features

### 🏠 Core Features

#### Member Management
- Complete member profiles with photos and documents
- Family grouping and relationships
- Document storage and management
- Member lifecycle tracking (visitor → member)
- Advanced search and filtering

#### Attendance Tracking
- **QR Code Check-In** - Fast, contactless attendance
- GPS verification for location accuracy
- Manual attendance marking
- Family member check-in
- Absence alerts and follow-up automation
- Comprehensive attendance reports

#### Financial Management
- Income and expense tracking
- Multi-level approval workflow
- Budget management and tracking
- Giving history and receipts
- Mobile payment integration (Paystack, Flutterwave)
- Recurring giving setup
- Financial analytics and forecasting

#### Communication
- **SMS Broadcasting** - Bulk messaging with templates
- Email notifications
- Push notifications (PWA)
- In-app messaging
- Automated birthday/anniversary wishes
- Delivery tracking and analytics

### 📱 Mobile Progressive Web App

- **Installable** on iOS and Android
- **Offline functionality** with service worker
- Self-service member portal
- QR code check-in
- Mobile giving
- Event registration
- Profile management
- Ministry tools (Shepherd, Service Units)

### 🔐 Security Features

#### Dual Authentication
- **System Access**: Admin-only, invitation-only, mandatory 2FA
- **Mobile Access**: Self-registration with progressive verification

#### Enterprise Security
- AES-256-GCM encryption for sensitive data
- HMAC-SHA256 digital signatures
- Password complexity enforcement
- Account lockout after 5 failed attempts
- Session timeout (30 minutes)
- Comprehensive audit logging
- OWASP Top 10 protection

### 🎯 Ministry Tools

#### Shepherds (Small Groups)
- Flock management (12-15 members per shepherd)
- Visit tracking with GPS
- Performance metrics
- Bulk messaging
- Engagement analytics

#### Service Units
- Ministry team management
- Duty roster generation
- Task tracking
- Check-in with GPS verification
- Unit performance reports

#### Children's Ministry
- Secure check-in/check-out with 4-digit codes
- Age-based class assignment
- Allergy and medical alerts
- Incident reporting
- Attendance history
- Parent communication

#### Equipment Management
- QR-based checkout/return
- Condition tracking
- Maintenance scheduling
- Overdue alerts
- Equipment inventory

### 📊 Advanced Features

#### Programs & Events
- Event creation and management
- Online registration with payment
- Attendance tracking
- Resource allocation
- Event calendar

#### Service Planning
- Worship service schedules
- Worship sets and songs
- Team assignments
- Resource management

#### Prayer Requests
- Online submission
- Assignment to intercessors
- Progress tracking
- Testimony collection

#### Welfare Management
- Case submission and tracking
- Auto-priority scoring
- Fund disbursement
- Impact assessment
- Program management

#### Counselling
- Session scheduling
- Case management
- Encrypted notes
- Counsellor matching
- Resource library

#### Reports & Analytics
- Custom report builder
- Interactive dashboards
- Scheduled reports
- Export to PDF/Excel/CSV
- Real-time analytics

---

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 10.x
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum (JWT)
- **Cache & Queue**: Redis
- **Storage**: Local / AWS S3

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js / Vanilla JS
- **Build Tool**: Vite 5.x
- **Icons**: Heroicons

### Mobile
- **PWA**: Progressive Web App
- **Offline**: Service Worker
- **Manifest**: Web App Manifest

### Third-Party Services
- **SMS**: Twilio
- **Payments**: Paystack, Flutterwave
- **QR Codes**: SimpleSoftwareIO/simple-qrcode
- **Email**: SMTP / SendGrid / Mailgun

---

## 🚀 Quick Start

### Prerequisites

```bash
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- NPM >= 9.x
- Redis (optional but recommended)
```

### Installation (Quick)

```bash
# Clone repository
git clone https://github.com/your-org/church-cms.git
cd church-cms

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env, then:
php artisan migrate --seed

# Build assets
npm run build

# Start server
php artisan serve
```

Visit: `http://localhost:8000`

**Default Admin Credentials**:
- Email: `admin@churchcms.com`
- Password: `Admin@123456`

⚠️ **Change the default password immediately after first login!**

---

## 📦 Installation

### Detailed Installation Steps

#### 1. Clone and Setup

```bash
git clone https://github.com/your-org/church-cms.git
cd church-cms
```

#### 2. Install PHP Dependencies

```bash
composer install --optimize-autoloader
```

#### 3. Install Node Dependencies

```bash
npm install
```

#### 4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file:

```env
APP_NAME="Your Church Name"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=church_management
DB_USERNAME=root
DB_PASSWORD=your_password

# Redis (recommended)
REDIS_HOST=127.0.0.1
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

# Church Info
CHURCH_NAME="Your Church Name"
CHURCH_ADDRESS="Your Address"
CHURCH_PHONE="+233XXXXXXXXX"
CHURCH_EMAIL="info@yourchurch.com"

# SMS (Twilio)
TWILIO_SID=your_sid
TWILIO_TOKEN=your_token
TWILIO_PHONE=+1234567890
TWILIO_ENABLED=true

# Payment Gateway (Paystack for Ghana)
PAYSTACK_PUBLIC_KEY=pk_live_xxx
PAYSTACK_SECRET_KEY=sk_live_xxx
```

#### 5. Database Setup

```bash
# Create database
mysql -u root -p
CREATE DATABASE church_management;
EXIT;

# Run migrations
php artisan migrate --force

# Seed initial data (creates admin user)
php artisan db:seed --class=AdminUserSeeder --force
```

#### 6. Build Assets

```bash
# Production build
npm run build

# Or development with watch
npm run dev
```

#### 7. Storage Setup

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

#### 8. Cache Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

#### 9. Queue Worker (Optional but Recommended)

```bash
# Start queue worker
php artisan queue:work --daemon

# Or use Supervisor (production)
# See: https://laravel.com/docs/10.x/queues#supervisor-configuration
```

#### 10. Schedule Cron (Optional)

Add to crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## ⚙️ Configuration

### Church-Specific Settings

Edit `config/church.php` or use environment variables:

```php
return [
    'name' => env('CHURCH_NAME', 'My Church'),
    'address' => env('CHURCH_ADDRESS', ''),
    'phone' => env('CHURCH_PHONE', ''),
    'email' => env('CHURCH_EMAIL', ''),

    // Shepherd configuration
    'max_flock_size' => 15,

    // Attendance thresholds
    'attendance_committed_threshold' => 0.80, // 80%

    // Financial thresholds
    'dual_approval_amount' => 5000, // GHS

    // GPS verification
    'church_latitude' => 5.6037,
    'church_longitude' => -0.1870,
    'location_radius_meters' => 100,
];
```

### Feature Flags

```env
ENABLE_SMS_BROADCASTS=true
ENABLE_ONLINE_GIVING=true
ENABLE_TWO_FACTOR_AUTH=true
ENABLE_QR_CHECK_IN=true
ENABLE_GPS_VERIFICATION=true
```

---

## 📖 Usage

### Admin Dashboard

Access: `http://your-domain.com/admin`

**Features**:
- Real-time analytics dashboard
- Member management
- Financial oversight
- QR code generation
- SMS broadcasting
- System settings

### Mobile App

Access: `http://your-domain.com/mobile`

**Features**:
- Self-service registration
- QR check-in
- Mobile giving
- Event registration
- Profile management
- Ministry tools

### Installing PWA

**On iOS**:
1. Open in Safari
2. Tap Share button
3. Select "Add to Home Screen"

**On Android**:
1. Open in Chrome
2. Tap menu (⋮)
3. Select "Add to Home Screen"

---

## 📡 API Documentation

Full API documentation available at `SKILL.md` or online at:
`http://your-domain.com/api/documentation`

### Quick API Example

```bash
# Login
curl -X POST http://your-domain.com/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@church.com","password":"password123"}'

# Get members (with token)
curl -X GET http://your-domain.com/api/v1/members \
  -H "Authorization: Bearer your-token-here"
```

See `SKILL.md` for complete API reference.

---

## 📱 Mobile PWA

### Features
- ✅ Installable on home screen
- ✅ Offline functionality
- ✅ Push notifications
- ✅ Camera access (QR scanning)
- ✅ GPS location
- ✅ Fast and responsive

### Browser Support
- ✅ Chrome (Desktop & Mobile)
- ✅ Safari (Desktop & Mobile)
- ✅ Firefox (Desktop & Mobile)
- ✅ Edge (Desktop)

---

## 🤝 Contributing

We welcome contributions! See `CONTRIBUTING.md` for guidelines.

### Quick Contribution Guide

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🆘 Support

### Documentation

**Essential Guides:**
- **README.md** - This file (Quick start & overview)
- **USER_GUIDE.md** - Complete user manual
- **SKILL.md** - Full API reference
- **CONTRIBUTING.md** - How to contribute
- **CHANGELOG.md** - Version history

**Setup & Installation:**
- `docs/setup/QUICK_START.md` - Fast setup guide
- `docs/setup/BEGINNER_INSTALLATION_GUIDE.md` - Detailed beginner guide

**Deployment:**
- `docs/deployment/DEPLOYMENT_GUIDE.md` - Production deployment guide

**Features:**
- `docs/features/qr-system/QR_QUICK_START_GUIDE.md` - QR code quick start
- `docs/features/qr-system/QR_SCHEDULER_SETUP_GUIDE.md` - QR scheduler setup

**Mobile PWA:**
- `docs/mobile-pwa/PWA_SETUP_GUIDE.md` - PWA setup guide
- `docs/mobile-pwa/PWA_TESTING_GUIDE.md` - PWA testing guide
- `docs/mobile-pwa/MOBILE_LOGIN_GUIDE.md` - Mobile login guide
- `docs/mobile-pwa/MOBILE_QUICK_REFERENCE.md` - Mobile quick reference

**Architecture & Design:**
- `docs/project-documentation/01_PROJECT_OVERVIEW.md` - Project overview
- `docs/project-documentation/02_TECH_STACK.md` - Technology stack
- `docs/project-documentation/03_DATABASE_DESIGN.md` - Database design
- `docs/project-documentation/04_API_DOCUMENTATION.md` - API architecture
- `docs/project-documentation/05_FRONTEND_ARCHITECTURE.md` - Frontend architecture
- `docs/project-documentation/06_AUTHENTICATION_COMPLETE.md` - Authentication system
- `docs/project-documentation/07_FEATURE_MODULES_UPDATED.md` - Feature modules
- `docs/project-documentation/QR_CODE_IMPLEMENTATION_SPEC.md` - QR code specification
- `docs/project-documentation/UI_UX_CONSISTENCY_GUIDE.md` - UI/UX guidelines

**Security:**
- `docs/security/SECURITY_AUDIT_REPORT.md` - Security audit report

**Development:**
- `docs/implementation-guides/NEXT_STEPS.md` - Future development roadmap

### Community
- **GitHub Issues**: [Report bugs](https://github.com/your-org/church-cms/issues)
- **Discussions**: [Ask questions](https://github.com/your-org/church-cms/discussions)
- **Email**: support@yourchurch.com

### Professional Support
For professional support, training, and custom development:
- **Email**: enterprise@yourchurch.com
- **Website**: https://yourchurch.com/support

---

## 🎯 Roadmap

### Version 2.0 (Planned)
- [ ] Mobile apps (iOS & Android) with React Native
- [ ] Advanced analytics with AI insights
- [ ] Multi-church support (network)
- [ ] Accounting integration (QuickBooks, Xero)
- [ ] Video streaming integration
- [ ] Advanced CRM features
- [ ] Multi-language support (Twi, Ga, Ewe)
- [ ] Biometric authentication

---

## 🏆 Acknowledgments

### Built With
- [Laravel](https://laravel.com) - The PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS
- [Alpine.js](https://alpinejs.dev) - Minimal JavaScript framework
- [SimpleSoftwareIO/simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode) - QR code generation

### Inspired By
Modern church management needs and feedback from church leaders.

---

## 📊 Project Statistics

```
Total Lines of Code:     40,000+
Database Tables:         100+
API Endpoints:           250+
Mobile Pages:            24
Documentation Pages:     25 (streamlined from 68)
Test Coverage:           In Progress
```

---

## 🌟 Star History

If you find this project helpful, please consider giving it a star ⭐

---

**Made with ❤️ for churches worldwide**

**Version**: 1.0.0
**Last Updated**: December 28, 2025

---

## 📞 Contact

**Project Maintainer**: Your Name
**Email**: your-email@example.com
**Website**: https://yourchurch.com

---

[⬆ Back to top](#-church-management-system)
