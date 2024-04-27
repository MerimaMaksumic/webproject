<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once __DIR__ . '/../../rest/services/BookService.class.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing ID for the book']);
    exit();
}

$book_service = new BookService();
$book_id = $_GET['id'];
$book = $book_service->get_book_by_id($book_id);

echo json_encode($book);
