<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Admin;
use core\models\Manufacturer;

class AdminController {

    public function staff_login() {

        // Verifica se há sessão aberta
        if (Store::is_client_logged()) {
            Store::redirect();
        }
       
        // POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

            if (!isset($_POST['username']) ||
                !isset($_POST['password'])) {

                $_SESSION['error'] = "Os dados foram preenchidos incorretamente.";
                Store::redirect('admin');
                return;
            }

           $username = $_POST['username'];
           $password = $_POST['password'];       
           
           $admin = new Admin();
        
           $admin_account = $admin->verify_admin($username, $password);

           if(!$admin_account) {
                $_SESSION['error'] = "Login inválido.";
                store::redirect('admin');
                return;
           }
           else {
                $_SESSION['admin_id'] = $admin_account->id;
                $_SESSION['admin_username'] = $admin_account->utilizador;

                store::redirect();
                return;
           }
        }
        // GET
        else {
            Store::layout('Admin/staff_login');
        }
    }
    
    public function management_panel() {
        if(Store::is_admin_logged()) {
            Store::layout('Admin/management_panel');
            return;
        }
        else {
            Store::layout('Admin/access_denied');
            return;
        }
    }

    public function add_products() {
        if(Store::is_admin_logged()) {

            $manufacturer = new Manufacturer();

            $data = [
                'fabricantes' => $manufacturer->get_manufacturers() 
            ];

            Store::layout('Admin/add_products', $data);
            return;
        }
        else {
            Store::layout('Admin/access_denied');
            return;
        }
    }
}