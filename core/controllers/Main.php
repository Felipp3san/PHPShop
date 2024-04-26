<?php

namespace core\controllers;
use core\classes\Store;

class Main {
    public function index()
    {
        $clientes = ['felippe', 'rhuanna', 'dayane'];

        Store::Layout('Main/index', $clientes);
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
        Store::Layout('Main/index');
    }

    public function logout()
    {
        unset($_SESSION['cliente']);
        Store::Layout('Main/index');
    }
}