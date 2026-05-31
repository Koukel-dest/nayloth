<?php

// Format : 'METHODE' => [ '/uri' => ['NomController', 'methode'] ]

$routes = [

    'GET' => [
               '/nayloth' => 'AuthController.php',
                       '/admin'   => 'DashboardController.php',
        '/manager' => 'DashboardController.php',
        '/agent'   => 'DashboardController.php',
        '/agents/ajouter' => 'add_agent.php',
        '/Agents' => 'list_agent.php',
        '/admin/clients' => 'clientcController.php',
        '/admin/clients/create' => 'clientcController.php',
        '/admin/clients/show' => 'clientcController.php',
    ],

    'POST' => [
        '/nayloth' => 'AuthController.php',
        '/admin/clients/create' => 'clientcController.php',
    ],

];