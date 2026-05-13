<?php

// Format : 'METHODE' => [ '/uri' => ['NomController', 'methode'] ]

$routes = [

    'GET' => [
        '/'                  => ['AuthController', 'showLogin'],
        '/login'             => ['AuthController', 'showLogin'],
        '/logout'            => ['AuthController', 'logout'],

        // Dashboards (à remplir quand les controllers seront créés)
        '/dashboard/admin'   => ['DashboardController', 'admin'],
        '/dashboard/manager' => ['DashboardController', 'manager'],
        '/dashboard/agent'   => ['DashboardController', 'agent'],
    ],

    'POST' => [
        '/login'             => ['AuthController', 'login'],
    ],

];