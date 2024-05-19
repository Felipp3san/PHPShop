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

        foreach ($search_query as $query) {
            $nome[] = 'produto.nome LIKE '. '\'%'. $query . '%\'';
            $descricao[] = 'produto.descricao LIKE '. '\'%'. $query . '%\'';
            $nome_fabricante[] = 'fabricante.nome LIKE '. '\'%'. $query . '%\'';
        };

        $results = $db->select("
            SELECT produto.*, AVG(review.avaliacao) AS 'avaliacao_media', COUNT(review.id) AS 'total_avaliacoes' 
            FROM produto 
            LEFT JOIN review ON produto.id = review.produto_id 
            LEFT JOIN fabricante ON produto.fabricante_id = fabricante.id
            WHERE ((". implode(' AND ', $nome) .") OR (". implode(' AND ', $descricao) .") OR (". implode(' AND ', $nome_fabricante) ."))
            AND (" . $filters . ") 
            GROUP BY produto.id
        ");

        if(sizeof($results) > 0) {
            return $results;
        }
        else {
            return false;
        }
    }

    public function get_products_by_query($search_query) {
    
        $db = new Database();
        
        foreach ($search_query as $query) {
            $nome[] = 'produto.nome LIKE '. '\'%'. $query . '%\'';
            $descricao[] = 'produto.descricao LIKE '. '\'%'. $query . '%\'';
            $nome_fabricante[] = 'nome LIKE '. '\'%'. $query . '%\'';
        };
        
        // $params = [
        //     ':nome' => implode(' AND ', $nome),
        //     ':descricao' => implode(' AND ', $descricao),
        //     ':fabricante_nome' => implode(' AND ', $nome_fabricante),
        // ];
        
        $results = $db->select("
            SELECT produto.*, AVG(review.avaliacao) AS 'avaliacao_media', COUNT(review.id) AS 'total_avaliacoes' 
            FROM produto 
            LEFT JOIN review ON produto.id = review.produto_id 
            WHERE (". implode(' AND ', $nome) .")
            OR (". implode(' AND ', $descricao) .")
            OR (produto.fabricante_id IN (SELECT id FROM fabricante WHERE ". implode(' AND ', $nome_fabricante) ."))
            GROUP BY produto.id
        ");

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
    // Verifica se o produto possui no minimo a quantidade adicionada ao carrinho.
    public function verify_item_quantity($cliente_id, $item_id, $quantity) {
        $db = new Database();

        $params = [
            ':cliente_id' => $cliente_id,
            ':item_id' => $item_id,
        ];

        $item_cart = $db->select("
            SELECT quantidade 
            FROM item_carrinho 
            WHERE item_id = :item_id AND cliente_id = :cliente_id
        ", $params);

        unset($params[':cliente_id']);
        
        $product = $db->select("
            SELECT id, quantidade  
            FROM produto
            WHERE id = :item_id 
        ", $params);

        if(!$item_cart) {

            if($product[0]->quantidade >= $quantity) {
                return true;
            }
        }
        else {
            
            if($product[0]->quantidade >= ($item_cart[0]->quantidade + $quantity)) {
                return true; 
            } 
        }

        return false;
    }
    
    // Atualiza a quantidade dos items ao criar pedido
    public function update_items_quantities($items) {

        $db = new Database();

        $results = true;

        foreach ($items as $item) {

            unset($params);

            $params = [
                ':item_id' => $item['id'],
                ':quantidade' => $item['quantity'],
            ];

            $partial_result = $db->update("
                UPDATE produto
                SET quantidade = quantidade - :quantidade 
                WHERE id = :item_id
            ", $params);

            if($partial_result == false) {
                $results = false;
            }
        }

        return $results; 
    }
}