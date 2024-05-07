<?php

namespace core\controllers;

use core\classes\Store;
use core\classes\Email;
use core\models\Customer;

class AuthenticationController {

    public function login() {

        // Mantem a persistência da ultima página visitada
        $_SESSION['previous-action'] = "login";

        // Verifica se há sessão aberta
        if (Store::is_client_logged()) {
            return Store::redirect();
        }

        // POST('/?a=login/')
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

            // Valida se os campos foram preenchidos corretamente
            if (!isset($_POST['email']) ||
                !isset($_POST['password']) ||
                !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {

                $_SESSION['error-title'] = "Login inválido";
                $_SESSION['error'] = "Preencha os campos corretamente.";
                return Store::redirect('login');
            }

            $email = $_POST['email'];
            $password = $_POST['password'];

            $customer = new Customer();
            $customer_account = $customer->validate_login($email, $password);

            // verificar se email informado possui cadastro.
            if(!$customer_account) {

                $_SESSION['error-title'] = "Login inválido";
                $_SESSION['error'] = "Verifique seu e-mail e senha.";
                return Store::redirect('login');
            }
            // login bem-sucedido
            else {
                // Extrai o primeiro nome do nome completo
                $full_name = explode(" ", $customer_account->nome_completo);
                $first_name = ucfirst($full_name[0]);

                // Define as variáveis de sessão cliente
                $_SESSION['customer_id'] = $customer_account->id;
                $_SESSION['customer_email'] = $customer_account->email;
                $_SESSION['customer_name'] = $first_name;

                return Store::redirect();
            }
        }
        // GET('/?a=login/')
        else {
            return Store::layout('Authentication/login');
        }
    }

    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_password']);
        unset($_SESSION['customer_id']);
        unset($_SESSION['customer_email']);
        unset($_SESSION['customer_name']);
        Store::redirect();
    }

    public function register() {

        // Verifica se já existe sessão aberta
        if (Store::is_client_logged()) {
            return Store::redirect();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

            // Passwords não coincidem.
            if($_POST['password'] != $_POST['confirm-password']) {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "As senhas não coincidem.";
                return Store::redirect('register');
            }

            // Verificar se email já existe na database.
            $customer = new Customer();
        
            if($customer->is_email_in_use($_POST['email'])) {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "Email informado já está em uso.";
                return Store::redirect('register');
            }

            // Criar o personal_url(para validação de conta por email).
            $purl = Store::create_hash();
            
            // Tenta inserir novo utilizar na base de dados. 
            if(!$customer->create_user($purl)) {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "Falha ao criar nova conta de utilizador.";
                return Store::redirect('register');
            }

            // Enviar email com o personalURL para email do cliente.
            $customer_email = strtolower(trim($_POST['email']));
        
            $result = Email::send_verification_email($customer_email, $purl);

            if ($result) {
                // // Apresentar um mensagem indicando que deve validar email.
                return Store::layout('Authentication/account_created');
            }
            else {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "Falha ao enviar email de confirmação. Por favor, tente novamente.";
                return Store::redirect('register');
            }
        }
        else {
            Store::layout('Authentication/login');
        } 
    }

    public function confirm_email() {

        // Verifica se já existe sessão aberta
        if (Store::is_client_logged()) {
            Store::redirect();
            return;
        }

        // Verificar se existe um purl na query string
        if (!isset($_GET['purl'])) {
            Store::redirect();
            return;
        }

        // Verificar se o purl é válido
        $purl = $_GET['purl'];

        if (strlen($purl) != 12) {
            Store::redirect();
            return;
        }

        $customer = new Customer();
        $result = $customer->validate_email($purl);
        
        if($result) {
            Store::layout('Authentication/confirm_email');
        }
        else {
            Store::redirect();
        }        
    }

    public function forgot_password() {
        // Verificar se foi enviado um formulário de registo 'POST'
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $customer = new Customer(); 

            $email = trim($_POST['email']);

            if(!$customer->is_email_in_use($email)){
                $_SESSION['error'] = "Email não encontrado na nossa base de dados.";
                Store::redirect("forgot_password");
                return;
            }

            if(!$customer->is_active($email)){
                $_SESSION['error'] = "A conta com email fornecido ainda não foi ativada.";
                Store::redirect("forgot_password");
                return;
            }

            // Criar o personal_url(para recuperação de email).
            $purl = Store::create_hash(); 

            if(!$customer->associate_purl($email, $purl)) {
                $_SESSION['error'] = "Ocorreu um erro, tente novamente.";
                Store::redirect("forgot_password");
                return;
            } 
            
            $result = Email::send_recovery_email($email, $purl);

            if($result){
                $_SESSION['success'] = "Um email de recuperação foi enviado! <br> Caso não o encontre na sua caixa de entrada, verifique também a pasta de SPAM.";
                Store::redirect("forgot_password"); 
                return;
            }
        }
        else {
            Store::layout('Authentication/forgot_password');
        }
    }

    public function recovery() {
        // Verifica se já existe sessão aberta
        if (Store::is_client_logged()) {
            Store::redirect();
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $purl = $_POST['purl'];

            // Passwords não coincidem.
            if($_POST['password'] != $_POST['confirm-password']) {
                $_SESSION['error'] = "As senhas não coincidem.";
                Store::redirect("recovery&purl={$purl}");
                return;
            }

            $customer = new Customer();
            $result = $customer->change_password($purl);

            if($result) {
                $_SESSION['success'] = "Senha alterada com sucesso.";
                Store::layout('Authentication/recovery');
            }
            else {
                Store::redirect();
            }     
        }
        else {
            // Verificar se existe um purl na query string
            if (!isset($_GET['purl'])) {
                Store::redirect();
                return;
            }

            // Verificar se o purl é válido
            $purl = $_GET['purl'];
    
            if (strlen($purl) != 12) {
                Store::redirect();
                return;
            }

            Store::layout('Authentication/recovery');
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