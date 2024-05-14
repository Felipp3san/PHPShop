<?php

namespace core\models;

use core\classes\Database;

class Review {
    public function get_reviews_by_product_id($product_id) {

        $db = new Database();

        $params = [
            ':produto_id' => $product_id
        ];

        $results = $db->select("
            SELECT * FROM review
            WHERE produto_id = :produto_id
        ", $params);


        // Calcular a média das notas
        $grades = [];

        foreach($results as $result) {
            $grades[] = $result->avaliacao;
        }
        
        if(sizeof($results) > 0) {
            return $data = [
                'reviews' => $results,
                'average_grade' => $this->calculate_average($grades)
            ];
        }
        else {
            return false;
        }
    }
    
    public function calculate_average($grades) {
        return array_sum($grades) / count($grades);
    }
}