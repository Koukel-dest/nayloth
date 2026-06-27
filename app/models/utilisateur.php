<?php
require_once __DIR__ . "/db_connect.php";

function findUserByEmail(string $email): array|false {
    global $db;
    var_dump($db);
    $stmt = $db->prepare("SELECT * FROM `user` WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserPassword(string $email, string $hashedPwd): bool {
    global $db;
    $stmt = $db->prepare("UPDATE `user` SET pwd = :pwd WHERE email = :email");
    return $stmt->execute([':pwd' => $hashedPwd, ':email' => $email]);
}

function checkUserRole (string $u_role){ // function permettant de bloquer les acces si le user n'est pas le bon
    if(!isset($_SESSION['user_role']) || $u_role != $_SESSION['user_role']){
        header("HTTP/1.1 403 Forbidden");
        exit();
    }
}