<?php
require_once __DIR__ . "/db_connect.php";

function findUserByEmail(string $email): array|false {
    global $db;
    var_dump($db);
    $stmt = $db->prepare("SELECT * FROM `user` WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function checkUserRole (string $u_role){ // function permettant de bloquer les acces si le user n'est pas le bon
    if(!isset($_SESSION['user_role']) || $u_role != $_SESSION['user_role']){
        header('Location: /NAYLOTH/public/nayloth');
        exit();
    }
}

function getManagerById ($id_user){
    global $db;
    $stmt = $db->prepare("SELECT `id_user`, `prenom`,
    `nom`, `u_role` FROM `user` WHERE `id_user` = :id_user
    AND `u_role` = :u_role");
    $stmt->execute([':id_user' => $id_user, ':u_role' => 'manager']);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllManagers (){
    global $db;
    $stmt = $db->prepare("SELECT `id_user`, `prenom`,
    `nom`, `u_role` FROM `user` WHERE `u_role` = :u_role");
    $stmt->execute([':u_role' => 'manager']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}