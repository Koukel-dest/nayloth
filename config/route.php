<?php

// Format : 'METHODE' => [ '/uri' => ['NomController', 'methode'] ]

$routes = [

    'GET' => [
               '/nayloth' => 'AuthController.php',
                       '/admin'   => 'DashboardController.php',
        '/manager' => 'DashboardController.php',
        '/agent'   => 'DashboardController.php',
        '/ajouter_agent' => 'add_agent.php',
        '/Agents' => 'read_agent.php',
        '/profil_agent' => 'profil_agent.php',
        '/delete_agent' => 'delete_agent.php',
        '/logout' => 'deconnexion.php',
    ],

    'POST' => [
        '/nayloth' => 'AuthController.php',
        '/ajouter_agent' => 'add_agent.php',
    ],

];