<?php
require_once __DIR__ . '/../models/affectation.php';

$id = $_GET['id'] ?? '';
if (empty($id)) {
    header('Location: /NAYLOTH/public/Affectations');
    exit;
}

$raw = getAffectationById($id);
if (!$raw) {
    header('Location: /NAYLOTH/public/Affectations');
    exit;
}

$affectation = [
    'id_affectation'      => $raw[0]['id_affectation'],
    'agent_nom'           => $raw[0]['agent_nom'],
    'agent_prenom'        => $raw[0]['agent_prenom'],
    'contrat_titre'       => $raw[0]['contrat_titre'],
    'date_debut'          => $raw[0]['date_debut'],
    'date_fin'            => $raw[0]['date_fin'],
    'statut_affectation'  => $raw[0]['statut_affectation'],
    'competences'         => array_filter(array_column($raw, 'competence'))
];

require_once __DIR__ . '/../views/affectation_detail.php';