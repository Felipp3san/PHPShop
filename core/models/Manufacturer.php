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
}