<?php
$payments = loadPayments();
usort($payments, function($a,$b){return strtotime($b['created_at'])-strtotime($a['created_at']);});
?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div class="flex items-center gap-3">
        <div class="text-blue-600">
            <?php echo getIcon('payment', 32); ?>
        </div>
        <h2 class="text-3xl font-bold text-gradient">مدیریت پرداخت ها</h2>
    </div>
    <div class="flex items-center gap-2 text-gray-600">
        <?php echo getIcon('orders', 20); ?>
        <span><?php echo count($payments); ?> رکورد</span>
    </div>
</div>

<div class="premium-card hover-lift rounded-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
        <h5 class="text-white font-bold text-lg">لیست پرداخت‌ها</h5>
    </div>
    <div class="p-6">
        <?php if(empty($payments)): ?>
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <?php echo getIcon('payment', 40); ?>
            </div>
            <h6 class="text-xl font-semibold text-gray-600 mb-2">پرداختی ثبت نشده است</h6>
            <p class="text-gray-500">هنوز هیچ پرداختی انجام نشده است</p>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-right py-4 px-4 font-bold text-gray-800">#</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">سفارش</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">کاربر</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">مبلغ</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">درگاه</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">وضعیت</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">شماره پیگیری</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">تاریخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($payments as $p): $u=getUserById($p['user_id']); ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4 font-semibold text-blue-600"><?php echo $p['id']; ?></td>
                        <td class="py-4 px-4 font-semibold text-gray-800">#<?php echo $p['order_id']; ?></td>
                        <td class="py-4 px-4 text-gray-700"><?php echo $u? htmlspecialchars($u['username']):'نامشخص'; ?></td>
                        <td class="py-4 px-4 font-semibold text-gray-800"><?php echo formatPrice($p['amount']); ?></td>
                        <td class="py-4 px-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">ZarinPal</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $p['status']==='completed'?'bg-green-100 text-green-800':'bg-red-100 text-red-800'; ?>">
                                <?php echo $p['status']==='completed'?'موفق':'ناموفق'; ?>
                            </span>
                        </td>
                        <td class="py-4 px-4 text-gray-600"><?php echo htmlspecialchars($p['ref_id']??'-'); ?></td>
                        <td class="py-4 px-4 text-gray-600"><?php echo date('Y/m/d H:i', strtotime($p['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>


