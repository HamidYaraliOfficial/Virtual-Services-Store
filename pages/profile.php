<?php
requireLogin();

$userId = $_SESSION['user_id'];
$user = getUserById($userId);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_profile') {
        $username = sanitize($_POST['username'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        $firstName = sanitize($_POST['first_name'] ?? '');
        $lastName = sanitize($_POST['last_name'] ?? '');
        
        // Validation
        if (empty($username) || empty($email)) {
            $error = 'نام کاربری و ایمیل اجباری هستند';
        } elseif (!validateEmail($email)) {
            $error = 'فرمت ایمیل صحیح نیست';
        } else {
            // Check if username or email is taken by another user
            $users = loadUsers();
            $conflict = false;
            
            foreach ($users as $u) {
                if ($u['id'] != $userId) {
                    if ($u['username'] === $username) {
                        $error = 'این نام کاربری قبلا ثبت شده است';
                        $conflict = true;
                        break;
                    }
                    if ($u['email'] === $email) {
                        $error = 'این ایمیل قبلا ثبت شده است';
                        $conflict = true;
                        break;
                    }
                }
            }
            
            if (!$conflict) {
                // Update user data
                foreach ($users as &$u) {
                    if ($u['id'] == $userId) {
                        $u['username'] = $username;
                        $u['email'] = $email;
                        $u['phone'] = $phone;
                        $u['first_name'] = $firstName;
                        $u['last_name'] = $lastName;
                        $u['updated_at'] = date('Y-m-d H:i:s');
                        break;
                    }
                }
                
                if (saveUsers($users)) {
                    $_SESSION['username'] = $username;
                    $user = getUserById($userId); // Refresh user data
                    $success = 'اطلاعات با موفقیت به روز رسانی شد';
                } else {
                    $error = 'خطا در به روز رسانی اطلاعات';
                }
            }
        }
    } elseif ($action === 'change_password') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validation
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $error = 'تمام فیلدها اجباری هستند';
        } elseif (!password_verify($currentPassword, $user['password'])) {
            $error = 'رمز عبور فعلی اشتباه است';
        } elseif (strlen($newPassword) < 6) {
            $error = 'رمز عبور جدید باید حداقل 6 کاراکتر باشد';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'رمز عبور جدید و تکرار آن یکسان نیستند';
        } else {
            // Update password
            $users = loadUsers();
            foreach ($users as &$u) {
                if ($u['id'] == $userId) {
                    $u['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                    $u['updated_at'] = date('Y-m-d H:i:s');
                    break;
                }
            }
            
            if (saveUsers($users)) {
                $success = 'رمز عبور با موفقیت تغییر کرد';
            } else {
                $error = 'خطا در تغییر رمز عبور';
            }
        }
    }
}
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
                    <a href="?page=dashboard" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-tachometer-alt ml-3"></i> داشبورد
                    </a>
                    <a href="?page=profile" class="flex items-center px-6 py-4 text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
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
            <div class="flex items-center gap-3 mb-6">
                <i class="fas fa-user text-blue-600 text-2xl"></i>
                <h2 class="text-2xl font-bold text-gray-800">ویرایش پروفایل</h2>
            </div>
            
            <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                <?php echo $success; ?>
            </div>
            <?php endif; ?>
            
            <!-- Profile Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-800">اطلاعات شخصی</h5>
                </div>
                <div class="p-6">
                    <form method="POST" class="space-y-6">
                        <?php echo csrfInput(); ?>
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">نام</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="first_name" name="first_name" 
                                       value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">نام خانوادگی</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="last_name" name="last_name" 
                                       value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">نام کاربری *</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="username" name="username" 
                                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ایمیل *</label>
                                <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">شماره تلفن</label>
                            <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
                            <i class="fas fa-check"></i> ذخیره تغییرات
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Change Password -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-800">تغییر رمز عبور</h5>
                </div>
                <div class="p-6">
                    <form method="POST" class="space-y-6">
                        <?php echo csrfInput(); ?>
                        <input type="hidden" name="action" value="change_password">
                        
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">رمز عبور فعلی</label>
                            <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   id="current_password" name="current_password" required>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">رمز عبور جدید</label>
                                <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="new_password" name="new_password" minlength="6" required>
                            </div>
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">تکرار رمز عبور جدید</label>
                                <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
                            <i class="fas fa-key"></i> تغییر رمز عبور
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Account Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-800">اطلاعات حساب</h5>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-3">
                            <p class="text-gray-700"><span class="font-semibold">تاریخ عضویت:</span> <?php echo date('Y/m/d', strtotime($user['created_at'])); ?></p>
                            <p class="text-gray-700"><span class="font-semibold">وضعیت حساب:</span> <span class="inline-block bg-green-100 text-green-800 text-sm px-2 py-1 rounded-full font-medium">فعال</span></p>
                            <p class="text-gray-700"><span class="font-semibold">نقش کاربری:</span> 
                                <?php echo $user['role'] === 'admin' ? 'مدیر' : 'کاربر عادی'; ?>
                            </p>
                        </div>
                        <div class="space-y-3">
                            <?php if (isset($user['updated_at'])): ?>
                            <p class="text-gray-700"><span class="font-semibold">آخرین به روز رسانی:</span> <?php echo date('Y/m/d H:i', strtotime($user['updated_at'])); ?></p>
                            <?php endif; ?>
                            <p class="text-gray-700"><span class="font-semibold">تعداد سفارشات:</span> <?php echo count(array_filter(loadOrders(), function($o) use ($userId) { return $o['user_id'] == $userId; })); ?></p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-wrap gap-3">
                            <button class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2" onclick="downloadUserData()">
                                <i class="fas fa-download"></i> دانلود اطلاعات
                            </button>
                            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2" onclick="deleteAccount()">
                                <i class="fas fa-trash"></i> حذف حساب
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    var newPassword = document.getElementById('new_password').value;
    var confirmPassword = this.value;
    
    if (confirmPassword && newPassword !== confirmPassword) {
        this.setCustomValidity('رمز عبور و تکرار آن یکسان نیستند');
        this.classList.add('is-invalid');
    } else {
        this.setCustomValidity('');
        this.classList.remove('is-invalid');
        if (confirmPassword && newPassword === confirmPassword) {
            this.classList.add('is-valid');
        }
    }
});

function downloadUserData() {
    if (confirm('آیا می خواهید اطلاعات حساب خود را دانلود کنید؟')) {
        // In a real application, this would download user's data
        showToast('اطلاعیه', 'قابلیت دانلود اطلاعات به زودی فعال خواهد شد', 'info');
    }
}

function deleteAccount() {
    if (confirm('آیا از حذف حساب کاربری خود اطمینان دارید؟ این عمل غیرقابل بازگشت است.')) {
        if (confirm('آیا واقعا می خواهید حساب خود را حذف کنید؟ تمام اطلاعات شما پاک خواهد شد.')) {
            // In a real application, this would delete the user account
            showToast('اطلاعیه', 'قابلیت حذف حساب به زودی فعال خواهد شد', 'info');
        }
    }
}
</script>
