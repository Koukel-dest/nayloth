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
        '/admin/pdf' => 'pdfController.php',
        '/profil_agent' => 'profil_agent.php',
        '/delete_agent' => 'delete_agent.php',
        '/ajouter_affectation' => 'add_affectation.php',
        '/logout' => 'deconnexion.php',
        '/affectations' => 'read_affectation.php',
        '/affectation_detail' => 'affectation_detail_contr.php',
        '/delete_affectation' => 'delete_affectation.php',
        '/missions' => 'missions.php',
        '/mot-de-passe-oublie' => 'forgot_password.php',
        '/reinitialiser-mot-de-passe' => 'reset_password.php',
        '/agents_disponibles' => 'agent_disponibles.php',
        '/suivi_missions'     => 'suivi_missions.php',
        
    ],

    'POST' => [
        '/nayloth' => 'AuthController.php',
        '/admin/clients/create' => 'clientController.php',
        '/admin/clients/edit'   => 'clientController.php',
        '/admin/clients/delete' => 'clientController.php',
        '/ajouter_agent' => 'add_agent.php',
        '/ajouter_affectation' => 'add_affectation.php',
        
        '/missions' => 'missions.php',

        // route contrat + devis
        '/admin/contrat/create' => 'contratController.php',
        '/admin/contrat/edit' => 'contratController.php',
        '/admin/contrat/devis/create' => 'devisController.php',
        '/admin/contrat/devis/edit' => 'devisController.php',
        '/mot-de-passe-oublie' => 'forgot_password.php',
        '/reinitialiser-mot-de-passe' => 'reset_password.php',
    ],

];