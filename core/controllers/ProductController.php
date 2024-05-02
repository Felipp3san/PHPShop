<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Product;

class ProductController {

    public function products() {

        $category_id = $_GET['id'];
        $category_name = $_GET['category-name'];

        $products = new Product();

        $data = [
            'category_name' => $category_name,
            'category_id' => $category_id,
            'data' => $products->get_products_from_category_with_review($category_id)
        ];

        Store::layout("Products/products", $data);
    }
}