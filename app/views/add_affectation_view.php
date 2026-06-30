<?php
$page_title = 'Créer une affectation';
require_once __DIR__ . '/layout/header.php';
?>

<div class="form-page">

  <?php if (isset($_SESSION['erreur'])): ?>
    <p class="form-error"><?= $_SESSION['erreur'] ?></p>
    <?php unset($_SESSION['erreur']); ?>
  <?php endif; ?>

  <form method="POST" action="/NAYLOTH/public/ajouter_affectation">

    <div class="form-section">
      <div class="form-section-title">Affectation</div>
      <div class="form-grid">

        <div class="form-group">
          <label>Agent</label>
          <select name="agent_id">
            <option value="">-- Sélectionner un agent --</option>
            <?php foreach ($agents as $agent): ?>
              <option value="<?= $agent['id_user'] ?>" <?= (isset($selectedAgentId) && $selectedAgentId == $agent['id_user']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($agent['nom'] . ' ' . $agent['prenom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Contrat</label>
          <select name="contrat_id">
            <option value="">-- Sélectionner un contrat --</option>
            <?php foreach ($contrats as $contrat): ?>
              <option value="<?= $contrat['id_contrat'] ?>">
                <?= htmlspecialchars($contrat['titre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Date de début</label>
          <input type="date" name="date_debut" />
        </div>

        <div class="form-group">
          <label>Date de fin</label>
          <input type="date" name="date_fin" />
        </div>

        <div class="form-group">
          <label>Statut</label>
          <select name="statut">
            <option value="active">Active</option>
            <option value="terminee">Terminée</option>
            <option value="suspendue">Suspendue</option>
          </select>
        </div>

      </div>
    </div>

    <div class="form-actions">
      <a href="/NAYLOTH/public/affectations" class="btn-cancel">Annuler</a>
      <button type="submit" class="btn-primary">Créer l'affectation</button>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>