<?php

namespace core\models;

use core\classes\Database;

class Admin {

    public function verify_admin($username, $password) {
        $db = new Database();

        $params = [
            ":utilizador" => $username,
            ":senha" => $password
        ];

        $results = $db->select("
            SELECT * FROM gestor
            WHERE utilizador = :utilizador AND  
            senha = :senha
        ", $params);

        if(!$results) {
            return false;
        }
        else {
            return $results[0];
        }
    }
}
