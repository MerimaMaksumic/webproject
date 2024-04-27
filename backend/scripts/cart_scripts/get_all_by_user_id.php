<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once __DIR__ . '/../../rest/services/CartService.class.php';

if (!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'User ID is required']);
    exit();
}

$cart_service = new CartService();
$user_id = $_GET['user_id'];
$cart_items = $cart_service->get_cart_for_user($user_id);

echo json_encode(['cart' => $cart_items]);
