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

    public function get_category_by_id($category_id) {

        $db = new Database();

        $params = [
            ":id" => $category_id
        ];

        $results = $db->select("
            SELECT * FROM categoria 
            WHERE id = :id
        ", $params);

        if (sizeof($results) == 1) {
            return $results[0];
        } 
        else {
            return false;
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

    public function clear_category_name_for_db($original_category_name) {

        //'á é í oo â ã'; exemplo retorna a_e_i_oo_a_a
        $modified_category_name = str_replace(array(' ', 'à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('_', 'a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $original_category_name); 

        return $modified_category_name;
    }
}