<?php
requireLogin();

$userId = $_SESSION['user_id'];
$user = getUserById($userId);

// Get user's orders
$orders = loadOrders();
$userOrders = array_filter($orders, function($order) use ($userId) {
    return $order['user_id'] == $userId;
});

// Sort orders by date (newest first)
usort($userOrders, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

// Calculate statistics
$totalOrders = count($userOrders);
$completedOrders = count(array_filter($userOrders, function($order) {
    return $order['status'] === 'completed';
}));
$totalSpent = array_sum(array_column($userOrders, 'total'));
$pendingOrders = count(array_filter($userOrders, function($order) {
    return $order['status'] === 'pending' || $order['status'] === 'processing';
}));

// Get recent orders (last 5)
$recentOrders = array_slice($userOrders, 0, 5);
?>

<div class="container mx-auto px-4 py-8 mt-20">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-full inline-flex items-center justify-center text-white mb-4 text-2xl font-bold">
                        <?php echo strtoupper(substr($user['username'], 0, 2)); ?>
                    </div>
                    <h5 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($user['username']); ?></h5>
                    <p class="text-gray-600 mb-3"><?php echo htmlspecialchars($user['email']); ?></p>
                    <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">فعال</span>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-gray-800">منوی کاربری</h6>
                </div>
                <div class="divide-y divide-gray-200">
                    <a href="?page=dashboard" class="flex items-center px-6 py-4 text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
                        <i class="fas fa-tachometer-alt ml-3"></i> داشبورد
                    </a>
                    <a href="?page=profile" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-user ml-3"></i> پروفایل
                    </a>
                    <a href="?page=orders" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-shopping-bag ml-3"></i> سفارشات من
                    </a>
                    <a href="?page=favorites" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-heart ml-3"></i> علاقه مندی ها
                    </a>
                    <a href="?page=tickets" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-comments ml-3"></i> تیکت ها
                    </a>
                    <a href="logout.php" class="flex items-center px-6 py-4 text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt ml-3"></i> خروج
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-tachometer-alt text-blue-600 text-2xl"></i>
                    <h2 class="text-2xl font-bold text-gray-800">داشبورد کاربری</h2>
                </div>
                <span class="text-gray-600 mt-2 md:mt-0">خوش آمدید، <?php echo htmlspecialchars($user['username']); ?></span>
            </div>
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="text-blue-600 text-4xl mb-3">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo $totalOrders; ?></h3>
                    <p class="text-gray-600">کل سفارشات</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="text-green-600 text-4xl mb-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo $completedOrders; ?></h3>
                    <p class="text-gray-600">تکمیل شده</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="text-yellow-600 text-4xl mb-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo $pendingOrders; ?></h3>
                    <p class="text-gray-600">در انتظار</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="text-cyan-600 text-4xl mb-3">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h5 class="text-xl font-bold text-gray-800 mb-1"><?php echo formatPrice($totalSpent); ?></h5>
                    <p class="text-gray-600">کل خرید</p>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-gray-800">آخرین سفارشات</h5>
                    <a href="?page=orders" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">مشاهده همه</a>
                </div>
                <div class="p-6">
                    <?php if (empty($recentOrders)): ?>
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-bag text-gray-400 text-6xl mb-4"></i>
                        <h6 class="text-gray-600 text-lg font-medium mb-4">هنوز سفارشی ثبت نکرده اید</h6>
                        <a href="?page=services" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">شروع خرید</a>
                    </div>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-right py-3 px-4 font-semibold text-gray-700">شماره سفارش</th>
                                    <th class="text-right py-3 px-4 font-semibold text-gray-700">تاریخ</th>
                                    <th class="text-right py-3 px-4 font-semibold text-gray-700">مبلغ</th>
                                    <th class="text-right py-3 px-4 font-semibold text-gray-700">وضعیت</th>
                                    <th class="text-right py-3 px-4 font-semibold text-gray-700">عملیات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($recentOrders as $order): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-gray-800 font-medium">#<?php echo $order['id']; ?></td>
                                    <td class="py-3 px-4 text-gray-600"><?php echo date('Y/m/d', strtotime($order['created_at'])); ?></td>
                                    <td class="py-3 px-4 text-gray-800 font-medium"><?php echo formatPrice($order['total']); ?></td>
                                    <td class="py-3 px-4">
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch ($order['status']) {
                                            case 'pending':
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                                $statusText = 'در انتظار';
                                                break;
                                            case 'processing':
                                                $statusClass = 'bg-blue-100 text-blue-800';
                                                $statusText = 'در حال پردازش';
                                                break;
                                            case 'completed':
                                                $statusClass = 'bg-green-100 text-green-800';
                                                $statusText = 'تکمیل شده';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'bg-red-100 text-red-800';
                                                $statusText = 'لغو شده';
                                                break;
                                            default:
                                                $statusClass = 'bg-gray-100 text-gray-800';
                                                $statusText = 'نامشخص';
                                        }
                                        ?>
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="?page=order&id=<?php echo $order['id']; ?>" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                                            مشاهده
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center hover:shadow-xl transition-shadow">
                    <i class="fas fa-plus-circle text-blue-600 text-5xl mb-4"></i>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">خرید جدید</h5>
                    <p class="text-gray-600 mb-4">خدمات جدید را مشاهده کنید</p>
                    <a href="?page=services" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">مشاهده خدمات</a>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center hover:shadow-xl transition-shadow">
                    <i class="fas fa-comments text-green-600 text-5xl mb-4"></i>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">پشتیبانی</h5>
                    <p class="text-gray-600 mb-4">با تیم پشتیبانی در ارتباط باشید</p>
                    <a href="?page=tickets" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">ارسال تیکت</a>
                </div>
            </div>
        </div>
    </div>
</div>
