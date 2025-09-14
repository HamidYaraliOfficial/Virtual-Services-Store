<?php
// Database configuration (JSON files)
define('DATA_DIR', __DIR__ . '/../data/');
define('USERS_FILE', DATA_DIR . 'users.json');
define('SERVICES_FILE', DATA_DIR . 'services.json');
define('ORDERS_FILE', DATA_DIR . 'orders.json');
define('SETTINGS_FILE', DATA_DIR . 'settings.json');
define('PAYMENTS_FILE', DATA_DIR . 'payments.json');
define('TICKETS_FILE', DATA_DIR . 'tickets.json');

// Site configuration
define('SITE_NAME', 'فروشگاه خدمات مجازی');
define('SITE_URL', 'http://localhost');
define('ADMIN_EMAIL', 'admin@shop.com');

// ZarinPal configuration
define('ZARINPAL_MERCHANT_ID', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
define('ZARINPAL_SANDBOX', true); // Set to false for production

// Create data directory if it doesn't exist
if (!file_exists(DATA_DIR)) {
    mkdir(DATA_DIR, 0777, true);
}

// Initialize data files if they don't exist
$defaultUsers = [
    [
        'id' => 1,
        'username' => 'Admin',
        'email' => 'admin@shop.com',
        'password' => password_hash('Admin123', PASSWORD_DEFAULT),
        'role' => 'admin',
        'created_at' => date('Y-m-d H:i:s'),
        'status' => 'active'
    ]
];

$defaultServices = [
    [
        'id' => 1,
        'title' => 'افزایش فالوور اینستاگرام',
        'description' => 'افزایش فالوور واقعی و با کیفیت برای اکانت اینستاگرام شما',
        'price' => 50000,
        'category' => 'اینستاگرام',
        'image' => 'assets/images/instagram-followers.jpg',
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ],
    [
        'id' => 2,
        'title' => 'افزایش لایک پست',
        'description' => 'افزایش لایک برای پست های اینستاگرام',
        'price' => 20000,
        'category' => 'اینستاگرام',
        'image' => 'assets/images/instagram-likes.jpg',
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ],
    [
        'id' => 3,
        'title' => 'افزایش ممبر تلگرام',
        'description' => 'افزایش ممبر واقعی برای کانال تلگرام',
        'price' => 30000,
        'category' => 'تلگرام',
        'image' => 'assets/images/telegram-members.jpg',
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ]
];

$defaultSettings = [
    'site_name' => 'فروشگاه خدمات مجازی',
    'site_description' => 'بهترین خدمات مجازی با کیفیت',
    'zarinpal_merchant_id' => '',
    'zarinpal_sandbox' => true,
    'currency' => 'تومان',
    'admin_email' => 'admin@shop.com'
];

// Initialize files
if (!file_exists(USERS_FILE)) {
    file_put_contents(USERS_FILE, json_encode($defaultUsers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if (!file_exists(SERVICES_FILE)) {
    file_put_contents(SERVICES_FILE, json_encode($defaultServices, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if (!file_exists(ORDERS_FILE)) {
    file_put_contents(ORDERS_FILE, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if (!file_exists(SETTINGS_FILE)) {
    file_put_contents(SETTINGS_FILE, json_encode($defaultSettings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if (!file_exists(PAYMENTS_FILE)) {
    file_put_contents(PAYMENTS_FILE, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if (!file_exists(TICKETS_FILE)) {
    file_put_contents(TICKETS_FILE, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>
