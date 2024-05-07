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

        if($results != false && $results > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function is_active($email) {
        $db = new Database();

        $params = [
            ":email" => $email 
        ];

        $results = $db->select("
            SELECT email, ativo FROM cliente
            WHERE email = :email
        ", $params);

        if($results != false && $results > 0) {
            if($results[0]->ativo == 1) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
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
    
    public function validate_login($email, $password) {

        $db = new Database();

        $params = [ 
            ':email' => strtolower(trim($email)),
        ];

        $results = $db->select("
            SELECT * FROM cliente
            WHERE email = :email
            AND ativo = 1 AND deleted_at IS NULL",
        $params);

        // Email não possui conta
        if(!$results) {
            return false;
        }
        else {

            $customer_account = $results[0];

            // Senha inválida
            if(!password_verify($password, $customer_account->senha)) {
                return false;
            }

            // Login bem-sucedido
            return $customer_account;
        }
    }

    public function create_user($purl) {
        $db = new Database();

        $params = [
            ':nome_completo' => strtolower(trim($_POST['full-name'])),
            ':email' => strtolower(trim($_POST['email'])),
            ':senha' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ':personal_url' => $purl,
        ];

        $result = $db->insert("
            INSERT INTO cliente(nome_completo, email, senha, personal_url)
            VALUES(:nome_completo, :email, :senha, :personal_url)", 
            $params);

        return $result;
    }

    public function associate_purl($email, $purl) {

        $db = new Database();

        $params = [
            ":email" => $email,
            ":personal_url" => $purl
        ];
        
        $result = $db->update("
            UPDATE cliente SET personal_url = :personal_url
            WHERE email = :email
        ", $params);

        return $result;
    }

    public function change_password($purl) {
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
                ':id' => $id_cliente,
                ':senha' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ];

            // Remover o personal_url e mudar status de ativo.
            $db->update("
                UPDATE cliente SET personal_url='', senha= :senha
                WHERE id = :id
            ", $params);

            return true;
        }
        else {
            return false;
        }
    } 
}