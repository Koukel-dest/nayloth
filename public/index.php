<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../env.php';
require_once __DIR__ . '/../app/models/db_connect.php';
require_once __DIR__ . '/../config/route.php';
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router($routes);
$router->dispatch();