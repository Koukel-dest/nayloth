<?php
require_once __DIR__ . '/../models/affectation.php';

$id = $_GET['id'] ?? '';
if (empty($id)) {
    header('Location: /NAYLOTH/public/Affectations');
    exit;
}

if (deleteAffectationById($id)) {
    $_SESSION['succes'] = 'Affectation supprimée avec succès.';
} else {
    $_SESSION['erreur'] = 'Impossible de supprimer cette affectation.';
}
header('Location: /NAYLOTH/public/affectations');
exit;   