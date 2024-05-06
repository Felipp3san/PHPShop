<?php

namespace core\controllers;

use core\models\Favorite;
use core\classes\Store;

class FavoriteController {

    public function add_favorite() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $customer_id = $_POST['favorite-customer-id'];
            $item_id = $_POST['favorite-item-id'];
            $category_name = $_POST['favorite-item-category'];
            $actual_url = substr($_POST['actual-url'], 4);

            $favorite = new Favorite();

            $favorite->add_favorite($customer_id, $item_id, $category_name);

            return Store::redirect($actual_url);
        }
    }

    public function remove_favorite() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $customer_id = $_POST['favorite-customer-id'];
            $item_id = $_POST['favorite-item-id'];
            $actual_url = substr($_POST['actual-url'], 4);

            $favorite = new Favorite();

            $favorite->remove_favorite($customer_id, $item_id);

            return Store::redirect($actual_url);
        }
    }

    public function show_favorites() {

        if (!Store::is_client_logged()) {
            return Store::redirect();
        }

        $favorite = new Favorite();

        $data = [
            'favorites' => $favorite->get_favorites($_SESSION['customer_id']),
        ];

        return Store::layout("Favorite/favorites", $data);
    }
}