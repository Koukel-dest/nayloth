<?php

class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = str_replace('/NAYLOTH/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $uri = rtrim($uri, '/') ?: '/';

        if (!isset($this->routes[$method][$uri])) {
            $this->abort(404);
            return;
        }

        $controllerFile = $this->routes[$method][$uri];
        $controllerPath = __DIR__ . '/../controllers/' . $controllerFile;

        if (!file_exists($controllerPath)) {
            $this->abort(500, "Contrôleur introuvable : $controllerFile");
            return;
        }

        require_once $controllerPath;
    }

    private function abort(int $code, string $message = ''): void
    {
        http_response_code($code);
        $messages = [
            404 => 'Page introuvable.',
            500 => 'Erreur serveur : ' . $message,
        ];
        echo $messages[$code] ?? 'Erreur inconnue.';
        exit;
    }
}