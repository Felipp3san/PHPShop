<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\Email;
use core\classes\Store;
use core\models\Customer;

class Main {
    public function index()
    {
        Store::layout('Main/index');
    }

    public function store()
    {
        Store::layout('Main/store');
    }

    public function cart()
    {
        Store::layout('Main/cart');
    }

    public function login()
    {
        if (Store::is_client_logged()) {
            $this->index();
            return;
        }

        Store::layout('Main/login');
    }

    public function logout()
    {
        unset($_SESSION['cliente']);
        $this->index();
    }

    public function register()
    {
        // Verifica se já existe sessão aberta
        if (Store::is_client_logged()) {
            $this->index();
            return;
        }

        Store::layout('Main/register');
    }

    public function create_user() {

        // Verificar se foi enviado um formulário de registo 'POST'
        if ($_SERVER['REQUEST_METHOD'] != 'POST') { 
            $this->register();
            return;
        }
                
        // Passwords não coincidem.
        if($_POST['password'] != $_POST['confirm-password']) {
            $_SESSION['error'] = "As senhas não coincidem.";
            $this->register();
            return;
        }
        
        // Verificar se email já existe na database.
        $customer = new Customer();

        if($customer->is_email_in_use($_POST['email'])) {
            $_SESSION['error'] = "Email informado já está em uso.";
            $this->register();
            return;
        }
        
        // Criar o personal_url(para validação de conta por email).
        $purl = Store::create_hash();
        
        // Tenta inserir novo utilizar na base de dados. 
        if(!$customer->create_user($purl)) {
            $_SESSION['error'] = "Falha ao criar nova conta de utilizador.";
            $this->register();
            return;
        }

        // Enviar email com o personalURL para email do cliente.
        $email = new Email();
        $customer_email = strtolower(trim($_POST['email']));
        $customer_name = strtolower(trim($_POST['full-name']));

        $result = $email->send_verification_email($customer_email ,$customer_name, $purl);
         
        if ($result) {
            // // Apresentar um mensagem indicando que deve validar email.
            Store::layout('Main/account_created');
        }
        else {
            $_SESSION['error'] = "Falha ao enviar email de confirmação. Por favor, tente novamente.";
            $this->register();
            return;
        }
    }

    public function confirm_email() {

        // Verifica se já existe sessão aberta
        if (Store::is_client_logged()) {
            $this->index();
            return;
        }

        // Verificar se existe um purl na query string
        if (!isset($_GET['purl'])) {
            $this->index();
            return;
        }

        // Verificar se o purl é válido
        $purl = $_GET['purl'];

        if (strlen($purl) != 12) {
            $this->index();
            return;
        }

        $customer = new Customer();
        $result = $customer->validate_email($purl);
        
        if($result) {
            Store::layout('Main/confirm_email');
        }
        else {
            Store::redirect();
        }        
    }
}

// CLIENTE:
// --------------
// nome_completo [full-name]
// email [email]
// senha [password]
// morada [address]
// cidade [city]
// telefone [phone]
// personal_url 
// ativo
// created_at
// updated_at
// deleted_at