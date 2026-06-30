<?php
require_once __DIR__ . '/../models/mission_model.php';
require_once __DIR__ . '/../models/affectation.php';

updateAffectationsExpirees();

$raw = getAllMissions();


$missions = [];
foreach ($raw as $row) {
    $id = $row['id_affectation'];
    if (!isset($missions[$id])) {
        $missions[$id] = [
            'id_affectation'     => $id,
            'agent_nom'          => $row['agent_nom'],
            'agent_prenom'       => $row['agent_prenom'],
            'contrat_titre'      => $row['contrat_titre'],
            'date_debut'         => $row['date_debut'],
            'date_fin'           => $row['date_fin'],
            'statut_affectation' => $row['statut_affectation'],
            'competences'        => []
        ];
    }
    if ($row['competence']) {
        $missions[$id]['competences'][] = $row['competence'];
    }
}

$stats = countMissionsParStatut();

require_once __DIR__ . '/../views/suivi_missions.php';