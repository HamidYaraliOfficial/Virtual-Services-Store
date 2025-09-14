<?php
$orders = loadOrders();

// Handle order status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $orderId = intval($_POST['order_id'] ?? 0);
    
    if ($action === 'update_status' && $orderId > 0) {
        $newStatus = $_POST['status'] ?? '';
        
        foreach ($orders as &$order) {
            if ($order['id'] == $orderId) {
                $order['status'] = $newStatus;
                $order['updated_at'] = date('Y-m-d H:i:s');
                break;
            }
        }
        
        if (saveOrders($orders)) {
            $success = 'وضعیت سفارش به روز رسانی شد';
        } else {
            $error = 'خطا در به روز رسانی وضعیت';
        }
    }
}

// Sort orders by date (newest first)
usort($orders, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

$totalOrders = count($orders);
$pendingOrders = count(array_filter($orders, function($o) { return $o['status'] === 'pending'; }));
$processingOrders = count(array_filter($orders, function($o) { return $o['status'] === 'processing'; }));
$completedOrders = count(array_filter($orders, function($o) { return $o['status'] === 'completed'; }));
?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <h2 class="text-3xl font-bold text-gradient">مدیریت سفارشات</h2>
    <div class="flex items-center gap-2 text-gray-600">
        <?php echo getIcon('orders', 24); ?>
        <span><?php echo $totalOrders; ?> سفارش</span>
    </div>
</div>

<?php if (isset($error)): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
    <?php echo $error; ?>
</div>
<?php endif; ?>

<?php if (isset($success)): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
    <?php echo $success; ?>
</div>
<?php endif; ?>

<!-- Order Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="premium-card hover-lift rounded-2xl p-6 text-center">
        <h3 class="text-3xl font-bold text-yellow-600 mb-2"><?php echo $pendingOrders; ?></h3>
        <p class="text-gray-600">در انتظار</p>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center">
        <h3 class="text-3xl font-bold text-blue-600 mb-2"><?php echo $processingOrders; ?></h3>
        <p class="text-gray-600">در حال پردازش</p>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center">
        <h3 class="text-3xl font-bold text-green-600 mb-2"><?php echo $completedOrders; ?></h3>
        <p class="text-gray-600">تکمیل شده</p>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center">
        <h3 class="text-3xl font-bold text-purple-600 mb-2"><?php echo $totalOrders; ?></h3>
        <p class="text-gray-600">کل سفارشات</p>
    </div>
</div>

<!-- Orders Table -->
<div class="premium-card hover-lift rounded-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
        <h5 class="text-white font-bold text-lg">لیست سفارشات</h5>
    </div>
    <div class="p-6">
        <?php if (empty($orders)): ?>
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <?php echo getIcon('orders', 40); ?>
            </div>
            <h5 class="text-xl font-semibold text-gray-600 mb-2">هیچ سفارشی یافت نشد</h5>
            <p class="text-gray-500">هنوز سفارشی ثبت نشده است</p>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-right py-4 px-4 font-bold text-gray-800">شماره سفارش</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">کاربر</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">تعداد اقلام</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">مبلغ کل</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">وضعیت پرداخت</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">وضعیت سفارش</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">تاریخ</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($orders as $order): ?>
                    <?php $user = getUserById($order['user_id']); ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4 font-semibold text-blue-600">#<?php echo $order['id']; ?></td>
                        <td class="py-4 px-4">
                            <?php if ($user): ?>
                            <div>
                                <div class="font-semibold text-gray-800"><?php echo htmlspecialchars($user['username']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($user['email']); ?></div>
                            </div>
                            <?php else: ?>
                            <span class="text-gray-500">کاربر حذف شده</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-4 text-gray-700"><?php echo count($order['items']); ?> مورد</td>
                        <td class="py-4 px-4 font-semibold text-gray-800"><?php echo formatPrice($order['total']); ?></td>
                        <td>
                            <?php
                            $paymentStatusClass = '';
                            $paymentStatusText = '';
                            switch ($order['payment_status'] ?? 'pending') {
                                case 'paid':
                                    $paymentStatusClass = 'success';
                                    $paymentStatusText = 'پرداخت شده';
                                    break;
                                case 'failed':
                                    $paymentStatusClass = 'danger';
                                    $paymentStatusText = 'ناموفق';
                                    break;
                                default:
                                    $paymentStatusClass = 'warning';
                                    $paymentStatusText = 'در انتظار';
                            }
                            ?>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $paymentStatusClass === 'success' ? 'bg-green-100 text-green-800' : ($paymentStatusClass === 'danger' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); ?>"><?php echo $paymentStatusText; ?></span>
                        </td>
                        <td>
                            <?php
                            $statusClass = '';
                            $statusText = '';
                            switch ($order['status']) {
                                case 'pending':
                                    $statusClass = 'warning';
                                    $statusText = 'در انتظار';
                                    break;
                                case 'processing':
                                    $statusClass = 'info';
                                    $statusText = 'در حال پردازش';
                                    break;
                                case 'completed':
                                    $statusClass = 'success';
                                    $statusText = 'تکمیل شده';
                                    break;
                                case 'cancelled':
                                    $statusClass = 'danger';
                                    $statusText = 'لغو شده';
                                    break;
                            }
                            ?>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $statusClass === 'success' ? 'bg-green-100 text-green-800' : ($statusClass === 'info' ? 'bg-blue-100 text-blue-800' : ($statusClass === 'danger' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>"><?php echo $statusText; ?></span>
                        </td>
                        <td class="py-4 px-4">
                            <div>
                                <div class="text-gray-700"><?php echo date('Y/m/d', strtotime($order['created_at'])); ?></div>
                                <div class="text-sm text-gray-500"><?php echo date('H:i', strtotime($order['created_at'])); ?></div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <button class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors" onclick="openOrderModal(<?php echo $order['id']; ?>)">
                                    <?php echo getIcon('view', 16); ?>
                                </button>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                            onchange="this.form.submit()">
                                        <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>در انتظار</option>
                                        <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>در حال پردازش</option>
                                        <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>تکمیل شده</option>
                                        <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>لغو شده</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Order Details Modal -->
                    <div class="modal fade" id="orderModal<?php echo $order['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">جزئیات سفارش #<?php echo $order['id']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>اطلاعات سفارش</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td>شماره سفارش:</td>
                                                    <td><strong>#<?php echo $order['id']; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>تاریخ ثبت:</td>
                                                    <td><?php echo date('Y/m/d H:i', strtotime($order['created_at'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>مبلغ کل:</td>
                                                    <td><strong><?php echo formatPrice($order['total']); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>روش پرداخت:</td>
                                                    <td><?php echo htmlspecialchars($order['payment_method'] ?? 'نامشخص'); ?></td>
                                                </tr>
                                                <?php if (isset($order['ref_id'])): ?>
                                                <tr>
                                                    <td>شماره پیگیری:</td>
                                                    <td><?php echo htmlspecialchars($order['ref_id']); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>اطلاعات مشتری</h6>
                                            <?php if ($user): ?>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td>نام کاربری:</td>
                                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>ایمیل:</td>
                                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>تاریخ عضویت:</td>
                                                    <td><?php echo date('Y/m/d', strtotime($user['created_at'])); ?></td>
                                                </tr>
                                            </table>
                                            <?php else: ?>
                                            <p class="text-muted">کاربر حذف شده است</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <h6 class="mt-4">اقلام سفارش</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>خدمت</th>
                                                    <th>تعداد</th>
                                                    <th>قیمت واحد</th>
                                                    <th>جمع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($order['items'] as $item): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($item['service']['title']); ?></strong><br>
                                                        <small class="text-muted"><?php echo htmlspecialchars($item['service']['category']); ?></small>
                                                    </td>
                                                    <td><?php echo $item['quantity']; ?></td>
                                                    <td><?php echo formatPrice($item['service']['price']); ?></td>
                                                    <td><strong><?php echo formatPrice($item['total']); ?></strong></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3">مجموع:</th>
                                                    <th><?php echo formatPrice($order['total']); ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
