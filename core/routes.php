<?php

// coleção de rotas

$routes = [
    // Admin
    'admin' => 'AdminController@staff_login',
    'management_panel' => 'AdminController@management_panel',
    'add_staff' => 'AdminController@add_staff',
    'add_products' => 'AdminController@add_products',
    'add_manufacturer' => 'AdminController@add_manufacturer',
    'visualize_manufacturers' => 'AdminController@visualize_manufacturers',
    'visualize_staff' => 'AdminController@visualize_staff',

    // Main
    'index' => 'MainController@index',

    // Cart
    'cart' => 'CartController@cart',

    // Authentication
    'login' => 'AuthenticationController@login',
    'logout' => 'AuthenticationController@logout',
    'register' => 'AuthenticationController@register',
    'confirm_email' => 'AuthenticationController@confirm_email',
    'forgot_password' => 'AuthenticationController@forgot_password',
    'recovery' => 'AuthenticationController@recovery',

    // Products
    'products' => 'ProductController@products',
    
    // Favorites
    'favorites' => 'FavoriteController@show_favorites',
    'add_favorite' => 'FavoriteController@add_favorite',
    'remove_favorite' => 'ProductController@remove_favorite',
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
