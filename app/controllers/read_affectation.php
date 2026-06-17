<?php
require_once __DIR__ . '/../models/affectation.php';

updateAffectationsExpirees();

$raw = getAllAffectations();


$affectations = getAllAffectations();
$affectations = [];
foreach ($raw as $row) {
    $id = $row['id_affectation'];
    if (!isset($affectations[$id])) {
        $affectations[$id] = $row;
        $affectations[$id]['competences'] = [];
    }
    if ($row['competence']) {
        $affectations[$id]['competences'][] = $row['competence'];
    }
}

require_once __DIR__ . '/../views/list_affectation.php';    