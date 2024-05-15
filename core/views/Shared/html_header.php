<?php

use core\models\Category;
use core\classes\Store;
use core\models\Cart;

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
                        <?php if (!isset($_SESSION['admin_id'])) : ?>
                        <div class="nav-link">
                            <a class="btn btn-link p-0 text-light text-decoration-none" href="?a=favorites">
                                <i class="fa-solid fa-heart"></i>
                                <span>Favoritos</span>
                            </a>
                        </div>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <!-- BARRA DE PESQUISA -->
                <div class="col-6 d-flex justify-content-between align-items-center">
                    <div class="col-10">
                        <form action="" method="GET">
                            <input type="hidden" name="a" value="search_products">
                            <div class="search-bar bg-light">
                                <div class="search-bar-icon">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                                <div class="d-flex search-bar-input">
                                    <input type="text" id="search-bar" name="query" class="form-control rounded-0 border-0 bg-light" placeholder="Escreva aqui o que procura..." aria-label="Escreva aqui o que procura..." aria-describedby="button-addon2">
                                    <button class="btn btn-outline-dark border-0 rounded-0" type="submit" id="button-addon2">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-2">
                    </div>
                </div>
                <!-- MINHA CONTA -->
                <div class="d-flex justify-content-between align-items-center">
                    <ul class="navbar-nav align-items-center gap-3">
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
                                            <li><a class="dropdown-item" href="?a=account">Minha conta</a></li>
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
                            <!-- CONTAGEM DOS PRODUTOS NO CARRINHO -->
                            <a href="?a=cart" class="btn btn-primary position-relative">
                                <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php if (Store::is_client_logged()) : ?>
                                        <?= Cart::get_cart_items_count_by_customer_id($_SESSION['customer_id']) ?? 0?>
                                    <?php else : ?>
                                        <?= Cart::get_cart_items_count_by_session_id(session_id()) ?? 0?>
                                    <?php endif ?>
                                </span>
                            </a>
                        </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid container-width min-height py-5 d-flex flex-column">