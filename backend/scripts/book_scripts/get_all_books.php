<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once __DIR__ . '/../../rest/services/BookService.class.php';

$book_service = new BookService();
$books = $book_service->get_all_books();

$response = ["books" => $books];
echo json_encode($response);
