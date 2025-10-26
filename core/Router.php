<?php
// core/Router.php

class Router {
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file) {
        $router = new static;
        require $file;
        return $router;
    }

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType) {
        foreach ($this->routes[$requestType] as $route => $controllerAction) {
            $pattern = "#^" . $route . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                
                list($controller, $action) = explode('@', $controllerAction);

                // Chamamos a função passando os argumentos na ordem correta.
                return $this->callAction($controller, $action, $matches);
            }
        }

        throw new Exception('Nenhuma rota definida para esta URI.');
    }

    protected function callAction($controller, $action, $params = []) {
        $controllerClass = "App\\Controllers\\{$controller}";
        $controllerInstance = new $controllerClass;
        
        if (!method_exists($controllerInstance, $action)) {
            throw new Exception(
                "O controller {$controller} não responde à action {$action}."
            );
        }

        return $controllerInstance->$action(...$params);
    }
}
