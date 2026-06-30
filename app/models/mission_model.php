<?php
require_once __DIR__ . '/db_connect.php';

function getAgentsDisponibles(): array
{
    global $db;
    $stmt = $db->prepare("
        SELECT u.id_user, u.prenom, u.nom, u.email,
               a.date_entree,
               c.nom AS competence
        FROM `user` u
        LEFT JOIN `agent` a ON a.user_id = u.id_user
        LEFT JOIN `agent_competence` ac ON ac.agent_id = u.id_user
        LEFT JOIN `competence` c ON c.id_competence = ac.competence_id
        WHERE u.u_role = 'agent'
          AND u.id_user NOT IN (
              SELECT agent_id FROM `affectation`
              WHERE statut_affectation = 'active'
                AND (date_fin IS NULL OR date_fin >= CURDATE())
          )
        ORDER BY u.nom ASC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


 
function getAllMissions(): array
{
    global $db;
    $stmt = $db->prepare("
        SELECT af.id_affectation, af.date_debut, af.date_fin, af.statut_affectation,
               u.id_user AS agent_id, u.prenom AS agent_prenom, u.nom AS agent_nom,
               co.titre AS contrat_titre,
               c.nom AS competence
        FROM `affectation` af
        JOIN `user` u ON u.id_user = af.agent_id
        JOIN `contrat` co ON co.id_contrat = af.contrat_id
        LEFT JOIN `agent_competence` ac ON ac.agent_id = u.id_user
        LEFT JOIN `competence` c ON c.id_competence = ac.competence_id
        ORDER BY af.date_debut DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function countMissionsParStatut(): array
{
    global $db;
    $stmt = $db->prepare("
        SELECT statut_affectation, COUNT(*) AS total
        FROM `affectation`
        GROUP BY statut_affectation
    ");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $counts = ['active' => 0, 'terminee' => 0, 'suspendue' => 0];
    foreach ($rows as $row) {
        $counts[$row['statut_affectation']] = $row['total'];
    }
    return $counts;
}

function getMissionsForAgent(string $agent_id): array
{
    global $db;
    $stmt = $db->prepare("
        SELECT a.id_affectation, a.date_debut, a.date_fin, a.statut_affectation,
               c.titre AS contrat_titre, cl.nom AS client_nom
        FROM `affectation` a
        JOIN `contrat` c ON c.id_contrat = a.contrat_id
        LEFT JOIN `client` cl ON cl.id_client = c.client_id
        WHERE a.agent_id = :agent_id
          AND a.statut_affectation IN ('en_attente', 'active', 'refusee')
        ORDER BY a.date_debut DESC, a.id_affectation DESC
    ");
    $stmt->execute([':agent_id' => $agent_id]);
    $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($missions as &$mission) {
        if (empty($mission['client_nom'])) {
            $mission['client_nom'] = 'Client inconnu';
        }
    }

    return $missions;
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
