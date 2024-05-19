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

                $db->insert("
                    INSERT INTO item_pedido(num_pedido, item_id, quantidade, preco)
                    VALUES (:order_number, :product_id, :product_quantity, :product_price);
                ", $item_params);
            }

            return $order_number;
        } 
        else {
            return false;
        }

        // Remover quantidades dos items da base de dados
        // Limpar carrinho
    }

    public function get_order($order_number) {
        $db = new Database();

        $params = [
            ':num_pedido' => $order_number,
        ];
       
        // Buscar pedido
        $results = $db->select("
            SELECT 
                pedido.num_pedido AS num_pedido, 
                pedido.data_pedido AS data_pedido, 
                pedido.estado_entrega_id AS estado_entrega_id, 
                pedido.morada_entrega_id AS morada_entrega_id, 
                pedido.cod_rastreamento AS cod_rastreamento, 
                cliente.nome_completo AS nome_cliente,
                estado_pagamento.estado AS estado_pagamento,
                estado_entrega.estado AS estado_entrega,
                metodo_pagamento.tipo AS tipo_pagamento
            FROM pedido
            INNER JOIN cliente ON pedido.cliente_id = cliente.id
            INNER JOIN estado_pagamento ON pedido.estado_pagamento_id = estado_pagamento.id
            INNER JOIN estado_entrega ON pedido.estado_entrega_id = estado_entrega.id
            INNER JOIN metodo_pagamento ON pedido.metodo_pagamento_id = metodo_pagamento.id
            WHERE pedido.num_pedido = :num_pedido
        ", $params);
        
        if(sizeof($results) > 0){

            $data = [
                'details' => $results[0],
            ];

            // Buscar items do pedido        
            $products = $db->select("
                SELECT 
                    produto.id AS id, 
                    produto.nome AS nome_produto,
                    produto.imagem AS imagem_produto, 
                    item_pedido.quantidade AS quantidade,
                    item_pedido.preco AS preco
                FROM item_pedido
                INNER JOIN produto ON produto.id = item_pedido.item_id
                WHERE item_pedido.num_pedido = :num_pedido
            ", $params);

            $data['products'] = $products;

            return $data;
        } else {
            return false;
        }
    }

    public function get_orders_by_customer_id($customer_id) {
        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id,
        ];
       
        // Buscar pedido
        $orders = $db->select("
            SELECT 
                pedido.num_pedido AS num_pedido, 
                pedido.data_pedido AS data_pedido, 
                cliente.nome_completo AS nome_cliente,
                estado_pagamento.estado AS estado_pagamento,
                estado_entrega.estado AS estado_entrega
            FROM pedido
            INNER JOIN cliente ON pedido.cliente_id = cliente.id
            INNER JOIN estado_pagamento ON pedido.estado_pagamento_id = estado_pagamento.id
            INNER JOIN estado_entrega ON pedido.estado_entrega_id = estado_entrega.id
            WHERE pedido.cliente_id = :cliente_id
        ", $params);
        
        if(sizeof($orders) > 0){

            foreach($orders as $order) {

                $params = [
                    ':num_pedido' => $order->num_pedido
                ];

                $products = $db->select("
                    SELECT 
                        produto.id AS id, 
                        produto.nome AS nome_produto,
                        produto.imagem AS imagem_produto, 
                        produto.preco AS preco, 
                        item_pedido.quantidade AS quantidade,
                        item_pedido.preco AS preco_total,
                        item_pedido.num_pedido AS num_pedido
                    FROM item_pedido
                    INNER JOIN produto ON produto.id = item_pedido.item_id
                    WHERE item_pedido.num_pedido = :num_pedido
                ", $params);

                $order->products = $products; 
            }

            // echo '<pre>';
            // die(print_r($orders));

            return $orders;
        } else {
            return false;
        }
    }

    public function get_order_address($address_id) {

        $db = new Database();

        $params = [
            ':id' => $address_id
        ];

        $results = $db->select("
            SELECT * FROM morada_faturacao 
            WHERE id = :id        
        ", $params);

        if(sizeof($results) > 0) {
            return $results[0];
        }
        else {
            return false;
        }
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