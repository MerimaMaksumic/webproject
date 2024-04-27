<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once __DIR__ . '/../../rest/services/BookService.class.php';

$book_service = new BookService();
$json_str = file_get_contents('php://input');
$payload = json_decode($json_str, true);

if (empty($payload['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Book ID is required for update']);
    exit();
}

$book_id = $payload['id'];
$result = $book_service->update_book($book_id, $payload);

echo json_encode($result);
