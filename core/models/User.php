<?php

namespace core\models;

use core\classes\Database;

class User {

    public function is_email_in_use($email) {
        $db = new Database();

        $params = [
            ':email' => strtolower(trim($email)),
        ];

        $results = $db->select("
            SELECT email FROM cliente WHERE email = :email",
            $params);

        if($results) {
            return true;
        } else {
            return false;
        }
    }

    public function create_user($purl) {
        $db = new Database();

        $params = [
            ':nome_completo' => strtolower(trim($_POST['full-name'])),
            ':email' => strtolower(trim($_POST['email'])),
            ':senha' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ':morada' => strtolower(trim($_POST['address'])),
            ':cidade' => strtolower(trim($_POST['city'])),
            ':telefone' => strtolower(trim($_POST['phone'])),
            ':personal_url' => $purl,
        ];

        $result = $db->insert("
            INSERT INTO cliente(nome_completo, email, senha, morada, cidade, telefone, personal_url)
            VALUES(:nome_completo, :email, :senha, :morada, :cidade, :telefone, :personal_url)", 
            $params);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}