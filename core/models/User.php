<?php

namespace core\models;

use core\classes\Database;

class User {
    public function get_account_data($customer_id) {
        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id 
        ];

        $results = $db->select("
            SELECT * FROM cliente
            WHERE id = :cliente_id        
        ", $params);

        if(sizeof($results) > 0) {
            return $results[0];
        }
        else {
            return false;
        }
    }

    public function get_addresses($customer_id) {

        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id 
        ];

        $results = $db->select("
            SELECT * FROM morada_faturacao 
            WHERE cliente_id = :cliente_id        
        ", $params);

        if(sizeof($results) > 0) {
            return $results;
        }
        else {
            return false;
        }
    }

    public function add_address($customer_id, $nome, $apelido, $morada, $cidade, $cod_postal, $nif, $telefone = null) {
        $db = new Database();
        $params = [
            ':cliente_id' => $customer_id,
            ':nome' => $nome,
            ':apelido' => $apelido, 
            ':morada' => $morada,
            ':cidade' => $cidade,
            ':cod_postal' => $cod_postal,
            ':nif' => $nif,
        ];
        
        // Verifica se cliente já possui endereços, caso sim, ativo = 0. 
        if(self::address_quantity($customer_id) == 0) {
            $params[':ativo'] = 1;
        } 
        else {
            $params[':ativo'] = 0;
        };
        
        if(isset($telefone) && $telefone != null) {
            
            $params[':telefone'] = $telefone;

            $results = $db->insert("
                INSERT INTO morada_faturacao(nome, apelido, morada, cidade, cod_postal, telefone, nif, ativo, cliente_id)
                VALUES (:nome, :apelido, :morada, :cidade, :cod_postal, :telefone, :nif, :ativo, :cliente_id)
            ", $params);

        } else {
            
            $results = $db->insert("
                INSERT INTO morada_faturacao(nome, apelido, morada, cidade, cod_postal, nif, ativo, cliente_id)
                VALUES (:nome, :apelido, :morada, :cidade, :cod_postal, :nif, :ativo, :cliente_id) 
            ", $params);
        }

        return $results;
    }

    public function remove_address($customer_id, $address_id) {
        $db = new Database();

        $params = [
            ':morada_id' => $address_id,
        ];

        $results = $db->delete("
            DELETE FROM morada_faturacao
            WHERE id = :morada_id
        ", $params);

        // Ao remover, define a morada mais antiga como padrão, se ainda existir alguma.
        if(self::address_quantity($customer_id) > 0){

            $params[':cliente_id'] = $customer_id;
            unset($params[':morada_id']);

            // Procure a morada com o menor id e atualiza o ativo para true.
            $update_result = $db->update("
                UPDATE morada_faturacao
                SET ativo = 1 
                WHERE id = (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM morada_faturacao WHERE cliente_id = :cliente_id
                    ) as temp 
                ) 
            ",$params); 
        }

        return $results;
    }

    public static function address_limit_reached($customer_id) {
        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id 
        ];

        $results = $db->select("
            SELECT * FROM morada_faturacao 
            WHERE cliente_id = :cliente_id        
        ", $params);

        if(sizeof($results) >= 3) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function address_quantity($customer_id) {
        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id 
        ];

        $results = $db->select("
            SELECT * FROM morada_faturacao 
            WHERE cliente_id = :cliente_id        
        ", $params);

        if(sizeof($results) >= 0) {
            return sizeof($results);
        }
        else {
            return 0;
        }
    }

    public function define_default_address($customer_id, $address_id) {

        $db = new Database();

        $params = [
            ':cliente_id' => $customer_id,
        ];
        
        // MUDAR TODOS OS ATIVOS PARA 0
        $results = $db->update("
            UPDATE morada_faturacao
            SET ativo=0 
            WHERE cliente_id = :cliente_id
        ", $params);
        
        $params[':endereco_id'] = $address_id;

        // DEFINIR APENAS O PADRAO COMO ATIVO
        $results = $db->update("
            UPDATE morada_faturacao
            SET ativo=1
            WHERE cliente_id = :cliente_id 
            AND id = :endereco_id
        ", $params);

        return $results;
    }
}
