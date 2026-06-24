<?php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/contrat.php';
require_once __DIR__ . '/../models/devis.php';
require_once __DIR__ . '/../models/client.php';
require_once __DIR__ . '/../helpers/pdf.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = str_replace('/NAYLOTH/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

checkUserRole('admin');

//create devis
if($method === 'GET' && $uri === '/admin/contrat/devis/create'){
    $contrat = getContratById($_GET['contrat_id']);
    $contrat_id = $_GET['contrat_id'];
    if(!$contrat){
        header('Location: /NAYLOTH/public/admin/contrat/show?id=' . $contrat_id);
        exit;
    } elseif($contrat['statut_contrat'] <> 'en_attente'){
        header('Location: /NAYLOTH/public/admin/contrat/show?id=' . $contrat_id);
        exit;
    }
    require_once __DIR__ . '/../views/devis_create.php';
}
elseif($method === 'POST' && $uri === '/admin/contrat/devis/create'){
    $contrat = getContratById($_POST['contrat_id']);
    $contrat_id = $_POST['contrat_id'];
    if($contrat['statut_contrat'] <> 'en_attente'){
        $erreur = "Ce contrat n'accepte pas de devis";
        require_once __DIR__ . '/../views/devis_create.php';
    } elseif(empty($_POST['montant_ht'])){
        $erreur = 'Tous les champs sont obligatoires.';
        require_once __DIR__ . '/../views/devis_create.php';
    } else{
        $montant_ht = $_POST['montant_ht'];

        $id_devis = createDevis($montant_ht, $contrat_id);
        $devis = getDevisById($id_devis);
        $client = getClientById($contrat['client_id']);
        ob_start();
        require_once __DIR__ . '/../templates/devis_pdf.php';
        $html = ob_get_clean();
        generatePdf($html, 'devis_' . $id_devis . '.pdf');

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
    } elseif($devis['statut_devis'] <> 'en_attente'){
        header('Location: /NAYLOTH/public/admin/contrat/show?id=' . $devis['contrat_id']);
        exit;
    }
    require_once __DIR__ . '/../views/devis_edit.php';
}
elseif($method === 'POST' && $uri === '/admin/contrat/devis/edit'){
    $contrat = getContratById($_POST['contrat_id']);
    $devis = getDevisById($_POST['id_devis']);
    if($devis['statut_devis'] <> 'en_attente'){
        header('Location: /NAYLOTH/public/admin/contrat/show?id=' . $devis['contrat_id']);
        exit;
    } elseif(empty($_POST['montant_ht'])){
        $erreur = 'Tous les champs sont obligatoires.';
        require_once __DIR__ . '/../views/devis_edit.php';
    } else{
        $id_devis = $_POST['id_devis'];
        $montant_ht = $_POST['montant_ht'];
        $statut_devis = $_POST['statut_devis'];
        $contrat_id = $_POST['contrat_id'];

        updateDevis($id_devis, $montant_ht, $statut_devis);

        if($statut_devis === 'accepte'){
            $devis = getDevisById($id_devis);
            $contrat = getContratById($contrat_id);
            $client = getClientById($contrat['client_id']);
            $manager = getManagerById($contrat['manager_id']);
            ob_start();
            require_once __DIR__ . '/../templates/contrat_pdf.php';
            $html = ob_get_clean();
            generatePdf($html, 'contrat_' . $contrat_id . '.pdf');
        }

        header('Location: /NAYLOTH/public/admin/contrat/show?id=' . $contrat_id);
        exit;
    }
}