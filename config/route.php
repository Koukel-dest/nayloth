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
        '/ajouter_agent' => 'add_agent.php',
        '/Agents' => 'read_agent.php',
        '/profil_agent' => 'profil_agent.php',
        '/delete_agent' => 'delete_agent.php',
        '/logout' => 'deconnexion.php',
        '/missions' => 'missions.php',
        '/mot-de-passe-oublie' => 'forgot_password.php',
        '/reinitialiser-mot-de-passe' => 'reset_password.php',
    ],

    'POST' => [
        '/nayloth' => 'AuthController.php',
        '/admin/clients/create' => 'clientController.php',
        '/admin/clients/edit'   => 'clientController.php',
        '/admin/clients/delete' => 'clientController.php',
        '/ajouter_agent' => 'add_agent.php',
        '/missions' => 'missions.php',
        '/mot-de-passe-oublie' => 'forgot_password.php',
        '/reinitialiser-mot-de-passe' => 'reset_password.php',
    ],

];