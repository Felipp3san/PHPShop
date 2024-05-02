<?php

namespace core\controllers;

use core\classes\Store;

class MainController {

    public function index() {
        // Mantem a persistência da ultima página visitada
        $_SESSION['previous-action'] = "";

        Store::layout('Main/index');
    }
}
