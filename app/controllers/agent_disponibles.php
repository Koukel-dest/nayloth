<?php
require_once __DIR__ . '/../models/mission_model.php';

$raw = getAgentsDisponibles();


$agents = [];
foreach ($raw as $row) {
    $id = $row['id_user'];
    if (!isset($agents[$id])) {
        $agents[$id] = [
            'id_user'      => $id,
            'nom'          => $row['nom'],
            'prenom'       => $row['prenom'],
            'email'        => $row['email'],
            'date_entree'  => $row['date_entree'],
            'competences'  => []
        ];
    }
    if ($row['competence']) {
        $agents[$id]['competences'][] = $row['competence'];
    }
}

require_once __DIR__ . '/../views/agents_disponibles.php';