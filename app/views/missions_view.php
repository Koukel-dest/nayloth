<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="list-page">

  <div class="list-header">
    <div>
      <div class="list-title">Mes missions</div>
      <div class="list-subtitle"><?= count($missions) ?> mission(s) au total</div>
    </div>
  </div>

  <div class="list-card">
    <div class="list-card-header">
      <span class="list-card-title">Liste des missions</span>
      <span class="list-card-count"><?= count($missions) ?> missions</span>
    </div>

    <table class="list-table">
      <thead>
        <tr>
          <th>Contrat</th>
          <th>Client</th>
          <th>Date début</th>
          <th>Date fin</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($missions as $mission): ?>
        <tr>
          <td><?= htmlspecialchars($mission['contrat_titre']) ?></td>
          <td><?= htmlspecialchars($mission['client_nom']) ?></td>
          <td><?= htmlspecialchars($mission['date_debut']) ?></td>
          <td><?= htmlspecialchars($mission['date_fin'] ?? '—') ?></td>
          <td>
            <span class="badge <?= $mission['statut_affectation'] === 'active' ? 'badge-dispo' : 'badge-assigned' ?>">
              <?= htmlspecialchars($mission['statut_affectation']) ?>
            </span>
          </td>
          <td>
            <?php if ($mission['statut_affectation'] === 'en_attente'): ?>
              <form method="POST" action="/NAYLOTH/public/missions" style="display:inline;">
                <input type="hidden" name="id_affectation" value="<?= htmlspecialchars($mission['id_affectation']) ?>" />
                <input type="hidden" name="action" value="accepter" />
                <button type="submit" class="btn-primary">Accepter</button>
              </form>
              <form method="POST" action="/NAYLOTH/public/missions" style="display:inline;">
                <input type="hidden" name="id_affectation" value="<?= htmlspecialchars($mission['id_affectation']) ?>" />
                <input type="hidden" name="action" value="refuser" />
                <button type="submit" class="btn-danger">Refuser</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
