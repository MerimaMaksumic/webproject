<?php

require_once __DIR__ . '/../dao/WishlistDao.class.php';

class WishlistService {
    private $wishlist_dao;

    public function __construct() {
        $this->wishlist_dao = new WishlistDao();
    }

 
    public function get_wishlist_for_user($user_id) {
        return $this->wishlist_dao->get_wishlist_by_user_id($user_id);
    }

 
    public function add_item_to_wishlist($wishlist_item) {
        return $this->wishlist_dao->add_to_wishlist($wishlist_item);
    }

   
    public function delete_item_from_wishlist($wishlist_id) {
        $this->wishlist_dao->delete_wishlist_item($wishlist_id);
    }
}
