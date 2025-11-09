<?php
// core/Database.php

/**
 * Classe para gerenciar a conexão com o banco de dados usando PDO.
 * Garante que apenas uma instância da conexão seja criada (Singleton Pattern).
 */

class Database {
    private static $instance = null;
    private ?int $insert_id = null;
    protected $conn;


    /**
     * O construtor é privado para prevenir a criação de novas instâncias
     */

    private function __construct() {
        // Carrega as configurações do banco de dados
        require_once __DIR__ . '/../config/database.php';

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Em uma aplicação real, você deveria logar este erro, não exibi-lo.
            die('Erro de conexão: ' . $e->getMessage());
        }
    }


     /**
     * Método para executar consultas de forma segura.
     * 
     *
     * @param string $query A query SQL com placeholders (?, ?, etc.)
     * @param array  $params Um array de parâmetros para o bind.
     * @param bool   $notdie Se true, retorna um array de erro em vez de 'die()'.
     * @return PDOStatement|array Retorna o PDOStatement em sucesso, ou um array de erro.
     */

    public function consulta(string $query, array $params = [], bool $notdie = false)
    {
        $this->insert_id = null; 
        
        try {
            $pdo = $this->conn;

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);

            if (stripos(trim($query), 'INSERT') === 0) {
                 $this->insert_id = $pdo->lastInsertId();
            }
            
            return $stmt; 

        } catch (PDOException $e) {
            if ($notdie) {
                return [
                    'error_code' => $e->getCode(),
                    'error_desc' => $e->getMessage()
                ];
            }
            
            die("<b>Ocorreu um erro ao executar a consulta:</b><br>" . $e->getMessage());
        }
    }





    /**
     * Método estático que controla o acesso à instância.
     * @return PDO A instância da conexão PDO.
     */
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
