<?php

namespace core\controllers;

use core\classes\Store;
use core\models\User;

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
        $_SESSION['cliente'] = "Felippe";
        $this->index();
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

        /* 
        Caso seja enviado um formulário, tentar adicionar novo cliente a base de dados
        Do contrário, redireciona para página de registo. 
        */
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
        $user = new User();

        if($user->is_email_in_use($_POST['email'])) {
            $_SESSION['error'] = "Email informado já está em uso.";
            $this->register();
            return;
        }
        
        // Criar o personal_url(para validação de conta por email).
        $purl = Store::create_hash();
        
        // Inserir novo registo na tabela cliente.
        if($user->create_user($purl)) {
            $_SESSION['error'] = "Falha ao criar nova conta de utilizador.";
            $this->register();
            return;
        }

        // Enviar email com o personalURL para email do cliente.
        // Apresentar um mensagem indicando que deve validar email.
        $confirmation_link = "http://phpshop.test/public/index.php?a=confirmar_email&purl=$purl";
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