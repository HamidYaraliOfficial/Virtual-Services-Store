<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

$action = $_POST['action'] ?? '';
$csrf = $_POST['csrf_token'] ?? '';

if (!verifyCsrfToken($csrf)) {
    $response['message'] = 'CSRF token invalid';
    echo json_encode($response);
    exit;
}
$serviceId = intval($_POST['service_id'] ?? 0);

switch ($action) {
    case 'add':
        if ($serviceId > 0) {
            $service = getServiceById($serviceId);
            if ($service) {
                addToCart($serviceId);
                $response['success'] = true;
                $response['message'] = 'محصول به سبد خرید اضافه شد';
                $response['cart_count'] = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            } else {
                $response['message'] = 'محصول یافت نشد';
            }
        } else {
            $response['message'] = 'شناسه محصول نامعتبر است';
        }
        break;
        
    case 'remove':
        if ($serviceId > 0) {
            removeFromCart($serviceId);
            $response['success'] = true;
            $response['message'] = 'محصول از سبد خرید حذف شد';
            $response['cart_count'] = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
        } else {
            $response['message'] = 'شناسه محصول نامعتبر است';
        }
        break;
        
    case 'update':
        $updateAction = $_POST['update_action'] ?? '';
        
        if ($serviceId > 0 && in_array($updateAction, ['increase', 'decrease'])) {
            if (!isset($_SESSION['cart'][$serviceId])) {
                $response['message'] = 'محصول در سبد خرید یافت نشد';
            } else {
                if ($updateAction === 'increase') {
                    $_SESSION['cart'][$serviceId]++;
                } else {
                    $_SESSION['cart'][$serviceId]--;
                    if ($_SESSION['cart'][$serviceId] <= 0) {
                        unset($_SESSION['cart'][$serviceId]);
                    }
                }
                $response['success'] = true;
                $response['message'] = 'تعداد محصول به روز رسانی شد';
                $response['cart_count'] = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            }
        } else {
            $response['message'] = 'پارامترهای نامعتبر';
        }
        break;
        
    case 'clear':
        clearCart();
        $response['success'] = true;
        $response['message'] = 'سبد خرید پاک شد';
        $response['cart_count'] = 0;
        break;
        
    case 'get_count':
        $response['success'] = true;
        $response['cart_count'] = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
        break;
        
    default:
        $response['message'] = 'عملیات نامعتبر';
        break;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
