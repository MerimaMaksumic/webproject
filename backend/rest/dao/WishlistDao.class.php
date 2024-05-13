<?php

require_once __DIR__ . '/BaseDao.class.php';

class WishlistDao extends BaseDao {
    public function __construct() {
        parent::__construct("wishlist");
    }

   
    public function get_wishlist_by_user_id($user_id) {
        $query = "SELECT b.title, b.author, b.price, b.imageUrl, w.wishlist_id
                  FROM wishlist w
                  JOIN books b ON w.book_id = b.id
                  WHERE w.user_id = :user_id";
        return $this->query($query, ["user_id" => $user_id]);
    }

   
    public function add_to_wishlist($wishlist_item) {
        return $this->insert("wishlist", $wishlist_item);
    }

  
    public function delete_wishlist_item($wishlist_id) {
        $this->execute("DELETE FROM wishlist WHERE wishlist_id = :wishlist_id", ["wishlist_id" => $wishlist_id]);
    }
}
