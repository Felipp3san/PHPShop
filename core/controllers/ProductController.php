<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Favorite;
use core\models\Manufacturer;
use core\models\Product;

class ProductController {

    public function products() {

        $category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $category_name = $_GET['category-name'] ?? null;
        
        $products = new Product();
        $manufacturer = new Manufacturer();

        // Verificação da validade dos dados
        if ($category_id === false || $category_id === null || empty($category_id) ||
            $category_name === null || empty($category_name)) {
            return Store::redirect();
        };

        // GET
        $filter_params = $this->get_filter_params($_GET);
        
        if(sizeof($filter_params) > 0)
            $filtered_products = $products->get_filtered_products($category_id, $filter_params);
        else {
            $filtered_products = $products->get_products_from_category_with_review($category_id);
        }

        $data = [
            'category_name' => $category_name,
            'category_id' => $category_id,
            'filter_manufacturers' => $manufacturer->get_manufacturers_by_product_category($category_id),
            'data' => $filtered_products,
        ];

        return Store::layout("Products/products", $data);
    }

    public function add_favorite() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $customer_id = $_POST['favorite-customer-id'];
            $item_id = $_POST['favorite-item-id'];
            $category_name = $_POST['favorite-item-category'];
            $actual_url = substr($_POST['actual-url'], 4);

            $favorite = new Favorite();

            $favorite->add_favorite($customer_id, $item_id, $category_name);

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

    private function get_filter_params($get_data) {

        $filter_params = [];

        // Stock
        if (isset($get_data['in-stock']) && !isset($get_data['no-stock'])) {
            $filter_params['in-stock'] = "produto.quantidade >= 1";
        } elseif (isset($get_data['no-stock']) && !isset($get_data['in-stock'])) {
            $filter_params['no-stock'] = "produto.quantidade = 0";
        }

        // Fabricantes
        if(isset($get_data['manufacturer'])) {
            $filter_params['manufacturer'] = "produto.fabricante_id IN(" . implode(', ', $get_data['manufacturer']) .')';
        }
    
        return $filter_params;
    }

}