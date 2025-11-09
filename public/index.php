<?php
// public/index.php

ini_set('display_errors', 1);
error_reporting(E_ALL);


$autoloader = __DIR__ . '/../vendor/autoload.php';
$functions = __DIR__ . '/../functions.php';

if (!file_exists($autoloader)) {
    die("Erro: As dependências do Composer não foram encontradas. Rode 'composer install' na raiz do seu projeto.");
}
require_once $autoloader;
require_once $functions;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    die("Erro: Não foi possível encontrar o arquivo .env. Certifique-se de que ele existe na raiz do projeto e não está no .gitignore do servidor de produção.");
}

// Inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carrega as classes base
require_once dirname(__DIR__) . '/core/Controller.php';
require_once dirname(__DIR__) . '/core/Database.php';
require_once dirname(__DIR__) . '/core/Router.php';

// Autoloader para as classes do seu projeto (namespace App\)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
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
        // die("Autoloader não encontrou o arquivo: " . $file);
    }
});

// Roteamento
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];

try {
    Router::load(dirname(__DIR__) . '/routes.php')->direct($uri, $method);
} catch (Exception $e) {
    die($e->getMessage());
}
