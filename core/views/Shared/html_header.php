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
    <title><?= $titulo ?></title>
</head>

<body class="d-flex flex-column">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="?a=index">
                <img src="assets/images/php.png" alt="php-logo" width="75" height="75">
                <span>Shop</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="container d-flex justify-content-between align-items-center">
                    <div class="col-2 nav-link dropdown d-flex align-items-center">
                        <button class="btn btn-link p-0 text-light text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none;">
                            <i class="fa-solid fa-bars"></i><span> Categorias</span>
                        </button>
                        <ul class="dropdown-menu rounded-0">
                            <?php $category = new Category ?>
                            <?php foreach ($category->get_categories() as $categoria) : ?>
                                <li><a class="dropdown-item" href="?a=products&category-name=<?= $categoria->nome ?>&id=<?= $categoria->id ?>"><?= $categoria->nome ?></a></li>
                            <?php endforeach ?>
                        </ul>
                        </button>
                    </div>
                    <div class="col-7">
                        <form action="">
                            <input type="text" class="form-control rounded-0 border-0" id="search-bar" placeholder="Escreva aqui o que procura...">
                        </form>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
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
                            <li class="nav-item">
                                <a class="nav-link text-light" href="?a=cart">
                                    <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                    <span class="badge p-1">10</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- <div class="container-fluid navegacao text-light">
        <div class="container d-flex align-items-center">
            <div class="col-3">
                <a class="d-flex align-items-center gap-1" href="?a=index">
                    <img src="assets/images/php.png" alt="php-logo" width="100" height="100">
                    <span>Shop</span>
                </a>
            </div>
            <div class="col-6">
                <form action="">
                    <input type="text" class="form-control rounded-0 border-0" id="search-bar" placeholder="Escreva aqui o que procura...">
                </form>
            </div>
            <div class="col-3 d-flex justify-content-end gap-4">
                <div class="dropdown">
                    <button class="btn btn-link p-0 text-light" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none;">
                        <i class="fa-solid fa-user fa-lg"></i>
                    </button>
                    <ul class="dropdown-menu rounded-0">
                        <?php if (Store::is_client_logged()) : ?>
                            <li><a class="dropdown-item disabled text-dark">Olá, <?= $_SESSION['customer_name'] ?>!</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="?a=conta">Minha conta</a></li>
                            <li><a class="dropdown-item" href="?a=logout">Logout</a></li>
                        <?php else : ?>
                            <li><a class="dropdown-item" href="?a=login">Login</a></li>
                            <li><a class="dropdown-item" href="?a=register">Criar conta</a></li>
                        <?php endif ?>
                    </ul>
                </div>

                <a href="?a=cart">
                    <div class="">
                        <i class="fa-solid fa-cart-shopping fa-lg"></i>
                        <span class="badge p-1">10</span>
                    </div>
                </a>
            </div>
        </div>
    </div> -->