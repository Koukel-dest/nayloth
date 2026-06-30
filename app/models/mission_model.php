<?php

 
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