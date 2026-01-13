<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ChurchCMS - Empowering Ministry Through Technology. Comprehensive church management platform for member management, attendance tracking, financial management, and more. Built specifically for modern ministries.">
    
    <title>ChurchCMS - Empowering Ministry Through Technology</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind Config and App Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass {
            @apply bg-white/80 backdrop-blur-xl border border-white/20;
        }
        .text-gradient-premium {
            @apply bg-gradient-premium bg-clip-text text-transparent;
        }
        .hero-pattern {
            background-color: #3b82f6;
            background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 selection:bg-primary-100 selection:text-primary-700">
    <!-- Navigation -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-6">
        <div class="container mx-auto px-6">
            <div class="glass rounded-2xl px-6 py-4 flex justify-between items-center shadow-soft">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-premium rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-church text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-heading font-black tracking-tight text-slate-800">Church<span class="text-primary-600">CMS</span></span>
                </a>

                <!-- Desktop Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Features</a>
                    <a href="#benefits" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Benefits</a>
                    <a href="#about" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">About</a>
                    <div class="h-6 w-px bg-slate-200"></div>
                    <a href="{{ route('login') }}" class="text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary px-6 py-2.5">
                        Start Now <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                <!-- Mobile Toggle -->
                <button class="md:hidden text-slate-600 hover:text-primary-600 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen pt-32 pb-20 flex items-center overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary-50/50 to-transparent"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary-200/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-48 -left-24 w-72 h-72 bg-accent-200/20 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="animate-fade-in">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-50 border border-primary-100 text-primary-700 text-xs font-bold tracking-wider uppercase mb-8">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                        </span>
                        Next-Gen Church Management
                    </div>
                    <h1 class="text-5xl md:text-7xl font-heading font-black text-slate-900 leading-[1.1] mb-8">
                        Empowering Ministry <br>
                        Through <span class="text-gradient-premium">Technology</span>
                    </h1>
                    <p class="text-lg md:text-xl text-slate-600 leading-relaxed mb-10 max-w-xl">
                        ChurchCMS is your complete management solution designed to help you focus on what matters most—building community and spreading faith. Streamline operations with intuitive tools.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="btn btn-primary px-8 py-4 text-lg">
                            Get Started Free <i class="fas fa-rocket ml-2"></i>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-secondary px-8 py-4 text-lg">
                            Admin Login <i class="fas fa-sign-in-alt ml-2"></i>
                        </a>
                    </div>
                    
                    <div class="mt-12 flex items-center gap-6">
                        <div class="flex -space-x-4">
                            @for($i = 1; $i <= 4; $i++)
                                <div class="w-12 h-12 rounded-full border-4 border-white bg-slate-200 flex items-center justify-center overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=User+{{$i}}&background=random" alt="User">
                                </div>
                            @endfor
                        </div>
                        <div class="text-sm font-medium text-slate-500">
                            <span class="text-slate-900 font-bold italic">Trusted by</span> <br>
                            500+ Ministries worldwide
                        </div>
                    </div>
                </div>

                <div class="relative animate-slide-up">
                    <div class="relative z-10 glass rounded-[2.5rem] p-4 shadow-2xl border-white/50 overflow-hidden transform hover:rotate-1 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1510127034890-ba27508e9f1c?auto=format&fit=crop&q=80&w=1000" class="rounded-[2rem] w-full shadow-inner shadow-black/10" alt="Church Dashboard">
                        
                        <!-- Floating Cards -->
                        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl animate-float max-w-[200px]">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-green-500/20 text-green-600 flex items-center justify-center">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-800">Growth</span>
                            </div>
                            <div class="text-2xl font-black text-slate-900">+24%</div>
                            <div class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Attendance this month</div>
                        </div>

                        <div class="absolute -top-6 -right-6 glass p-6 rounded-2xl shadow-xl animate-float-delayed max-w-[200px]">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-800">Giving</span>
                            </div>
                            <div class="text-2xl font-black text-slate-900">$12.5k</div>
                            <div class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Online donations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-20 animate-fade-in">
                <span class="badge badge-primary px-4 py-2 mb-6">Capabilities</span>
                <h2 class="text-4xl md:text-5xl font-heading font-black text-slate-900 mb-6">Everything Your Ministry Needs</h2>
                <p class="text-lg text-slate-600">Comprehensive tools designed specifically for modern church administration and member engagement</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Bento Grid Layout -->
                <div class="lg:col-span-2 lg:row-span-2 card card-hover p-8 flex flex-col justify-between group">
                    <div class="w-16 h-16 rounded-2xl bg-primary-100 text-primary-600 flex items-center justify-center mb-8 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-heading font-bold text-slate-900 mb-4">Member Management</h3>
                        <p class="text-slate-600 mb-6 italic leading-relaxed">Comprehensive profiles, lifecycle tracking, and secure document storage for every member of your congregation.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm font-medium text-slate-700">
                                <i class="fas fa-check-circle text-primary-500"></i> Family Units & Hierarchies
                            </li>
                            <li class="flex items-center gap-3 text-sm font-medium text-slate-700">
                                <i class="fas fa-check-circle text-primary-500"></i> Digital Directory
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card card-hover p-8 group">
                    <div class="w-12 h-12 rounded-xl bg-accent-100 text-accent-600 flex items-center justify-center mb-6 group-hover:bg-accent-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-slate-900 mb-3">Attendance</h3>
                    <p class="text-slate-600 text-sm">Real-time tracking with analytics and recurring service insights.</p>
                </div>

                <div class="card card-hover p-8 group">
                    <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-hand-holding-usd text-xl"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-slate-900 mb-3">Finance</h3>
                    <p class="text-slate-600 text-sm">Dual approval workflow for transparency and secure auditing.</p>
                </div>

                <div class="lg:col-span-2 card card-hover p-8 flex items-center gap-8 group">
                    <div class="w-20 h-20 flex-shrink-0 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-sms text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-heading font-bold text-slate-900 mb-2">SMS Broadcasting</h3>
                        <p class="text-slate-600 text-sm">Send targeted broadcasts with custom templates and track delivery status in real-time.</p>
                    </div>
                </div>

                <div class="card card-hover p-8 group">
                    <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center mb-6 group-hover:bg-red-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-pray text-xl"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-slate-900 mb-3">Prayer</h3>
                    <p class="text-slate-600 text-sm">Track requests and celebrate testimonies within your community.</p>
                </div>

                <div class="card card-hover p-8 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-child text-xl"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-slate-900 mb-3">Kids Ministry</h3>
                    <p class="text-slate-600 text-sm">Secure check-in/out and curriculum management for children.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 hero-pattern"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="text-center animate-slide-up">
                    <div class="text-5xl font-heading font-black text-white mb-2">500+</div>
                    <div class="text-primary-400 font-bold uppercase tracking-widest text-xs">Churches Served</div>
                </div>
                <div class="text-center animate-slide-up" style="animation-delay: 100ms">
                    <div class="text-5xl font-heading font-black text-white mb-2">50K+</div>
                    <div class="text-primary-400 font-bold uppercase tracking-widest text-xs">Active Members</div>
                </div>
                <div class="text-center animate-slide-up" style="animation-delay: 200ms">
                    <div class="text-5xl font-heading font-black text-white mb-2">99.9%</div>
                    <div class="text-primary-400 font-bold uppercase tracking-widest text-xs">Platform Uptime</div>
                </div>
                <div class="text-center animate-slide-up" style="animation-delay: 300ms">
                    <div class="text-5xl font-heading font-black text-white mb-2">24/7</div>
                    <div class="text-primary-400 font-bold uppercase tracking-widest text-xs">Support Desk</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-20">
                <span class="badge badge-warning px-4 py-2 mb-6">Why ChurchCMS</span>
                <h2 class="text-4xl md:text-5xl font-heading font-black text-slate-900 mb-6">Built for Modern Ministries</h2>
                <p class="text-lg text-slate-600">Experience the difference with our comprehensive, secure, and easy-to-use platform</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="card card-hover p-10 bg-white group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-8 border border-blue-100 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bolt text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold text-slate-900 mb-4">Lightning Fast</h3>
                    <p class="text-slate-600 leading-relaxed">Built with modern tech for optimal performance. No lagging, just smooth administration from any location.</p>
                </div>

                <div class="card card-hover p-10 bg-white group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-8 border border-indigo-100 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold text-slate-900 mb-4">Secure by Design</h3>
                    <p class="text-slate-600 leading-relaxed">Enterprise-grade encryption with role-based access control. Your data is protected by the highest industry standards.</p>
                </div>

                <div class="card card-hover p-10 bg-white group">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-8 border border-amber-100 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-mobile-alt text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold text-slate-900 mb-4">Mobile Ready</h3>
                    <p class="text-slate-600 leading-relaxed">Every feature is accessible from any device. Manage your ministry from your desk or while on mission.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-premium relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
        <div class="container mx-auto px-6 relative z-10 text-center text-white">
            <h2 class="text-4xl md:text-6xl font-heading font-black mb-8 animate-fade-in">Ready to Transform Your Ministry?</h2>
            <p class="text-xl md:text-2xl opacity-90 mb-12 max-w-3xl mx-auto leading-relaxed">
                Join hundreds of churches worldwide using ChurchCMS to streamline operations and engage their communities more effectively
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center animate-slide-up">
                <a href="{{ route('register') }}" class="btn bg-white text-primary-700 px-10 py-5 text-xl font-bold hover:bg-slate-50 hover:scale-105 transition-all shadow-2xl">
                    Get Started Free <i class="fas fa-sparkles ml-2"></i>
                </a>
                <a href="{{ route('login') }}" class="btn border-2 border-white/40 text-white px-10 py-5 text-xl font-bold hover:bg-white/10 transition-all">
                    Admin Access <i class="fas fa-lock ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="about" class="bg-slate-950 text-white pt-24 pb-12">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-4 gap-16 mb-20">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-church text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-heading font-black tracking-tight">Church<span class="text-primary-500">CMS</span></span>
                    </div>
                    <p class="text-slate-400 text-lg leading-relaxed max-w-md mb-8 italic">
                        "Empowering ministries through state-of-the-art technology, so you can focus on the mission that matters most."
                    </p>
                    <div class="flex gap-4">
                        @foreach(['facebook', 'twitter', 'instagram', 'youtube'] as $social)
                            <a href="#" class="w-10 h-10 rounded-full border border-slate-800 flex items-center justify-center hover:bg-primary-600 hover:border-primary-600 transition-all text-slate-400 hover:text-white">
                                <i class="fab fa-{{$social}}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-8">Platform</h4>
                    <ul class="space-y-4">
                        <li><a href="#features" class="text-slate-400 hover:text-primary-400 transition-colors">Core Features</a></li>
                        <li><a href="#benefits" class="text-slate-400 hover:text-primary-400 transition-colors">Why Choose Us</a></li>
                        <li><a href="{{ route('login') }}" class="text-slate-400 hover:text-primary-400 transition-colors">Admin Portal</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-400 hover:text-primary-400 transition-colors">Start Free Trial</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-8">Support</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-slate-400 hover:text-primary-400 transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-primary-400 transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-primary-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-primary-400 transition-colors">Contact US</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-12 border-t border-slate-900 flex flex-col md:row justify-between items-center gap-6">
                <p class="text-slate-500 text-sm italic">&copy; {{ date('Y') }} ChurchCMS. Built with ❤️ for the Global Church.</p>
                <div class="flex items-center gap-8 text-xs font-bold text-slate-600 uppercase tracking-widest">
                    <a href="#">Status</a>
                    <a href="#">Terms</a>
                    <a href="#">Security</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('py-4');
                navbar.querySelector('.container').classList.add('max-w-7xl');
            } else {
                navbar.classList.remove('py-4');
                navbar.querySelector('.container').classList.remove('max-w-7xl');
            }
        });
    </script>
</body>
</html>
