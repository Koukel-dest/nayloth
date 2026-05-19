<?php

// Format : 'METHODE' => [ '/uri' => ['NomController', 'methode'] ]

$routes = [

    'GET' => [
               '/login' => 'AuthController.php',
                       '/admin'   => 'DashboardController.php',
        '/manager' => 'DashboardController.php',
        '/agent'   => 'DashboardController.php',
    ],

    'POST' => [
        '/login' => 'AuthController.php',
    ],

];