<?php
require_once __DIR__ . "/db_connect.php";

function getAllagents(string $id): array|false
{
    global $db;
    $stmt = $db->prepare("
        SELECT u.id_user, u.prenom, u.nom, u.email,
               c.nom AS competence
        FROM `user` u
        LEFT JOIN `agent_competence` ac ON ac.agent_id = u.id_user
        LEFT JOIN `competence` c ON c.id_competence = ac.competence_id
    ");
    $stmt->execute([':id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAgentById(string $id): array|false
{
    global $db;
    $stmt = $db->prepare("
        SELECT u.id_user, u.prenom, u.nom, u.email,
               c.nom AS competence
        FROM `user` u
        LEFT JOIN `agent_competence` ac ON ac.agent_id = u.id_user
        LEFT JOIN `competence` c ON c.id_competence = ac.competence_id
        WHERE u.id_user = :id
    ");
    $stmt->execute([':id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function addAgent(string $prenom, string $nom, string $email, string $pwd, array $competences): bool
{
    global $db;

    $id_user = generateUUID();
    $stmt = $db->prepare("INSERT INTO `user` (id_user, prenom, nom, email, pwd, u_role) 
                          VALUES (:id, :prenom, :nom, :email, :pwd, 'agent')");
    $stmt->execute([
        ':id'     => $id_user,
        ':prenom' => $prenom,
        ':nom'    => $nom,
        ':email'  => $email,
        ':pwd'    => password_hash($pwd, PASSWORD_BCRYPT)
    ]);

    foreach ($competences as $competence_nom) {
        
        
        $stmt2 = $db->prepare("SELECT id_competence FROM `competence` WHERE nom = :nom");
        $stmt2->execute([':nom' => trim($competence_nom)]);
        $competence = $stmt2->fetch(PDO::FETCH_ASSOC);

    
        if (!$competence) {
            $id_competence = generateUUID();
            $stmt3 = $db->prepare("INSERT INTO `competence` (id_competence, nom) VALUES (:id, :nom)");
            $stmt3->execute([':id' => $id_competence, ':nom' => trim($competence_nom)]);
        } else {
            $id_competence = $competence['id_competence'];
        }

      
        $stmt4 = $db->prepare("INSERT INTO `agent_competence` (id_agent_competence, agent_id, competence_id) 
                               VALUES (:id, :agent_id, :competence_id)");
        $stmt4->execute([
            ':id'            => generateUUID(),
            ':agent_id'      => $id_user,
            ':competence_id' => $id_competence
        ]);
    }

    return true;
}