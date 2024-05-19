<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Cart;
use core\models\Product;

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

            $customer_id = $_SESSION['customer_id'];
            $item_id = $_POST['item-id'];
            $item_price = $_POST['item-price'];
            $quantity = $_POST['quantity'];
            
            $cart = new Cart();
            $product = new Product();

            // Verifica se o item possui a quantidade inserida no carrinho
            if(isset($_POST['selected-quantity'])) {
                // Carrinho
                $results = $product->verify_item_quantity($customer_id, $item_id, $_POST['selected-quantity'] + $quantity);
            }
            else {
                // Detalhes
                $results = $product->verify_item_quantity($customer_id, $item_id, $quantity);
            }

            if(!$results) {
                $_SESSION['error-title'] = "Adicionar ao carrinho";
                $_SESSION['error'] = "O item não possui em estoque a quantidade selecionada."; 
                return Store::redirect($actual_url);
            }
            //============================================================

            if(Store::is_client_logged()) {
                $customer_id = $_SESSION['customer_id'];
                $results = $cart->add_to_cart($item_id, $quantity, $item_price, $customer_id);
            }
            else {
                $session_id = session_id();
                $results = $cart->add_to_cart($item_id, $quantity, $item_price, null ,$session_id);
            }

            if($results) {
                $_SESSION['success-title'] = "Adicionar ao carrinho";
                $_SESSION['success'] = "Item adicionado ao carrinho!";
            }
            else {
                $_SESSION['error-title'] = "Adicionar ao carrinho";
                $_SESSION['error'] = "Erro, tente novamente.";
            }

            return Store::redirect($actual_url);
        }
    }

    public function remove_from_cart(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 

            // URL atual para redirecionamento
            $actual_url = substr($_POST['actual-url'], 4);

            $cart = new Cart();

            $item_id = $_POST['item-id'];
            $quantity = $_POST['quantity'];
            $to_remove = $_POST['to-remove'];

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
