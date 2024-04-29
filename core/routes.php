<?php

// coleção de rotas

$routes = [
    // Main
    'index' => 'MainController@index',
    'store' => 'MainController@store',
    'cart' => 'MainController@cart',

    // Authentication
    'login' => 'AuthenticationController@login',
    'logout' => 'AuthenticationController@logout',
    'register' => 'AuthenticationController@register',
    'confirm_email' => 'AuthenticationController@confirm_email',
    'forgot_password' => 'AuthenticationController@forgot_password',
    'recovery' => 'AuthenticationController@recovery',
];

// ação Default
$action = 'index';

/* verificar se existe ação na query string
ou seja, http://phpshop.test/public/index.php?a=carrinho  
verifica o valor do argumento 'a' passado na url.*/
if(isset($_GET['a'])) {
    if (!key_exists($_GET['a'], $routes)) {
        $action = 'index';
    }
    else {
        $action = $_GET['a'];
    }
}

$parts = explode('@', $routes[$action]);

$controller = ucfirst($parts[0]);
$controller = 'core\\controllers\\'.$controller;

$method = $parts[1];

$ctr = new $controller();
$ctr->$method();
