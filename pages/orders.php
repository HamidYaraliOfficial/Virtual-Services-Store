<?php
requireLogin();

$userId = $_SESSION['user_id'];
$orders = array_filter(loadOrders(), function($o) use ($userId) { return $o['user_id'] == $userId; });
usort($orders, function($a, $b) { return strtotime($b['created_at']) - strtotime($a['created_at']); });
?>

<style>
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
</style>

<div class="container mx-auto px-4 py-8 mt-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div class="flex items-center gap-3">
            <div class="text-blue-600">
                <?php echo getIcon('orders', 32); ?>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">سفارشات من</h2>
        </div>
        <a href="?page=services" class="btn-premium text-white px-6 py-3 rounded-2xl font-semibold hover-lift shadow-lg flex items-center gap-2">
            <?php echo getIcon('plus', 20); ?> خرید جدید
        </a>
    </div>

    <div class="premium-card hover-lift rounded-2xl overflow-hidden">
        <div class="p-6">
            <?php if (empty($orders)): ?>
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <?php echo getIcon('orders', 48); ?>
                </div>
                <h6 class="text-xl font-semibold text-gray-600 mb-2">سفارشی یافت نشد</h6>
                <p class="text-gray-500 mb-6">هنوز هیچ سفارشی ثبت نکرده‌اید</p>
                <a href="?page=services" class="btn-premium text-white px-8 py-3 rounded-2xl font-semibold hover-lift shadow-lg">
                    شروع خرید
                </a>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-right py-4 px-4 font-bold text-gray-800">شماره سفارش</th>
                            <th class="text-right py-4 px-4 font-bold text-gray-800">تاریخ</th>
                            <th class="text-right py-4 px-4 font-bold text-gray-800">مبلغ</th>
                            <th class="text-right py-4 px-4 font-bold text-gray-800">پرداخت</th>
                            <th class="text-right py-4 px-4 font-bold text-gray-800">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($orders as $order): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4 font-semibold text-blue-600">#<?php echo $order['id']; ?></td>
                            <td class="py-4 px-4 text-gray-700"><?php echo date('Y/m/d H:i', strtotime($order['created_at'])); ?></td>
                            <td class="py-4 px-4 font-semibold text-gray-800"><?php echo formatPrice($order['total']); ?></td>
                            <td class="py-4 px-4">
                                <?php
                                $p = $order['payment_status'] ?? 'pending';
                                $cls = $p === 'paid' ? 'bg-green-100 text-green-800' : ($p === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                                $txt = $p === 'paid' ? 'پرداخت شده' : ($p === 'failed' ? 'ناموفق' : 'در انتظار');
                                ?>
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $cls; ?>"><?php echo $txt; ?></span>
                            </td>
                            <td class="py-4 px-4">
                                <?php
                                $s = $order['status'];
                                $sCls = $s === 'completed' ? 'bg-green-100 text-green-800' : ($s === 'processing' ? 'bg-blue-100 text-blue-800' : ($s === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'));
                                $sTxt = $s === 'completed' ? 'تکمیل شده' : ($s === 'processing' ? 'در حال پردازش' : ($s === 'cancelled' ? 'لغو شده' : 'در انتظار'));
                                ?>
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $sCls; ?>"><?php echo $sTxt; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


