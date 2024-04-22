<?php

require_once __DIR__ . '/BaseDao.class.php';

class BookDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("books");
    }

    public function get_all_books()
    {
        return $this->query("SELECT * FROM books", []);
    }

    public function get_book_by_id($book_id)
    {
        return $this->query_unique("SELECT * FROM books WHERE id = :id", ["id" => $book_id]);
    }

    public function add_book($book)
    {
        return $this->insert('books', $book);
    }

    public function update_book($book_id, $book)
    {
        return $this->execute_update('books', $book_id, $book);
    }

    public function delete_book_by_id($book_id)
    {
        $this->execute("DELETE FROM books WHERE id = :id", ["id" => $book_id]);
    }
}
