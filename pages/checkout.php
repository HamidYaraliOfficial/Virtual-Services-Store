<?php
requireLogin();

$cartItems = [];
$cartTotal = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $serviceId => $quantity) {
        $service = getServiceById($serviceId);
        if ($service) {
            $cartItems[] = [
                'service' => $service,
                'quantity' => $quantity,
                'total' => $service['price'] * $quantity
            ];
            $cartTotal += $service['price'] * $quantity;
        }
    }
}

if (empty($cartItems)) {
    header('Location: ?page=cart');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethod = $_POST['payment_method'] ?? '';
    
    if ($paymentMethod === 'zarinpal') {
        // Create order
        $orders = loadOrders();
        $orderId = generateId($orders);
        
        $newOrder = [
            'id' => $orderId,
            'user_id' => $_SESSION['user_id'],
            'items' => $cartItems,
            'total' => $cartTotal,
            'status' => 'pending',
            'payment_method' => 'zarinpal',
            'created_at' => date('Y-m-d H:i:s'),
            'payment_status' => 'pending'
        ];
        
        $orders[] = $newOrder;
        saveOrders($orders);
        
        // Redirect to payment
        header('Location: payment/zarinpal.php?order_id=' . $orderId);
        exit;
    } else {
        $error = 'لطفا روش پرداخت را انتخاب کنید';
    }
}

$user = getUserById($_SESSION['user_id']);
?>

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
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
</style>

<div class="container mx-auto px-4 py-8 mt-20">
    <div class="flex items-center gap-3 mb-6">
        <div class="text-blue-600"><?php echo getIcon('credit-card', 32); ?></div>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">تسویه حساب</h2>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Billing Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-800">اطلاعات صورتحساب</h5>
                </div>
                <div class="p-6">
                    <form method="POST" class="space-y-6">
                        <?php echo csrfInput(); ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">نام</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="first_name" name="first_name" 
                                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">نام خانوادگی</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       id="last_name" name="last_name" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   id="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">شماره تلفن</label>
                            <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   id="phone" name="phone" required>
                        </div>
                        
                        <!-- Payment Methods -->
                        <div class="bg-gray-50 rounded-xl p-6 mt-6">
                            <h6 class="text-lg font-semibold text-gray-800 mb-4">روش پرداخت</h6>
                            
                            <?php if ($error): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                                <?php echo $error; ?>
                            </div>
                            <?php endif; ?>
                            
                            <div class="space-y-4">
                                <div class="flex items-center p-4 border border-gray-300 rounded-lg">
                                    <input type="radio" name="payment_method" id="zarinpal" value="zarinpal" 
                                           class="w-4 h-4 text-blue-600 ml-3" checked>
                                    <label for="zarinpal" class="flex items-center cursor-pointer">
                                        <img src="assets/images/zarinpal-logo.png" alt="ZarinPal" height="30" class="ml-3">
                                        <div>
                                            <div class="font-medium text-gray-800">ZarinPal پرداخت آنلاین با زرین پال</div>
                                            <div class="text-sm text-gray-600">پرداخت امن با کارت های عضو شتاب</div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center p-4 border border-gray-300 rounded-lg bg-gray-100 opacity-50">
                                    <input type="radio" name="payment_method" id="wallet" value="wallet" 
                                           class="w-4 h-4 text-blue-600 ml-3" disabled>
                                    <label for="wallet" class="cursor-not-allowed">
                                        <div class="font-medium text-gray-600">کیف پول (موجودی: 0 تومان)</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="flex items-center mt-6">
                            <input type="checkbox" id="terms" class="w-4 h-4 text-blue-600 ml-3" required>
                            <label for="terms" class="text-sm text-gray-700">
                                با <a href="#" onclick="openTermsModal()" class="text-blue-600 hover:text-blue-800">قوانین و مقررات</a> موافقم
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full btn-premium text-white px-6 py-4 rounded-2xl font-bold text-lg hover-lift shadow-xl mt-6 flex items-center justify-center gap-3">
                            <?php echo getIcon('credit-card', 24); ?> پرداخت امن <?php echo formatPrice($cartTotal); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-1">
            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-gray-800">خلاصه سفارش</h6>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="flex justify-between items-center">
                            <div>
                                <h6 class="font-medium text-gray-800"><?php echo htmlspecialchars($item['service']['title']); ?></h6>
                                <small class="text-gray-600">تعداد: <?php echo $item['quantity']; ?></small>
                            </div>
                            <span class="font-medium text-gray-800"><?php echo formatPrice($item['total']); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">جمع کل:</span>
                            <span class="text-gray-800"><?php echo formatPrice($cartTotal); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">تخفیف:</span>
                            <span class="text-green-600">0 تومان</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">مالیات:</span>
                            <span class="text-gray-800">0 تومان</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-gray-800">مبلغ نهایی:</span>
                            <span class="text-blue-600"><?php echo formatPrice($cartTotal); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Security Info -->
            <div class="premium-card hover-lift rounded-2xl mt-6 p-6 text-center">
                <div class="text-green-600 mb-3"><?php echo getIcon('shield', 48); ?></div>
                <h6 class="font-semibold text-gray-800 mb-2">پرداخت امن</h6>
                <p class="text-sm text-gray-600">
                    تمام پرداخت ها با رمزنگاری SSL 256 بیتی محافظت می شوند
                </p>
            </div>
            
            <!-- Support -->
            <div class="premium-card hover-lift rounded-2xl mt-6 p-6 text-center">
                <div class="text-blue-600 mb-3"><?php echo getIcon('support', 48); ?></div>
                <h6 class="font-semibold text-gray-800 mb-2">پشتیبانی 24/7</h6>
                <p class="text-sm text-gray-600 mb-4">
                    در صورت بروز مشکل با پشتیبانی در ارتباط باشید
                </p>
                <a href="?page=contact" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">تماس با پشتیبانی</a>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-96 overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h5 class="text-xl font-semibold text-gray-800">قوانین و مقررات خرید</h5>
            <button type="button" onclick="closeTermsModal()" class="text-gray-500 hover:text-gray-700">
                <?php echo getIcon('close', 24); ?>
            </button>
        </div>
        <div class="p-6">
            <h6 class="text-lg font-semibold text-gray-800 mb-3">شرایط خرید و استفاده از خدمات</h6>
            <div class="space-y-2 mb-6">
                <p class="text-gray-700">1. تمامی خدمات ارائه شده دارای ضمانت کیفیت هستند.</p>
                <p class="text-gray-700">2. در صورت عدم رضایت از خدمات، امکان بازگشت وجه تا 48 ساعت وجود دارد.</p>
                <p class="text-gray-700">3. زمان تحویل خدمات بین فوری تا 24 ساعت متغیر است.</p>
                <p class="text-gray-700">4. استفاده از خدمات برای اهداف غیرقانونی ممنوع است.</p>
                <p class="text-gray-700">5. سایت حق تغییر قیمت ها و شرایط را محفوظ می دارد.</p>
            </div>
            
            <h6 class="text-lg font-semibold text-gray-800 mb-3">سیاست بازگشت وجه</h6>
            <div class="space-y-2">
                <p class="text-gray-700">1. درخواست بازگشت وجه باید تا 48 ساعت پس از خرید ارسال شود.</p>
                <p class="text-gray-700">2. بازگشت وجه پس از بررسی درخواست انجام می شود.</p>
                <p class="text-gray-700">3. مدت زمان بازگشت وجه تا 7 روز کاری است.</p>
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
