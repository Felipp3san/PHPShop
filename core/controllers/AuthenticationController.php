<?php

namespace core\controllers;

use core\classes\Store;
use core\classes\Email;
use core\models\Customer;

class AuthenticationController {

    public function login() {
        // Mantem a persistência da ultima página visitada
        $_SESSION['previous-action'] = "login";

        if (Store::is_client_logged()) {
            Store::redirect();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            /*
            validar se os campos foram preenchidos corretamente
            pedir informações a base de dados
            criar sessao de cliente
            */
            if (!isset($_POST['email']) ||
                !isset($_POST['password']) ||
                !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {

                $_SESSION['error'] = "Os dados foram preenchidos incorretamente.";
                Store::redirect('login');
                return;
            }

            $customer = new Customer();

            if(!$customer->login_verification()) {
                Store::redirect('login');
                return;
            }
            else {
                Store::redirect();
                return;
            };
        }
        else {
            Store::layout('Authentication/login');
        }
    }

    public function logout() {
        unset($_SESSION['cliente']);
        Store::redirect();
    }

    public function register() {

        // Verifica se já existe sessão aberta
        if (Store::is_client_logged()) {
            Store::redirect();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

            // Passwords não coincidem.
            if($_POST['password'] != $_POST['confirm-password']) {
                $_SESSION['error'] = "As senhas não coincidem.";
                Store::redirect('register');
                return;
            }

            // Verificar se email já existe na database.
            $customer = new Customer();
        
            if($customer->is_email_in_use($_POST['email'])) {
                $_SESSION['error'] = "Email informado já está em uso.";
                Store::redirect('register');
                return;
            }

            // Criar o personal_url(para validação de conta por email).
            $purl = Store::create_hash();
            
            // Tenta inserir novo utilizar na base de dados. 
            if(!$customer->create_user($purl)) {
                $_SESSION['error'] = "Falha ao criar nova conta de utilizador.";
                Store::redirect('register');
                return;
            }

            // Enviar email com o personalURL para email do cliente.
            $customer_email = strtolower(trim($_POST['email']));
        
            $result = Email::send_verification_email($customer_email, $purl);

            if ($result) {
                // // Apresentar um mensagem indicando que deve validar email.
                Store::layout('Authentication/account_created');
                return;
            }
            else {
                $_SESSION['error'] = "Falha ao enviar email de confirmação. Por favor, tente novamente.";
                Store::redirect('register');
                return;
            }
        }
        else {
            Store::layout('Authentication/register');
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