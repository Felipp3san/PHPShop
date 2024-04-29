<?php

use core\classes\Store;
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <title><?= $titulo ?></title>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container-fluid navegacao d-flex justify-content-between px-4 fs-4">
        <div class="d-flex align-items-center gap-5">
            <a class="d-flex align-items-center gap-1" href="?a=index">
                <img src="assets/images/php.png" alt="php-logo" width="75" height="75">
                <span>Shop</span>
            </a>
            <a class="link-navegacao" href="?a=index">Inicio</a>
            <a class="link-navegacao" href="?a=store">Loja</a>
        </div>
        <div class="d-flex align-items-center gap-5">
            <?php if (Store::is_client_logged()) : ?>
                <span>Olá, <?= $_SESSION['cliente'] ?>!</span>
                <a class="link-navegacao" href="?a=conta">Conta</a>
                <a class="link-navegacao" href="?a=logout">Logout</a>
            <?php else : ?>
                <a class="link-navegacao" href="?a=login">Login</a>
                <a class="link-navegacao" href="?a=register">Criar conta</a>
            <?php endif ?>

            <a href="?a=cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="badge bg-warning p-2">10</span>
            </a>
        </div>
    </div>