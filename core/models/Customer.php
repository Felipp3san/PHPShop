<?php

namespace core\models;

use core\classes\Database;

class Customer {

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

    public function validate_email($purl) {
        $db = new Database();

        $params = [
            ':purl' => $purl
        ];

        $results = $db->select("
            SELECT * FROM cliente WHERE personal_url = :purl",
            $params);

        if ($results != false && count($results) == 1) {

            $id_cliente = $results[0]->id;

            $params = [
                ':id' => $id_cliente
            ];

            // Remover o personal_url e mudar status de ativo.
            $db->update("
                UPDATE cliente SET personal_url='', ativo=1 
                WHERE id = :id
            ", $params);

            return true;
        }
        else {
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