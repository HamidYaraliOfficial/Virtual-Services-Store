<?php
// Load latest services
$latestServices = array_slice($services, 0, 6);
?>

<!-- Hero Section -->
<section class="hero-bg min-h-screen flex items-center relative overflow-hidden pt-20">
    <!-- Floating Shopping Icons -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-icon absolute top-32 right-20 w-16 h-16 bg-white rounded-full shadow-lg flex items-center justify-center">
            <i class="fas fa-credit-card text-blue-600 text-xl"></i>
        </div>
        <div class="floating-icon absolute top-48 left-32 w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center">
            <i class="fas fa-truck text-green-600 text-2xl"></i>
        </div>
        <div class="floating-icon absolute bottom-40 right-40 w-18 h-18 bg-white rounded-full shadow-lg flex items-center justify-center">
            <i class="fas fa-shield-alt text-purple-600 text-xl"></i>
        </div>
        <div class="floating-icon absolute bottom-32 left-20 w-14 h-14 bg-white rounded-full shadow-lg flex items-center justify-center">
            <i class="fas fa-star text-yellow-500 text-lg"></i>
        </div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-12 lg:mb-0 text-center lg:text-right">
                <h2 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    فروشگاه
                    <span class="gradient-text block">
                        آنلاین مدرن
                    </span>
                    شما
                </h2>
                <p class="text-xl lg:text-2xl text-gray-600 mb-10 leading-relaxed">
                    بهترین خدمات دیجیتال با کیفیت بالا، قیمت مناسب و تحویل سریع.
                    از بازی‌های Steam تا طراحی وب‌سایت، همه چیز در یک مکان!
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center lg:justify-start">
                    <a href="?page=services" class="btn-primary text-white px-10 py-4 rounded-xl text-lg font-medium shadow-lg">
                        <i class="fas fa-shopping-bag ml-2"></i>
                        مشاهده محصولات
                    </a>
                    <a href="?page=contact" class="bg-white text-gray-800 px-10 py-4 rounded-xl text-lg font-medium border-2 border-gray-300 hover:border-blue-600 hover:text-blue-600 transition-all">
                        <i class="fas fa-phone ml-2"></i>
                        تماس با ما
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 flex justify-center">
                <div class="relative">
                    <div class="w-80 h-80 bg-white rounded-3xl shadow-2xl flex items-center justify-center border border-gray-200">
                        <div class="text-center">
                            <div class="text-8xl mb-4">🛒</div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">خرید آسان</h3>
                            <p class="text-gray-600">تجربه خرید بی‌نظیر</p>
                        </div>
                    </div>
                    <div class="absolute -top-6 -right-6 w-20 h-20 bg-blue-600 rounded-2xl shadow-xl flex items-center justify-center floating-icon">
                        <i class="fas fa-bolt text-white text-2xl"></i>
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-green-600 rounded-2xl shadow-xl flex items-center justify-center floating-icon">
                        <i class="fas fa-check-circle text-white text-3xl"></i>
                    </div>
                    <div class="absolute top-20 -left-8 w-16 h-16 bg-purple-600 rounded-2xl shadow-xl flex items-center justify-center floating-icon">
                        <i class="fas fa-heart text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="stats-number text-4xl lg:text-5xl font-bold mb-4"><?php echo count($services); ?></div>
                <div class="text-gray-600 text-lg font-medium">خدمات فعال</div>
            </div>
            <div class="text-center">
                <div class="stats-number text-4xl lg:text-5xl font-bold mb-4"><?php echo count(loadUsers()) - 1; ?></div>
                <div class="text-gray-600 text-lg font-medium">کاربر عضو</div>
            </div>
            <div class="text-center">
                <div class="text-4xl lg:text-5xl font-bold mb-4 text-blue-600">۲۴/۷</div>
                <div class="text-gray-600 text-lg font-medium">پشتیبانی آنلاین</div>
            </div>
            <div class="text-center">
                <div class="stats-number text-4xl lg:text-5xl font-bold mb-4">۹۹</div>
                <div class="text-gray-600 text-lg font-medium">درصد رضایت</div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold gradient-text mb-6">محصولات و خدمات</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                مجموعه کاملی از خدمات دیجیتال با بهترین کیفیت و قیمت
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($latestServices as $index => $service): ?>
            <div class="product-card card-hover rounded-2xl p-8 text-center">
                <div class="service-icon w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-<?php 
                        $icons = ['gamepad', 'mobile-alt', 'laptop-code', 'chart-line', 'palette', 'code'];
                        echo $icons[$index % count($icons)]; 
                    ?> text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($service['title']); ?></h3>
                <p class="text-gray-600 mb-6 leading-relaxed"><?php echo htmlspecialchars($service['description']); ?></p>
                <div class="space-y-3 mb-8">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                        <span class="text-gray-700 font-medium"><?php echo htmlspecialchars($service['title']); ?></span>
                        <span class="text-blue-600 font-bold"><?php echo number_format($service['price']); ?> ت</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <a href="?page=service&id=<?php echo $service['id']; ?>" 
                       class="w-full bg-gray-100 text-gray-800 py-3 px-6 rounded-xl font-medium hover:bg-gray-200 transition-all inline-block">
                        مشاهده جزئیات
                    </a>
                    <form method="post" action="ajax/cart.php" style="display: inline-block; width: 100%;">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
                        <button type="submit" class="w-full btn-primary text-white py-3 rounded-xl font-medium">
                            <i class="fas fa-cart-plus ml-2"></i>
                            افزودن به سبد
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="?page=services" class="btn-primary text-white px-10 py-4 rounded-xl text-lg font-medium shadow-lg">
                مشاهده تمام خدمات
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold gradient-text mb-6">چرا ما را انتخاب کنید؟</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">مزایای خرید از فروشگاه آنلاین ما</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">پرداخت امن</h3>
                <p class="text-gray-600 leading-relaxed">تمام تراکنش‌ها با بالاترین سطح امنیت</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shipping-fast text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">تحویل سریع</h3>
                <p class="text-gray-600 leading-relaxed">محصولات دیجیتال فوراً تحویل داده می‌شود</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-headset text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">پشتیبانی ۲۴/۷</h3>
                <p class="text-gray-600 leading-relaxed">تیم پشتیبانی همیشه در خدمت شماست</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-award text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">کیفیت تضمینی</h3>
                <p class="text-gray-600 leading-relaxed">تضمین کیفیت یا بازگشت وجه</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2">
                <div class="relative">
                    <div class="w-full max-w-lg mx-auto">
                        <div class="bg-white rounded-3xl shadow-2xl p-12 border border-gray-200">
                            <div class="text-center">
                                <div class="text-8xl mb-6">🏪</div>
                                <h3 class="text-3xl font-bold text-gray-800 mb-4">فروشگاه مدرن</h3>
                                <p class="text-gray-600 text-lg">تجربه خرید بی‌نظیر</p>
                            </div>
                        </div>
                        <div class="absolute -top-6 -right-6 w-20 h-20 bg-blue-600 rounded-2xl shadow-xl flex items-center justify-center floating-icon">
                            <i class="fas fa-star text-white text-2xl"></i>
                        </div>
                        <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-green-600 rounded-2xl shadow-xl flex items-center justify-center floating-icon">
                            <i class="fas fa-thumbs-up text-white text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-bold gradient-text mb-8">درباره شاپ آنلاین</h2>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    ما با بیش از ۵ سال تجربه در زمینه فروش آنلاین، بهترین خدمات دیجیتال را با کیفیت فوق‌العاده 
                    و قیمت مناسب ارائه می‌دهیم.
                </p>
                <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                    هدف ما ایجاد تجربه خرید آسان، امن و لذت‌بخش برای تمام مشتریان است. 
                    با استفاده از جدیدترین تکنولوژی‌ها، پلتفرمی مدرن و کاربرپسند ایجاد کرده‌ایم.
                </p>
                <a href="?page=contact" class="btn-primary text-white px-8 py-4 rounded-xl text-lg font-medium">
                    <i class="fas fa-phone ml-2"></i>
                    تماس با ما
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold gradient-text mb-6">نظرات مشتریان</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">تجربه مشتریان ما از خدمات فروشگاه</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 text-center border border-gray-200 shadow-lg">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
                <div class="mb-4">
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                </div>
                <p class="text-gray-600 mb-6 leading-relaxed">"خدمات عالی و با کیفیت. پشتیبانی فوق العاده سریع و دقیق."</p>
                <h6 class="text-lg font-bold text-gray-800">علی احمدی</h6>
            </div>
            
            <div class="bg-white rounded-2xl p-8 text-center border border-gray-200 shadow-lg">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user text-green-600 text-xl"></i>
                </div>
                <div class="mb-4">
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                </div>
                <p class="text-gray-600 mb-6 leading-relaxed">"قیمت ها بسیار مناسب و کیفیت خدمات بی نظیر است."</p>
                <h6 class="text-lg font-bold text-gray-800">فاطمه محمدی</h6>
            </div>
            
            <div class="bg-white rounded-2xl p-8 text-center border border-gray-200 shadow-lg">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user text-purple-600 text-xl"></i>
                </div>
                <div class="mb-4">
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                </div>
                <p class="text-gray-600 mb-6 leading-relaxed">"تحویل سریع و دقیق. حتما دوباره خرید خواهم کرد."</p>
                <h6 class="text-lg font-bold text-gray-800">محمد رضایی</h6>
            </div>
        </div>
    </div>
</section>