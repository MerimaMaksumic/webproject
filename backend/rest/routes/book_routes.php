<?php

require_once __DIR__ . '/../services/BookService.class.php';

Flight::group('/books', function () {

    /**
     * @OA\Get(
     *     path="/books/all",
     *     summary="Get all books",
     *     tags={"Books"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all books",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *     )
     * )
     */
    Flight::route('GET /all', function () {
        $book_service = new BookService();
        $books = $book_service->get_all_books();
        Flight::json($books);
    });

    /**
     * @OA\Get(
     *     path="/books/{id}",
     *     summary="Get a single book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book found",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    Flight::route('GET /@id', function ($id) {
        $book_service = new BookService();
        $book = $book_service->get_book_by_id($id);
        if ($book) {
            Flight::json($book);
        } else {
            Flight::halt(404, 'Book not found');
        }
    });

    /**
 * @OA\Post(
 *     path="/books/add",
 *     summary="Add a new book",
 *     tags={"Books"},
 *     @OA\RequestBody(
 *         description="Data for the new book",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"title", "author", "publishedDate"},
 *             @OA\Property(property="title", type="string", example="Swagger Book"),
 *             @OA\Property(property="author", type="string", example="Stephen Hawking"),
 *             @OA\Property(property="publishedDate", type="string", format="date", example="1988-06-15"),
 *             @OA\Property(property="isbn", type="string", example="9780553380163"),
 *             @OA\Property(property="summary", type="string", example="A landmark volume in science writing by one of the great minds of our time.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Book successfully added",
 *         @OA\JsonContent(ref="#/components/schemas/Book")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Failed to add book"
 *     )
 * )
 */
    Flight::route('POST /add', function () {
        $data = Flight::request()->data->getData();
        $book_service = new BookService();
        $book = $book_service->add_book($data);
        if ($book) {
            Flight::json($book, 201);
        } else {
            Flight::halt(400, 'Failed to add book');
        }
    });

    /**
     * @OA\Put(
     *     path="/books/update/{id}",
     *     summary="Update an existing book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Updated data for the book",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"title", "author"},
     *             @OA\Property(property="title", type="string", example="Updated Book Title"),
     *             @OA\Property(property="author", type="string", example="Updated Author Name"),
     *             @OA\Property(property="publishedDate", type="string", format="date", example="Updated Date 2024-12-01"),
     *             @OA\Property(property="isbn", type="string", example="Updated ISBN 9780553380164"),
     *             @OA\Property(property="summary", type="string", example="Updated summary of the book.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to update book"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    Flight::route('PUT /update/@id', function ($id) {
        $data = Flight::request()->data->getData();
        $book_service = new BookService();
        $book = $book_service->update_book($id, $data);
        if ($book) {
            Flight::json($book);
        } else {
            Flight::halt(400, 'Failed to update book');
        }
    });

    /**
     * @OA\Delete(
     *     path="/books/delete/{id}",
     *     summary="Delete a book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book successfully deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Book successfully deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found or could not be deleted"
     *     )
     * )
     */
    Flight::route('DELETE /delete/@id', function ($id) {
        $book_service = new BookService();
        $success = $book_service->delete_book_by_id($id);
        if ($success) {
            Flight::json(['message' => "Book successfully deleted"], 200);
        } else {
            Flight::halt(404, 'Book not found or could not be deleted');
        }
    });
});
