<?php

// coleção de rotas
$routes = [
    'inicio' => 'main@index',
    'loja' => 'main@loja',
    'carrinho' => 'loja@carrinho'
];

// ação Default
$action = 'inicio';

/* verificar se existe ação na query string
ou seja, http://phpshop.test/public/index.php?a=carrinho  
verifica o valor do argumento 'a' passado na url.*/
if(isset($_GET['a']))
{
    if (!key_exists($_GET['a'], $routes)) 
    {
        $action = 'inicio';
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
