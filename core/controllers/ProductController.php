<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Product;

class ProductController {

    public function products() {

        $category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $category_name = $_GET['category-name'] ?? null;
        
        $products = new Product();

        // Verificação da validade dos dados
        if ($category_id === false || $category_id === null || empty($category_id) ||
            $category_name === null || empty($category_name)) {
            return Store::redirect();
        };

        // POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $filter_params = $this->get_filter_params($_POST);

            if(sizeof($filter_params) > 0)
                $filtered_products = $products->get_filtered_products($category_id, $filter_params);
            else {
                $filtered_products = $products->get_products_from_category_with_review($category_id);
            }

            $data = [
                'category_name' => $category_name,
                'category_id' => $category_id,
                'data' => $filtered_products,
            ];

            return Store::layout("Products/products", $data);
        }
        // GET
        else {
            
            $data = [
                'category_name' => $category_name,
                'category_id' => $category_id,
                'data' => $products->get_products_from_category_with_review($category_id)
            ];

            return Store::layout("Products/products", $data);
        }
    }

    private function get_filter_params($post_data) {

        $filter_params = [];
    
        if (isset($post_data['in-stock']) && !isset($post_data['no-stock'])) {
            $filter_params['in-stock'] = "produto.quantidade >= 1";
        } elseif (isset($post_data['no-stock']) && !isset($post_data['in-stock'])) {
            $filter_params['no-stock'] = "produto.quantidade = 0";
        }
    
        return $filter_params;
    }
}