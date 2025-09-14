<?php
$error = '';
$success = '';

// Handle service actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete' && isset($_POST['service_id'])) {
        $serviceId = intval($_POST['service_id']);
        $services = loadServices();
        
        foreach ($services as $key => $service) {
            if ($service['id'] == $serviceId) {
                unset($services[$key]);
                break;
            }
        }
        
        if (saveServices(array_values($services))) {
            $success = 'خدمت با موفقیت حذف شد';
        } else {
            $error = 'خطا در حذف خدمت';
        }
    } elseif ($action === 'toggle_status' && isset($_POST['service_id'])) {
        $serviceId = intval($_POST['service_id']);
        $services = loadServices();
        
        foreach ($services as &$service) {
            if ($service['id'] == $serviceId) {
                $service['status'] = $service['status'] === 'active' ? 'inactive' : 'active';
                break;
            }
        }
        
        if (saveServices($services)) {
            $success = 'وضعیت خدمت تغییر کرد';
        } else {
            $error = 'خطا در تغییر وضعیت';
        }
    }
}

// Reload services after changes
$services = loadServices();
?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div class="flex items-center gap-3">
        <div class="text-blue-600">
            <?php echo getIcon('services', 32); ?>
        </div>
        <h2 class="text-3xl font-bold text-gradient">مدیریت خدمات</h2>
    </div>
    <a href="?page=add-service" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-2xl font-semibold hover-lift shadow-lg flex items-center gap-3">
        <?php echo getIcon('plus', 20); ?> افزودن خدمت جدید
    </a>
</div>

<?php if ($error): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
    <?php echo $error; ?>
</div>
<?php endif; ?>

<?php if ($success): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
    <?php echo $success; ?>
</div>
<?php endif; ?>

<!-- Services Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="premium-card hover-lift rounded-2xl p-6 text-center bg-gradient-to-br from-blue-50 to-blue-100">
        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <?php echo getIcon('services', 32); ?>
        </div>
        <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo count($services); ?></div>
        <div class="text-gray-600">کل خدمات</div>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center bg-gradient-to-br from-green-50 to-green-100">
        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <?php echo getIcon('check', 32); ?>
        </div>
        <?php $activeServices = count(array_filter($services, function($s) { return $s['status'] === 'active'; })); ?>
        <div class="text-3xl font-bold text-green-600 mb-2"><?php echo $activeServices; ?></div>
        <div class="text-gray-600">فعال</div>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center bg-gradient-to-br from-yellow-50 to-yellow-100">
        <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <?php echo getIcon('clock', 32); ?>
        </div>
        <div class="text-3xl font-bold text-yellow-600 mb-2"><?php echo count($services) - $activeServices; ?></div>
        <div class="text-gray-600">غیرفعال</div>
    </div>
    <div class="premium-card hover-lift rounded-2xl p-6 text-center bg-gradient-to-br from-purple-50 to-purple-100">
        <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <?php echo getIcon('star', 32); ?>
        </div>
        <?php $categories = array_unique(array_column($services, 'category')); ?>
        <div class="text-3xl font-bold text-purple-600 mb-2"><?php echo count($categories); ?></div>
        <div class="text-gray-600">دسته بندی</div>
    </div>
</div>

<!-- Services Table -->
<div class="premium-card hover-lift rounded-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
        <h5 class="text-white font-bold text-lg">لیست خدمات</h5>
    </div>
    <div class="p-6">
        <?php if (empty($services)): ?>
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <?php echo getIcon('services', 40); ?>
            </div>
            <h5 class="text-xl font-semibold text-gray-600 mb-2">هیچ خدمتی یافت نشد</h5>
            <p class="text-gray-500 mb-6">برای شروع، خدمت جدیدی اضافه کنید</p>
            <a href="?page=add-service" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-2xl font-semibold hover-lift shadow-lg">افزودن خدمت جدید</a>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-right py-4 px-4 font-bold text-gray-800">تصویر</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">عنوان</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">دسته بندی</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">قیمت</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">وضعیت</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">تاریخ ایجاد</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($services as $service): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4">
                            <img src="<?php echo $service['image'] ?? '../assets/images/default-service.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($service['title']); ?>" 
                                 class="w-12 h-12 rounded-xl object-cover">
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-semibold text-gray-800 mb-1"><?php echo htmlspecialchars($service['title']); ?></div>
                            <div class="text-sm text-gray-500"><?php echo htmlspecialchars(substr($service['description'], 0, 50)); ?>...</div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"><?php echo htmlspecialchars($service['category']); ?></span>
                        </td>
                        <td class="py-4 px-4 font-semibold text-gray-800">
                            <?php echo formatPrice($service['price']); ?>
                        </td>
                        <td class="py-4 px-4">
                            <?php if ($service['status'] === 'active'): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">فعال</span>
                            <?php else: ?>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">غیرفعال</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-4 text-gray-600">
                            <?php echo date('Y/m/d', strtotime($service['created_at'])); ?>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <a href="../index.php?page=service&id=<?php echo $service['id']; ?>" 
                                   class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors" target="_blank" title="مشاهده">
                                    <?php echo getIcon('view', 16); ?>
                                </a>
                                <a href="?page=edit-service&id=<?php echo $service['id']; ?>" 
                                   class="p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors" title="ویرایش">
                                    <?php echo getIcon('settings', 16); ?>
                                </a>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                    <button type="submit" class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors" 
                                            title="<?php echo $service['status'] === 'active' ? 'غیرفعال کردن' : 'فعال کردن'; ?>">
                                        <?php echo getIcon('settings', 16); ?>
                                    </button>
                                </form>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                    <button type="submit" class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors confirm-delete" title="حذف">
                                        <?php echo getIcon('delete', 16); ?>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
