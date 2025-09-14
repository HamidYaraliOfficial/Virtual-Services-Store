<?php
$error = '';
$success = '';
// Captcha removed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'لطفا تمام فیلدها را پر کنید';
    } elseif (!validateEmail($email)) {
        $error = 'لطفا یک ایمیل معتبر وارد کنید';
    } elseif (strlen($password) < 6) {
        $error = 'رمز عبور باید حداقل 6 کاراکتر باشد';
    } elseif ($password !== $confirmPassword) {
        $error = 'رمز عبور و تکرار آن یکسان نیستند';
    } else {
        // Check if username or email already exists
        $users = loadUsers();
        $userExists = false;
        
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $error = 'این نام کاربری قبلا ثبت شده است';
                $userExists = true;
                break;
            }
            if ($user['email'] === $email) {
                $error = 'این ایمیل قبلا ثبت شده است';
                $userExists = true;
                break;
            }
        }
        
        if (!$userExists) {
            // Create new user
            $newUser = [
                'id' => generateId($users),
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];
            
            $users[] = $newUser;
            
            if (saveUsers($users)) {
                $success = 'حساب کاربری با موفقیت ایجاد شد. اکنون می توانید وارد شوید';
                
                // Auto login
                $_SESSION['user_id'] = $newUser['id'];
                $_SESSION['username'] = $newUser['username'];
                $_SESSION['role'] = $newUser['role'];
                
                // Redirect to dashboard
                header('Location: ?page=dashboard');
                exit;
            } else {
                $error = 'خطا در ایجاد حساب کاربری';
            }
        }
    }
}
?>

<div class="container mx-auto px-4 py-8 mt-20">
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                <h3 class="text-center text-2xl font-bold text-gray-800 mb-6 flex items-center justify-center gap-3">
                    <div class="text-blue-600"><?php echo getIcon('user', 28); ?></div> ثبت نام
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
                               value="<?php echo htmlspecialchars($username ?? ''); ?>" 
                               minlength="3" required>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               id="email" name="email" 
                               value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">رمز عبور</label>
                        <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               id="password" name="password" minlength="6" required>
                    </div>
                    
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">تکرار رمز عبور</label>
                        <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    

                    <div class="flex items-center">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 ml-3" id="terms" required>
                        <label class="text-sm text-gray-700" for="terms">
                            <a href="#" onclick="openTermsModal()" class="text-blue-600 hover:text-blue-800 font-medium">قوانین و مقررات</a> را می پذیرم
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">ثبت نام</button>
                </form>
                
                <div class="text-center mt-6">
                    <p class="text-gray-600">قبلا ثبت نام کرده اید؟ <a href="?page=login" class="text-blue-600 hover:text-blue-800 font-medium">وارد شوید</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-96 overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h5 class="text-xl font-semibold text-gray-800">قوانین و مقررات</h5>
            <button type="button" onclick="closeTermsModal()" class="text-gray-500 hover:text-gray-700">
                <?php echo getIcon('close', 24); ?>
            </button>
        </div>
        <div class="p-6">
            <h6 class="text-lg font-semibold text-gray-800 mb-3">شرایط استفاده از خدمات</h6>
            <div class="space-y-2 mb-6">
                <p class="text-gray-700">1. کاربر متعهد می شود از خدمات سایت به صورت قانونی استفاده کند.</p>
                <p class="text-gray-700">2. تمامی اطلاعات ارائه شده توسط کاربر باید صحیح و کامل باشد.</p>
                <p class="text-gray-700">3. کاربر مسئول حفظ امنیت حساب کاربری خود می باشد.</p>
                <p class="text-gray-700">4. استفاده از خدمات برای اهداف غیرقانونی ممنوع است.</p>
                <p class="text-gray-700">5. سایت حق تغییر قوانین و مقررات را محفوظ می دارد.</p>
            </div>
            
            <h6 class="text-lg font-semibold text-gray-800 mb-3">سیاست حریم خصوصی</h6>
            <div class="space-y-2">
                <p class="text-gray-700">1. اطلاعات شخصی کاربران محفوظ و امن نگهداری می شود.</p>
                <p class="text-gray-700">2. اطلاعات کاربران به هیچ عنوان به اشخاص ثالث ارائه نمی شود.</p>
                <p class="text-gray-700">3. کاربران حق درخواست حذف اطلاعات شخصی خود را دارند.</p>
            </div>
        </div>
        <div class="border-t border-gray-200 p-6">
            <button type="button" onclick="closeTermsModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">بستن</button>
        </div>
    </div>
</div>

<script>
function openTermsModal() {
    document.getElementById('termsModal').classList.remove('hidden');
}

function closeTermsModal() {
    document.getElementById('termsModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('termsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTermsModal();
    }
});
</script>

<script>
// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    var password = document.getElementById('password').value;
    var confirmPassword = this.value;
    
    if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('رمز عبور و تکرار آن یکسان نیستند');
        this.classList.add('is-invalid');
    } else {
        this.setCustomValidity('');
        this.classList.remove('is-invalid');
        if (confirmPassword && password === confirmPassword) {
            this.classList.add('is-valid');
        }
    }
});
</script>
