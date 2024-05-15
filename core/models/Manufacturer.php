<?php

namespace core\models;

use core\classes\Database;

class Manufacturer {
    public function get_manufacturers() {

        $db = new Database();

        $results = $db->select("
            SELECT * FROM fabricante; 
        ");

        return $results;
    }

    public function get_manufacturers_by_product_category($category_id) {

        $db = new Database();

        $params = [
            ':categoria_id' => $category_id
        ];

        $results = $db->select("
            SELECT DISTINCT fabricante.id, fabricante.nome FROM fabricante
            INNER JOIN produto ON produto.fabricante_id = fabricante.id
            WHERE produto.categoria_id = :categoria_id;         
        ", $params);

        return $results;
    }

    public function get_manufacturers_by_query($search_query) {

        $db = new Database();

        $params = [
            ":query" => '%' . $search_query . '%'
        ];

        $results = $db->select("    
            SELECT DISTINCT fabricante.id, fabricante.nome FROM fabricante
            INNER JOIN produto ON produto.fabricante_id = fabricante.id
            WHERE produto.nome LIKE :query
            OR produto.descricao LIKE :query
            OR fabricante.nome LIKE :query
        ", $params);

        if(sizeof($results)) {
            return $results;
        }
        else {
            return false;
        }
    }

    public function add_manufacturer($params) {
        $db = new Database();

        $results = $db->insert("
            INSERT INTO fabricante(nome)
            VALUES(:nome)
        ", $params);

        return $results; 
    }
}