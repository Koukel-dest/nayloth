<?php
require_once __DIR__ . '/../models/affectation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $agent_id   = $_POST['agent_id']   ?? '';
    $contrat_id = $_POST['contrat_id'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin   = $_POST['date_fin']   ?? '';
    $statut     = $_POST['statut']     ?? '';
    $manager_id = $_SESSION['user_id'];

    if (empty($agent_id) || empty($contrat_id) || empty($date_debut) || empty($statut)) {
        $_SESSION['erreur'] = "Tous les champs obligatoires doivent être remplis.";
        header('Location: /NAYLOTH/public/ajouter_affectation');
        exit;
    }

        if (!isAgentDisponible($agent_id, $date_debut, $date_fin)) {
    $_SESSION['erreur'] = "Cet agent est déjà affecté sur cette période.";
    header('Location: /NAYLOTH/public/ajouter_affectation');
    exit;
}

if (!isQuotaDisponible($contrat_id)) {
    $_SESSION['erreur'] = "Le quota d'agents pour ce contrat est atteint.";
    header('Location: /NAYLOTH/public/ajouter_affectation');
    exit;
}


    if (addAffectation($agent_id, $contrat_id, $manager_id, $date_debut, $date_fin, $statut)) {
        $_SESSION['succes'] = "Affectation créée avec succès.";
        header('Location: /NAYLOTH/public/affectations');
        exit;
    } else {
        $_SESSION['erreur'] = "Erreur lors de la création de l'affectation.";
        header('Location: /NAYLOTH/public/ajouter_affectation');
        exit;
    }

} else {
    $agents   = getAllAgentsForSelect();
    $contrats = getAllContratsForSelect();
    require_once __DIR__ . '/../views/add_affectation_view.php';
}