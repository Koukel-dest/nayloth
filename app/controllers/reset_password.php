<?php
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/reset_token.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token       = $_POST['token']       ?? '';
    $pwd         = $_POST['pwd']         ?? '';
    $pwd_confirm = $_POST['pwd_confirm'] ?? '';

    $email = verifyResetToken($token);

    if (!$email) {
        $_SESSION['erreur'] = "Le lien de réinitialisation est invalide ou a expiré.";
        header('Location: /NAYLOTH/public/mot-de-passe-oublie');
        exit;
    }

    if (empty($pwd) || $pwd !== $pwd_confirm) {
        $_SESSION['erreur'] = "Les mots de passe ne correspondent pas.";
        header('Location: /NAYLOTH/public/reinitialiser-mot-de-passe?token=' . urlencode($token));
        exit;
    }

    updateUserPassword($email, password_hash($pwd, PASSWORD_BCRYPT));

    $_SESSION['succes'] = "Votre mot de passe a été modifié. Vous pouvez vous connecter.";
    header('Location: /NAYLOTH/public/nayloth');
    exit;

} else {

    $token = $_GET['token'] ?? '';
    $email = verifyResetToken($token);

    if (!$email) {
        $_SESSION['erreur'] = "Le lien de réinitialisation est invalide ou a expiré.";
        header('Location: /NAYLOTH/public/mot-de-passe-oublie');
        exit;
    }

    require_once __DIR__ . '/../views/reset_password_view.php';
}
