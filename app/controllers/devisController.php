<?php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/contrat.php';
require_once __DIR__ . '/../models/devis.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = str_replace('/NAYLOTH/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

checkUserRole('admin');

//create devis
if($method === 'GET' && $uri === '/admin/contrat/devis/create'){
    $contrat = getContratById($_GET['contrat_id']);
    if(!$contrat){
        header('Location: /NAYLOTH/public/admin/contrat/show');
        exit;
    }
    require_once __DIR__ . '/../views/devis_create.php';
}
elseif($method === 'POST' && $uri === '/admin/contrat/devis/create'){
    $contrat = getContratById($_POST['contrat_id']);
    if(empty($_POST['montant_ht'])){
        $erreur = 'Tous les champs sont obligatoires.';
        require_once __DIR__ . '/../views/devis_create.php';
    } else{
        $montant_ht = $_POST['montant_ht'];
        $contrat_id = $_POST['contrat_id'];

        createDevis($montant_ht, $contrat_id);
        header('Location: /NAYLOTH/public/admin/contrat/show?id=' . $contrat_id);
        exit;
    }
}

//edit devis
elseif($method === 'GET' && $uri === '/admin/contrat/devis/edit'){
    $devis = getDevisById($_GET['id']);
    $contrat = getContratById($devis['contrat_id']);
    if(!$contrat){
        header('Location: /NAYLOTH/public/admin/contrat');
        exit;
    }
    require_once __DIR__ . '/../views/devis_edit.php';
}
elseif($method === 'POST' && $uri === '/admin/contrat/devis/edit'){
    $contrat = getContratById($_POST['contrat_id']);
    $devis = getDevisById($_POST['id_devis']);
    if(empty($_POST['montant_ht'])){
        $erreur = 'Tous les champs sont obligatoires.';
        require_once __DIR__ . '/../views/devis_edit.php';
    } else{
        $id_devis = $_POST['id_devis'];
        $montant_ht = $_POST['montant_ht'];
        $statut_devis = $_POST['statut_devis'];
        $contrat_id = $_POST['contrat_id'];

        updateDevis($id_devis, $montant_ht, $statut_devis);
        header('Location: /NAYLOTH/public/admin/contrat/show?id=' . $contrat_id);
        exit;
    }
}