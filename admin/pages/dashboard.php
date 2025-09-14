<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div class="flex items-center gap-3">
        <div class="text-blue-600">
            <?php echo getIcon('dashboard', 32); ?>
        </div>
        <h2 class="text-3xl font-bold text-gradient">داشبورد مدیریت</h2>
    </div>
    <div class="flex items-center gap-2 text-gray-600">
        <?php echo getIcon('clock', 20); ?>
        <span><?php echo date('Y/m/d H:i'); ?></span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="premium-card hover-lift rounded-2xl p-6 text-center bg-gradient-to-br from-blue-50 to-blue-100">
        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <?php echo getIcon('user', 32); ?>
        </div>
        <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo $totalUsers; ?></div>
        <div class="text-gray-600">کل کاربران</div>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center bg-gradient-to-br from-green-50 to-green-100">
        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <?php echo getIcon('services', 32); ?>
        </div>
        <div class="text-3xl font-bold text-green-600 mb-2"><?php echo $totalServices; ?></div>
        <div class="text-gray-600">کل خدمات</div>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center bg-gradient-to-br from-purple-50 to-purple-100">
        <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <?php echo getIcon('orders', 32); ?>
        </div>
        <div class="text-3xl font-bold text-purple-600 mb-2"><?php echo $totalOrders; ?></div>
        <div class="text-gray-600">کل سفارشات</div>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center bg-gradient-to-br from-yellow-50 to-yellow-100">
        <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <?php echo getIcon('money', 32); ?>
        </div>
        <div class="text-3xl font-bold text-yellow-600 mb-2"><?php echo number_format($totalRevenue); ?></div>
        <div class="text-gray-600">کل درآمد (تومان)</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Recent Orders -->
    <div class="lg:col-span-2">
        <div class="premium-card hover-lift rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4 flex justify-between items-center">
                <h5 class="text-white font-bold text-lg">آخرین سفارشات</h5>
                <a href="?page=orders" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    مشاهده همه
                </a>
            </div>
            <div class="p-6">
                <?php
                $recentOrders = array_slice($orders, -5, 5, true);
                $recentOrders = array_reverse($recentOrders, true);
                ?>
                
                <?php if (empty($recentOrders)): ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <?php echo getIcon('orders', 32); ?>
                    </div>
                    <p class="text-gray-500">هیچ سفارشی ثبت نشده است</p>
                </div>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-right py-3 px-2 font-bold text-gray-800">شماره سفارش</th>
                                <th class="text-right py-3 px-2 font-bold text-gray-800">کاربر</th>
                                <th class="text-right py-3 px-2 font-bold text-gray-800">مبلغ</th>
                                <th class="text-right py-3 px-2 font-bold text-gray-800">وضعیت</th>
                                <th class="text-right py-3 px-2 font-bold text-gray-800">تاریخ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($recentOrders as $order): ?>
                            <?php $orderUser = getUserById($order['user_id']); ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-2 font-semibold text-blue-600">#<?php echo $order['id']; ?></td>
                                <td class="py-3 px-2 text-gray-700"><?php echo $orderUser ? htmlspecialchars($orderUser['username']) : 'نامشخص'; ?></td>
                                <td class="py-3 px-2 font-semibold text-gray-800"><?php echo formatPrice($order['total']); ?></td>
                                <td class="py-3 px-2">
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
                                    }
                                    ?>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </td>
                                <td class="py-3 px-2 text-gray-600"><?php echo date('Y/m/d', strtotime($order['created_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="space-y-6">
        <div class="premium-card hover-lift rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                <h5 class="text-white font-bold text-lg">عملیات سریع</h5>
            </div>
            <div class="p-6 space-y-4">
                <a href="?page=add-service" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-medium transition-all flex items-center gap-3">
                    <?php echo getIcon('plus', 20); ?> افزودن خدمت جدید
                </a>
                <a href="?page=users" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-colors flex items-center gap-3">
                    <?php echo getIcon('user', 20); ?> مدیریت کاربران
                </a>
                <a href="?page=orders" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-colors flex items-center gap-3">
                    <?php echo getIcon('orders', 20); ?> مدیریت سفارشات
                </a>
                <a href="?page=settings" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-colors flex items-center gap-3">
                    <?php echo getIcon('settings', 20); ?> تنظیمات سایت
                </a>
            </div>
        </div>
        
        <!-- System Info -->
        <div class="premium-card hover-lift rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <h6 class="text-white font-bold">اطلاعات سیستم</h6>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">نسخه PHP:</span>
                    <span class="font-semibold text-gray-800"><?php echo phpversion(); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">حافظه مصرفی:</span>
                    <span class="font-semibold text-gray-800"><?php echo round(memory_get_usage() / 1024 / 1024, 2); ?> MB</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">زمان سرور:</span>
                    <span class="font-semibold text-gray-800"><?php echo date('H:i:s'); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">وضعیت:</span>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">آنلاین</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="premium-card hover-lift rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
            <h6 class="text-white font-bold">نمودار فروش هفتگی</h6>
        </div>
        <div class="p-6">
            <div class="bg-gray-100 rounded-xl p-8 text-center">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <?php echo getIcon('chart', 32); ?>
                </div>
                <p class="text-gray-600">نمودار فروش در حال توسعه</p>
            </div>
        </div>
    </div>
    
    <div class="premium-card hover-lift rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-green-600 px-6 py-4">
            <h6 class="text-white font-bold">پرفروش ترین خدمات</h6>
        </div>
        <div class="p-6">
            <?php
            // Calculate best selling services
            $serviceSales = [];
            foreach ($orders as $order) {
                foreach ($order['items'] as $item) {
                    $serviceId = $item['service']['id'];
                    if (!isset($serviceSales[$serviceId])) {
                        $serviceSales[$serviceId] = [
                            'service' => $item['service'],
                            'count' => 0
                        ];
                    }
                    $serviceSales[$serviceId]['count'] += $item['quantity'];
                }
            }
            
            // Sort by count
            uasort($serviceSales, function($a, $b) {
                return $b['count'] - $a['count'];
            });
            
            $topServices = array_slice($serviceSales, 0, 5, true);
            ?>
            
            <?php if (empty($topServices)): ?>
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <?php echo getIcon('services', 32); ?>
                </div>
                <p class="text-gray-500">هنوز فروشی ثبت نشده است</p>
            </div>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($topServices as $serviceData): ?>
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div>
                        <h6 class="font-semibold text-gray-800 mb-1"><?php echo htmlspecialchars($serviceData['service']['title']); ?></h6>
                        <small class="text-gray-500"><?php echo htmlspecialchars($serviceData['service']['category']); ?></small>
                    </div>
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium"><?php echo $serviceData['count']; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
