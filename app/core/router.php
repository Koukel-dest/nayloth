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
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uri = rtrim($uri, '/') ?: '/';

        if (!isset($this->routes[$method][$uri])) {
            $this->abort(404);
            return;
        }

        [$controllerName, $action] = $this->routes[$method][$uri];

        $controllerPath = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerPath)) {
            $this->abort(500, "Contrôleur introuvable : $controllerName");
            return;
        }

        require_once $controllerPath;

        if (!class_exists($controllerName)) {
            $this->abort(500, "Classe introuvable : $controllerName");
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            $this->abort(500, "Méthode introuvable : $controllerName::$action");
            return;
        }

        $controller->$action();
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