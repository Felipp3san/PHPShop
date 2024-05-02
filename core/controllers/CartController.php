<?php

namespace core\controllers;

use core\classes\Store;

class CartController {
    public function cart() {
        // Mantem a persistência da ultima página visitada
        $_SESSION['previous-action'] = "cart";

        Store::layout('Cart/cart');
    }
}
