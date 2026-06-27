<?php
require_once __DIR__ . '/../models/agent_model.php';

$id = $_GET['id'] ?? '';

if (empty($id)) {
    header('Location: /NAYLOTH/public/Agents');
    exit;
}

$raw = getAgentById($id);

if (!$raw) {
    header('Location: /NAYLOTH/public/Agents');
    exit;
}

$agent = [
    'id_user'     => $raw[0]['id_user'],
    'nom'         => $raw[0]['nom'],
    'prenom'      => $raw[0]['prenom'],
    'email'       => $raw[0]['email'],
    'telephone'   => $raw[0]['telephone'],
    'date_entree' => $raw[0]['date_entree'],
    'notes'       => $raw[0]['notes'],
    'competences' => array_filter(array_column($raw, 'competence'))
];

require_once __DIR__ . '/../views/view_profil_agent.php';