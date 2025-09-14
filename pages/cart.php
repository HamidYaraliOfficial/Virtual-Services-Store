<?php
// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];
$total = 0;

// Calculate total
foreach ($cartItems as $serviceId => $quantity) {
    $service = getServiceById($serviceId);
    if ($service) {
        $total += $service['price'] * $quantity;
    }
}
?>

<!-- Cart Page -->
<section class="py-24 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 pt-20">
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold gradient-text mb-6">سبد خرید</h1>
            <p class="text-xl text-gray-600">بررسی و تکمیل سفارش شما</p>
        </div>

        <?php if (empty($cartItems)): ?>
        <!-- Empty Cart -->
        <div class="max-w-md mx-auto text-center py-16">
            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-8">
                <i class="fas fa-shopping-cart text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">سبد خرید شما خالی است</h3>
            <p class="text-gray-600 mb-8 leading-relaxed">
                هنوز محصولی به سبد خرید خود اضافه نکرده‌اید. 
                برای مشاهده محصولات به صفحه خدمات مراجعه کنید.
            </p>
            <a href="?page=services" class="btn-primary text-white px-8 py-4 rounded-xl text-lg font-medium shadow-lg">
                <i class="fas fa-shopping-bag ml-2"></i>
                مشاهده محصولات
            </a>
        </div>
        <?php else: ?>
        
        <!-- Cart Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items List -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-list-ul text-blue-600 ml-3"></i>
                        لیست محصولات
                    </h2>
                    
                    <div class="space-y-4">
                        <?php foreach ($cartItems as $serviceId => $quantity): ?>
                            <?php $service = getServiceById($serviceId); ?>
                            <?php if ($service): ?>
                            <div class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="w-24 h-24 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-cube text-blue-600 text-2xl"></i>
                                </div>
                                
                                <div class="flex-1 text-center md:text-right">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($service['title']); ?></h3>
                                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($service['description']); ?></p>
                                    <div class="flex items-center justify-center md:justify-start gap-4">
                                        <span class="text-lg font-bold text-blue-600"><?php echo number_format($service['price']); ?> تومان</span>
                                        <span class="text-gray-500">×</span>
                                        <span class="bg-white px-3 py-1 rounded-lg border font-medium"><?php echo $quantity; ?></span>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col gap-2">
                                    <div class="text-center mb-2">
                                        <span class="text-lg font-bold text-gray-800"><?php echo number_format($service['price'] * $quantity); ?> تومان</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <form method="post" action="ajax/cart.php" style="display: inline;">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="service_id" value="<?php echo $serviceId; ?>">
                                            <input type="hidden" name="update_action" value="increase">
                                            <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
                                            <button type="submit" class="w-8 h-8 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors">
                                                <i class="fas fa-plus text-sm"></i>
                                            </button>
                                        </form>
                                        
                                        <form method="post" action="ajax/cart.php" style="display: inline;">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="service_id" value="<?php echo $serviceId; ?>">
                                            <input type="hidden" name="update_action" value="decrease">
                                            <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
                                            <button type="submit" class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors">
                                                <i class="fas fa-minus text-sm"></i>
                                            </button>
                                        </form>
                                        
                                        <form method="post" action="ajax/cart.php" style="display: inline;">
                                            <input type="hidden" name="action" value="remove">
                                            <input type="hidden" name="service_id" value="<?php echo $serviceId; ?>">
                                            <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
                                            <button type="submit" class="w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 sticky top-24">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-receipt text-green-600 ml-3"></i>
                        خلاصه سفارش
                    </h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">تعداد اقلام:</span>
                            <span class="font-medium"><?php echo array_sum($cartItems); ?> عدد</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">جمع کل:</span>
                            <span class="text-xl font-bold text-gray-800"><?php echo number_format($total); ?> تومان</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">هزینه ارسال:</span>
                            <span class="text-green-600 font-medium">رایگان</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-4 bg-blue-50 px-4 rounded-xl">
                            <span class="text-lg font-bold text-gray-800">مبلغ نهایی:</span>
                            <span class="text-2xl font-bold text-blue-600"><?php echo number_format($total); ?> تومان</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="?page=checkout" class="w-full btn-primary text-white py-4 rounded-xl text-lg font-medium text-center block">
                                <i class="fas fa-credit-card ml-2"></i>
                                ادامه خرید
                            </a>
                        <?php else: ?>
                            <a href="?page=login" class="w-full btn-primary text-white py-4 rounded-xl text-lg font-medium text-center block">
                                <i class="fas fa-sign-in-alt ml-2"></i>
                                ورود برای ادامه
                            </a>
                        <?php endif; ?>
                        
                        <a href="?page=services" class="w-full bg-gray-100 text-gray-800 py-4 rounded-xl text-lg font-medium text-center block hover:bg-gray-200 transition-colors">
                            <i class="fas fa-arrow-right ml-2"></i>
                            بازگشت به فروشگاه
                        </a>
                    </div>
                    
                    <!-- Security Badges -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-center gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-alt text-green-500"></i>
                                <span>پرداخت امن</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-lock text-blue-500"></i>
                                <span>محافظت SSL</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php endif; ?>
    </div>
</section>

<!-- Recommended Products -->
<?php if (!empty($cartItems)): ?>
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold gradient-text mb-4">محصولات پیشنهادی</h2>
            <p class="text-gray-600">محصولات مرتبط که ممکن است به شما کمک کند</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php 
            $recommendedServices = array_slice($services, 0, 4);
            foreach ($recommendedServices as $index => $service): 
            ?>
            <div class="product-card rounded-2xl p-6 text-center">
                <div class="service-icon w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-<?php 
                        $icons = ['star', 'gift', 'heart', 'thumbs-up'];
                        echo $icons[$index % count($icons)]; 
                    ?> text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($service['title']); ?></h3>
                <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars(substr($service['description'], 0, 60)) . '...'; ?></p>
                <div class="text-blue-600 font-bold mb-4"><?php echo number_format($service['price']); ?> تومان</div>
                <form method="post" action="ajax/cart.php">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
                    <button type="submit" class="w-full bg-blue-100 text-blue-600 py-2 rounded-xl font-medium hover:bg-blue-200 transition-colors">
                        <i class="fas fa-plus ml-1"></i>
                        افزودن
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>