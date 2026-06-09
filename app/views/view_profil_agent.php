<?php
$page_title = $agent['prenom'] . ' ' . $agent['nom'];
require_once __DIR__ . '/layout/header.php';
?>
<link rel="stylesheet" href="/NAYLOTH/assets/css/style_auth.css" />
<div class="profile-page">


  <div class="breadcrumb">
    <a href="/NAYLOTH/public/admin">Tableau de bord</a> /
    <a href="/NAYLOTH/public/Agents">Agents</a> /
    <span>Profil agent</span>
  </div>


  <div class="profile-card">
    <div class="profile-identity">
      <div class="profile-avatar">
        <?= strtoupper(substr($agent['prenom'], 0, 1) . substr($agent['nom'], 0, 1)) ?>
      </div>
      <div class="profile-identity-info">
        <div class="profile-name"><?= htmlspecialchars($agent['nom'] . ', ' . $agent['prenom']) ?></div>
        <div class="profile-meta"><?= htmlspecialchars($agent['email']) ?></div>
      </div>
    </div>

    <div class="profile-details">
      <div class="profile-field">
        <div class="profile-field-label">Nom complet</div>
        <div class="profile-field-value"><?= htmlspecialchars($agent['prenom'] . ' ' . $agent['nom']) ?></div>
      </div>
      <div class="profile-field">
        <div class="profile-field-label">E-mail</div>
        <div class="profile-field-value"><?= htmlspecialchars($agent['email']) ?></div>
      </div>
      <div class="profile-field">
        <div class="profile-field-label">Téléphone</div>
        <div class="profile-field-value"><?= htmlspecialchars($agent['telephone'] ?? '—') ?></div>
      </div>
      <div class="profile-field">
        <div class="profile-field-label">Date d'entrée</div>
        <div class="profile-field-value"><?= $agent['date_entree'] ?? '—' ?></div>
      </div>
    </div>
  </div>

  <div class="profile-card">
    <div class="profile-card-title">Compétences</div>
    <div class="profile-tags">
      <?php if (!empty($agent['competences'])): ?>
        <?php foreach ($agent['competences'] as $comp): ?>
          <span class="tag"><?= htmlspecialchars($comp) ?></span>
        <?php endforeach; ?>
      <?php else: ?>
        <span class="muted">Aucune compétence renseignée</span>
      <?php endif; ?>
    </div>
  </div>


  <?php if (!empty($agent['notes'])): ?>
  <div class="profile-card">
    <div class="profile-card-title">Notes</div>
    <div class="profile-notes"><?= htmlspecialchars($agent['notes']) ?></div>
  </div>
  <?php endif; ?>

  <div class="profile-card profile-card-danger">
    <div>
      <div class="danger-title">Supprimer cet agent</div>
      <div class="danger-subtitle">Cette action est irréversible. Le profil et l'historique de l'agent seront supprimés définitivement.</div>
    </div>
    <a href="/NAYLOTH/public/delete_agent?id=<?= $agent['id_user'] ?>" class="btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer l'agent</a>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>