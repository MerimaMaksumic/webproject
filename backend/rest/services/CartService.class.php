<?php

require_once __DIR__ . '/../dao/CartDao.class.php';

class CartService {
    private $cart_dao;

    public function __construct() {
        $this->cart_dao = new CartDao();
    }

    public function get_cart_for_user($user_id) {
        return $this->cart_dao->get_cart_by_user_id($user_id);
    }

    public function add_item_to_cart($cart_item) {
        return $this->cart_dao->add_to_cart($cart_item);
    }

    public function update_cart_item($id, $cart_item) {
        return $this->cart_dao->update_cart_item($id, $cart_item);
    }

    public function delete_item_from_cart($id) {
        $this->cart_dao->delete_cart_item($id);
    }
}
