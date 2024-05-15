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

        foreach ($search_query as $query) {
            $nome[] = 'produto.nome LIKE '. '\'%'. $query . '%\'';
            $descricao[] = 'produto.descricao LIKE '. '\'%'. $query . '%\'';
            $nome_fabricante[] = 'fabricante.nome LIKE '. '\'%'. $query . '%\'';
        };

        $results = $db->select("    
            SELECT DISTINCT fabricante.id, fabricante.nome FROM fabricante
            INNER JOIN produto ON produto.fabricante_id = fabricante.id
            WHERE (". implode(' AND ', $nome) .")
            OR (". implode(' AND ', $descricao) .")
            OR (" . implode(' AND ', $nome_fabricante) . ");
        ");

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