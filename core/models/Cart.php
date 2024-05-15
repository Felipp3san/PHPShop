<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Cart {

    public function add_to_cart($item_id, $quantity, $price, $customer_id = null, $session_id = null) {
        $db = new Database();

        $params = [
            ':item_id' => $item_id,
            ':quantidade' => $quantity,
            ':preco' => $price,
        ];
        
        if(Store::is_client_logged()) {

            $params[':cliente_id'] = $customer_id;

            // SE O ITEM JÁ EXISTE NO CARRINHO, APENAS MUDA A QUANTIDADE
            if($this->is_item_in_cart_customer_id($customer_id, $item_id)) {
                
                unset($params[':preco']);
                
                $results = $db->update("
                UPDATE item_carrinho
                SET quantidade = quantidade + :quantidade
                WHERE cliente_id = :cliente_id AND item_id = :item_id
                ", $params);
            }
            else {

                $results = $db->insert("
                    INSERT INTO item_carrinho(item_id, quantidade, preco, cliente_id)
                    VALUES (:item_id, :quantidade, :preco, :cliente_id)
                ", $params);
            }
        }
        else {
            
            $params[':session_id'] = $session_id;

            // SE O ITEM JÁ EXISTE NO CARRINHO, APENAS MUDA A QUANTIDADE
            if($this->is_item_in_cart_session_id($session_id, $item_id)) {

                unset($params[':preco']);

                $results = $db->update("
                    UPDATE item_carrinho
                    SET quantidade = quantidade + :quantidade
                    WHERE session_id = :session_id AND item_id = :item_id
                ", $params);
            } 
            else {

                $results = $db->insert("
                    INSERT INTO item_carrinho(item_id, quantidade, preco, session_id)
                    VALUES (:item_id, :quantidade, :preco, :session_id)
                ", $params);
            }
        }

        return $results;
    }

    public function remove_from_cart($item_id, $quantity, $to_remove, $customer_id = null, $session_id = null) {

        $db = new Database();

        $params = [
            ':item_id' => $item_id,
            ':quantidade' => $quantity,
            ':remover' => $to_remove,
        ];
        
        
        if(Store::is_client_logged()) {
            
            $params[':cliente_id'] = $customer_id; 
            
            // REMOVER SE A QUANTIDADE ESTIVER EM 1, ATUALIZAR SE FOR MAIS
            if($to_remove >= $quantity) {
               
                unset($params[':quantidade']);
                unset($params[':remover']);

                $results = $db->delete("
                DELETE FROM item_carrinho
                WHERE item_id = :item_id AND cliente_id = :cliente_id
                ", $params);
            }
            else {
                $results = $db->update("
                UPDATE item_carrinho
                SET quantidade = :quantidade - :remover
                WHERE item_id = :item_id AND cliente_id = :cliente_id
                ", $params);
            }
        }
        else {
            
            $params[':session_id'] = $session_id;
            
            // REMOVER SE A QUANTIDADE ESTIVER EM 1, ATUALIZAR SE FOR MAIS
            if($to_remove >= $quantity) {
               
                unset($params[':quantidade']);
                unset($params[':remover']);
                
                $results = $db->delete("
                DELETE FROM item_carrinho
                WHERE item_id = :item_id AND session_id = :session_id
                ", $params);
            }
            else {
                $results = $db->update("
                    UPDATE item_carrinho
                    SET quantidade = :quantidade - :remover
                    WHERE item_id = :item_id AND session_id = :session_id
                ", $params);
            }
        }

        return $results;
    }

    public function get_cart_items_by_customer_id($customer_id) {

        $db = new Database(); 

        $params = [
            ':cliente_id' => $customer_id
        ];

        $results = $db->select("
            SELECT i.item_id, i.quantidade, i.preco, p.imagem, p.nome, p.descricao_curta FROM item_carrinho as I
            INNER JOIN produto as P ON p.id = i.item_id 
            WHERE i.cliente_id = :cliente_id
        ", $params);

        if(sizeof($results) > 0) {
            return $results;
        }
        else {
            return false;
        }
    }

    public function get_cart_items_by_session_id($session_id) {

        $db = new Database(); 

        $params = [
            ':session_id' => $session_id,
        ];

        $results = $db->select("
            SELECT i.item_id, i.quantidade, i.preco, p.imagem, p.nome, p.descricao_curta FROM item_carrinho as I
            INNER JOIN produto as P ON p.id = i.item_id 
            WHERE i.session_id = :session_id
        ", $params);

        if(sizeof($results) > 0) {
            return $results;
        }
        else {
            return false;
        }
    }

    public function is_item_in_cart_customer_id($customer_id, $item_id){

        $db = new Database(); 

        $params = [
            ':cliente_id' => $customer_id,
            ':item_id' => $item_id,
        ];

        $results = $db->select("
            SELECT * FROM item_carrinho 
            WHERE item_carrinho.cliente_id = :cliente_id AND item_carrinho.item_id = :item_id
        ", $params);

        if(sizeof($results) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function is_item_in_cart_session_id($session_id, $item_id){

        $db = new Database(); 

        $params = [
            ':session_id' => $session_id,
            ':item_id' => $item_id,
        ];

        $results = $db->select("
            SELECT * FROM item_carrinho 
            WHERE item_carrinho.session_id = :session_id AND item_carrinho.item_id = :item_id
        ", $params);

        if(sizeof($results) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function get_cart_items_count_by_session_id($session_id) {
        $db = new Database(); 

        $params = [
            ':session_id' => $session_id,
        ];

        $results = $db->select("
            SELECT SUM(quantidade) as 'contagem' FROM item_carrinho
            WHERE session_id = :session_id
        ", $params);

        if(sizeof($results) > 0) {
            return $results[0]->contagem;
        }
        else {
            return 0;
        }
    }

    public static function get_cart_items_count_by_customer_id($customer_id) {
        $db = new Database(); 

        $params = [
            ':cliente_id' => $customer_id,
        ];

        $results = $db->select("
            SELECT SUM(quantidade) AS 'contagem' FROM item_carrinho
            WHERE cliente_id = :cliente_id
        ", $params);

        if(sizeof($results) > 0) {
            return $results[0]->contagem;
        }
        else {
            return false;
        }
    }
}
