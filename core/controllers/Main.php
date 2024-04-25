<?php

namespace core\controllers;
use core\classes\Functions;

class Main
{
    public function index()
    {
        $data = [
            'titulo' => 'Página index MAIN',
            'clientes' => ['felippe', 'rhuanna', 'dayane']
        ];

        Functions::Layout([
            'Shared/html_header',
            'Main/index',
            'Shared/html_footer',
        ], $data);
    }

    public function loja()
    {
        echo "LOJA";
    }
}