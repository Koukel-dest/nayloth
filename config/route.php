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
        '/ajouter_affectation' => 'add_affectation.php',
        '/logout' => 'deconnexion.php',
        '/affectations' => 'read_affectation.php',
        '/affectation_detail' => 'affectation_detail_contr.php',
        '/delete_affectation' => 'delete_affectation.php',
    ],

    'POST' => [
        '/nayloth' => 'AuthController.php',
        '/admin/clients/create' => 'clientController.php',
        '/admin/clients/edit'   => 'clientController.php',
        '/admin/clients/delete' => 'clientController.php',
        '/ajouter_agent' => 'add_agent.php',
        '/ajouter_affectation' => 'add_affectation.php',
        
    ],

];