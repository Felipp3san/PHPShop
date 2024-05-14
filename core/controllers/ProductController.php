<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Category;
use core\models\Favorite;
use core\models\Manufacturer;
use core\models\Product;
use core\models\Review;

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
        
        if(sizeof($filter_params) > 0) {
            $filter_results = $products->get_filtered_products($category_id, $filter_params);
        }
        else {
            $filter_results = $products->get_products_from_category_with_review($category_id);
        };

        $data = [
            'category_name' => $category_name,
            'category_id' => $category_id,
            'filter_manufacturers' => $filter_results['manufacturers'],
            'products' => $filter_results['products'],
        ];

        return Store::layout("Products/products", $data);
    }

    public function search_products() {
        
        // Verifica se o parâmetro 'query' foi enviado na URL
        if(isset($_GET['query']) && !empty($_GET['query'])) {

            $search_query = trim($_GET['query']);
            $product = new Product();

            $results = $product->get_products_categories_by_query($search_query);

            if(sizeof($results) > 0) {
                $data = [
                    'category_name' => "Resultados da pesquisa",
                    'products' => $results['products'],
                ];
                
                return Store::layout("Products/products", $data);
            }
            else {

            return Store::redirect();
            }
        } else {
            return Store::redirect();
        }
    }

    public function get_product_details() {
        // Filtra o product_id inserido na url
        $product_id = filter_input(INPUT_GET, 'product-id', FILTER_VALIDATE_INT);

        $product = new Product();
        $results = $product->get_product_by_id($product_id);
        
        if($results) {

            $data = [];

            // produto
            $data['product'] = $results; 

            // Separar imagens
            $data['pictures'] = explode("@", $results->imagem);

            // Buscar reviews
            $review = new Review();
            $data['reviews'] = $review->get_reviews_by_product_id($product_id);

            // Buscar produtos relacionados
            $data['related-products'] = $product->get_products_from_category_with_review($results->categoria_id);

            return Store::layout("Products/details", $data);
        }
        else {
            return Store::redirect();
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