<?php

namespace core\classes;

use Exception;

class Store
{
    public static function Layout($structure, $data = null){
        // verifica se 'structures' é um array.
        if(empty($structure))
        {
            throw new Exception("Página inválida.");
        }

        // passar variáveis para as estruturas

        // dados fixos
        $fixedData = [
            'titulo' => APP_NAME . ' ' . APP_VERSION,
        ];

        extract($fixedData);

        // dados variáveis
        if(!empty($data) && is_array($data))
        {
            extract($data);
        }

        // apresentar as views da aplicação.
        include("../core/views/Shared/html_header.php");
        include("../core/views/$structure.php");
        include("../core/views/Shared/html_footer.php");
    }

    public static function ClienteLogado(){
        // Verifica se existe um cliente com sessão
        return (isset($_SESSION['cliente']));
    }
}