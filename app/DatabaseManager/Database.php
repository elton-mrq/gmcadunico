<?php

namespace App\DatabaseManager;

use Exception;
use \PDO;
use \PDOException;

class Database{

    /**
     * HOST DE CONEXAO COM O BD
     */
    private static $dbHost;

    /**
     * NOME DO BD
     */
    private static $dbName;

    /**
     * USUARIO DO BD
     */
    private static $dbUser;

    /**
     * SENHA DE ACESSO AO BD
     */
    private static $dbPass;

    /**
     * PORTA DE ACESSO AO BD
     */
    private static $dbPort;
   
    /**
     * NOME DA TABLE
     */
    private $table;

    /**
     * INSTANCIA DE CONEXAO COM BD
     */
    private $connection;

    public function __construct($table = null)
    {
      $this->table = $table;
      $this->setConnection();  
    }

    /**
     * MÉTODO RESPONSÁVEL POR RECEBER PARAMETROS DE CONFIGURAÇÃO DA CLASSE
     *
     * @param [string] $dbHost
     * @param [string] $dbName
     * @param [string] $dbUser
     * @param [string] $dbPass
     * @param integer $dbPort
     */
    public static function config($dbHost, $dbName, $dbUser, $dbPass, $dbPort = 3606)
    {
       self::$dbHost = $dbHost;  
       self::$dbName = $dbName;
       self::$dbUser = $dbUser;
       self::$dbPass = $dbPass;
       self::$dbPort = $dbPort;    
    }

    private function setConnection()
    {
        $config = 'mysql:host=' . self::$dbHost . ';dbname=' . self::$dbName . ';port=' . self::$dbPort;
        try {
            $this->connection = new PDO($config, self::$dbUser, self::$dbPass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            throw new Exception('Erro de conexão com o Banco de Dados: ' . $ex->getMessage(), 500);
        }
    }

    /**
     * Método que executa as queries
     *
     * @param string $query
     * @param array $params
     * @return void
     */
    private function execute($query, $params = [])
    {

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
        } catch (PDOException $ex) {
            throw new Exception("Erro ao executar query: " . $ex->getMessage(), 500);
        }

    }

    /**
     * Método que insere registros no banco
     * @param array $values
     * @return integer
     */
    public function insert($values)
    {
        //DADOS DA QUERY
        $fields = array_keys($values);
        $binds  = array_pad([], count($fields), '?');

        //MONTA QUERY
        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        //CHAMA O MÉTODO QUE EXECUTA O INSERT
        $this->execute($query, array_values($values));

        //RETORNA O ULTIMO ID INSERIDO
        return $this->connection->lastInsertId();
    }

    /**
     * Método responsável por executar operação de atualização
     * @param string $where
     * @param array $values (key => value)
     * @return boolean
     */
    public function update($where, $values)
    {
        //TRATA OS DADOS
        $fields = array_values($values);

        //MONTA A QUERY
        $query = "UPDATE $this->table SET " . implode(' = ?, ', $fields) . " = ? WHERE $where";

        //EXECUTA A QUERY
        $this->execute($query, array_values($values));

        //RETORNA BOOLEAN TRUE
        return true;
    }

    /**
     * Método responsável por deletar registro do Banco
     * @param string $where
     * @return boolean
     */
    public function delete($where)
    {
        //MONTA A QUERY DE EXCLUSAO
        $query = "DELETE FROM $this->table WHERE $where";

        //EXECUTA A QUERY
        $this->execute($query);

        //RETORNA BOOLEAN TRUE
        return true;
    }

    /**
     * Método responsável por executar uma consulta no banco
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        //DADOS DA QUERY
        $where = strlen($where) ? "WHERE $where" : '';
        $order = strlen($order) ? "ORDER BY $order" : '';
        $limit = strlen($limit) ? "LIMIT $limit" : '';

        $query = "SELECT $fields FROM $this->table $where $order $limit";

        //EXECUTA A QUERY
        return $this->execute($query);
    }
         
}