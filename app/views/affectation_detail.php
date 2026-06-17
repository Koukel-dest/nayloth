<?php
$page_title = 'Détail affectation';
require_once __DIR__ . '/layout/header.php';
?>

<div class="profile-page">

  
  <div class="breadcrumb">
    <a href="/NAYLOTH/public/admin">Tableau de bord</a> /
    <a href="/NAYLOTH/public/affectations">Affectations</a> /
    <span>Détail</span>
  </div>

  <div class="profile-card">
    <div class="profile-identity">
      <div class="profile-avatar">
        <?= strtoupper(substr($affectation['agent_prenom'], 0, 1) . substr($affectation['agent_nom'], 0, 1)) ?>
      </div>
      <div class="profile-identity-info">
        <div class="profile-name"><?= htmlspecialchars($affectation['agent_nom'] . ', ' . $affectation['agent_prenom']) ?></div>
        <div class="profile-meta"><?= htmlspecialchars($affectation['agent_email'] ?? '') ?></div>
      </div>
      <div style="margin-left: auto;">
        <?php
          $statut = $affectation['statut_affectation'];
          $badgeClass = match($statut) {
              'active'    => 'badge-dispo',
              'terminee'  => 'badge-assigned',
              'suspendue' => 'badge-pending',
              default     => 'badge-dispo',
          };
          $statutLabel = match($statut) {
              'active'    => 'Active',
              'terminee'  => 'Terminée',
              'suspendue' => 'Suspendue',
              default     => $statut,
          };
        ?>
        <span class="badge <?= $badgeClass ?>"><?= $statutLabel ?></span>
      </div>
    </div>

    <div class="profile-details">
      <div class="profile-field">
        <div class="profile-field-label">Client</div>
        <div class="profile-field-value"><?= htmlspecialchars($affectation['contrat_titre']) ?></div>
      </div>
      <div class="profile-field">
        <div class="profile-field-label">Contrat</div>
        <div class="profile-field-value"><?= htmlspecialchars($affectation['contrat_titre']) ?></div>
      </div>
      <div class="profile-field">
        <div class="profile-field-label">Début de mission</div>
        <div class="profile-field-value"><?= date('d F Y', strtotime($affectation['date_debut'])) ?></div>
      </div>
      <div class="profile-field">
        <div class="profile-field-label">Fin prévue</div>
        <div class="profile-field-value"><?= $affectation['date_fin'] ? date('d F Y', strtotime($affectation['date_fin'])) : '—' ?></div>
      </div>
    </div>
  </div>

  <
  <div class="profile-card">
    <div class="profile-card-title">Compétences requises pour cette mission</div>
    <div class="profile-tags">
      <?php if (!empty($affectation['competences'])): ?>
        <?php foreach ($affectation['competences'] as $comp): ?>
          <span class="tag"><?= htmlspecialchars($comp) ?></span>
        <?php endforeach; ?>
      <?php else: ?>
        <span class="muted">Aucune compétence renseignée</span>
      <?php endif; ?>
    </div>
  </div>


  <div class="profile-card profile-card-danger">
    <div>
      <div class="danger-title">Supprimer cette affectation</div>
      <div class="danger-subtitle">Cette action est irréversible.</div>
    </div>
    <a href="/NAYLOTH/public/delete_affectation?id=<?= $affectation['id_affectation'] ?>" class="btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>