<?php
require_once __DIR__ . "/db_connect.php";

function getAllAgents(): array
{
    global $pdo;
    $stmt = $pdo->query("SELECT id, name, email FROM agents");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}