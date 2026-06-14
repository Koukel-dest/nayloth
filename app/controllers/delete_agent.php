<?php
require_once __DIR__ . '/../models/agent_model.php';

$id = $_GET['id'] ?? '';

if (empty($id)) {
    $_SESSION['erreur'] = 'Agent introuvable.';
    header('Location: /NAYLOTH/public/Agents');
    exit;
}

if (deleteAgentById($id)) {
    $_SESSION['succes'] = 'Agent supprimé avec succès.';
} else {
    $_SESSION['erreur'] = 'Impossible de supprimer cet agent.';
}

header('Location: /NAYLOTH/public/Agents');
exit;
