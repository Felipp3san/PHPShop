<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Cart;
use core\models\Order;
use core\models\Product;
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

    public function checkout() {
        // Se utilizador não estiver logado ao tentar finalizar compra, é redirecionado para login
        if(!Store::is_client_logged()) {
            return Store::redirect('login');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if(!isset($_POST['payment'])){
                $_SESSION['error-title'] = "Método de pagamento não selecionado";
                $_SESSION['error'] = "Selecione um método de pagamento.";
                return Store::redirect('preview_order');
            }

            if(!isset($_POST['address'])){
                $_SESSION['error-title'] = "Morada não selecionada";
                $_SESSION['error'] = "Selecione uma morada para entrega.";
                return Store::redirect('preview_order');
            }

            $cliente_id = $_SESSION['customer_id'];

            // Adicionar todos os produtos e informações em um só array 
            $ids = $_POST['cart-items-ids'];
            $quantities = $_POST['cart-items-quantities'];
            $prices = $_POST['cart-items-prices'];

            for ($i=0; $i < sizeof($ids); $i++) { 
                $products[] = [
                    'id' => $ids[$i],
                    'quantity' => $quantities[$i],
                    'price' => $prices[$i],
                ];
            };
            // =================

            $params = [
                'customer_id' => $cliente_id,
                'payment' => $_POST['payment'],
                'address' => $_POST['address'],
                'products' => $products,
            ];
            
            $order = new Order();
            $cart = new Cart();
            $product = new Product();

            $order_number = $order->create_order($params);

            // Criação do pedido bem sucedida
            if($order_number) {

                // Limpar carrinho
                $cart->clear_cart($cliente_id);

                // Modificar quantidade dos itens
                $product->update_items_quantities($products);

                return Store::layout('Order/order', $order->get_order($order_number));
            }
        }
    }

    public function order() {

        $order = new Order();

        return Store::layout('Order/order', $order->get_order(317159374288639));
    }
}