<?php

namespace core\classes;

use Exception;

class Store
{
    public static function layout($structure, $data = null){
        // verifica se 'structures' é um array.
        if(empty($structure))
        {
            throw new Exception("Página inválida.");
        }

        // passar variáveis para as estruturas

        // dados fixos
        $fixed_data = [
            'titulo' => APP_NAME . ' ' . APP_VERSION,
        ];

        extract($fixed_data);

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

    public static function is_client_logged(){
        // Verifica se existe um cliente com sessão
        return (isset($_SESSION['cliente']));
    }

    public static function create_hash($num_characters = 12){

        $hash = [];

        // Códigos ASCII inválidos.
        $nums_to_exclude = array_merge(range(58, 64), range(91, 96));

        while(sizeof($hash) < $num_characters){

            // Gerar um número aleatório entre 48 e 57 (correspondente a sequencia de numeros de 0 a 9 em ASCII)
            // Gerar um número aleatório entre 65 e 90 (correspondente às letras maiúsculas do alfabeto em ASCII)
            // Gerar um número aleatório entre 97 e 122 (correspondente às letras minúsculas do alfabeto em ASCII)
            $random_number = rand(48, 122);

            if(!in_array($random_number, $nums_to_exclude)){
                // Converter código ASCII para char e incluir no array.
                $hash[] = chr($random_number);
            }
        }

        // Converte array em string e retornar
        return implode("", $hash);
    }

    public static function redirect($rota = '')
    {
        if(empty($rota)) {
            header("Location: " . APP_BASEURL);
        } 
        else {
            header("Location: " . APP_BASEURL . "?a={$rota}");
        }
    }
}