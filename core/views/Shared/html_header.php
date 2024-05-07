<?php

use core\models\Category;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title><?= $titulo ?></title>
</head>

<body class="d-flex flex-column">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid container-width">
            <div class="container-fluid d-flex justify-content-between">
                <!-- LOGO -->
                <div class="d-flex justify-items-between align-items-center gap-5">
                    <a class="navbar-brand" href="?a=index">
                        <img src="assets/images/php.png" alt="php-logo" width="75" height="75">
                        <span>Shop</span>
                    </a>
                    <!-- CATEGORIAS -->
                    <div class="nav-link dropdown">
                        <button class="btn btn-link p-0 text-light text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i><span> Categorias</span>
                        </button>
                        <ul class="dropdown-menu rounded-0">
                            <?php $category = new Category ?>
                            <?php foreach ($category->get_categories() as $categoria) : ?>
                                <li><a class="dropdown-item" href="?a=products&category-name=<?= $categoria->nome ?>&id=<?= $categoria->id ?>"><?= $categoria->nome ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <!-- FAVORITOS -->
                    <?php if (Store::is_client_logged()) : ?>
                        <div class="nav-link">
                            <a class="btn btn-link p-0 text-light text-decoration-none" href="?a=favorites">
                                <i class="fa-solid fa-heart"></i>
                                <span>Favoritos</span>
                            </a>
                        </div>
                    <?php endif ?>
                </div>
                <!-- BARRA DE PESQUISA -->
                <div class="col-6 d-flex justify-content-between align-items-center">
                    <div class="col-10">
                        <form action="">
                            <div class="search-bar bg-light">
                                <div class="search-bar-icon">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                                <div class="search-bar-input">
                                    <input type="text" class="form-control rounded-0 border-0 bg-light" id="search-bar" placeholder="Escreva aqui o que procura...">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-2">
                    </div>
                </div>
                <!-- MINHA CONTA -->
                <div class="d-flex justify-content-between align-items-center">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <div class="nav-link dropdown">
                                <button class="btn btn-link p-0 text-light" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none;">
                                    <i class="fa-solid fa-user fa-lg"></i>
                                </button>
                                <ul class="dropdown-menu rounded-0">
                                    <?php if (Store::is_client_logged()) : ?>
                                        <?php if (isset($_SESSION['admin_id'])) : ?>
                                            <li><a class="dropdown-item disabled text-dark">Olá, <?= $_SESSION['admin_username'] ?>!</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="?a=management_panel">Painel de Gestão</a></li>
                                        <?php else : ?>
                                            <li><a class="dropdown-item disabled text-dark">Olá, <?= $_SESSION['customer_name'] ?>!</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="?a=conta">Minha conta</a></li>
                                        <?php endif ?>
                                        <li><a class="dropdown-item" href="?a=logout">Logout</a></li>
                                    <?php else : ?>
                                        <li><a class="dropdown-item" href="?a=login">Login</a></li>
                                        <li><a class="dropdown-item" href="?a=register">Criar conta</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </li>
                        <!-- CARRINHO -->                                        
                        <?php if (!isset($_SESSION['admin_id'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="?a=cart">
                                    <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                    <span class="badge p-1">10</span>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid container-width min-height py-5 d-flex flex-column">