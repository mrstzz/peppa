<?php
// config/database.php

/**
 * Função simples para carregar variáveis de ambiente de um arquivo .env
 * sem a necessidade do Composer/vendor.
 *
 * @param string $path O caminho para o diretório que contém o arquivo .env
 */
function loadEnv($path) {
    $envFile = $path . '/.env';
    if (!file_exists($envFile)) {
        // Se o arquivo .env não existir, não faz nada.
        return;
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignora linhas que são comentários
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Separa a linha em nome e valor
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Remove aspas do início e do fim do valor, se houver
        if (substr($value, 0, 1) == '"' && substr($value, -1) == '"') {
            $value = substr($value, 1, -1);
        }

        // Define as variáveis de ambiente para a sessão atual
        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

// Carrega as variáveis de ambiente do arquivo .env que está na raiz do projeto
loadEnv(__DIR__ . '/../');

// Define as constantes de conexão a partir das variáveis de ambiente
// A função getenv() lê as variáveis que carregamos com putenv()
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'seu_banco');
