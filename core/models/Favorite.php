<?php

namespace core\models;

use core\classes\Database;

class Favorite {

    public static function verify_favorite($customer_id, $item_id) {
        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id,
            ':item_id' => $item_id,
        ];

        $results = $db->select("
            SELECT * FROM favorito
            WHERE cliente_id = :cliente_id AND item_id = :item_id 
        ", $params);

        if($results) {
            return true;
        }
        else {
            return false;
        }
    }

    public function add_favorite($customer_id, $item_id, $category_name) {
        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id,
            ':item_id' => $item_id,
            ':nome_categoria' => $category_name,
        ];

        $results = $db->insert("
            INSERT INTO favorito(item_id, cliente_id, nome_categoria)
            VALUES (:item_id, :cliente_id, :nome_categoria) 
        ", $params);

        return $results;
    }

    public function remove_favorite($customer_id, $item_id) {
        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id,
            ':item_id' => $item_id,
        ];

        $results = $db->delete("
            DELETE FROM favorito
            WHERE item_id = :item_id AND cliente_id = :cliente_id
        ", $params);

        return $results;
    }

    public function get_favorites($customer_id) {

        $db = new Database();

        $params = [
            ':customer_id' => $customer_id,
        ];

        $results = $db->select("
            SELECT * FROM produto
            INNER JOIN favorito ON produto.id=favorito.item_id
            WHERE favorito.cliente_id = :customer_id;
        ", $params);

        return $results;
    }
}