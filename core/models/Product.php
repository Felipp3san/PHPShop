<?php

namespace core\models;

use core\classes\Database;

class Product {
    public function get_products() {
        $db = new Database();

        $results = $db->select("
            SELECT * FROM produto
        "); 

        if(!$results) {
            return false;
        }
        else {
            return $results;
        }
    }

    public function get_products_with_review() {
        $db = new Database();

        $results = $db->select("
            SELECT produto.*, AVG(review.avaliacao) AS 'avaliacao_media', COUNT(review.id) AS 'total_avaliacoes' 
            FROM produto 
            LEFT JOIN review ON produto.id = review.produto_id 
            GROUP BY produto.id;
        "); 

        if(!$results) {
            return false;
        }
        else {
            return $results;
        }
    }

    public function get_products_from_category_with_review($category_id) {
        $db = new Database();

        $params = [
            ":categoria_id" => $category_id
        ];

        $results = $db->select("
            SELECT produto.*, AVG(review.avaliacao) AS 'avaliacao_media', COUNT(review.id) AS 'total_avaliacoes' 
            FROM produto 
            LEFT JOIN review ON produto.id = review.produto_id 
            WHERE categoria_id = :categoria_id
            GROUP BY produto.id
        ", $params); 

        if(!$results) {
            return false;
        }
        else {
            return $results;
        }
    }

    public function get_filtered_products($category_id, $filter_params) {

        $db = new Database();

        $filters = implode(" AND ", $filter_params);

        $params = [
            ":categoria_id" => $category_id,
        ];

        $results = $db->select("
            SELECT produto.*, AVG(review.avaliacao) AS 'avaliacao_media', COUNT(review.id) AS 'total_avaliacoes' 
            FROM produto 
            LEFT JOIN review ON produto.id = review.produto_id 
            WHERE categoria_id = :categoria_id AND " . $filters . 
            " GROUP BY produto.id
        ", $params); 

        if(!$results) {
            return false;
        }
        else {
            return $results;
        }
    }

    public function add_product($params) {
        $db = new Database();

        $results = $db->insert("
            INSERT INTO produto(nome, descricao, fabricante_id, preco, quantidade, categoria_id, imagem, ativo)
            VALUES(:nome, :descricao, :fabricante_id, :preco, :quantidade, :categoria_id, :imagem, :ativo)
        ", $params);

        return $results; 
    }
}