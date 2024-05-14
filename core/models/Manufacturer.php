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

    public function get_manufacturers_by_category($category_id) {

        $db = new Database();

        if(is_array($category_id)) {
            $params = [
                ':categoria_id' => implode(",", $category_id)
            ];
        }
        else {
            $params = [
                ':categoria_id' => $category_id
            ];
        }

        $results = $db->select("
            SELECT DISTINCT fabricante.id AS fabricante_id, fabricante.nome as nome_fabricante FROM fabricante
            INNER JOIN produto ON produto.fabricante_id = fabricante.id
            WHERE produto.categoria_id IN (:categoria_id);         
        ", $params);

        if(sizeof($results) > 0) {

            $manufacturers = $this->manufacturers_to_array($results); 

            return $manufacturers;
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

    public function manufacturers_to_array($results) {

        $manufacturers = [];
            
        foreach ($results as $product) {
            $manufacturer_exist = false;
            
            // Verifica se o fabricante já existe no array $manufacturers
            foreach ($manufacturers as $manufacturer) {
                if ($manufacturer['id_fabricante'] === $product->fabricante_id) {
                    $manufacturer_exist = true;
                    break;
                }
            }
            
            // Se o fabricante não existir, adiciona-o ao array $manufacturers
            if (!$manufacturer_exist) {
                $manufacturers[] = [
                    'id_fabricante' => $product->fabricante_id,
                    'nome_fabricante' => $product->nome_fabricante
                ];
            }
        }

        return $manufacturers;
    }
}