<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once __DIR__ . '/../../rest/services/BookService.class.php';

$book_service = new BookService();
$json_str = file_get_contents('php://input');
$payload = json_decode($json_str, true);

if (empty($payload['title']) || empty($payload['author']) || empty($payload['price'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Required fields are missing. Title, author, and price must be provided.']);
    exit();
}

$book = $book_service->add_book([
    'title' => $payload['title'],
    'author' => $payload['author'],
    'price' => $payload['price'],
    'publisher' => $payload['publisher'] ?? null,
    'publish_date' => $payload['publish_date'] ?? null,
    'num_of_pages' => $payload['num_of_pages'] ?? null,
    'dimensions' => $payload['dimensions'] ?? null,
    'language' => $payload['language'] ?? null,
    'type' => $payload['type'] ?? null,
    'isbn' => $payload['isbn'] ?? null,
    'imageUrl' => $payload['imageUrl'] ?? null
]);

echo json_encode($book);
