<?php

session_start();

require_once __DIR__ . '/../config/route.php';
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router($routes);
$router->dispatch();