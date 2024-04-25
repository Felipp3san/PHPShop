<?php

namespace core\classes;

use Exception;

class Functions
{
    public static function Layout($structures, $data = null)
    {
        // verifica se 'structures' é um array.
        if(!is_array($structures))
        {
            throw new Exception("Coleção inválida.");
        }

        // passar variáveis para as estruturas
        if(!empty($data) && is_array($data))
        {
            extract($data);
        }

        // apresentar as views da aplicação.
        foreach($structures as $structure)
        {
            include("../core/views/$structure.php");
        }
    }
}