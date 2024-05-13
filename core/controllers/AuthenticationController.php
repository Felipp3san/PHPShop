<?php

namespace core\controllers;

use core\classes\Store;
use core\classes\Email;
use core\models\Customer;

class AuthenticationController {

    public function login() {
            
        // Verifica se há sessão aberta
        if (Store::is_client_logged()) {
            return Store::redirect();
        }
        
        // POST('/?a=login/')
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

            // Mantem a persistência da ultima página visitada 
            $_SESSION['previous-action'] = "login";

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

            // Mantem a persistência da ultima página visitada 
            $_SESSION['previous-action'] = "register";

            // Passwords não coincidem.
            if($_POST['password'] != $_POST['confirm-password']) {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "As senhas não coincidem.";
                return Store::redirect('login');
            }

            $customer_email = strtolower(trim($_POST['email']));

            // Verificar se email é válido.
            if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "Endereço de email inválido.";
                return Store::redirect('login');
            }

            // Verificar se email já existe na database.
            $customer = new Customer();
        
            if($customer->is_email_in_use($customer_email)) {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "Email informado já está em uso.";
                return Store::redirect('login');
            }

            // Criar o personal_url(para validação de conta por email).
            $purl = Store::create_hash();
            
            // Tenta inserir novo utilizar na base de dados. 
            if(!$customer->create_user($purl)) {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "Falha ao criar nova conta de utilizador.";
                return Store::redirect('login');
            }

            // Enviar email com o personalURL para email do cliente.
            $result = Email::send_verification_email($customer_email, $purl);

            if ($result) {
                //Apresentar um mensagem indicando que deve validar email.
                return Store::layout('Authentication/account_created');
            }
            else {
                $_SESSION['error-title'] = "Registo inválido";
                $_SESSION['error'] = "Falha ao enviar email de confirmação. Por favor, tente novamente.";
                return Store::redirect('login');
            }
        }
        else {
            return Store::redirect('login');        
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
        
        // Mantem a persistência da ultima página visitada 
        $_SESSION['previous-action'] = "login";

        // Verificar se foi enviado um formulário de registo 'POST'
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $customer = new Customer(); 

            $email = trim($_POST['email']);

            if(!$customer->is_email_in_use($email)){
                $_SESSION['error-title'] = "Recuperação de acesso";
                $_SESSION['error'] = "Email não encontrado em nossa base de dados.";
            }

            if(!$customer->is_active($email)){
                $_SESSION['error-title'] = "Recuperação de acesso";
                $_SESSION['error'] = "A conta com email fornecido ainda não foi ativada.";
                return Store::redirect("forgot_password");
            }

            // Criar o personal_url(para recuperação de email).
            $purl = Store::create_hash(); 

            if(!$customer->associate_purl($email, $purl)) {
                $_SESSION['error-title'] = "Recuperação de acesso";
                $_SESSION['error'] = "Ocorreu um erro, tente novamente.";
                return Store::redirect("forgot_password");
            } 
            
            $result = Email::send_recovery_email($email, $purl);

            if($result){
                $_SESSION['success-title'] = "Recuperação de acesso";
                $_SESSION['success'] = "Um email de recuperação foi enviado! <br> Verifique a pasta de SPAM.";
                return Store::redirect("forgot_password"); 
            }
        }
        else {
            return Store::layout('Authentication/forgot_password');
        }
    }

    public function recovery() {
        // Verifica se já existe sessão aberta
        if (Store::is_client_logged()) {
            return Store::redirect();
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $purl = $_POST['purl'];

            // Passwords não coincidem.
            if($_POST['password'] != $_POST['confirm-password']) {
                $_SESSION['error-title'] = "Recuperação de acesso";
                $_SESSION['error'] = "As senhas não coincidem.";
                return Store::redirect("recovery&purl={$purl}");
            }

            $customer = new Customer();
            $result = $customer->change_password($purl);

            if($result) {
                $_SESSION['success-title'] = "Recuperação de acesso";
                $_SESSION['success'] = "Senha alterada com sucesso.";
            }
            else {
            }     

            return Store::redirect('login');
        }
        else {
            // Verificar se existe um purl na query string
            if (!isset($_GET['purl'])) {
                return Store::redirect();
            }

            // Verificar se o purl é válido
            $purl = $_GET['purl'];
    
            if (strlen($purl) != 12) {
                return Store::redirect();
            }
            else {
                $customer = new Customer;
                $result = $customer->validate_purl($purl);
            }

            if($result) {
                return Store::layout('Authentication/recovery');
            }
            else {
                return Store::redirect();
            }
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