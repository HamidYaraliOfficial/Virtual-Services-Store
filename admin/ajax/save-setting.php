<?php
session_start();
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

header('Content-Type: application/json');

if (!isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'unauthorized']);
    exit;
}

$name = $_POST['name'] ?? '';
$value = $_POST['value'] ?? '';
$csrf = $_POST['csrf_token'] ?? '';

if (!verifyCsrfToken($csrf)) {
    echo json_encode(['success' => false, 'message' => 'invalid_csrf']);
    exit;
}

if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'invalid']);
    exit;
}

$settings = loadSettings();
$settings[$name] = $value;

if (saveSettings($settings)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}


