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
            return Store::redirect();
        }
       
        // POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

            if (!isset($_POST['username']) ||
                !isset($_POST['password'])) {

                $_SESSION['error-title'] = "Login";
                $_SESSION['error'] = "Os dados foram preenchidos incorretamente.";
                return Store::redirect('admin');
            }

           $username = $_POST['username'];
           $password = $_POST['password'];       
           
           $admin = new Admin();
        
           $admin_account = $admin->verify_admin($username, $password);

           if(!$admin_account) {
                $_SESSION['error-title'] = "Login";
                $_SESSION['error'] = "Login inválido.";
                return Store::redirect('admin');
           }
           else {
                $_SESSION['admin_id'] = $admin_account->id;
                $_SESSION['admin_username'] = $admin_account->utilizador;
                return Store::redirect();
           }
        }
        // GET
        else {
           return Store::layout('Admin/staff_login');
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
                $_SESSION['error-title'] = "Senha inválida";
                $_SESSION['error'] = "As senhas não coincidem.";
            }
            else {
                $admin = new Admin();

                $results = $admin->create_staff($username, $password);

                if($results) {
                    $_SESSION['success-title'] = "Gestor adicionado";
                    $_SESSION['success'] = "Gestor adicionado com sucesso!";
                }
                else {
                    $_SESSION['error-title'] = "Erro";
                    $_SESSION['error'] = "Erro, tente novamente.";
                }
            }
            return Store::redirect('add_staff');
        }
        // GET
        else {
            return Store::layout('Admin/add_staff');
        }
    }

    public function products() {
        if(!Store::is_admin_logged()) { 
            return Store::layout('Admin/access_denied');
        }

        $product = new Product();

        $data = [
            'products' => $product->get_products()
        ];

        return Store::layout('Admin/products', $data);
    }

    public function edit_product() {

        if(!Store::is_admin_logged()) { 
            return Store::layout('Admin/access_denied');
        }

        $product = new Product();
        $category = new Category();
        $manufacturer = new Manufacturer();

        $data = [
            'product' => $product->get_product_by_id($_GET['id']),
            'categories' => $category->get_categories(),
            'manufacturers' => $manufacturer->get_manufacturers(),
        ];

        return Store::layout('Admin/edit_product', $data);
    }

    public function add_products() {
        if(!Store::is_admin_logged()) { 
            return Store::layout('Admin/access_denied');
        }

        // POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $product = new Product();
            $category = new Category();

            $params = [
                ':nome' => trim($_POST['nome']),
                ':descricao' => trim($_POST['descricao']),
                ':fabricante_id' => $_POST['fabricante_id'],
                ':preco' => filter_var(trim($_POST['preco']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':quantidade' => $_POST['quantidade'],
                ':categoria_id' => $_POST['categoria_id'],
            ];
            
            // Buscar nome da categoria a partir do id
            $category_name = $category->get_category_by_id($_POST['categoria_id'])->nome;
            $modified_category_name = $category->clear_category_name_for_db(strtolower($category_name));
           
            // Adiciona categorias aos caminhos das imagens e concatena separando com @ para envia a base de dados
            if(isset($_POST['imagens'])) {
                $images = $_POST['imagens'];
                
                foreach ($images as $key => $value) {
                    $images[$key] = $modified_category_name . "/" . $value;
                }
                
                $images = implode('@', $images) . '@';
                $params[':imagem'] = $images;
            }
            // =========================================================
            
            if($_POST['ativo']) {
                $params[':ativo'] = 1;                
            }
            else {
                $params[':ativo'] = 0;                
            }

            $results = $product->add_product($params);
            
            if($results) {
                $_SESSION['success-title'] = "Produto adicionado";
                $_SESSION['success'] = "Produto adicionado com sucesso!";
                return Store::redirect('add_products');
            }
            else {
                $_SESSION['error-title'] = "Erro";
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

            return Store::layout('Admin/add_products', $data);
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
                $_SESSION['success-title'] = "Fabricante adicionado";
                $_SESSION['success'] = "Fabricante adicionado com sucesso!";
            }
            else {
                $_SESSION['error-title'] = "Erro";
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