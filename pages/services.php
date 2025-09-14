<!-- Services Page -->
<section class="py-24 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 pt-20">
        <div class="text-center mb-20">
            <h1 class="text-4xl lg:text-5xl font-bold gradient-text mb-6">محصولات و خدمات</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                مجموعه کاملی از خدمات دیجیتال با بهترین کیفیت و قیمت در بازار
            </p>
        </div>
        
        <!-- Search and Filter -->
        <div class="flex flex-col md:flex-row gap-6 mb-12">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="جستجو در محصولات..." 
                           class="w-full px-4 py-3 pl-12 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div class="flex gap-4">
                <select class="px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>همه دسته‌ها</option>
                    <option>بازی‌ها</option>
                    <option>طراحی</option>
                    <option>برنامه‌نویسی</option>
                </select>
                <select class="px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>مرتب‌سازی</option>
                    <option>ارزان‌ترین</option>
                    <option>گران‌ترین</option>
                    <option>محبوب‌ترین</option>
                </select>
            </div>
        </div>
        
        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php foreach ($services as $index => $service): ?>
            <div class="product-card card-hover rounded-2xl p-8 text-center searchable-item">
                <div class="service-icon w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-<?php 
                        $icons = ['gamepad', 'mobile-alt', 'laptop-code', 'chart-line', 'palette', 'code', 'shopping-cart', 'rocket', 'paint-brush', 'database'];
                        echo $icons[$index % count($icons)]; 
                    ?> text-3xl text-blue-600"></i>
                </div>
                
                <?php if (!empty($service['image']) && file_exists($service['image'])): ?>
                    <img src="<?php echo htmlspecialchars($service['image']); ?>" 
                         alt="<?php echo htmlspecialchars($service['title']); ?>"
                         class="w-full h-48 object-cover rounded-xl mb-6">
                <?php endif; ?>
                
                <h3 class="text-2xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($service['title']); ?></h3>
                <p class="text-gray-600 mb-6 leading-relaxed"><?php echo htmlspecialchars($service['description']); ?></p>
                
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-medium">قیمت:</span>
                        <span class="text-2xl font-bold text-blue-600"><?php echo number_format($service['price']); ?> تومان</span>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <a href="?page=service&id=<?php echo $service['id']; ?>" 
                       class="w-full bg-gray-100 text-gray-800 py-3 px-6 rounded-xl font-medium hover:bg-gray-200 transition-all inline-block">
                        <i class="fas fa-eye ml-2"></i>
                        مشاهده جزئیات
                    </a>
                    <form method="post" action="ajax/cart.php" style="display: inline-block; width: 100%;">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
                        <button type="submit" class="w-full btn-primary text-white py-3 rounded-xl font-medium">
                            <i class="fas fa-cart-plus ml-2"></i>
                            افزودن به سبد خرید
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- No Results Message -->
        <div id="noResults" class="text-center py-12 hidden">
            <div class="text-6xl text-gray-300 mb-4">🔍</div>
            <h3 class="text-2xl font-bold text-gray-600 mb-2">نتیجه‌ای یافت نشد</h3>
            <p class="text-gray-500">لطفا کلمات کلیدی دیگری امتحان کنید</p>
        </div>
        
        <!-- Load More Button -->
        <div class="text-center">
            <button class="btn-primary text-white px-10 py-4 rounded-xl text-lg font-medium shadow-lg">
                <i class="fas fa-plus ml-2"></i>
                نمایش بیشتر
            </button>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold gradient-text mb-6">دسته‌بندی خدمات</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">انتخاب سریع بر اساس نیاز شما</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <a href="#" class="group bg-white rounded-2xl p-6 text-center border border-gray-200 hover:border-blue-300 hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 transition-colors">
                    <i class="fas fa-gamepad text-blue-600 text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">بازی‌ها</h3>
                <p class="text-sm text-gray-600">Steam, Epic Games</p>
            </a>
            
            <a href="#" class="group bg-white rounded-2xl p-6 text-center border border-gray-200 hover:border-green-300 hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition-colors">
                    <i class="fas fa-mobile-alt text-green-600 text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">موبایل</h3>
                <p class="text-sm text-gray-600">اپلیکیشن‌ها</p>
            </a>
            
            <a href="#" class="group bg-white rounded-2xl p-6 text-center border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition-colors">
                    <i class="fas fa-laptop-code text-purple-600 text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">وب</h3>
                <p class="text-sm text-gray-600">طراحی سایت</p>
            </a>
            
            <a href="#" class="group bg-white rounded-2xl p-6 text-center border border-gray-200 hover:border-orange-300 hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-600 transition-colors">
                    <i class="fas fa-chart-line text-orange-600 text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">مارکتینگ</h3>
                <p class="text-sm text-gray-600">تبلیغات دیجیتال</p>
            </a>
            
            <a href="#" class="group bg-white rounded-2xl p-6 text-center border border-gray-200 hover:border-pink-300 hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-pink-600 transition-colors">
                    <i class="fas fa-palette text-pink-600 text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">گرافیک</h3>
                <p class="text-sm text-gray-600">طراحی لوگو</p>
            </a>
            
            <a href="#" class="group bg-white rounded-2xl p-6 text-center border border-gray-200 hover:border-indigo-300 hover:shadow-lg transition-all">
                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 transition-colors">
                    <i class="fas fa-code text-indigo-600 text-2xl group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">نرم‌افزار</h3>
                <p class="text-sm text-gray-600">توسعه کاربردی</p>
            </a>
        </div>
    </div>
</section>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const items = document.querySelectorAll('.searchable-item');
    const noResults = document.getElementById('noResults');
    let hasResults = false;
    
    items.forEach(function(item) {
        const text = item.textContent.toLowerCase();
        if (text.includes(query)) {
            item.style.display = '';
            hasResults = true;
        } else {
            item.style.display = 'none';
        }
    });
    
    if (hasResults || query === '') {
        noResults.classList.add('hidden');
    } else {
        noResults.classList.remove('hidden');
    }
});
</script>