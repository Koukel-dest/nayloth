<?php
require_once __DIR__ . '/../models/agent_model.php';

$raw = getAllAgents();

$agents = [];
foreach ($raw as $row) {
    $id = $row['id_user'];
    if (!isset($agents[$id])) {
        $agents[$id] = [
            'id_user'     => $id,
            'nom'         => $row['nom'],
            'prenom'      => $row['prenom'],
            'email'       => $row['email'],
            'statut'      => 'Disponible',
            'competences' => []
        ];
    }
    if ($row['competence']) {
        $agents[$id]['competences'][] = $row['competence'];
    }
}

$competences = getAllCompetences();
require_once __DIR__ . '/../views/list_agent.php';