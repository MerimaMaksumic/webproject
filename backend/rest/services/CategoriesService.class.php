<?php

require_once __DIR__ . '/../dao/CategoriesDao.class.php';

class CategoriesService
{
    private $categories_dao;

    public function __construct()
    {
        $this->categories_dao = new CategoriesDao();
    }


    public function get_all_categories()
    {
        return $this->categories_dao->get_all_categories();
    }

   
    public function get_category_by_id($category_id)
    {
        return $this->categories_dao->get_category_by_id($category_id);
    }

 
    public function add_category($category)
    {
        return $this->categories_dao->add_category($category);
    }

    
    public function update_category($category_id, $category)
    {
        return $this->categories_dao->update_category($category_id, $category);
    }

   
    public function delete_category_by_id($category_id)
    {
        return $this->categories_dao->delete_category_by_id($category_id);
    }
}
