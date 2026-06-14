<?php
require_once __DIR__ . "/db_connect.php";

function getAllAgents(string $search = '', string $competence = ''): array
{
    global $db;

    $base = "
        SELECT u.id_user, u.prenom, u.nom, u.email,
               c.nom AS competence
        FROM `user` u
        LEFT JOIN `agent_competence` ac ON ac.agent_id = u.id_user
        LEFT JOIN `competence` c ON c.id_competence = ac.competence_id
        WHERE u.u_role = 'agent'";

    $params = [];
    $clauses = [];

    if ($search !== '') {
        $clauses[] = "(u.nom LIKE :term OR u.prenom LIKE :term)";
        $params[':term'] = '%' . $search . '%';
    }

    if ($competence !== '') {
        $clauses[] = "c.nom = :competence";
        $params[':competence'] = $competence;
    }

    if (!empty($clauses)) {
        $base .= ' AND ' . implode(' AND ', $clauses);
    }

    $stmt = $db->prepare($base);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAgentById(string $id): array|false
{
    global $db;
    $stmt = $db->prepare("
        SELECT u.id_user, u.prenom, u.nom, u.email,
               a.telephone, a.date_entree, a.notes,
               c.nom AS competence
        FROM `user` u
        LEFT JOIN `agent` a ON a.user_id = u.id_user
        LEFT JOIN `agent_competence` ac ON ac.agent_id = u.id_user
        LEFT JOIN `competence` c ON c.id_competence = ac.competence_id
        WHERE u.id_user = :id
    ");
    $stmt->execute([':id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteAgentById(string $id): bool
{
    global $db;

    try {
        $db->beginTransaction();

        $stmt = $db->prepare("DELETE FROM `agent_competence` WHERE `agent_id` = :id");
        $stmt->execute([':id' => $id]);

        $stmt = $db->prepare("DELETE FROM `affectation` WHERE `agent_id` = :id");
        $stmt->execute([':id' => $id]);

        $stmt = $db->prepare("DELETE FROM `notification` WHERE `user_id` = :id");
        $stmt->execute([':id' => $id]);

        $stmt = $db->prepare("DELETE FROM `agent` WHERE `user_id` = :id");
        $stmt->execute([':id' => $id]);

        $stmt = $db->prepare("DELETE FROM `user` WHERE `id_user` = :id AND `u_role` = 'agent'");
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() === 0) {
            $db->rollBack();
            return false;
        }

        $db->commit();
        return true;
    } catch (PDOException $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        return false;
    }
}

function generateUUID(): string
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}


function addAgent(string $prenom, string $nom, string $email, string $pwd, string $telephone, string $date_entree, string $notes, array $competences): bool
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

   
    $stmt2 = $db->prepare("INSERT INTO `agent` (id_agent, user_id, telephone, date_entree, notes) 
                           VALUES (:id, :user_id, :telephone, :date_entree, :notes)");
    $stmt2->execute([
        ':id'          => generateUUID(),
        ':user_id'     => $id_user,
        ':telephone'   => $telephone,
        ':date_entree' => $date_entree ?: null,
        ':notes'       => $notes
    ]);

 foreach ($competences as $id_competence) {
    $stmt = $db->prepare("INSERT INTO `agent_competence` (id_agent_competence, agent_id, competence_id) 
                          VALUES (:id, :agent_id, :competence_id)");
    $stmt->execute([
        ':id'            => generateUUID(),
        ':agent_id'      => $id_user,
        ':competence_id' => $id_competence
    ]);
}
    return true;
}

function getAllCompetences(): array
{
    global $db;
    $stmt = $db->prepare("SELECT id_competence, nom FROM `competence`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}