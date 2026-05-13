<?php

require_once __DIR__ . '/../models/Utilisateur.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['pwd'])) {

    $email = $_POST['email'];
    $pwd   = $_POST['pwd'];

    
    $user = findUserByEmail($email);


    if ($user && password_verify($pwd, $user['pwd'])) {

        $_SESSION['user_id']     = $user['id_user'];
        $_SESSION['user_role']   = $user['u_role'];
        $_SESSION['user_nom']    = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];

        if ($user['u_role'] === 'admin') {
            header('Location: /dashboard/admin');
            exit;
        } elseif ($user['u_role'] === 'manager') {
            header('Location: /dashboard/manager');
            exit;
        } elseif ($user['u_role'] === 'agent') {
            header('Location: /dashboard/agent');
            exit;
        }

    }

    $_SESSION['erreur'] = "Email ou mot de passe incorrect";
    header('Location: /authviews');
    exit;
}