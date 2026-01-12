<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ChurchCMS - Empowering Ministry Through Technology. Comprehensive church management platform for member management, attendance tracking, financial management, and more. Built specifically for modern ministries.">
    <title>ChurchCMS - Empowering Ministry Through Technology</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Church CMS Brand Colors */
            --primary: #6B46C1;
            --primary-dark: #553C9A;
            --primary-light: #9F7AEA;
            --secondary: #F6AD55;
            --secondary-dark: #ED8936;
            --secondary-light: #FBD38D;
            --accent: #38B2AC;
            --dark: #2D3748;
            --dark-light: #4A5568;
            --gray: #718096;
            --light: #F7FAFC;
            --white: #ffffff;
            --gradient: linear-gradient(135deg, #6B46C1 0%, #F6AD55 100%);
            --gradient-reverse: linear-gradient(135deg, #F6AD55 0%, #6B46C1 100%);
            --gradient-soft: linear-gradient(135deg, rgba(107, 70, 193, 0.05) 0%, rgba(246, 173, 85, 0.05) 100%);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background: var(--white);
            overflow-x: hidden;
        }

        /* Modern Navigation with Glassmorphism */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 1.25rem 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(107, 70, 193, 0.1);
        }

        nav.scrolled {
            padding: 0.875rem 0;
            box-shadow: 0 10px 40px rgba(107, 70, 193, 0.1);
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .logo i {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2rem;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            font-size: 0.938rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:not(.btn)::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient);
            transition: width 0.3s ease;
        }

        .nav-links a:not(.btn):hover::after {
            width: 100%;
        }

        .nav-links a:not(.btn):hover {
            color: var(--primary);
        }

        /* Modern Buttons */
        .btn {
            padding: 0.875rem 1.75rem;
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.938rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--white);
            box-shadow: 0 4px 20px rgba(107, 70, 193, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(107, 70, 193, 0.4);
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
        }

        .btn-large {
            padding: 1.125rem 2.25rem;
            font-size: 1rem;
            border-radius: 1rem;
        }

        .btn-white {
            background: var(--white);
            color: var(--primary);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        /* Modern Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #6B46C1 0%, #8B5CF6 50%, #F6AD55 100%);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hero-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 4rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--white);
            letter-spacing: -0.03em;
            animation: fadeInUp 0.8s ease;
        }

        .hero-content .highlight {
            background: linear-gradient(135deg, #FBD38D 0%, #FFFFFF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.25rem;
            line-height: 1.8;
            margin-bottom: 2.5rem;
            color: rgba(255, 255, 255, 0.95);
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        /* Hero Illustration */
        .hero-visual {
            position: relative;
            animation: fadeInRight 0.8s ease 0.6s both;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        .hero-card-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .hero-stat {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 0.5rem;
        }

        .hero-stat-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Features Section - Bento Box Layout */
        .features {
            padding: 8rem 2rem;
            background: var(--light);
            position: relative;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 5rem;
            animation: fadeInUp 0.8s ease;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: var(--gradient-soft);
            color: var(--primary);
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(107, 70, 193, 0.15);
        }

        .section-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.25rem;
            color: var(--dark);
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* Bento Grid Layout */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .bento-item {
            background: var(--white);
            border-radius: 1.5rem;
            padding: 2rem;
            border: 1px solid rgba(107, 70, 193, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .bento-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .bento-item:hover::before {
            transform: scaleX(1);
        }

        .bento-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(107, 70, 193, 0.15);
            border-color: var(--primary-light);
        }

        .bento-item.large {
            grid-column: span 2;
        }

        .bento-item.tall {
            grid-row: span 2;
        }

        .bento-icon {
            width: 70px;
            height: 70px;
            background: var(--gradient);
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: var(--white);
            box-shadow: 0 8px 20px rgba(107, 70, 193, 0.3);
        }

        .bento-title {
            font-size: 1.375rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }

        .bento-description {
            color: var(--gray);
            line-height: 1.7;
            font-size: 0.938rem;
        }

        /* Stats Section */
        .stats {
            padding: 6rem 2rem;
            background: var(--gradient);
            color: var(--white);
            position: relative;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        .stat-card {
            text-align: center;
            animation: fadeInUp 0.8s ease;
        }

        .stat-number {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .stat-label {
            font-size: 1.125rem;
            opacity: 0.95;
            font-weight: 500;
        }

        /* Benefits Section with Cards */
        .benefits {
            padding: 8rem 2rem;
            background: var(--white);
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 4rem;
        }

        .benefit-card {
            background: var(--gradient-soft);
            border-radius: 1.5rem;
            padding: 2.5rem;
            border: 1px solid rgba(107, 70, 193, 0.15);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .benefit-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(107, 70, 193, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .benefit-card:hover::after {
            opacity: 1;
        }

        .benefit-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(107, 70, 193, 0.15);
            border-color: var(--primary);
        }

        .benefit-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--white);
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(107, 70, 193, 0.3);
        }

        .benefit-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }

        .benefit-text {
            color: var(--gray);
            line-height: 1.7;
        }

        /* CTA Section */
        .cta {
            padding: 8rem 2rem;
            background: var(--gradient);
            color: var(--white);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .cta p {
            font-size: 1.375rem;
            margin-bottom: 3rem;
            opacity: 0.95;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            gap: 1.25rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: var(--white);
            padding: 5rem 2rem 2rem;
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr repeat(3, 1fr);
            gap: 4rem;
            margin-bottom: 3rem;
        }

        .footer-brand {
            max-width: 350px;
        }

        .footer-logo {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .footer-logo i {
            color: var(--secondary);
        }

        .footer-tagline {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 0.938rem;
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .footer-section h3 {
            margin-bottom: 1.25rem;
            font-weight: 700;
            font-size: 1.125rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.75rem;
        }

        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-section a:hover {
            color: var(--secondary);
            transform: translateX(4px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }

        .footer-bottom p {
            margin-bottom: 0.5rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .bento-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .bento-item.large,
            .bento-item.tall {
                grid-column: span 1;
                grid-row: span 1;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .benefits-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content p {
                font-size: 1.125rem;
            }

            .section-title {
                font-size: 2.25rem;
            }

            .nav-links {
                display: none;
            }

            .bento-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .cta h2 {
                font-size: 2.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-church"></i>
                <span>ChurchCMS</span>
            </div>
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#benefits">Benefits</a>
                <a href="#about">About</a>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>
                    Empowering Ministry<br>
                    Through <span class="highlight">Technology</span>
                </h1>
                <p>
                    ChurchCMS is your complete church management solution designed to help you focus on what matters most—building community and spreading faith. Streamline operations with powerful, intuitive tools built for modern ministries.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn btn-white btn-large">
                        <i class="fas fa-sign-in-alt"></i> Admin Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline btn-large" style="border-color: white; color: white;">
                        <i class="fas fa-rocket"></i> Get Started Free
                    </a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-card">
                    <div class="hero-card-grid">
                        <div class="hero-stat">
                            <div class="hero-stat-number">20+</div>
                            <div class="hero-stat-label">Modules</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-number">250+</div>
                            <div class="hero-stat-label">Features</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-number">100%</div>
                            <div class="hero-stat-label">Secure</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-number">24/7</div>
                            <div class="hero-stat-label">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section - Bento Grid -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">
                    <i class="fas fa-stars"></i> POWERFUL FEATURES
                </span>
                <h2 class="section-title">Everything Your Ministry Needs</h2>
                <p class="section-subtitle">
                    Comprehensive tools designed specifically for modern church administration and member engagement
                </p>
            </div>

            <div class="bento-grid">
                <div class="bento-item large">
                    <div class="bento-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="bento-title">Member Management</h3>
                    <p class="bento-description">
                        Comprehensive member profiles, family tracking, lifecycle management, and document storage. Keep all member information organized and accessible in one secure platform.
                    </p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="bento-title">Attendance Tracking</h3>
                    <p class="bento-description">
                        Real-time attendance tracking with analytics and insights.
                    </p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="bento-title">Financial Management</h3>
                    <p class="bento-description">
                        Complete financial tracking with dual approval workflow.
                    </p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="bento-title">Event Management</h3>
                    <p class="bento-description">
                        Plan programs and track registrations effortlessly.
                    </p>
                </div>

                <div class="bento-item large">
                    <div class="bento-icon">
                        <i class="fas fa-sms"></i>
                    </div>
                    <h3 class="bento-title">SMS Broadcasting</h3>
                    <p class="bento-description">
                        Send targeted SMS broadcasts to members with custom templates, track delivery status, and schedule messages for maximum engagement.
                    </p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <i class="fas fa-pray"></i>
                    </div>
                    <h3 class="bento-title">Prayer Management</h3>
                    <p class="bento-description">
                        Track prayer requests and celebrate answered prayers.
                    </p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3 class="bento-title">Children's Ministry</h3>
                    <p class="bento-description">
                        Secure check-in/out system with curriculum management.
                    </p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h3 class="bento-title">QR Code System</h3>
                    <p class="bento-description">
                        Streamline check-ins with QR codes for everything.
                    </p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="bento-title">Advanced Reporting</h3>
                    <p class="bento-description">
                        Custom reports and analytics for data-driven decisions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">500+</div>
                <div class="stat-label">Churches Served</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">50K+</div>
                <div class="stat-label">Active Members</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">99.9%</div>
                <div class="stat-label">Uptime</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Support Available</div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="benefits">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">
                    <i class="fas fa-star"></i> WHY CHOOSE US
                </span>
                <h2 class="section-title">Built for Modern Ministries</h2>
                <p class="section-subtitle">
                    Experience the difference with our comprehensive, secure, and easy-to-use platform
                </p>
            </div>

            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="benefit-title">Lightning Fast</h3>
                    <p class="benefit-text">
                        Built with modern technology for optimal performance and 99.9% uptime guarantee.
                    </p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="benefit-title">Bank-Level Security</h3>
                    <p class="benefit-text">
                        Enterprise-grade encryption with role-based access control and complete audit logging.
                    </p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="benefit-title">Mobile-First Design</h3>
                    <p class="benefit-text">
                        Access from anywhere on any device with our responsive interface.
                    </p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="benefit-title">Easy to Use</h3>
                    <p class="benefit-text">
                        Intuitive interface designed for all skill levels with comprehensive training.
                    </p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="benefit-title">Powerful Analytics</h3>
                    <p class="benefit-text">
                        Real-time insights and data visualization for informed decision making.
                    </p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="benefit-title">Dedicated Support</h3>
                    <p class="benefit-text">
                        Expert support team ready to help with setup, training, and assistance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2>Ready to Transform Your Ministry?</h2>
            <p>
                Join hundreds of churches worldwide using ChurchCMS to streamline operations and engage their communities more effectively
            </p>
            <div class="cta-buttons">
                <a href="{{ route('login') }}" class="btn btn-white btn-large">
                    <i class="fas fa-sign-in-alt"></i> Admin Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline btn-large" style="border-color: white; color: white;">
                    <i class="fas fa-rocket"></i> Start Free Trial
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="about">
        <div class="footer-content container">
            <div class="footer-brand">
                <div class="footer-logo">
                    <i class="fas fa-church"></i>
                    <span>ChurchCMS</span>
                </div>
                <div class="footer-tagline">Empowering Ministry Through Technology</div>
                <p class="footer-description">
                    A comprehensive church management platform designed to empower ministries worldwide. From member management to financial tracking, we help churches focus on their mission by simplifying administration.
                </p>
            </div>

            <div class="footer-section">
                <h3>Platform</h3>
                <ul>
                    <li><a href="#features"><i class="fas fa-arrow-right"></i> Features</a></li>
                    <li><a href="#benefits"><i class="fas fa-arrow-right"></i> Benefits</a></li>
                    <li><a href="{{ route('login') }}"><i class="fas fa-arrow-right"></i> Login</a></li>
                    <li><a href="{{ route('register') }}"><i class="fas fa-arrow-right"></i> Register</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Resources</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-arrow-right"></i> Documentation</a></li>
                    <li><a href="#"><i class="fas fa-arrow-right"></i> Help Center</a></li>
                    <li><a href="#"><i class="fas fa-arrow-right"></i> Contact Us</a></li>
                    <li><a href="#"><i class="fas fa-arrow-right"></i> Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Connect</h3>
                <ul>
                    <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="#"><i class="fab fa-youtube"></i> YouTube</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom container">
            <p>&copy; {{ date('Y') }} ChurchCMS. All rights reserved. Built with ❤️ for churches worldwide.</p>
            <p style="margin-top: 0.5rem; font-size: 0.875rem; opacity: 0.8;">Empowering Ministry Through Technology</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.8s ease forwards';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.bento-item, .benefit-card, .stat-card').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
