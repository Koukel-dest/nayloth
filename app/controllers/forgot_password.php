<?php
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/reset_token.php';
require_once __DIR__ . '/../models/mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {

    $email = $_POST['email'];
    $user = findUserByEmail($email);

    if ($user) {
        $token = generateResetToken($email);
        $lien = "http://localhost/NAYLOTH/public/reinitialiser-mot-de-passe?token=" . $token;

        $sujet = "Réinitialisation de votre mot de passe Nayloth";
        $corps = "Bonjour,\n\n"
               . "Vous avez demandé la réinitialisation de votre mot de passe.\n"
               . "Cliquez sur ce lien pour choisir un nouveau mot de passe (valable 30 minutes) :\n"
               . "$lien\n\n"
               . "Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.";

        sendMail($email, $sujet, $corps);
    }

    // Message identique que l'email existe ou non, pour ne pas révéler les comptes existants.
    $_SESSION['info'] = "Si cet email correspond à un compte, un lien de réinitialisation vient d'être envoyé.";
    header('Location: /NAYLOTH/public/mot-de-passe-oublie');
    exit;

} else {
    require_once __DIR__ . '/../views/forgot_password_view.php';
}
