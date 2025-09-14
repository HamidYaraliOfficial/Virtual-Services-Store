<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

requireLogin();

$orderId = $_GET['order_id'] ?? 0;

if (!$orderId) {
    header('Location: ../index.php?page=cart');
    exit;
}

$orders = loadOrders();
$order = null;

foreach ($orders as $o) {
    if ($o['id'] == $orderId && $o['user_id'] == $_SESSION['user_id']) {
        $order = $o;
        break;
    }
}

if (!$order) {
    header('Location: ../index.php?page=cart');
    exit;
}

// ZarinPal configuration
$settings = loadSettings();
$merchantId = $settings['zarinpal_merchant_id'] ?? ZARINPAL_MERCHANT_ID;
$sandbox = $settings['zarinpal_sandbox'] ?? ZARINPAL_SANDBOX;

if ($sandbox) {
    $zarinpalUrl = 'https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json';
    $gatewayUrl = 'https://sandbox.zarinpal.com/pg/StartPay/';
} else {
    $zarinpalUrl = 'https://api.zarinpal.com/pg/v4/payment/request.json';
    $gatewayUrl = 'https://www.zarinpal.com/pg/StartPay/';
}

$amount = $order['total'];
$description = 'خرید خدمات مجازی - سفارش شماره ' . $orderId;
$callbackUrl = SITE_URL . '/payment/zarinpal-callback.php';

$data = [
    'merchant_id' => $merchantId,
    'amount' => $amount,
    'description' => $description,
    'callback_url' => $callbackUrl,
    'metadata' => [
        'order_id' => $orderId,
        'user_id' => $_SESSION['user_id']
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $zarinpalUrl);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen(json_encode($data))
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    $result = json_decode($response, true);
    
    if (isset($result['data']['code']) && $result['data']['code'] == 100) {
        // Save authority to order
        $authority = $result['data']['authority'];
        
        // Update order with authority
        foreach ($orders as &$o) {
            if ($o['id'] == $orderId) {
                $o['authority'] = $authority;
                $o['payment_status'] = 'redirected';
                break;
            }
        }
        saveOrders($orders);
        
        // Redirect to ZarinPal
        header('Location: ' . $gatewayUrl . $authority);
        exit;
    } else {
        $error = 'خطا در اتصال به درگاه پرداخت: ' . ($result['errors'][0]['message'] ?? 'خطای نامشخص');
    }
} else {
    $error = 'خطا در اتصال به سرور پرداخت';
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطا در پرداخت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 4rem;"></i>
                        <h3 class="mt-3">خطا در پرداخت</h3>
                        <p class="text-muted"><?php echo $error ?? 'خطای نامشخص در پردازش پرداخت'; ?></p>
                        <div class="mt-4">
                            <a href="../index.php?page=checkout" class="btn btn-primary me-2">تلاش مجدد</a>
                            <a href="../index.php?page=cart" class="btn btn-outline-secondary">بازگشت به سبد خرید</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
