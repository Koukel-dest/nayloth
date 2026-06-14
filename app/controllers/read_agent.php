<?php
require_once __DIR__ . '/../models/agent_model.php';

$search = trim($_GET['q'] ?? '');
$competence = trim($_GET['competence'] ?? '');
$raw = getAllAgents($search, $competence);

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
$searchTerm = $search;
$competenceTerm = $competence;
require_once __DIR__ . '/../views/list_agent.php';