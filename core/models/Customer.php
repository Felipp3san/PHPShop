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

        return $result;
    }

    public function login_verification() {

        $db = new Database();

        $params = [ 
            ':email' => strtolower(trim($_POST['email'])),
        ];

        $results = $db->select("
            SELECT * FROM cliente
            WHERE email= :email",
        $params);

        // verifica se utilizador existe.
        if(!$results) {
            $_SESSION['error'] = "Utilizador não registado.";
            return false;
        }
        // verifica se utilizador está ativo
        if ($results[0]->ativo != 1){
            $_SESSION['error'] = "Verifique seu email antes de aceder a conta.";
            return false;
        }

        // verifica se a senha está correta
        if (!password_verify($_POST['password'], $results[0]->senha)) {
            $_SESSION['error'] = "A senha está incorreta.";
            return false;
        }

        $_SESSION['cliente'] = ucfirst(explode(" ", $results[0]->nome_completo)[0]);

        return true;
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