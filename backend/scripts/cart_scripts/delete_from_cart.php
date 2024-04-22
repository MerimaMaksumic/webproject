<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once __DIR__ . '/../../rest/services/CartService.class.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Cart item ID is required']);
    exit();
}

$cart_service = new CartService();
$cart_service->delete_item_from_cart($_GET['id']);

echo json_encode(['message' => 'Item removed from cart successfully']);
