<?php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/client.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = str_replace('/NAYLOTH/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

checkUserRole('admin');

// acceuil
if($method === 'GET' && $uri === '/admin/clients'){
    $clients = getAllClients();
    require_once __DIR__ . '/../views/clients_list.php';
}

// create clients
elseif($method === 'GET' && $uri === '/admin/clients/create'){
    require_once __DIR__ . '/../views/clients_create.php';
}
elseif($method === 'POST' && $uri === '/admin/clients/create'){
    if(empty($_POST['nom']) || empty($_POST['siret']) || empty($_POST['contact_email'])){
        $erreur = 'Tous les champs sont obligatoires.';
        require_once __DIR__ . '/../views/clients_create.php';
    } else{
        $nom = $_POST['nom'];
        $siret = $_POST['siret'];
        $contact_email = $_POST['contact_email'];
        createClient($nom, $siret, $contact_email);
        header('Location: /NAYLOTH/public/admin/clients');
        exit;
    }
}

// client specifique
elseif($method === 'GET' && $uri === '/admin/clients/show'){
    $client = getClientById ($_GET['id']);
    if(!$client){
        header('Location: /NAYLOTH/public/admin/clients');
        exit;
    }
    require_once __DIR__ . '/../views/clients_show.php';
}

// edit client
elseif($method === 'GET' && $uri === '/admin/clients/edit'){
    $client = getClientById ($_GET['id']);
    if(!$client){
        header('Location: /NAYLOTH/public/admin/clients');
        exit;
    }
    require_once __DIR__ . '/../views/clients_edit.php';
}
elseif($method === 'POST' && $uri === '/admin/clients/edit'){
    if(empty($_POST['nom']) || empty($_POST['siret']) || empty($_POST['contact_email'])){
        $erreur = 'Tous les champs sont obligatoires.';
        $client = getClientById($_POST['id_client']);
        require_once __DIR__ . '/../views/clients_edit.php';
    } else{
        $id_client = $_POST['id_client'];
        $nom = $_POST['nom'];
        $siret = $_POST['siret'];
        $contact_email = $_POST['contact_email'];
        updateClient ($id_client, $nom, $siret, $contact_email);
        header('Location: /NAYLOTH/public/admin/clients');
        exit;
    }
}

// delete client
elseif($method === 'POST' && $uri === '/admin/clients/delete'){
    deleteClient($_POST['id_client']);
    header('Location: /NAYLOTH/public/admin/clients');
    exit;
}