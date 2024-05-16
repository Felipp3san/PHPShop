<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Cart;
use core\models\User;

class OrderController {
    public function preview_order() {

        // Se utilizador não estiver logado ao tentar finalizar compra, é redirecionado para login
        if(!Store::is_client_logged()) {
            return Store::redirect('login');
        }

        $customer_id = $_SESSION['customer_id'];
        $cart = new Cart(); 
        $user = new User();

        $data['cart_items'] = $cart->get_cart_items_by_customer_id($customer_id);

        $addresses = $user->get_addresses($customer_id);
           
        if($addresses) {
            $data['addresses'] = $addresses;
        }

        return Store::layout('Order/preview_order', $data);
    }
}