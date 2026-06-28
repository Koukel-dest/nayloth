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

        require_once __DIR__ . '/../models/mailer.php';
        $sujet = "Bienvenue chez Nayloth - vos identifiants";
        $corps = "Bonjour $prenom,\n\n"
               . "Votre compte agent a été créé.\n"
               . "Email : $email\n"
               . "Mot de passe : $pwd\n\n"
               . "Connectez-vous sur la plateforme Nayloth.";

        if (sendMail($email, $sujet, $corps)) {
            $_SESSION['succes'] = "Agent créé avec succès. Un email avec ses identifiants lui a été envoyé.";
        } else {
            $_SESSION['succes'] = "Agent créé avec succès, mais l'email n'a pas pu être envoyé.";
        }

        header('Location: /NAYLOTH/public/Agents');
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