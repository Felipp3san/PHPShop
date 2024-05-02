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
}