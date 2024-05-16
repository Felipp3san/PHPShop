<?php

namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database
{
    private $connection;

    private function open_connection() {
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

    private function close_connection() {
        $this->connection = null;
    }

    public function select($sql, $params = null) {

        $sql = trim($sql);

        // Verificar se é uma instrução SELECT com regex.
        if(!preg_match("/^SELECT/i", $sql)) {
            throw new Exception('(Database) Não é uma instrução SELECT.');
        }

        $results = null;

        try {
            $this->open_connection();

            if(!empty($params)) {
                $execute = $this->connection->prepare($sql);
                $execute->execute($params);
                $results = $execute->fetchAll(PDO::FETCH_CLASS);
            }
            else {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
                $results = $execute->fetchAll(PDO::FETCH_CLASS);
            }
            
        } catch (PDOException $e) {
           return false; 
        } finally {
            $this->close_connection();
        }

        return $results;
    }
    
    public function insert($sql, $params = null) {

        $sql = trim($sql);
        
        // Verificar se é uma instrução SELECT com regex.
        if(!preg_match("/^INSERT/i", $sql)) {
            throw new Exception('(Database) Não é uma instrução INSERT.');
        }

        try {
            $this->open_connection();

            if(!empty($params)) {
                $execute = $this->connection->prepare($sql);
                $sucess = $execute->execute($params);
            }
            else {
                $execute = $this->connection->prepare($sql);
                $sucess = $execute->execute();
            }
        } catch (PDOException $e) {
            return false; 
        } finally {
            $this->close_connection();
        }

        return $sucess;
    }

    public function update($sql, $params = null) {

        $sql = trim($sql);
        
        // Verificar se é uma instrução SELECT com regex.
        if(!preg_match("/^UPDATE/i", $sql)) {
            throw new Exception('(Database) Não é uma instrução UPDATE.');
        }

        try {
            $this->open_connection();

            if(!empty($params)) {
                $execute = $this->connection->prepare($sql);
                $success = $execute->execute($params);
            }
            else {
                $execute = $this->connection->prepare($sql);
                $success = $execute->execute();
            }
        } catch (PDOException $e) {
           return false; 
        } finally {
            $this->close_connection();
        }

        return $success;
    }

    public function delete($sql, $params = null) {

        $sql = trim($sql);

        // Verificar se é uma instrução SELECT com regex.
        if(!preg_match("/^DELETE/i", $sql)) {
            throw new Exception('(Database) Não é uma instrução DELETE.');
        }

        try {
            $this->open_connection();

            if(!empty($params)) {
                $execute = $this->connection->prepare($sql);
                $success = $execute->execute($params);
            }
            else {
                $execute = $this->connection->prepare($sql);
                $success = $execute->execute();
            }
        } catch (PDOException $e) {
            return false; 
        } finally {
            $this->close_connection();
        }

        return $success;
    }

    // GENERICO
    public function statement($sql, $params = null) {

        $sql = trim($sql);

        // Verificar se é uma instrução SELECT com regex.
        if(preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql)) {
            throw new Exception('(Database) Instrução inválida.');
        }

        try {
            $this->open_connection();

            if(!empty($params)) {
                $execute = $this->connection->prepare($sql);
                $execute->execute($params);
            }
            else {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch (PDOException $e) {
            return false; 
        } finally {
            $this->close_connection();
        }

        return true;
    }
    
}

/*
define('MYSQL_SERVER',      'localhost');
define('MYSQL_DATABASE',    'php_shop');
define('MYSQL_USER',        'user_php_shop');
define('MYSQL_PASS',        '123');
define('MYSQL_CHARSET',     'utf8');
*/