<?php
$error = '';
$success = '';

// Load current settings
$settings = loadSettings();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $merchantId = sanitize($_POST['zarinpal_merchant_id'] ?? '');
    $sandbox = isset($_POST['zarinpal_sandbox']) ? true : false;
    
    // Validation
    if (empty($merchantId)) {
        $error = 'شناسه درگاه اجباری است';
    } elseif (strlen($merchantId) !== 36) {
        $error = 'شناسه درگاه باید 36 کاراکتر باشد';
    } else {
        // Update settings
        $settings['zarinpal_merchant_id'] = $merchantId;
        $settings['zarinpal_sandbox'] = $sandbox;
        
        if (saveSettings($settings)) {
            $success = 'تنظیمات درگاه پرداخت با موفقیت ذخیره شد';
        } else {
            $error = 'خطا در ذخیره تنظیمات';
        }
    }
}

// Test connection function
$testResult = '';
if (isset($_POST['test_connection'])) {
    $merchantId = $settings['zarinpal_merchant_id'] ?? '';
    $sandbox = $settings['zarinpal_sandbox'] ?? true;
    
    if (empty($merchantId)) {
        $testResult = 'ابتدا شناسه درگاه را وارد کنید';
    } else {
        // Test ZarinPal connection
        $testUrl = $sandbox ? 
            'https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json' : 
            'https://api.zarinpal.com/pg/v4/payment/request.json';
        
        $testData = [
            'merchant_id' => $merchantId,
            'amount' => 1000,
            'description' => 'تست اتصال',
            'callback_url' => 'http://test.com'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $testUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($testData))
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $result = json_decode($response, true);
            if (isset($result['data']['code'])) {
                if ($result['data']['code'] == 100) {
                    $testResult = 'اتصال موفق - درگاه درست کار می کند';
                } else {
                    $testResult = 'خطا: ' . ($result['errors'][0]['message'] ?? 'خطای نامشخص');
                }
            } else {
                $testResult = 'پاسخ نامعتبر از سرور';
            }
        } else {
            $testResult = 'خطا در اتصال به سرور - کد: ' . $httpCode;
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>مدیریت درگاه پرداخت</h2>
    <div class="text-muted">
        <i class="bi bi-bank"></i> تنظیمات ZarinPal
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <!-- ZarinPal Settings -->
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <img src="../assets/images/zarinpal-logo.png" alt="ZarinPal" height="30" class="me-2">
                <h5 class="mb-0">تنظیمات زرین پال</h5>
            </div>
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label for="zarinpal_merchant_id" class="form-label">شناسه درگاه (Merchant ID)</label>
                        <input type="text" class="form-control" id="zarinpal_merchant_id" 
                               name="zarinpal_merchant_id" 
                               value="<?php echo htmlspecialchars($settings['zarinpal_merchant_id'] ?? ''); ?>"
                               placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
                               pattern="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"
                               required>
                        <div class="form-text">
                            شناسه درگاه را از پنل زرین پال دریافت کنید. فرمت: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
                        </div>
                        <div class="invalid-feedback">
                            شناسه درگاه اجباری است و باید در فرمت صحیح باشد
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="zarinpal_sandbox" 
                                   name="zarinpal_sandbox" 
                                   <?php echo ($settings['zarinpal_sandbox'] ?? true) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="zarinpal_sandbox">
                                حالت تست (Sandbox)
                            </label>
                        </div>
                        <div class="form-text">
                            در حالت تست، پرداخت ها واقعی نیستند و برای آزمایش استفاده می شوند.
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> ذخیره تنظیمات
                        </button>
                        <button type="submit" name="test_connection" class="btn btn-outline-info">
                            <i class="bi bi-wifi"></i> تست اتصال
                        </button>
                    </div>
                </form>
                
                <?php if ($testResult): ?>
                <div class="mt-3">
                    <div class="alert alert-info">
                        <strong>نتیجه تست:</strong> <?php echo $testResult; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Payment Statistics -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">آمار پرداخت ها</h5>
            </div>
            <div class="card-body">
                <?php
                $payments = loadPayments();
                $totalPayments = count($payments);
                $successfulPayments = count(array_filter($payments, function($p) {
                    return $p['status'] === 'completed';
                }));
                $totalAmount = array_sum(array_column($payments, 'amount'));
                $successRate = $totalPayments > 0 ? round(($successfulPayments / $totalPayments) * 100, 1) : 0;
                ?>
                
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-primary"><?php echo $totalPayments; ?></h4>
                            <small class="text-muted">کل تراکنش ها</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success"><?php echo $successfulPayments; ?></h4>
                            <small class="text-muted">موفق</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-danger"><?php echo $totalPayments - $successfulPayments; ?></h4>
                            <small class="text-muted">ناموفق</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info"><?php echo $successRate; ?>%</h4>
                            <small class="text-muted">نرخ موفقیت</small>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>کل مبلغ دریافتی:</h6>
                        <h4 class="text-success"><?php echo formatPrice($totalAmount); ?></h4>
                    </div>
                    <div class="col-md-6">
                        <h6>میانگین هر تراکنش:</h6>
                        <h4 class="text-info">
                            <?php echo $totalPayments > 0 ? formatPrice($totalAmount / $totalPayments) : '0 تومان'; ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Gateway Status -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">وضعیت درگاه</h6>
            </div>
            <div class="card-body text-center">
                <?php if (!empty($settings['zarinpal_merchant_id'])): ?>
                <div class="text-success mb-3">
                    <i class="bi bi-check-circle" style="font-size: 3rem;"></i>
                </div>
                <h6 class="text-success">درگاه فعال</h6>
                <p class="text-muted">درگاه پرداخت تنظیم شده و آماده استفاده است</p>
                <div class="mt-3">
                    <small class="text-muted">حالت: </small>
                    <?php if ($settings['zarinpal_sandbox'] ?? true): ?>
                    <span class="badge bg-warning">تست</span>
                    <?php else: ?>
                    <span class="badge bg-success">عملیاتی</span>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="text-danger mb-3">
                    <i class="bi bi-x-circle" style="font-size: 3rem;"></i>
                </div>
                <h6 class="text-danger">درگاه غیرفعال</h6>
                <p class="text-muted">شناسه درگاه تنظیم نشده است</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Setup Guide -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">راهنمای تنظیم</h6>
            </div>
            <div class="card-body">
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">
                        در سایت <a href="https://zarinpal.com" target="_blank">ZarinPal.com</a> ثبت نام کنید
                    </li>
                    <li class="list-group-item">
                        درخواست درگاه پرداخت ارسال کنید
                    </li>
                    <li class="list-group-item">
                        پس از تایید، شناسه درگاه (Merchant ID) را دریافت کنید
                    </li>
                    <li class="list-group-item">
                        شناسه را در فرم بالا وارد کنید
                    </li>
                    <li class="list-group-item">
                        اتصال را تست کنید
                    </li>
                </ol>
            </div>
        </div>
        
        <!-- Support -->
        <div class="card mt-4">
            <div class="card-body text-center">
                <i class="bi bi-question-circle text-info fs-1 mb-3"></i>
                <h6>نیاز به کمک؟</h6>
                <p class="small text-muted">
                    برای راهنمایی بیشتر با پشتیبانی زرین پال تماس بگیرید
                </p>
                <a href="https://docs.zarinpal.com" target="_blank" class="btn btn-outline-info btn-sm">
                    مستندات زرین پال
                </a>
            </div>
        </div>
    </div>
</div>
