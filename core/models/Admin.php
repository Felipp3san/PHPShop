<?php

namespace core\models;

use core\classes\Database;

class Admin {

    public function verify_admin($username, $password) {
        $db = new Database();

        $params = [
            ":utilizador" => $username
        ];

        $results = $db->select("
            SELECT * FROM gestor
            WHERE utilizador = :utilizador
            AND ativo = 1 AND deleted_at IS NULL
        ", $params);

        if(!$results) {
            return false;
        }
        else {
            $admin_account = $results[0];

            if(!password_verify($password, $admin_account->senha)) {
                return false;
            }
            else {
                return $admin_account;
            }
        }
    }

    public function get_staff() {
        $db = new Database();

        $results = $db->select("
            SELECT id, utilizador, ativo, created_at, updated_at, deleted_at 
            FROM gestor
        ");

        if(!$results) {
            return false;
        }
        else {
            return $results;
        }
    }

    public function create_staff($utilizador, $senha) {
        $db = new Database();

        $params = [
            ':utilizador' => strtolower($utilizador),
            ':senha' => password_hash($senha, PASSWORD_DEFAULT),
        ];

        $result = $db->insert("
            INSERT INTO gestor(utilizador, senha, ativo)
            VALUES(:utilizador, :senha, 1)
            ", $params);

        return $result;
    }
}
