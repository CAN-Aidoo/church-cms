<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transform your church management with our comprehensive, modern Church Management System. Streamline operations, engage members, and grow your ministry.">
    <title>{{ config('app.name') }} - Modern Church Management System</title>

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
            /* Brand Colors - Blue & Gold Theme */
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #60a5fa;
            --secondary: #f59e0b;
            --secondary-dark: #d97706;
            --secondary-light: #fbbf24;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --gray: #64748b;
            --light: #f8fafc;
            --white: #ffffff;
            /* Brand Gradients - Blue to Gold */
            --gradient: linear-gradient(135deg, #3b82f6 0%, #f59e0b 100%);
            --gradient-reverse: linear-gradient(135deg, #f59e0b 0%, #3b82f6 100%);
            --gradient-soft: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(245, 158, 11, 0.1) 100%);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background: var(--white);
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: var(--shadow-sm);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        nav.scrolled {
            padding: 0.5rem 0;
            box-shadow: var(--shadow);
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
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--gray);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--white);
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
        }

        .btn-large {
            padding: 1rem 2rem;
            font-size: 1.125rem;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: var(--gradient);
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)" /></svg>');
            opacity: 0.3;
        }

        .hero-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            max-width: 700px;
            color: var(--white);
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.8s ease;
        }

        .hero p {
            font-size: 1.25rem;
            line-height: 1.8;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
            animation: fadeInUp 0.8s ease 0.6s both;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            opacity: 0.9;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Features Section */
        .features {
            padding: 8rem 2rem;
            background: var(--light);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: var(--gradient-soft);
            color: var(--primary);
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: var(--white);
            box-shadow: var(--shadow);
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }

        .feature-description {
            color: var(--gray);
            line-height: 1.6;
        }

        /* Benefits Section */
        .benefits {
            padding: 8rem 2rem;
            background: var(--white);
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 4rem;
            align-items: center;
        }

        .benefits-image {
            position: relative;
        }

        .benefits-image img {
            width: 100%;
            border-radius: 1rem;
            box-shadow: var(--shadow-xl);
        }

        .benefits-content h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .benefit-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .benefit-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-soft);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--primary);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .benefit-text h3 {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--dark);
        }

        .benefit-text p {
            color: var(--gray);
            font-size: 0.938rem;
        }

        /* CTA Section */
        .cta {
            padding: 6rem 2rem;
            background: var(--gradient);
            color: var(--white);
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.125rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-white {
            background: var(--white);
            color: var(--primary);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: var(--white);
            padding: 3rem 2rem 1.5rem;
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: var(--white);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Floating shapes */
        .floating-shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            top: 10%;
            right: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            bottom: 20%;
            left: 10%;
            animation-delay: 2s;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-church"></i> {{ config('app.name') }}
            </div>
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#benefits">Benefits</a>
                <a href="#about">About</a>
                <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <!-- Floating shapes -->
        <div class="floating-shape shape-1">
            <svg width="100" height="100" viewBox="0 0 100 100" fill="currentColor">
                <circle cx="50" cy="50" r="40"/>
            </svg>
        </div>
        <div class="floating-shape shape-2">
            <svg width="120" height="120" viewBox="0 0 100 100" fill="currentColor">
                <rect x="10" y="10" width="80" height="80" rx="20"/>
            </svg>
        </div>

        <div class="hero-container">
            <div class="hero-content">
                <h1>Transform Your Church Management</h1>
                <p>
                    Empower your ministry with our comprehensive Church Management System.
                    Streamline operations, engage members, track attendance, manage finances,
                    and grow your church community with powerful, easy-to-use tools.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn btn-white btn-large">
                        <i class="fas fa-sign-in-alt"></i> Admin Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline btn-large" style="border-color: white; color: white;">
                        <i class="fas fa-user-plus"></i> Get Started
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat">
                        <div class="stat-number">20+</div>
                        <div class="stat-label">Modules</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">250+</div>
                        <div class="stat-label">Features</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Secure</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Access</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">POWERFUL FEATURES</span>
                <h2 class="section-title">Everything You Need to Manage Your Church</h2>
                <p class="section-subtitle">
                    Comprehensive tools designed specifically for modern church administration and member engagement
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Member Management</h3>
                    <p class="feature-description">
                        Comprehensive member profiles, family tracking, lifecycle management,
                        and document storage. Keep all member information organized and accessible.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Attendance Tracking</h3>
                    <p class="feature-description">
                        Track service attendance, generate reports, identify trends, and engage
                        with absentees. Real-time analytics and insights at your fingertips.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="feature-title">Financial Management</h3>
                    <p class="feature-description">
                        Complete financial tracking with income/expense management, dual approval
                        workflow, budget tracking, and comprehensive financial reports.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="feature-title">Event & Program Management</h3>
                    <p class="feature-description">
                        Plan and manage church programs, handle registrations, track attendance,
                        and measure program effectiveness with detailed analytics.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sms"></i>
                    </div>
                    <h3 class="feature-title">SMS Broadcasting</h3>
                    <p class="feature-description">
                        Send targeted SMS broadcasts to members, use custom templates, track
                        delivery status, and schedule messages for optimal engagement.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-pray"></i>
                    </div>
                    <h3 class="feature-title">Prayer Management</h3>
                    <p class="feature-description">
                        Receive and track prayer requests, assign to prayer teams, monitor
                        progress, and celebrate answered prayers with testimonies.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3 class="feature-title">Children's Ministry</h3>
                    <p class="feature-description">
                        Secure check-in/check-out system, curriculum management, event planning,
                        and comprehensive reporting for your children's programs.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="feature-title">Advanced Reporting</h3>
                    <p class="feature-description">
                        Custom report builder, scheduled reports, analytics dashboard, and
                        export capabilities for data-driven decision making.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h3 class="feature-title">QR Code System</h3>
                    <p class="feature-description">
                        Generate QR codes for services, events, payments, and member registration.
                        Streamline check-ins and enhance member experience.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="benefits">
        <div class="container">
            <div class="benefits-grid">
                <div class="benefits-content">
                    <h2>Why Choose Our Church Management System?</h2>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Lightning Fast & Reliable</h3>
                            <p>Built with modern technology for optimal performance and 99.9% uptime guarantee</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Bank-Level Security</h3>
                            <p>Enterprise-grade encryption, role-based access control, and audit logging</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Mobile-First Design</h3>
                            <p>Access from anywhere on any device with our responsive, mobile-optimized interface</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Easy to Use</h3>
                            <p>Intuitive interface designed for all skill levels with comprehensive training resources</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Powerful Analytics</h3>
                            <p>Real-time insights and data visualization to help you make informed decisions</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Dedicated Support</h3>
                            <p>Expert support team ready to help you succeed with setup, training, and ongoing assistance</p>
                        </div>
                    </div>
                </div>

                <div class="benefits-image">
                    <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <rect width="500" height="500" fill="url(#grad1)" rx="20"/>
                        <circle cx="250" cy="250" r="80" fill="white" opacity="0.3"/>
                        <circle cx="250" cy="250" r="60" fill="white" opacity="0.5"/>
                        <circle cx="250" cy="250" r="40" fill="white" opacity="0.7"/>
                        <path d="M 250 200 L 280 240 L 250 280 L 220 240 Z" fill="white"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Transform Your Church?</h2>
            <p>Join hundreds of churches already using our platform to grow and engage their communities</p>
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
            <div class="footer-section">
                <h3><i class="fas fa-church"></i> {{ config('app.name') }}</h3>
                <p>
                    Empowering churches with modern management tools to focus on what matters most -
                    building community and spreading faith.
                </p>
            </div>

            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#benefits">Benefits</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
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
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved. Built with ❤️ for churches worldwide.</p>
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

        // Smooth scrolling for anchor links
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
    </script>
</body>
</html>
