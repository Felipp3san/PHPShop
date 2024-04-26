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

<body>
    <div class="container-fluid navegacao">
        <div class="row">
            <div class="col-6 d-flex gap-4 p-3">
                <a href="?a=index">
                    <h3><?= APP_NAME ?></h3>
                </a>
                <div class="fs-4 d-flex gap-3">
                    <a href="?a=index">Inicio</a>
                    <a href="?a=store">Loja</a>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-end gap-4 p-3 fs-4">

                <?php if (Store::clienteLogado()): ?>
                    <span>Olá, <?= $_SESSION['cliente'] ?>!</span>
                    <a href="?a=conta">Conta</a> 
                    <a href="?a=logout">Logout</a>
                <?php else : ?>
                    <a href="?a=login">Login</a>
                <?php endif ?>

                <a href="?a=cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge bg-warning p-2">10</span>
                </a>
            </div>
        </div>
    </div>