<?php
// core/Database.php

/**
 * Classe para gerenciar a conexão com o banco de dados usando PDO.
 * Garante que apenas uma instância da conexão seja criada (Singleton Pattern).
 */
class Database {
    private static $instance = null;
    private $conn;

    /**
     * O construtor é privado para prevenir a criação de novas instâncias
     * com o operador 'new'.
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
