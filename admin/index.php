<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

requireAdmin();

// Security headers for admin
secureHeaders();

// Get current page
$page = $_GET['page'] ?? 'dashboard';

// Load data for statistics
$users = loadUsers();
$services = loadServices();
$orders = loadOrders();
$payments = loadPayments();

$totalUsers = count($users) - 1; // Exclude admin
$totalServices = count($services);
$totalOrders = count($orders);
$totalRevenue = array_sum(array_column($orders, 'total'));
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت - فروشگاه خدمات مجازی</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Vazirmatn', sans-serif !important; }
        
        .premium-card {
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .premium-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .sidebar-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 sidebar-gradient shadow-2xl">
            <div class="p-6">
                <div class="text-center mb-8">
                    <h4 class="text-white text-xl font-bold mb-2">پنل مدیریت</h4>
                    <p class="text-white/70 text-sm">خوش آمدید، <?php echo $_SESSION['username']; ?></p>
                </div>
                
                <nav class="space-y-2">
                    <a href="?page=dashboard" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/20 rounded-xl transition-all <?php echo $page === 'dashboard' ? 'bg-white/30 text-white' : ''; ?>">
                        <?php echo getIcon('dashboard', 20); ?> داشبورد
                    </a>
                    <a href="?page=users" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/20 rounded-xl transition-all <?php echo $page === 'users' ? 'bg-white/30 text-white' : ''; ?>">
                        <?php echo getIcon('user', 20); ?> مدیریت کاربران
                    </a>
                    <a href="?page=services" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/20 rounded-xl transition-all <?php echo $page === 'services' ? 'bg-white/30 text-white' : ''; ?>">
                        <?php echo getIcon('services', 20); ?> مدیریت خدمات
                    </a>
                    <a href="?page=orders" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/20 rounded-xl transition-all <?php echo $page === 'orders' ? 'bg-white/30 text-white' : ''; ?>">
                        <?php echo getIcon('orders', 20); ?> مدیریت سفارشات
                    </a>
                    <a href="?page=payments" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/20 rounded-xl transition-all <?php echo $page === 'payments' ? 'bg-white/30 text-white' : ''; ?>">
                        <?php echo getIcon('payment', 20); ?> مدیریت پرداخت ها
                    </a>
                    <a href="?page=gateway" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/20 rounded-xl transition-all <?php echo $page === 'gateway' ? 'bg-white/30 text-white' : ''; ?>">
                        <?php echo getIcon('gateway', 20); ?> مدیریت درگاه
                    </a>
                    <a href="?page=settings" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/20 rounded-xl transition-all <?php echo $page === 'settings' ? 'bg-white/30 text-white' : ''; ?>">
                        <?php echo getIcon('settings', 20); ?> تنظیمات سایت
                    </a>
                    
                    <div class="border-t border-white/20 my-4"></div>
                    
                    <a href="../index.php" class="flex items-center gap-3 px-4 py-3 text-white/90 hover:text-white hover:bg-white/20 rounded-xl transition-all">
                        <?php echo getIcon('home', 20); ?> مشاهده سایت
                    </a>
                    <a href="../logout.php" class="flex items-center gap-3 px-4 py-3 text-red-200 hover:text-red-100 hover:bg-red-500/20 rounded-xl transition-all">
                        <?php echo getIcon('logout', 20); ?> خروج
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <div class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-medium">Admin</span>
                        <span class="text-gray-400">|</span>
                        <span class="text-gray-600">خوش آمدید، <?php echo $_SESSION['username']; ?></span>
                    </div>
                    <div class="flex items-center gap-4">
                        <input type="text" class="hidden md:block px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="جستجو..." style="width: 260px;">
                        <button class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition-colors" title="اعلان ها">
                            <?php echo getIcon('notification', 20); ?>
                        </button>
                        <a href="../" class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition-colors" title="نمایش سایت">
                            <?php echo getIcon('external', 20); ?>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Page Content -->
            <div class="flex-1 p-8">
                <?php
                switch ($page) {
                    case 'dashboard':
                        include 'pages/dashboard.php';
                        break;
                    case 'users':
                        include 'pages/users.php';
                        break;
                    case 'services':
                        include 'pages/services.php';
                        break;
                    case 'orders':
                        include 'pages/orders.php';
                        break;
                    case 'payments':
                        include 'pages/payments.php';
                        break;
                    case 'gateway':
                        include 'pages/gateway.php';
                        break;
                    case 'settings':
                        include 'pages/settings.php';
                        break;
                    case 'add-service':
                        include 'pages/add-service.php';
                        break;
                    case 'edit-service':
                        include 'pages/edit-service.php';
                        break;
                    default:
                        include 'pages/404.php';
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>
