<?php

require_once __DIR__ . '/BaseDao.class.php';

class CartDao extends BaseDao {
    public function __construct() {
        parent::__construct("cart");
    }

    public function get_cart_by_user_id($user_id) {
        $query = "SELECT b.title, b.author, b.price, c.quantity, b.imageUrl
                  FROM cart c
                  JOIN books b ON c.book_id = b.id
                  WHERE c.user_id = :user_id";
        return $this->query($query, ["user_id" => $user_id]);
    }

    public function add_to_cart($cart_item) {
        return $this->insert("cart", $cart_item);
    }

    public function update_cart_item($id, $cart_item) {
        return $this->execute_update("cart", $id, $cart_item);
    }

    public function delete_cart_item($id) {
        $this->execute("DELETE FROM cart WHERE id = :id", ["id" => $id]);
    }
}
