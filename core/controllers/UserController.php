<?php

namespace core\controllers;

use core\classes\Store;
use core\models\User;

class UserController {

    public function account(){

        // Verifica se há sessão aberta
        if (!Store::is_client_logged()) {
            return Store::redirect();
        }

        $user = new User();
        $customer_id = $_SESSION['customer_id'];

        $account_data = $user->get_account_data($customer_id);

        if($account_data) {

            $data = [
                'account_data' => $account_data,
            ];

            $addresses = $user->get_addresses($customer_id);
           
            if($addresses) {
                $data['addresses'] = $addresses;
            }

            return store::layout('user/account', $data);
        };

        return Store::redirect();
    }

    public function add_address(){

        // Verifica se há sessão aberta
        if (!Store::is_client_logged()) {
            return Store::redirect();
        }
        
        $user = new User();
        $customer_id = $_SESSION['customer_id'];
        
        // POST('/?a=login/')
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            
            $actual_url = $_POST['actual-url'];
            $nome = trim($_POST['nome']);
            $apelido = trim($_POST['apelido']);
            $morada = trim($_POST['morada']);
            $cidade = trim($_POST['cidade']);
            $cod_postal = filter_input(INPUT_POST, 'cod_postal', FILTER_VALIDATE_INT);
            $nif = filter_input(INPUT_POST, 'nif', FILTER_VALIDATE_INT);
            
            if(isset($_POST['telefone'])) {
                $telefone = filter_input(INPUT_POST, 'telefone', FILTER_VALIDATE_INT);
                $results = $user->add_address($customer_id, $nome, $apelido, $morada, $cidade, $cod_postal, $nif, $telefone);
            }
            else {
                $results = $user->add_address($customer_id, $nome, $apelido, $morada, $cidade, $cod_postal, $nif);
            }
            
            if($results) {
                $_SESSION['success-title'] = "Morada adicionada";
                $_SESSION['success'] = "Morada adicionada com sucesso!";
            }
            else {
            }
            
            return Store::redirect($actual_url);
        }

        $actual_url = $_GET['actual-url'];

        // GET
        if (!User::address_limit_reached($customer_id)) {
            $data['actual_url'] = $actual_url;
            return Store::layout('user/add_address', $data);
        }
        else {
            $_SESSION['error-title'] = "Limite de moradas atingido";
            $_SESSION['error'] = "Você já possui 3 moradas.";
            return Store::redirect($actual_url);
        }
        
    }

    public function remove_address(){
        // Verifica se há sessão aberta
        if (!Store::is_client_logged()) {
            return Store::redirect();
        }

        $actual_url = substr($_POST['actual-url'], 4);
        $user = new User();

        // POST('/?a=login/')
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $address_id = $_POST['address-id'];

            $results = $user->remove_address($address_id);
            
            if($results) {
                $_SESSION['success-title'] = "Remoção de morada";
                $_SESSION['success'] = "Morada removida com sucesso!";
            }
            else {

                $_SESSION['error-title'] = "Remoção de morada";
                $_SESSION['error'] = "Falha ao tentar remover morada. Tente novamente.";
            }
        }
        
        return Store::redirect($actual_url);
    }

    public function define_default_address() {
       // Verifica se há sessão aberta
       if (!Store::is_client_logged()) {
        return Store::redirect();
        }

        $customer_id = $_SESSION['customer_id'];

        // POST('/?a=login/')
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

            $user = new User();    
            $address_id = $_POST['address-id'];
            
            $user->define_default_address($customer_id, $address_id);

            return Store::redirect('account');
        }
    }
}