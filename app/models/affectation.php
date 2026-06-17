<?php
require_once __DIR__ . "/db_connect.php";
require_once __DIR__ . '/agent_model.php';
function getAllAgentsForSelect(): array
{
    global $db;
    $stmt = $db->prepare("SELECT id_user, prenom, nom FROM `user` WHERE u_role = 'agent'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllContratsForSelect(): array
{
    global $db;
    $stmt = $db->prepare("SELECT id_contrat, titre FROM `contrat`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addAffectation(string $agent_id, string $contrat_id, string $manager_id, string $date_debut, string $date_fin, string $statut): bool
{
    global $db;
    $stmt = $db->prepare("INSERT INTO `affectation` (id_affectation, date_debut, date_fin, statut_affectation, contrat_id, agent_id, manager_id)
                          VALUES (:id, :date_debut, :date_fin, :statut, :contrat_id, :agent_id, :manager_id)");
    return $stmt->execute([
        ':id'          => generateUUID(),
        ':date_debut'  => $date_debut,
        ':date_fin'    => $date_fin ?: null,
        ':statut'      => $statut,
        ':contrat_id'  => $contrat_id,
        ':agent_id'    => $agent_id,
        ':manager_id'  => $manager_id
    ]);
}

function updateAffectationsExpirees(): void
{
    global $db;
    $stmt = $db->prepare("
        UPDATE `affectation`
        SET statut_affectation = 'terminee'
        WHERE date_fin IS NOT NULL 
          AND date_fin < CURDATE()
          AND statut_affectation != 'terminee'
    ");
    $stmt->execute();
}

function getAllAffectations(): array
{
    global $db;
    $stmt = $db->prepare("
        SELECT a.id_affectation, a.date_debut, a.date_fin, a.statut_affectation,
               u.id_user AS agent_id, u.prenom AS agent_prenom, u.nom AS agent_nom,
               c.titre AS contrat_titre,
               comp.nom AS competence
        FROM `affectation` a
        JOIN `user` u ON u.id_user = a.agent_id
        JOIN `contrat` c ON c.id_contrat = a.contrat_id
        LEFT JOIN `agent_competence` ac ON ac.agent_id = u.id_user
        LEFT JOIN `competence` comp ON comp.id_competence = ac.competence_id
        ORDER BY a.date_debut DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function formatPeriode(string $date_debut, ?string $date_fin): string
{
    $debut = date('M Y', strtotime($date_debut));
    $fin = $date_fin ? date('M Y', strtotime($date_fin)) : '—';
    return $debut . ' – ' . $fin;
}

function getAffectationById(string $id_affectation): array|false
{
    global $db;
    $stmt = $db->prepare("
        SELECT a.id_affectation, a.date_debut, a.date_fin, a.statut_affectation,
               u.id_user AS agent_id, u.prenom AS agent_prenom, u.nom AS agent_nom,
               c.titre AS contrat_titre,
               comp.nom AS competence
        FROM `affectation` a
        JOIN `user` u ON u.id_user = a.agent_id
        JOIN `contrat` c ON c.id_contrat = a.contrat_id
        LEFT JOIN `agent_competence` ac ON ac.agent_id = u.id_user
        LEFT JOIN `competence` comp ON comp.id_competence = ac.competence_id
        WHERE a.id_affectation = :id_affectation
    ");
    $stmt->execute([':id_affectation' => $id_affectation]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteAffectationById(string $id_affectation): bool
{
    global $db;
    $stmt = $db->prepare("DELETE FROM `affectation` WHERE id_affectation = :id_affectation");
    return $stmt->execute([':id_affectation' => $id_affectation]);
}

function isAgentDisponible(string $agent_id, string $date_debut, string $date_fin): bool
{
    global $db;
    $stmt = $db->prepare("
        SELECT COUNT(*) FROM `affectation`
        WHERE agent_id = :agent_id
          AND statut_affectation = 'active'
          AND date_debut <= :date_fin
          AND (date_fin IS NULL OR date_fin >= :date_debut)
    ");
    $stmt->execute([
        ':agent_id'   => $agent_id,
        ':date_debut' => $date_debut,
        ':date_fin'   => $date_fin
    ]);
    return $stmt->fetchColumn() == 0;
}

function isQuotaDisponible(string $contrat_id): bool
{
    global $db;
    $stmt = $db->prepare("
        SELECT c.quota_agents, COUNT(a.id_affectation) AS nb_affectations
        FROM `contrat` c
        LEFT JOIN `affectation` a ON a.contrat_id = c.id_contrat
            AND a.statut_affectation = 'active'
        WHERE c.id_contrat = :contrat_id
        GROUP BY c.id_contrat
    ");
    $stmt->execute([':contrat_id' => $contrat_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nb_affectations'] < $result['quota_agents'];
}