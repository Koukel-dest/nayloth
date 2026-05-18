<?php

// Format : 'METHODE' => [ '/uri' => ['NomController', 'methode'] ]

$routes = [

    'GET' => [
               '/login' => 'AuthController.php'
    ],

    'POST' => [
        '/login' => 'AuthController.php',
    ],

];