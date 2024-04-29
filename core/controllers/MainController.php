<?php

namespace core\controllers;

use core\classes\Store;

class MainController {

    public function index() {
        // Mantem a persistência da ultima página visitada
        $_SESSION['previous-action'] = "";

        Store::layout('Main/index');
    }

    public function store() {
        // Mantem a persistência da ultima página visitada
        $_SESSION['previous-action'] = "store";

        Store::layout('Main/store');
    }

    public function cart() {
        // Mantem a persistência da ultima página visitada
        $_SESSION['previous-action'] = "cart";

        Store::layout('Main/cart');
    }
}
