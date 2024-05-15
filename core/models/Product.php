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

    public function get_product_by_id($product_id) {

        $db = new Database();

        $params = [
            ':id' => $product_id
        ];

        $results = $db->select("
            SELECT produto.*, fabricante.nome as 'nome_fabricante', categoria.nome as 'nome_categoria' FROM produto 
            INNER JOIN fabricante ON fabricante.id = produto.fabricante_id
            INNER JOIN categoria ON categoria.id = produto.categoria_id
            WHERE produto.id = :id 
        ", $params);

        if(sizeof($results) == 1) {
            return $results[0];
        }
        else {
            return false;
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

        if(sizeof($results) > 0) {
            return $results;
        }
        else {
            return false;
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
        
        if(sizeof($results) > 0) {
            return $results;
        }
        else {
            return false;
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
            WHERE categoria_id = :categoria_id AND " . $filters . " 
            GROUP BY produto.id
        ", $params); 

        if(sizeof($results) > 0) {
            return $results;
        }
        else {
            return false;
        }
    }

    public function get_filtered_products_query($search_query, $filter_params) {

        $db = new Database();

        $filters = implode(" AND ", $filter_params);

        $params = [
            ":query" => '%' . $search_query . '%'
        ];

        $results = $db->select("
            SELECT produto.*, AVG(review.avaliacao) AS 'avaliacao_media', COUNT(review.id) AS 'total_avaliacoes' 
            FROM produto 
            LEFT JOIN review ON produto.id = review.produto_id 
            LEFT JOIN fabricante ON produto.fabricante_id = fabricante.id
            WHERE (produto.nome LIKE :query OR produto.descricao LIKE :query OR fabricante.nome LIKE :query)
            AND (" . $filters . ") 
            GROUP BY produto.id
        ", $params);

        if(sizeof($results) > 0) {
            return $results;
        }
        else {
            return false;
        }
    }

    public function get_products_by_query($search_query) {
    
        $db = new Database();

        $params = [
            ':nome' => '%'.$search_query.'%'
        ];

        $results = $db->select("
            SELECT produto.*, AVG(review.avaliacao) AS 'avaliacao_media', COUNT(review.id) AS 'total_avaliacoes' 
            FROM produto 
            LEFT JOIN review ON produto.id = review.produto_id 
            WHERE nome LIKE :nome
            OR descricao LIKE :nome
            OR fabricante_id IN (SELECT id FROM fabricante WHERE nome LIKE :nome)
            GROUP BY produto.id
        ", $params);

        if(sizeof($results) > 0) {
            return $results;
        } else {
            return false;
        }
    }

    public function add_product($params) {
        $db = new Database();

        if (isset($params['imagem'])) {
            $results = $db->insert("
                INSERT INTO produto(nome, descricao, fabricante_id, preco, quantidade, categoria_id, imagem, ativo)
                VALUES(:nome, :descricao, :fabricante_id, :preco, :quantidade, :categoria_id, :imagem, :ativo)
            ", $params);
        }
        else {
            $results = $db->insert("
                INSERT INTO produto(nome, descricao, fabricante_id, preco, quantidade, categoria_id, ativo)
                VALUES(:nome, :descricao, :fabricante_id, :preco, :quantidade, :categoria_id, :imagem, :ativo)
            ", $params);
        }
        
        return $results; 
    }
}