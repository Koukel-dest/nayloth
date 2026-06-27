<?php
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/mission_model.php';

checkUserRole('agent');

$agent_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_affectation = $_POST['id_affectation'] ?? '';
    $action = $_POST['action'] ?? '';

    $statuts = [
        'accepter' => 'active',
        'refuser'  => 'refusee'
    ];

    if (isset($statuts[$action])) {
        updateMissionStatus($id_affectation, $agent_id, $statuts[$action]);
    }

    header('Location: /NAYLOTH/public/missions');
    exit;
}

$missions = getMissionsForAgent($agent_id);
require_once __DIR__ . '/../views/missions_view.php';
