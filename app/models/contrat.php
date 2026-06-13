<?php
require_once __DIR__ . "/db_connect.php";

function getAllContrat (){
    global $db;
    $stmt = $db->query("SELECT `id_contrat`, `titre`, `statut_contrat`,
    client.nom FROM `contrat`
    INNER JOIN `client`
    ON client.id_client = contrat.client_id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getContratById ($id_contrat){
    global $db;
    $stmt = $db->prepare("SELECT * FROM contrat WHERE `id_contrat` = :id_contrat");
    $stmt->execute([':id_contrat' => $id_contrat]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createContrat ($titre, $quota_agents, $date_debut, $client_id, $admin_id, $manager_id){
    global $db;
    $id = sprintf(
        '%08x-%04x-%04x-%04x-%012x',
        random_int(0, 0xffffffff),
        random_int(0, 0xffff),
        random_int(0x4000, 0x4fff),
        random_int(0x8000, 0xbfff),
        random_int(0, 0xffffffffffff)
    );
    $stmt = $db->prepare("INSERT INTO `contrat`
    (`id_contrat`, `titre`, `statut_contrat`, `quota_agents`,
    `date_debut`, `client_id`, `admin_id`, `manager_id`)
    VALUES (:id, :titre, :statut_contrat, :quota_agents, :date_debut,
    :client_id, :admin_id, :manager_id)");
    $stmt->execute([
        ':id' => $id,
        ':titre' => $titre,
        ':statut_contrat' => 'en_attente',
        ':quota_agents' => $quota_agents,
        ':date_debut' => $date_debut,
        ':client_id' => $client_id,
        ':admin_id' => $admin_id,
        ':manager_id' => $manager_id
    ]);
}

function updateContrat ($id_contrat, $titre, $statut_contrat, $quota_agents, $date_debut, $client_id, $manager_id){
    global $db;
    $stmt = $db->prepare("UPDATE `contrat` 
        SET `titre` = :titre,
        `statut_contrat` = :statut_contrat,
        `quota_agents` = :quota_agents,
        `date_debut` = :date_debut,
        `client_id` = :client_id,
        `manager_id` = :manager_id
        WHERE `id_contrat` = :id_contrat");
    $stmt->execute([
        ':id_contrat' => $id_contrat,
        ':titre' => $titre,
        ':statut_contrat' => $statut_contrat,
        ':quota_agents' => $quota_agents,
        ':date_debut' => $date_debut,
        ':client_id' => $client_id,
        ':manager_id' => $manager_id
    ]);
}