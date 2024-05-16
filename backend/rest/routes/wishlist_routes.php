<?php

require_once __DIR__ . '/../services/WishlistService.class.php';

/**
 * @OA\Info(title="Wishlist API", version="1.0.0")
 */
Flight::group('/wishlist', function () {

    /**
     * @OA\Get(
     *     path="/wishlist/user/{user_id}",
     *     summary="Get wishlist for a specific user",
     *     tags={"Wishlist"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="User ID to retrieve wishlist for",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of wishlist",
     *         @OA\JsonContent(type="array", @OA\Items(type="object", example={"wishlist_id": 123, "title": "Great Book", "author": "Famous Author", "price": 19.99, "imageUrl": "http://example.com/image.jpg"}))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Wishlist not found"
     *     )
     * )
     */
    Flight::route('GET /user/@user_id', function ($user_id) {
        $wishlist_service = new WishlistService();
        $wishlist = $wishlist_service->get_wishlist_for_user($user_id);
        if ($wishlist) {
            Flight::json($wishlist);
        } else {
            Flight::halt(404, 'Wishlist not found');
        }
    });

    /**
     * @OA\Post(
     *     path="/wishlist/add",
     *     summary="Add an item to the wishlist",
     *     tags={"Wishlist"},
     *     @OA\RequestBody(
     *         description="Wishlist item data to add",
     *         required=true,
     *         @OA\JsonContent(type="object", example={"user_id": 5, "book_id": 10})
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item added to wishlist successfully",
     *         @OA\JsonContent(type="object", example={"message": "Item added to wishlist"})
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to add item to wishlist"
     *     )
     * )
     */
    Flight::route('POST /add', function () {
        $data = Flight::request()->data->getData();
        $wishlist_service = new WishlistService();
        $result = $wishlist_service->add_item_to_wishlist($data);
        if ($result) {
            Flight::json(['message' => 'Item added to wishlist'], 201);
        } else {
            Flight::halt(400, 'Failed to add item to wishlist');
        }
    });

    /**
     * @OA\Delete(
     *     path="/wishlist/delete/{wishlist_id}",
     *     summary="Delete an item from the wishlist",
     *     tags={"Wishlist"},
     *     @OA\Parameter(
     *         name="wishlist_id",
     *         in="path",
     *         required=true,
     *         description="Wishlist item ID to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Wishlist item deleted successfully",
     *         @OA\JsonContent(type="object", example={"message": "Wishlist item successfully deleted"})
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Wishlist item not found or could not be deleted"
     *     )
     * )
     */
    Flight::route('DELETE /delete/@wishlist_id', function ($wishlist_id) {
        $wishlist_service = new WishlistService();
        $success = $wishlist_service->delete_item_from_wishlist($wishlist_id);
        if ($success) {
            Flight::json(['message' => 'Wishlist item successfully deleted'], 200);
        } else {
            Flight::halt(404, 'Wishlist item not found or could not be deleted');
        }
    });
});
