<?php

// coleção de rotas
$routes = [
    'index' => 'main@index',
    'store' => 'main@store',
    'cart' => 'main@cart',
    'login' => 'main@login',
    'logout' => 'main@logout',
    'register' => 'main@register',
    'create_user' => 'main@create_user',
    'confirm_email' => 'main@confirm_email',
];

// ação Default
$action = 'index';

/* verificar se existe ação na query string
ou seja, http://phpshop.test/public/index.php?a=carrinho  
verifica o valor do argumento 'a' passado na url.*/
if(isset($_GET['a']))
{
    if (!key_exists($_GET['a'], $routes)) 
    {
        $action = 'index';
    }
    else
    {
        $action = $_GET['a'];
    }
}

$parts = explode('@', $routes[$action]);

$controller = ucfirst($parts[0]);
$controller = 'core\\controllers\\'.$controller;

$method = $parts[1];

$ctr = new $controller();
$ctr->$method();
