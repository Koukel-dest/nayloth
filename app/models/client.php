<?php
require_once __DIR__ . "/db_connect.php";

function getAllClients (){
    global $db;
    $stmt = $db->query("SELECT `id_client`, `nom`, `siret`, `contact_email` FROM client");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getClientById ($id_client){
    global $db;
    $stmt = $db->prepare("SELECT * FROM client WHERE `id_client` = :id_client");
    $stmt->execute([':id_client' => $id_client]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createClient ($nom, $siret, $contact_email){
    global $db;
    $id = sprintf(
        '%08x-%04x-%04x-%04x-%012x',
        random_int(0, 0xffffffff),
        random_int(0, 0xffff),
        random_int(0x4000, 0x4fff),
        random_int(0x8000, 0xbfff),
        random_int(0, 0xffffffffffff)
    );
    $stmt = $db->prepare("INSERT INTO `client` (`id_client`, `nom`, `siret`, `contact_email`)
    VALUES (:id, :nom, :siret, :contact_email)");
    $stmt->execute([
        ':id' => $id, 
        ':nom' => $nom, 
        ':siret' => $siret, 
        ':contact_email' => $contact_email
    ]);
}

function updateClient ($id_client, $nom, $siret, $contact_email){
    global $db;
    $stmt = $db->prepare("UPDATE `client` 
        SET `nom` = :nom,
        `siret` = :siret,
        `contact_email` = :contact_email
        WHERE `id_client` = :id_client;
    ");
    $stmt->execute([
        ':id_client' => $id_client,
        ':nom' => $nom, 
        ':siret' => $siret, 
        ':contact_email' => $contact_email
    ]);
}

function deleteClient ($id_client){
    global $db;
    $stmt = $db->prepare("DELETE FROM `client` WHERE `id_client` = :id_client");
    $stmt->execute([':id_client' => $id_client]);
}