<?php

namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database
{
    private $connection;

    private function openConnection()
    {
        // PHP Data Object
        // new PDO('mysql:host=localhost;dbname=php_shop;charset=utf8')
        $this->connection = new PDO(
            'mysql:'.
            'host='.MYSQL_SERVER.';'.
            'dbname='.MYSQL_DATABASE.';'.
            'charset='.MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    private function closeConnection()
    {
        $this->connection = null;
    }

    public function select($sql, $parametros = null)
    {
        // Verificar se é uma instrução SELECT com regex.
        if(!preg_match("/^SELECT/i", $sql))
        {
            throw new Exception('(Database) Não é uma instrução SELECT.');
        }

        $this->openConnection();

        $results = null;

        try {
            if(!empty($parametros))
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parametros);
                $results = $execute->fetchAll(PDO::FETCH_CLASS);
            }
            else
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
                $results = $execute->fetchAll(PDO::FETCH_CLASS);
            }
        } catch (PDOException $e) {
           return false; 
        }
        
        $this->closeConnection();

        return $results;
    }
    
    public function insert($sql, $parametros = null)
    {
        // Verificar se é uma instrução SELECT com regex.
        if(!preg_match("/^INSERT/i", $sql)) {
            throw new Exception('(Database) Não é uma instrução INSERT.');
        }

        $this->openConnection();

        try {
            if(!empty($parametros))
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parametros);
            }
            else
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch (PDOException $e) {
           return false; 
        }
        
        $this->closeConnection();
    }

    public function update($sql, $parametros = null)
    {
        // Verificar se é uma instrução SELECT com regex.
        if(!preg_match("/^UPDATE/i", $sql))
        {
            throw new Exception('(Database) Não é uma instrução UPDATE.');
        }

        $this->openConnection();

        try {
            if(!empty($parametros))
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parametros);
            }
            else
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch (PDOException $e) {
           return false; 
        }
        
        $this->closeConnection();
    }

    public function delete($sql, $parametros = null)
    {
        // Verificar se é uma instrução SELECT com regex.
        if(!preg_match("/^DELETE/i", $sql))
        {
            throw new Exception('(Database) Não é uma instrução DELETE.');
        }

        $this->openConnection();

        try {
            if(!empty($parametros))
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parametros);
            }
            else
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch (PDOException $e) {
           return false; 
        }
        
        $this->closeConnection();
    }

    // GENERICO
    public function statement($sql, $parametros = null)
    {
        // Verificar se é uma instrução SELECT com regex.
        if(preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql))
        {
            throw new Exception('(Database) Instrução inválida.');
        }

        $this->openConnection();

        try {
            if(!empty($parametros))
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parametros);
            }
            else
            {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch (PDOException $e) {
           return false; 
        }
        
        $this->closeConnection();
    }
    
}

/*
define('MYSQL_SERVER',      'localhost');
define('MYSQL_DATABASE',    'php_shop');
define('MYSQL_USER',        'user_php_shop');
define('MYSQL_PASS',        '123');
define('MYSQL_CHARSET',     'utf8');
*/