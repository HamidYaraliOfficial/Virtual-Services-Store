<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Security headers
secureHeaders();
// Get current page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Load services
$services = loadServices();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شاپ آنلاین - فروشگاه مدرن خدمات دیجیتال</title>
    <meta name="csrf-token" content="<?php echo htmlspecialchars(getCsrfToken()); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite alternate',
                        'slide-up': 'slide-up 0.5s ease-out',
                        'fade-in': 'fade-in 0.6s ease-out'
                    },
                    keyframes: {
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        'pulse-glow': {
                            '0%': { 'box-shadow': '0 0 0 0 rgba(59, 130, 246, 0.7)' },
                            '100%': { 'box-shadow': '0 0 0 20px rgba(59, 130, 246, 0)' }
                        },
                        'slide-up': {
                            '0%': { transform: 'translateY(100px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        'fade-in': {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Vazirmatn', sans-serif !important;
        }
        
        body, html {
            font-family: 'Vazirmatn', sans-serif !important;
            direction: rtl;
            overflow-x: hidden;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .gradient-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
            background-size: 400% 400%;
            animation: gradient-x 15s ease infinite;
        }
        
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .premium-card {
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .premium-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-premium {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-premium:hover::before {
            left: 100%;
        }
        
        .dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            left: 0;
            top: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #e5e7eb;
            min-width: 192px;
            z-index: 1000;
            margin-top: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }
        
        .dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .hero-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
        }
        
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .product-card {
            background: white;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .product-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 20px 40px -12px rgba(59, 130, 246, 0.2);
        }
        
        .floating-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        .floating-icon:nth-child(2) { animation-delay: -1s; }
        .floating-icon:nth-child(3) { animation-delay: -2s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .nav-item {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        }
        
        .stats-number {
            font-weight: 800;
            color: #1e40af;
        }
        
        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            z-index: 9999;
            transition: width 0.3s ease;
        }
        
        .pulse-blue {
            animation: pulse-blue 2s infinite;
        }
        
        @keyframes pulse-blue {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .service-icon {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .product-card:hover .service-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50 overflow-x-hidden">
    <!-- Scroll Indicator -->
    <div class="scroll-indicator" id="scrollIndicator"></div>
    
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-sm fixed top-0 w-full z-50 border-b border-gray-200 transition-all duration-300" id="header">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="w-14 h-14 gradient-bg rounded-2xl flex items-center justify-center animate-pulse-glow">
                        <?php echo getIcon('cart', 28); ?>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-gradient">شاپ آنلاین</h1>
                        <p class="text-sm font-medium bg-gradient-to-r from-gray-600 to-gray-800 bg-clip-text text-transparent">فروشگاه مدرن و پیشرفته</p>
                    </div>
                </div>
                
                <nav class="hidden lg:flex items-center space-x-2 space-x-reverse">
                    <a href="index.php" class="nav-item flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium px-4 py-2 rounded-xl hover:bg-blue-50 transition-all duration-300">
                        <?php echo getIcon('home', 18); ?> خانه
                    </a>
                    <a href="?page=services" class="nav-item flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium px-4 py-2 rounded-xl hover:bg-blue-50 transition-all duration-300">
                        <?php echo getIcon('services', 18); ?> محصولات
                    </a>
                    <a href="?page=about" class="nav-item flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium px-4 py-2 rounded-xl hover:bg-blue-50 transition-all duration-300">
                        <?php echo getIcon('about', 18); ?> درباره ما
                    </a>
                    <a href="?page=contact" class="nav-item flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium px-4 py-2 rounded-xl hover:bg-blue-50 transition-all duration-300">
                        <?php echo getIcon('contact', 18); ?> تماس
                    </a>
                </nav>
                
                <div class="flex items-center space-x-4 space-x-reverse">
                    <a href="?page=cart" class="relative p-3 text-gray-600 hover:text-blue-600 transition-all duration-300 hover-lift premium-card rounded-2xl group">
                        <div class="group-hover:scale-110 transition-transform duration-300">
                            <?php echo getIcon('cart', 24); ?>
                        </div>
                        <span class="absolute -top-2 -right-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold cart-count animate-pulse">
                            <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                        </span>
                    </a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown" id="userDropdown">
                            <button onclick="toggleDropdown()" class="btn-premium text-white px-6 py-3 rounded-2xl font-semibold flex items-center gap-2 hover-lift shadow-lg">
                                <?php echo getIcon('user', 20); ?>
                                <?php echo $_SESSION['username']; ?>
                                <?php echo getIcon('chevron-down', 16); ?>
                            </button>
                            <div class="dropdown-menu premium-card">
                                <a href="?page=dashboard" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-t-xl transition-all duration-300">
                                    <?php echo getIcon('dashboard', 20); ?> داشبورد
                                </a>
                                <a href="?page=profile" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                                    <?php echo getIcon('profile', 20); ?> پروفایل
                                </a>
                                <a href="?page=orders" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                                    <?php echo getIcon('orders', 20); ?> سفارشات من
                                </a>
                                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-b-xl transition-all duration-300">
                                    <?php echo getIcon('logout', 20); ?> خروج
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="?page=login" class="btn-premium text-white px-8 py-3 rounded-2xl font-semibold hover-lift shadow-lg">
                            ورود / ثبت نام
                        </a>
                    <?php endif; ?>
                    <button onclick="toggleMobileMenu()" class="lg:hidden p-3 text-gray-600 premium-card rounded-2xl hover:bg-gray-50 transition-all duration-300 hover-lift">
                        <?php echo getIcon('menu', 24); ?>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="lg:hidden glass-effect border-t border-gray-200 hidden animate-slide-up">
            <div class="container mx-auto px-4 py-6">
                <nav class="flex flex-col space-y-2">
                    <a href="index.php" class="flex items-center gap-3 text-gray-700 font-medium py-3 px-4 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                        <?php echo getIcon('home', 20); ?> خانه
                    </a>
                    <a href="?page=services" class="flex items-center gap-3 text-gray-700 font-medium py-3 px-4 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                        <?php echo getIcon('services', 20); ?> محصولات
                    </a>
                    <a href="?page=about" class="flex items-center gap-3 text-gray-700 font-medium py-3 px-4 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                        <?php echo getIcon('about', 20); ?> درباره ما
                    </a>
                    <a href="?page=contact" class="flex items-center gap-3 text-gray-700 font-medium py-3 px-4 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                        <?php echo getIcon('contact', 20); ?> تماس
                    </a>
                    <a href="?page=cart" class="flex items-center gap-3 text-gray-700 font-medium py-3 px-4 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                        <?php echo getIcon('cart', 20); ?> سبد خرید
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <?php
        switch ($page) {
            case 'home':
                include 'pages/home.php';
                break;
            case 'services':
                include 'pages/services.php';
                break;
            case 'service':
                include 'pages/service-detail.php';
                break;
            case 'cart':
                include 'pages/cart.php';
                break;
            case 'checkout':
                include 'pages/checkout.php';
                break;
            case 'login':
                include 'pages/login.php';
                break;
            case 'register':
                include 'pages/register.php';
                break;
            case 'dashboard':
                include 'pages/dashboard.php';
                break;
            case 'profile':
                include 'pages/profile.php';
                break;
            case 'about':
                include 'pages/about.php';
                break;
            case 'contact':
                include 'pages/contact.php';
                break;
            case 'orders':
                include 'pages/orders.php';
                break;
            case 'favorites':
                include 'pages/favorites.php';
                break;
            case 'tickets':
                include 'pages/tickets.php';
                break;
            default:
                include 'pages/404.php';
                break;
        }
        ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-3 space-x-reverse mb-6">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">شاپ آنلاین</h3>
                            <p class="text-gray-400">فروشگاه مدرن دیجیتال</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        بهترین فروشگاه خدمات دیجیتال با کیفیت فوق‌العاده و پشتیبانی ۲۴ ساعته.
                    </p>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="text-xl font-bold mb-6">محصولات</h4>
                    <ul class="space-y-3">
                        <li><a href="?page=services" class="text-gray-400 hover:text-white transition-colors">خدمات مجازی</a></li>
                        <li><a href="?page=services" class="text-gray-400 hover:text-white transition-colors">طراحی وب‌سایت</a></li>
                        <li><a href="?page=services" class="text-gray-400 hover:text-white transition-colors">اپلیکیشن موبایل</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="text-xl font-bold mb-6">پشتیبانی</h4>
                    <ul class="space-y-3">
                        <li><a href="?page=about" class="text-gray-400 hover:text-white transition-colors">درباره ما</a></li>
                        <li><a href="?page=contact" class="text-gray-400 hover:text-white transition-colors">تماس با ما</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">سوالات متداول</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-xl font-bold mb-6">تماس با ما</h4>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <i class="fas fa-phone text-blue-400"></i>
                            <span class="text-gray-400">۰۲۱-۱۲۳۴۵۶۷۸</span>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <i class="fas fa-envelope text-blue-400"></i>
                            <span class="text-gray-400">info@shop.com</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 mb-4 md:mb-0">
                        © ۱۴۰۲ شاپ آنلاین. تمامی حقوق محفوظ است.
                    </p>
                    <div class="flex items-center space-x-6 space-x-reverse">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <i class="fas fa-shield-alt text-green-400"></i>
                            <span class="text-gray-400">پرداخت امن</span>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <i class="fas fa-award text-yellow-400"></i>
                            <span class="text-gray-400">کیفیت تضمینی</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navigation Functions
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Dropdown Functions
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('active');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Cart AJAX functionality
        function handleCartOperation(form, event) {
            event.preventDefault();
            
            const formData = new FormData(form);
            
            fetch('ajax/cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('موفق', data.message, 'success');
                    // Update cart count in header
                    const cartCountElement = document.querySelector('.cart-count');
                    if (cartCountElement && data.cart_count !== undefined) {
                        cartCountElement.textContent = data.cart_count;
                    }
                    // If on cart page, reload the page to update the display
                    if (window.location.search.includes('page=cart')) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                } else {
                    showToast('خطا', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('خطا', 'خطایی در ارتباط با سرور رخ داد', 'error');
            });
        }

        // Premium toast notification function
        function showToast(title, message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-24 left-4 z-50 p-4 rounded-2xl shadow-2xl max-w-sm transform translate-x-full transition-all duration-500 ease-out ${
                type === 'success' ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white' :
                type === 'error' ? 'bg-gradient-to-r from-red-400 to-red-600 text-white' :
                'bg-gradient-to-r from-blue-400 to-indigo-500 text-white'
            }`;
            
            const iconSvg = type === 'success' ? 
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>' :
                type === 'error' ? 
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>' :
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>';
            
            toast.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        ${iconSvg}
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-sm">${title}</div>
                        <div class="text-sm opacity-90">${message}</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 opacity-70 hover:opacity-100 transition-opacity">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Remove toast after 4 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 500);
            }, 4000);
        }

        // Initialize cart forms on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all cart forms
            const cartForms = document.querySelectorAll('form[action="ajax/cart.php"]');
            cartForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    handleCartOperation(this, event);
                });
            });
        });

        // Scroll Indicator
        window.addEventListener('scroll', () => {
            const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            document.getElementById('scrollIndicator').style.width = scrolled + '%';
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>