<?php

require_once __DIR__ . '/../services/CartService.class.php';

/**
 * @OA\Info(title="Cart API", version="1.0.0")
 */
Flight::group('/cart', function () {

    /**
     * @OA\Get(
     *     path="/cart/user/{user_id}",
     *     summary="Get cart for a specific user",
     *     tags={"Cart"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="User ID to retrieve cart for",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart retrieved successfully",
     *         @OA\JsonContent(type="object", example={"id": 1, "user_id": 5, "items": [{"id": 1, "book_id": 10, "quantity": 2}]})
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cart not found"
     *     )
     * )
     */
    Flight::route('GET /user/@user_id', function ($user_id) {
        $cart_service = new CartService();
        $cart = $cart_service->get_cart_for_user($user_id);
        if ($cart) {
            Flight::json($cart);
        } else {
            Flight::halt(404, 'Cart not found for this user');
        }
    });

    /**
     * @OA\Post(
     *     path="/cart/item/add",
     *     summary="Add an item to the cart",
     *     tags={"Cart"},
     *     @OA\RequestBody(
     *         description="Item data to add to the cart",
     *         required=true,
     *         @OA\JsonContent(type="object", example={"user_id": 5, "book_id": 10, "quantity": 2})
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item added to cart successfully",
     *         @OA\JsonContent(type="object", example={"id": 1, "user_id": 5, "book_id": 10, "quantity": 2})
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to add item to cart"
     *     )
     * )
     */
    Flight::route('POST /item/add', function () {
        $data = Flight::request()->data->getData();
        $cart_service = new CartService();
        $cart_item = $cart_service->add_item_to_cart($data);
        if ($cart_item) {
            Flight::json($cart_item, 201);
        } else {
            Flight::halt(400, 'Failed to add item to cart');
        }
    });

    /**
     * @OA\Put(
     *     path="/cart/item/update/{id}",
     *     summary="Update an item in the cart",
     *     tags={"Cart"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the cart item to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Item data to update",
     *         required=true,
     *         @OA\JsonContent(type="object", example={"book_id": 10, "quantity": 3})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart item updated successfully",
     *         @OA\JsonContent(type="object", example={"id": 1, "book_id": 10, "quantity": 3})
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to update cart item"
     *     )
     * )
     */
    Flight::route('PUT /item/update/@id', function ($id) {
        $data = Flight::request()->data->getData();
        $cart_service = new CartService();
        $cart_item = $cart_service->update_cart_item($id, $data);
        if ($cart_item) {
            Flight::json($cart_item);
        } else {
            Flight::halt(400, 'Failed to update cart item');
        }
    });

    /**
     * @OA\Delete(
     *     path="/cart/item/delete/{id}",
     *     summary="Delete an item from the cart",
     *     tags={"Cart"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the cart item to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart item deleted successfully",
     *         @OA\JsonContent(type="object", example={"message": "Cart item successfully deleted"})
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cart item not found or could not be deleted"
     *     )
     * )
     */
    Flight::route('DELETE /item/delete/@id', function ($id) {
        $cart_service = new CartService();
        $success = $cart_service->delete_item_from_cart($id);
        if ($success) {
            Flight::json(['message' => 'Cart item successfully deleted'], 200);
        } else {
            Flight::halt(404, 'Cart item not found or could not be deleted');
        }
    });
});
