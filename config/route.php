<?php

// Format : 'METHODE' => [ '/uri' => ['NomController', 'methode'] ]

$routes = [

    'GET' => [
               '/nayloth' => 'AuthController.php',
                       '/admin'   => 'DashboardController.php',
        '/manager' => 'DashboardController.php',
        '/agent'   => 'DashboardController.php',
    ],

    'POST' => [
        '/nayloth' => 'AuthController.php',
    ],

];