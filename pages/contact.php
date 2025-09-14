<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'لطفا تمام فیلدها را پر کنید';
    } elseif (!validateEmail($email)) {
        $error = 'فرمت ایمیل صحیح نیست';
    } else {
        // In a real application, send email here
        $success = 'پیام شما با موفقیت ارسال شد. به زودی با شما تماس خواهیم گرفت.';
    }
}
?>

<div class="container mx-auto px-4 py-8 mt-20">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12 animate-fade-in">
            <div class="mb-6">
                <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <?php echo getIcon('contact', 40); ?>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-gradient mb-4">تماس با ما</h1>
            <p class="text-xl text-gray-600">ما همیشه آماده پاسخگویی به سوالات شما هستیم</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="premium-card hover-lift rounded-2xl p-8 animate-slide-up">
                    <h4 class="text-2xl font-bold text-gray-800 mb-6">فرم تماس</h4>
                    
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
                    
                    <form method="POST" class="space-y-6">
                        <?php echo csrfInput(); ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">نام و نام خانوادگی</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                                <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">موضوع</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                    id="subject" name="subject" required>
                                <option value="">انتخاب کنید</option>
                                <option value="سوال عمومی" <?php echo (isset($subject) && $subject === 'سوال عمومی') ? 'selected' : ''; ?>>سوال عمومی</option>
                                <option value="پشتیبانی فنی" <?php echo (isset($subject) && $subject === 'پشتیبانی فنی') ? 'selected' : ''; ?>>پشتیبانی فنی</option>
                                <option value="شکایت" <?php echo (isset($subject) && $subject === 'شکایت') ? 'selected' : ''; ?>>شکایت</option>
                                <option value="پیشنهاد" <?php echo (isset($subject) && $subject === 'پیشنهاد') ? 'selected' : ''; ?>>پیشنهاد</option>
                                <option value="همکاری" <?php echo (isset($subject) && $subject === 'همکاری') ? 'selected' : ''; ?>>همکاری</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">پیام</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                      id="message" name="message" rows="6" placeholder="پیام خود را اینجا بنویسید..." required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn-premium text-white px-8 py-3 rounded-2xl font-semibold hover-lift shadow-lg flex items-center gap-3">
                            <?php echo getIcon('contact', 20); ?> ارسال پیام
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="space-y-6">
                <div class="premium-card hover-lift rounded-2xl p-6 animate-slide-up">
                    <h5 class="text-xl font-bold text-gray-800 mb-6">اطلاعات تماس</h5>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                                <?php echo getIcon('contact', 24); ?>
                            </div>
                            <div>
                                <h6 class="font-semibold text-gray-800 mb-1">ایمیل</h6>
                                <p class="text-gray-600 text-sm">info@shop.com<br>support@shop.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                                <?php echo getIcon('support', 24); ?>
                            </div>
                            <div>
                                <h6 class="font-semibold text-gray-800 mb-1">تلفن</h6>
                                <p class="text-gray-600 text-sm">021-12345678<br>0912-3456789</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                                <?php echo getIcon('about', 24); ?>
                            </div>
                            <div>
                                <h6 class="font-semibold text-gray-800 mb-1">آدرس</h6>
                                <p class="text-gray-600 text-sm">تهران، خیابان آزادی، پلاک 123</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600">
                                <?php echo getIcon('clock', 24); ?>
                            </div>
                            <div>
                                <h6 class="font-semibold text-gray-800 mb-1">ساعات کاری</h6>
                                <p class="text-gray-600 text-sm">شنبه تا پنج شنبه<br>9:00 تا 18:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="premium-card hover-lift rounded-2xl p-6 text-center animate-slide-up">
                    <h6 class="font-semibold text-gray-800 mb-4">شبکه های اجتماعی</h6>
                    <div class="flex justify-center gap-3">
                        <a href="#" class="w-12 h-12 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center transition-colors">
                            <?php echo getIcon('contact', 20); ?>
                        </a>
                        <a href="#" class="w-12 h-12 bg-red-100 hover:bg-red-200 text-red-600 rounded-xl flex items-center justify-center transition-colors">
                            <?php echo getIcon('heart', 20); ?>
                        </a>
                        <a href="#" class="w-12 h-12 bg-green-100 hover:bg-green-200 text-green-600 rounded-xl flex items-center justify-center transition-colors">
                            <?php echo getIcon('support', 20); ?>
                        </a>
                        <a href="#" class="w-12 h-12 bg-cyan-100 hover:bg-cyan-200 text-cyan-600 rounded-xl flex items-center justify-center transition-colors">
                            <?php echo getIcon('about', 20); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
    
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }
    
    .animate-slide-up {
        animation: slideUp 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
    
    @keyframes slideUp {
        0% { transform: translateY(50px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
</style>
