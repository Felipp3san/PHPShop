<?php 

namespace core\models;

use core\classes\Database;
use PDO;

class Order {
    public function create_order($params) {

        // Criar pedidos com os dados passados
        $db = new Database();

        $order_number = $this->generate_order_number($params['customer_id']);

        $order_params = [
            ':order_number' => $order_number,
            ':customer_id' => $params['customer_id'],
            ':payment' => $params['payment'],
            ':address' => $params['address'],
        ];

        $results = $db->insert("
            INSERT INTO pedido(num_pedido, morada_entrega_id, cliente_id, metodo_pagamento_id)
            VALUES (:order_number, :address, :customer_id, :payment);
        ", $order_params);

        if($results) {

            foreach($params['products'] as $product) {

                unset($item_params);

                $item_params = [
                    ':order_number' => $order_number,
                    ':product_id' => $product['id'],
                    ':product_quantity' => $product['quantity'],
                    ':product_price' => $product['price'],
                ];

                $results = $db->insert("
                    INSERT INTO item_pedido(num_pedido, item_id, quantidade, preco)
                    VALUES (:order_number, :product_id, :product_quantity, :product_price);
                ", $item_params);
            }

            return $results;
        } 

        // Remover quantidades dos items da base de dados
        // Limpar carrinho
    }

    // Função para gerar um número de pedido único
    function generate_order_number($customer_id) {

        do {
            // Obter o timestamp atual
            $timestamp = time();
    
            // Gerar um valor aleatório de 4 dígitos
            $random = mt_rand(1000, 9999);
    
            // Concatenar o ID do cliente, timestamp e valor aleatório para formar o número de pedido
            $order_number = $customer_id . $timestamp . $random;

        } while ($this->order_number_exists($order_number));

        return $order_number;
    }

    function order_number_exists($order_number) {

        $db = new Database();

        $params = [
            ':order_number' => $order_number,
        ];

        $results = $db->select("
            SELECT * FROM pedido
            WHERE num_pedido = :order_number
        ", $params);

        if(sizeof($results) > 0) {
            return true;
        } 
        else {
            return false;
        }
    }
}