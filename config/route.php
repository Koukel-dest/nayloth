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

        // route contrat + devis
        '/admin/contrat' => 'contratController.php',
        '/admin/contrat/create' => 'contratController.php',
        '/admin/contrat/show' => 'contratController.php',
        '/admin/contrat/edit' => 'contratController.php',
        '/admin/contrat/devis/create' => 'devisController.php',
        '/admin/contrat/devis/edit' => 'devisController.php',
    ],

    'POST' => [
        '/nayloth' => 'AuthController.php',
        '/admin/clients/create' => 'clientController.php',
        '/admin/clients/edit'   => 'clientController.php',
        '/admin/clients/delete' => 'clientController.php',
        '/ajouter_agent' => 'add_agent.php',

        // route contrat + devis
        '/admin/contrat/create' => 'contratController.php',
        '/admin/contrat/edit' => 'contratController.php',
        '/admin/contrat/devis/create' => 'devisController.php',
        '/admin/contrat/devis/edit' => 'devisController.php',
    ],

];