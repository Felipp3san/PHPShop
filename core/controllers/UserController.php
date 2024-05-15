<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Customer;

class UserController {

    public function account(){

        // Verifica se há sessão aberta
        if (!Store::is_client_logged()) {
            return Store::redirect();
        }

        $customer = new Customer();
        $customer_id = $_SESSION['customer_id'];

        $account_data = $customer->get_account_data($customer_id);

        if($account_data) {

            $data = [
                'account_data' => $account_data,
            ];

            $addresses = $customer->get_addresses($customer_id);
           
            if($addresses) {
                $data['addresses'] = $addresses;
            }

            return store::layout('user/account', $data);
        };

        return Store::redirect();
    }

    public function add_address(){

        // Verifica se há sessão aberta
        if (!Store::is_client_logged()) {
            return Store::redirect();
        }

        $customer_id = $_SESSION['customer_id'];

        // POST('/?a=login/')
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            
        }

        // GET
        return Store::layout('user/add_address');
    }
}