<?php
require_once __DIR__ . "/db_connect.php";

function findUserByEmail(string $email): array|false {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `user` WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}