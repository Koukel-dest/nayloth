<?php
require_once __DIR__ . '/../models/agent_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 var_dump($_POST);
    $prenom      = $_POST['prenom']      ?? '';
    $nom         = $_POST['nom']         ?? '';
    $email       = $_POST['email']       ?? '';
    $pwd         = $_POST['pwd']         ?? '';
    $pwd_confirm = $_POST['pwd_confirm'] ?? '';
    $liste_competences = $_POST['competences'] ?? [];

    if (empty($prenom) || empty($nom) || empty($email) || empty($pwd)) {
        $_SESSION['erreur'] = "Tous les champs obligatoires doivent être remplis.";
        header('Location: /NAYLOTH/public/ajouter_agent');
        exit;
    }

    if ($pwd !== $pwd_confirm) {
        $_SESSION['erreur'] = "Les mots de passe ne correspondent pas.";
        header('Location: /NAYLOTH/public/ajouter_agent');
        exit;
    }


    $competences = $_POST['competences'] ?? [];

    if (addAgent($prenom, $nom, $email, $pwd, 
             $_POST['telephone'] ?? '', 
             $_POST['date_entree'] ?? '', 
             $_POST['notes'] ?? '', 
             $competences)) {
        $_SESSION['succes'] = "Agent créé avec succès.";
        header('Location: /NAYLOTH/public/agents');
        exit;
    } else {
        $_SESSION['erreur'] = "Erreur lors de la création de l'agent.";
        header('Location: /NAYLOTH/public/ajouter_agent');
        exit;
    }

} else {
  $competences = getAllCompetences();
    require_once __DIR__ . '/../views/ajouter_agent.php';
}