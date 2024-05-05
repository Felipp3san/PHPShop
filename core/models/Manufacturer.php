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

    public function add_manufacturer($params) {
        $db = new Database();

        $results = $db->insert("
            INSERT INTO fabricante(nome)
            VALUES(:nome)
        ", $params);

        return $results; 
    }
}