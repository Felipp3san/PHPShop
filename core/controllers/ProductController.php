<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Favorite;
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

    public function add_favorite() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $customer_id = $_POST['favorite-customer-id'];
            $item_id = $_POST['favorite-item-id'];
            $actual_url = substr($_POST['actual-url'], 4);

            $favorite = new Favorite();

            $favorite->add_favorite($customer_id, $item_id);

            return Store::redirect($actual_url);
        }
    }

    public function remove_favorite() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $customer_id = $_POST['favorite-customer-id'];
            $item_id = $_POST['favorite-item-id'];
            $actual_url = substr($_POST['actual-url'], 4);

            $favorite = new Favorite();

            $favorite->remove_favorite($customer_id, $item_id);

            return Store::redirect($actual_url);
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