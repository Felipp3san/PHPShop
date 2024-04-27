<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\Store;

class Main {
    public function index()
    {
        Store::Layout('Main/index');
    }

    public function store()
    {
        Store::Layout('Main/store');
    }

    public function cart()
    {
        Store::Layout('Main/cart');
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
        if (Store::ClienteLogado()) {
            $this->index();
            return;
        }

        Store::Layout('Main/register');
    }

    public function createUser() {

        /* 
        Caso seja enviado um formulário, tentar adicionar novo cliente a base de dados
        Do contrário, redireciona para página de registo. 
        */
        if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        { 
            $this->register();
            return;
        }

        // Passwords não coincidem.
        if($_POST['password'] != $_POST['confirm-password'])
        {
            $_SESSION['error'] = "As senhas não coincidem.";
            $this->register();
            return;
        }


        // Verificar se email já existe na database.
        $db = new Database();

        $parameters = [
            ':email' => strtolower(trim($_POST['email'])),
        ];

        $results = $db->select("SELECT email FROM cliente WHERE email = :email", $parameters);

        if(count($results) > 0) 
        {
            $_SESSION['error'] = "Email informado já está em uso.";
            $this->register();
            return;
        }


        // Criar o personal_url(para validação de conta por email).
        // Inserir novo registo na tabela cliente.
        // Enviar email com o personalURL para email do cliente.
        // Apresentar um mensagem indicando que deve validar email.


    }
}