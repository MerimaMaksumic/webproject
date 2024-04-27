<?php

require_once __DIR__ . '/../dao/BookDao.class.php';

class BookService
{
    private $book_dao;

    public function __construct()
    {
        $this->book_dao = new BookDao();
    }

    public function get_all_books()
    {
        return $this->book_dao->get_all_books();
    }

    public function get_book_by_id($book_id)
    {
        return $this->book_dao->get_book_by_id($book_id);
    }

    public function add_book($book)
    {
        return $this->book_dao->add_book($book);
    }

    public function update_book($book_id, $book)
    {
        return $this->book_dao->update_book($book_id, $book);
    }

    public function delete_book_by_id($book_id)
    {
        return $this->book_dao->delete_book_by_id($book_id);
    }


    public function get_all_new_books(){
        return $this->get_all_new_books();
    }
}
