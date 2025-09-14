<?php
$settings = loadSettings();
$error='';$success='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $settings['site_name']=sanitize($_POST['site_name']??$settings['site_name']);
    $settings['site_description']=sanitize($_POST['site_description']??$settings['site_description']);
    $settings['admin_email']=sanitize($_POST['admin_email']??$settings['admin_email']);
    if(saveSettings($settings)){$success='تنظیمات با موفقیت ذخیره شد';}else{$error='خطا در ذخیره تنظیمات';}
}
?>

<div class="flex items-center gap-3 mb-8">
    <div class="text-blue-600">
        <?php echo getIcon('settings', 32); ?>
    </div>
    <h2 class="text-3xl font-bold text-gradient">تنظیمات سایت</h2>
</div>

<?php if($error):?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
    <?php echo $error; ?>
</div>
<?php endif; ?>

<?php if($success):?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
    <?php echo $success; ?>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="premium-card hover-lift rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                <h5 class="text-white font-bold text-lg">تنظیمات عمومی</h5>
            </div>
            <div class="p-6">
                <form method="POST" class="space-y-6">
                    <?php echo csrfInput(); ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نام سایت</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               name="site_name" value="<?php echo htmlspecialchars($settings['site_name']??''); ?>" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات سایت</label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                  rows="4" name="site_description" required><?php echo htmlspecialchars($settings['site_description']??''); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ایمیل مدیریت</label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               name="admin_email" value="<?php echo htmlspecialchars($settings['admin_email']??''); ?>" required>
                    </div>
                    <button class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-8 py-3 rounded-2xl font-semibold hover-lift shadow-lg flex items-center gap-3" type="submit">
                        <?php echo getIcon('check', 20); ?> ذخیره تنظیمات
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div>
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
                    <span class="text-gray-600">زمان سرور:</span>
                    <span class="font-semibold text-gray-800"><?php echo date('Y/m/d H:i'); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">وضعیت:</span>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">سالم</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">حافظه:</span>
                    <span class="font-semibold text-gray-800"><?php echo round(memory_get_usage() / 1024 / 1024, 2); ?> MB</span>
                </div>
            </div>
        </div>
    </div>
</div>


