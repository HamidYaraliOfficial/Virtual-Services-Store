<?php
$error = '';
$success = '';
// Captcha removed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'لطفا تمام فیلدها را پر کنید';
    } else {
        $user = getUserByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] === 'active') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect to dashboard or admin panel
                if ($user['role'] === 'admin') {
                    header('Location: admin/index.php');
                } else {
                    header('Location: ?page=dashboard');
                }
                exit;
            } else {
                $error = 'حساب کاربری شما غیرفعال است';
            }
        } else {
            $error = 'نام کاربری یا رمز عبور اشتباه است';
        }
    }
}
?>

<div class="container mx-auto px-4 py-8 mt-20">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                <h3 class="text-center text-2xl font-bold text-gray-800 mb-6 flex items-center justify-center gap-3">
                    <div class="text-blue-600"><?php echo getIcon('user', 28); ?></div> ورود به حساب کاربری
                </h3>
                
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
                
                <form method="POST" class="space-y-6">
                    <?php echo csrfInput(); ?>
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">نام کاربری</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               id="username" name="username" 
                               value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">رمز عبور</label>
                        <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               id="password" name="password" required>
                    </div>
                    
                    

                    <div class="flex items-center">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 ml-3" id="remember">
                        <label class="text-sm text-gray-700" for="remember">
                            مرا به خاطر بسپار
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">ورود</button>
                </form>
                
                <div class="text-center mt-6">
                    <p class="text-gray-600">حساب کاربری ندارید؟ <a href="?page=register" class="text-blue-600 hover:text-blue-800 font-medium">ثبت نام کنید</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
