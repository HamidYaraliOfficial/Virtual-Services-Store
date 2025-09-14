<div class="container mx-auto px-4 py-8 mt-20">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12 animate-fade-in">
            <div class="mb-6">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <?php echo getIcon('about', 40); ?>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-gradient mb-4">درباره ما</h1>
            <p class="text-xl text-gray-600">بهترین خدمات مجازی با کیفیت و قیمت مناسب</p>
        </div>
        
        <div class="premium-card hover-lift rounded-2xl p-8 animate-slide-up">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">داستان ما</h3>
            <p class="text-gray-700 leading-relaxed mb-8">
                فروشگاه خدمات مجازی ما با هدف ارائه بهترین و با کیفیت ترین خدمات در زمینه شبکه های اجتماعی و خدمات دیجیتال تاسیس شده است. ما با سال ها تجربه در این حوزه، متعهد به ارائه خدمات سریع، امن و قابل اعتماد هستیم.
            </p>
            
            <h4 class="text-xl font-bold text-gray-800 mb-4">ماموریت ما</h4>
            <p class="text-gray-700 leading-relaxed mb-8">
                ماموریت ما کمک به کسب و کارها و افراد برای رشد و موفقیت در فضای دیجیتال است. ما باور داریم که هر کسی باید امکان دسترسی به خدمات با کیفیت و مقرون به صرفه را داشته باشد.
            </p>
            
            <h4 class="text-xl font-bold text-gray-800 mb-6">چرا ما را انتخاب کنید؟</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="flex items-start gap-4 p-4 bg-green-50 rounded-xl hover-lift">
                    <div class="text-green-600 mt-1">
                        <?php echo getIcon('check', 32); ?>
                    </div>
                    <div>
                        <h6 class="font-semibold text-gray-800 mb-2">کیفیت تضمینی</h6>
                        <p class="text-sm text-gray-600">تمام خدمات ما با بالاترین کیفیت ارائه می شود</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 bg-yellow-50 rounded-xl hover-lift">
                    <div class="text-yellow-600 mt-1">
                        <?php echo getIcon('star', 32); ?>
                    </div>
                    <div>
                        <h6 class="font-semibold text-gray-800 mb-2">تحویل سریع</h6>
                        <p class="text-sm text-gray-600">خدمات در کمترین زمان ممکن تحویل داده می شود</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl hover-lift">
                    <div class="text-blue-600 mt-1">
                        <?php echo getIcon('shield', 32); ?>
                    </div>
                    <div>
                        <h6 class="font-semibold text-gray-800 mb-2">امنیت بالا</h6>
                        <p class="text-sm text-gray-600">اطلاعات شما کاملا محرمانه و امن نگهداری می شود</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 bg-purple-50 rounded-xl hover-lift">
                    <div class="text-purple-600 mt-1">
                        <?php echo getIcon('support', 32); ?>
                    </div>
                    <div>
                        <h6 class="font-semibold text-gray-800 mb-2">پشتیبانی 24/7</h6>
                        <p class="text-sm text-gray-600">تیم پشتیبانی ما همیشه در خدمت شما است</p>
                    </div>
                </div>
            </div>
            
            <h4 class="text-xl font-bold text-gray-800 mb-6">خدمات ما</h4>
            <div class="space-y-3">
                <div class="flex items-center gap-3 text-gray-700">
                    <div class="text-blue-600"><?php echo getIcon('services', 20); ?></div>
                    <span>افزایش فالوور اینستاگرام</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700">
                    <div class="text-blue-600"><?php echo getIcon('heart', 20); ?></div>
                    <span>افزایش لایک و کامنت</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700">
                    <div class="text-blue-600"><?php echo getIcon('user', 20); ?></div>
                    <span>افزایش ممبر تلگرام</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700">
                    <div class="text-blue-600"><?php echo getIcon('star', 20); ?></div>
                    <span>خدمات یوتیوب</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700">
                    <div class="text-blue-600"><?php echo getIcon('services', 20); ?></div>
                    <span>خدمات سایر شبکه های اجتماعی</span>
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
