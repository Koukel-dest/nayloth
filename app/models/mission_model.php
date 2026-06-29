<?php
require_once __DIR__ . "/db_connect.php";

function getMissionsForAgent(string $agent_id): array
{
    global $db;
    $stmt = $db->prepare("
        SELECT a.id_affectation, a.date_debut, a.date_fin, a.statut_affectation,
               c.titre AS contrat_titre, cl.nom AS client_nom
        FROM `affectation` a
        JOIN `contrat` c ON c.id_contrat = a.contrat_id
        JOIN `client` cl ON cl.id_client = c.client_id
        WHERE a.agent_id = :agent_id
        ORDER BY a.date_debut DESC
    ");
    $stmt->execute([':agent_id' => $agent_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateMissionStatus(string $id_affectation, string $agent_id, string $statut): bool
{
    global $db;
    $stmt = $db->prepare("
        UPDATE `affectation`
        SET `statut_affectation` = :statut
        WHERE `id_affectation` = :id AND `agent_id` = :agent_id
    ");
    return $stmt->execute([
        ':statut'   => $statut,
        ':id'       => $id_affectation,
        ':agent_id' => $agent_id
    ]);
}
