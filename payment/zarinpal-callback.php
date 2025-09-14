<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

$status = $_GET['Status'] ?? '';
$authority = $_GET['Authority'] ?? '';

if ($status !== 'OK' || !$authority) {
    $error = 'پرداخت لغو شد یا با خطا مواجه شد';
    include 'payment-result.php';
    exit;
}

// Find order by authority
$orders = loadOrders();
$order = null;
$orderIndex = null;

foreach ($orders as $index => $o) {
    if (isset($o['authority']) && $o['authority'] === $authority) {
        $order = $o;
        $orderIndex = $index;
        break;
    }
}

if (!$order) {
    $error = 'سفارش یافت نشد';
    include 'payment-result.php';
    exit;
}

// ZarinPal configuration
$settings = loadSettings();
$merchantId = $settings['zarinpal_merchant_id'] ?? ZARINPAL_MERCHANT_ID;
$sandbox = $settings['zarinpal_sandbox'] ?? ZARINPAL_SANDBOX;

if ($sandbox) {
    $verifyUrl = 'https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentVerification.json';
} else {
    $verifyUrl = 'https://api.zarinpal.com/pg/v4/payment/verify.json';
}

$data = [
    'merchant_id' => $merchantId,
    'amount' => $order['total'],
    'authority' => $authority
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $verifyUrl);
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
    
    if (isset($result['data']['code']) && ($result['data']['code'] == 100 || $result['data']['code'] == 101)) {
        // Payment successful
        $refId = $result['data']['ref_id'];
        
        // Update order status
        $orders[$orderIndex]['payment_status'] = 'paid';
        $orders[$orderIndex]['status'] = 'processing';
        $orders[$orderIndex]['ref_id'] = $refId;
        $orders[$orderIndex]['paid_at'] = date('Y-m-d H:i:s');
        
        saveOrders($orders);
        
        // Save payment record
        $payments = loadPayments();
        $payments[] = [
            'id' => generateId($payments),
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'amount' => $order['total'],
            'method' => 'zarinpal',
            'status' => 'completed',
            'ref_id' => $refId,
            'authority' => $authority,
            'created_at' => date('Y-m-d H:i:s')
        ];
        savePayments($payments);
        
        // Clear cart
        clearCart();
        
        // Success
        $success = true;
        $successMessage = 'پرداخت با موفقیت انجام شد';
        $orderId = $order['id'];
        
    } else {
        $error = 'تایید پرداخت ناموفق: ' . ($result['errors'][0]['message'] ?? 'خطای نامشخص');
        
        // Update order status to failed
        $orders[$orderIndex]['payment_status'] = 'failed';
        saveOrders($orders);
    }
} else {
    $error = 'خطا در اتصال به سرور تایید پرداخت';
    
    // Update order status to failed
    $orders[$orderIndex]['payment_status'] = 'failed';
    saveOrders($orders);
}

include 'payment-result.php';
?>
