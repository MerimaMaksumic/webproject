<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once __DIR__ . '/../../rest/services/CartService.class.php';

$cart_service = new CartService();
$json_str = file_get_contents('php://input');
$cart_item = json_decode($json_str, true);

if (empty($cart_item['book_id']) || empty($cart_item['user_id']) || empty($cart_item['quantity'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing fields: book_id, user_id and quantity are required']);
    exit();
}

$result = $cart_service->add_item_to_cart($cart_item);
echo json_encode($result);
