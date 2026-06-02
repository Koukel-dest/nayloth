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
        '/admin/clients'        => 'clientController.php',
        '/admin/clients/create' => 'clientController.php',
        '/admin/clients/show'   => 'clientController.php',
        '/admin/clients/edit'   => 'clientController.php',
    ],

    'POST' => [
        '/nayloth' => 'AuthController.php',
        '/admin/clients/create' => 'clientController.php',
        '/admin/clients/edit'   => 'clientController.php',
        '/admin/clients/delete' => 'clientController.php',
    ],

];