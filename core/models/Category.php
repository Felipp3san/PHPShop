<?php

namespace core\models;

use core\classes\Database;

class Category {
    public function get_categories() {

        $db = new Database();

        $results = $db->select("
            SELECT * FROM categoria 
        ");

        if (!$results) {
            return false;
        } 
        else {
            return $results;
        }
    }

    public function get_categories_by_query($search_query) {

        $db = new Database();

        $params = [
            ':search_query' => '%'.$search_query.'%'
        ];

        $results = $db->select("
            SELECT DISTINCT categoria.id FROM categoria
            INNER JOIN produto ON produto.categoria_id = categoria.id
            INNER JOIN fabricante ON fabricante.id = produto.fabricante_id
            WHERE produto.nome LIKE :search_query
            OR produto.descricao LIKE :search_query
            OR fabricante.nome LIKE :search_query 
        ", $params);
        
        if (sizeof($results) > 0) {

            $categories = [];

            foreach($results as $category) {
                $categories[] = $category->id;
            }

            return $categories;
        } 
        else {
            return false;
        } 
    }
}