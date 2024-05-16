<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Cart;

class CartController {

    public function cart() {
        
        $cart = new Cart();

        if(Store::is_client_logged()) {
            $data['cart_items'] = $cart->get_cart_items_by_customer_id($_SESSION['customer_id']);
        } else {
            $data['cart_items'] = $cart->get_cart_items_by_session_id(session_id());
        };
        
        Store::layout('Cart/cart', $data);
    }

    public function add_to_cart() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            // URL atual para redirecionamento
            $actual_url = substr($_POST['actual-url'], 4);

            $item_id = $_POST['item-id'];
            $item_price = $_POST['item-price'];
            $quantity = $_POST['quantity'];
            
            $cart = new Cart();

            if(Store::is_client_logged()) {
                $customer_id = $_SESSION['customer_id'];
                $results = $cart->add_to_cart($item_id, $quantity, $item_price, $customer_id);
            }
            else {
                $session_id = session_id();
                $results = $cart->add_to_cart($item_id, $quantity, $item_price, null ,$session_id);
            }

            if($results) {
                $_SESSION['success-title'] = "Carrinho";
                $_SESSION['success'] = "Item adicionado ao carrinho!";
            }
            else {
                $_SESSION['error-title'] = "Carrinho";
                $_SESSION['error'] = "Erro, tente novamente.";
            }

            return Store::redirect($actual_url);
        }
    }

    public function remove_from_cart(){

        if($_SERVER['REQUEST_METHOD'] == 'POST') { 

            $cart = new Cart();

            $item_id = $_POST['item-id'];
            $quantity = $_POST['quantity'];
            $to_remove = $_POST['to-remove'];
            $actual_url = $_POST['actual-url'];

            if(Store::is_client_logged()) {
                $customer_id = $_SESSION['customer_id'];
                $results = $cart->remove_from_cart($item_id, $quantity, $to_remove, $customer_id);
            }
            else {
                $session_id = session_id();
                $results = $cart->remove_from_cart($item_id, $quantity, $to_remove, null ,$session_id);
            }

            if($results) {
                $_SESSION['success-title'] = "Remover item do carrinho";
                $_SESSION['success'] = "Item removido do carrinho!";
            }
            else {
                $_SESSION['error-title'] = "Remover item do carrinho";
                $_SESSION['error'] = "Erro, tente novamente.";
            }

            return Store::redirect($actual_url);
        }
    }
}
