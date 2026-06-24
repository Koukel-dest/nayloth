<?php
require_once __DIR__ . "/db_connect.php";

//sert a selectionner tout les devis sur un contrat
function getAllDevis ($contrat_id){
    global $db;
    $stmt = $db->prepare("SELECT `id_devis`, `montant_ht`, `statut_devis`, `cree_le`, `contrat_id`
    FROM devis WHERE `contrat_id` = :contrat_id");
    $stmt->execute([':contrat_id' => $contrat_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDevisById ($id_devis){
    global $db;
    $stmt = $db->prepare("SELECT * FROM devis WHERE `id_devis` = :id_devis");
    $stmt->execute([':id_devis' => $id_devis]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createDevis ($montant_ht, $contrat_id){
    global $db;
    $id = sprintf(
        '%08x-%04x-%04x-%04x-%012x',
        random_int(0, 0xffffffff),
        random_int(0, 0xffff),
        random_int(0x4000, 0x4fff),
        random_int(0x8000, 0xbfff),
        random_int(0, 0xffffffffffff)
    );
    $stmt = $db->prepare("INSERT INTO `devis` 
    (`id_devis`, `montant_ht`, `statut_devis`, `contrat_id`)
    VALUES (:id, :montant_ht, :statut_devis, :contrat_id)");
    $stmt->execute([
        ':id' => $id,
        ':montant_ht' => $montant_ht,
        ':statut_devis' => 'en_attente',
        ':contrat_id' => $contrat_id
    ]);
    return $id;
}

function updateDevis ($id_devis, $montant_ht, $statut_devis){
    global $db;
    $stmt = $db->prepare("UPDATE `devis` 
        SET `montant_ht` = :montant_ht,
        `statut_devis` = :statut_devis
        WHERE `id_devis` = :id_devis");
    $stmt->execute([
        ':id_devis' => $id_devis,
        ':montant_ht' => $montant_ht,
        ':statut_devis' => $statut_devis,
    ]);
}