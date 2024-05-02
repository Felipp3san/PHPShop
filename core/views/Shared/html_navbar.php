<?php

use core\classes\Store;
?>

<div class="container-fluid navegacao text-light">
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
</div>