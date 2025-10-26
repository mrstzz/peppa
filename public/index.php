<?php
// public/index.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Verifica e carrega o autoloader do Composer
$autoloader = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($autoloader)) {
    die("Erro: As dependências do Composer não foram encontradas. Rode 'composer install' na raiz do seu projeto.");
}
require_once $autoloader;

// 2. Carrega as variáveis de ambiente do arquivo .env
try {
    // dirname(__DIR__) é uma forma mais segura de apontar para a raiz do projeto
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    die("Erro: Não foi possível encontrar o arquivo .env. Certifique-se de que ele existe na raiz do projeto e não está no .gitignore do servidor de produção.");
}

// 3. Inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 4. Carrega as classes base do seu Core
require_once dirname(__DIR__) . '/core/Controller.php';
require_once dirname(__DIR__) . '/core/Database.php';
require_once dirname(__DIR__) . '/core/Router.php';

// 5. Autoloader para as classes do seu projeto (namespace App\)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    // Usando dirname(__DIR__) para garantir o caminho correto para a pasta 'app'
    $base_dir = dirname(__DIR__) . '/app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    } else {
        // Se o arquivo não for encontrado, isso pode ajudar a depurar
        // die("Autoloader não encontrou o arquivo: " . $file);
    }
});

// 6. Roteamento
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];

try {
    Router::load(dirname(__DIR__) . '/routes.php')->direct($uri, $method);
} catch (Exception $e) {
    die($e->getMessage());
}
