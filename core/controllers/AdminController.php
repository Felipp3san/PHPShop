<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Admin;
use core\models\Category;
use core\models\Manufacturer;
use core\models\Product;

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

    public function add_staff() {
        if(!Store::is_admin_logged()) { 
            return Store::layout('Admin/access_denied');
        }

        // POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm-password'];

            if($password != $confirm_password) {
                $_SESSION['error'] = "As senhas não coincidem.";
                return Store::redirect('add_staff');
            }
            else {
                $admin = new Admin();

                $results = $admin->create_staff($username, $password);

                if($results) {
                    $_SESSION['success'] = "Gestor criado com sucesso!";
                }
                else {
                    $_SESSION['error'] = "Erro, tente novamente.";
                }

                return Store::redirect('add_staff');
            }
        }
        // GET
        else {
            return Store::layout('Admin/add_staff');
        }
    }

    public function add_products() {

        if(!Store::is_admin_logged()) { 
            return Store::layout('Admin/access_denied');
        }

        // POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $product = new Product();

            
            $params = [
                ':nome' => trim($_POST['nome']),
                ':descricao' => trim($_POST['descricao']),
                ':fabricante_id' => $_POST['fabricante_id'],
                ':preco' => filter_var(trim($_POST['preco']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':quantidade' => $_POST['quantidade'],
                ':categoria_id' => $_POST['categoria_id'],
                ':imagem' => $_POST['imagem'],
            ];
            
            if($_POST['ativo']) {
                $params[':ativo'] = 1;                
            }
            else {
                $params[':ativo'] = 0;                
            }

            $results = $product->add_product($params);
            
            if($results) {
                $_SESSION['success'] = "Produto adicionado com sucesso!";
                return Store::redirect('add_products');
            }
            else {
                $_SESSION['error'] = "Falha ao tentar adicionar novo produto.";
                return Store::redirect('add_products');
            }
        }
        // GET
        else {
            $manufacturers = new Manufacturer();
            $categories = new Category();

            $data = [
                'fabricantes' => $manufacturers->get_manufacturers(),
                'categorias' => $categories->get_categories()
            ];

            Store::layout('Admin/add_products', $data);
            return;
        }
    }

    public function add_manufacturer() {

        if(!Store::is_admin_logged()) { 
            return Store::layout('Admin/access_denied');
        }

        // POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $manufacturer = new Manufacturer();

            $params = [
                ':nome' => trim($_POST['nome']),
            ];
            
            $results = $manufacturer->add_manufacturer($params);

            if($results) {
                $_SESSION['success'] = "Fabricante adicionado com sucesso!";
            }
            else {
                $_SESSION['error'] = "Falha ao tentar adicionar novo fabricante.";
            }

            return Store::redirect('add_manufacturer');
        }
        // GET
        else {
            return Store::layout('Admin/add_manufacturer');
        }
    }

    public function visualize_manufacturers() {
        if(!Store::is_admin_logged()) { 
            return Store::layout('Admin/access_denied');
        }
        else {
            $manufacturer = new Manufacturer();

            $data = [
                'categoria' => 'Fabricantes',
                'elementos' => $manufacturer->get_manufacturers(),
            ];

            return Store::layout('Admin/visualize', $data);
        }
    }

    public function visualize_staff() {
        if(!Store::is_admin_logged()) { 
            return Store::layout('Admin/access_denied');
        }
        else {
            $admin = new Admin();

            $data = [
                'categoria' => 'Gestores',
                'elementos' => $admin->get_staff(),
            ];

            return Store::layout('Admin/visualize', $data);
        }
    }
}