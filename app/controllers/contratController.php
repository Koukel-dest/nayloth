<?php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/contrat.php';
require_once __DIR__ . '/../models/client.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = str_replace('/NAYLOTH/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

checkUserRole('admin');

// acceuil contrat
if($method === 'GET' && $uri === '/admin/contrat'){
    $contrats = getAllContrat();
    require_once __DIR__ . '/../views/contrats_list.php';
}

// create contrat
elseif($method === 'GET' && $uri === '/admin/contrat/create'){
    $clients = getAllClients();
    $managers = getAllManagers();
    require_once __DIR__ . '/../views/contrats_create.php';
}
elseif($method === 'POST' && $uri === '/admin/contrat/create'){
    if(empty($_POST['titre']) || empty($_POST['quota_agents']) ||
    empty($_POST['date_debut'])){
        $erreur = 'Tous les champs sont obligatoires.';
        $clients = getAllClients();
        $managers = getAllManagers();
        require_once __DIR__ . '/../views/contrats_create.php';
    } else{
        $titre = $_POST['titre'];
        $quota_agents = $_POST['quota_agents'];
        $date_debut = $_POST['date_debut'];
        $client_id = $_POST['client_id'];
        $admin_id = $_SESSION['user_id'];
        $manager_id = $_POST['manager_id'];

        createContrat($titre, $quota_agents, $date_debut, $client_id, $admin_id, $manager_id);
        header('Location: /NAYLOTH/public/admin/contrat');
        exit;
    }
}

// show contrat
elseif($method === 'GET' && $uri === '/admin/contrat/show'){
    $contrat = getContratById($_GET['id']);
    if(!$contrat){
        header('Location: /NAYLOTH/public/admin/contrat');
        exit;
    }
    $devis = getAllDevis($_GET['id']);
    $manager = getManagerById($contrat['manager_id']);
    require_once __DIR__ . '/../views/contrats_show.php';
}

// edit contrat
elseif($method === 'GET' && $uri === '/admin/contrat/edit'){
    $contrat = getContratById($_GET['id']);
    if(!$contrat){
        header('Location: /NAYLOTH/public/admin/contrat');
        exit;
    }
    $clients = getAllClients();
    $managers = getAllManagers();
    require_once __DIR__ . '/../views/contrats_edit.php';
}
elseif($method === 'POST' && $uri === '/admin/contrat/edit'){
    $contrat = getContratById($_POST['id_contrat']);
    if(empty($_POST['titre']) || empty($_POST['quota_agents']) ||
    empty($_POST['date_debut'])){
        $erreur = 'Tous les champs sont obligatoires.';
        $clients = getAllClients();
        $managers = getAllManagers();
        require_once __DIR__ . '/../views/contrats_edit.php';
    } else{
        $id_contrat = $contrat['id_contrat'];
        $titre = $_POST['titre'];
        $statut_contrat = $_POST['statut_contrat'];
        $quota_agents = $_POST['quota_agents'];
        $date_debut = $_POST['date_debut'];
        $client_id = $_POST['client_id'];
        $manager_id = $_POST['manager_id'];

        updateContrat($id_contrat, $titre, $statut_contrat, $quota_agents, $date_debut, $client_id, $manager_id);
        header('Location: /NAYLOTH/public/admin/contrat/show?id=' . $id_contrat);
        exit;
    }
}