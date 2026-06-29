<?php
global $db;

if ($_SESSION['user_role'] === 'admin') {

    $stmt = $db->query("SELECT COUNT(*) as nb FROM contrat");
    $nb_contrats = $stmt->fetch()['nb'];

    $stmt = $db->query("SELECT COUNT(*) as nb FROM contrat WHERE statut_contrat = 'actif'");
    $nb_contrats_actifs = $stmt->fetch()['nb'];

    $stmt = $db->query("SELECT COUNT(*) as nb FROM contrat WHERE statut_contrat = 'en_attente'");
    $nb_contrats_attente = $stmt->fetch()['nb'];

    $stmt = $db->query("SELECT COUNT(*) as nb FROM client");
    $nb_clients = $stmt->fetch()['nb'];

    $stmt = $db->query("SELECT COUNT(*) as nb FROM user WHERE u_role = 'agent'");
    $nb_agents = $stmt->fetch()['nb'];

    $stmt = $db->query("SELECT COUNT(*) as nb FROM devis WHERE statut_devis = 'en_attente'");
    $nb_devis_attente = $stmt->fetch()['nb'];

    require_once __DIR__ . '/../views/admin.php';

} elseif ($_SESSION['user_role'] === 'manager') {

    $manager_id = $_SESSION['user_id'];

    $stmt = $db->prepare("SELECT COUNT(*) as nb FROM contrat WHERE manager_id = :id");
    $stmt->execute([':id' => $manager_id]);
    $nb_contrats = $stmt->fetch()['nb'];

    $stmt = $db->prepare("SELECT COUNT(*) as nb FROM contrat WHERE manager_id = :id AND statut_contrat = 'actif'");
    $stmt->execute([':id' => $manager_id]);
    $nb_contrats_actifs = $stmt->fetch()['nb'];

    $stmt = $db->prepare("SELECT COUNT(*) as nb FROM contrat WHERE manager_id = :id AND statut_contrat = 'en_attente'");
    $stmt->execute([':id' => $manager_id]);
    $nb_contrats_attente = $stmt->fetch()['nb'];

    $stmt = $db->prepare("SELECT COUNT(DISTINCT agent_id) as nb FROM affectation WHERE manager_id = :id AND statut_affectation = 'active'");
    $stmt->execute([':id' => $manager_id]);
    $nb_agents_actifs = $stmt->fetch()['nb'];

    require_once __DIR__ . '/../views/manager.php';

} elseif ($_SESSION['user_role'] === 'agent') {

    $agent_id = $_SESSION['user_id'];

    $stmt = $db->prepare("SELECT COUNT(*) as nb FROM affectation WHERE agent_id = :id AND statut_affectation = 'active'");
    $stmt->execute([':id' => $agent_id]);
    $nb_affectations_actives = $stmt->fetch()['nb'];

    $stmt = $db->prepare("SELECT COUNT(*) as nb FROM affectation WHERE agent_id = :id");
    $stmt->execute([':id' => $agent_id]);
    $nb_affectations_total = $stmt->fetch()['nb'];

    require_once __DIR__ . '/../views/agent.php';

}
