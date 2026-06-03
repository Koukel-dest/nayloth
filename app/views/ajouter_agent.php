<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="form-page">

  <?php if (isset($_SESSION['erreur'])): ?>
    <p class="form-error"><?= $_SESSION['erreur'] ?></p>
    <?php unset($_SESSION['erreur']); ?>
  <?php endif; ?>

  <form method="POST" action="/NAYLOTH/public/ajouter_agent">

    <div class="form-section">
      <div class="form-section-title">Informations personnelles</div>
      <div class="form-grid">
        <div class="form-group">
          <label>Nom</label>
          <input type="text" name="nom" placeholder="Martin" />
        </div>
        <div class="form-group">
          <label>Prénom</label>
          <input type="text" name="prenom" placeholder="Lucas" />
        </div>
        <div class="form-group">
          <label>Adresse e-mail</label>
          <input type="email" name="email" placeholder="prenom.nom@nayloth.fr" />
        </div>
        <div class="form-group">
          <label>Téléphone</label>
          <input type="text" name="telephone" placeholder="+33 6 00 00 00 00" />
        </div>
        <div class="form-group">
          <label>Date d'entrée</label>
          <input type="date" name="date_entree" />
        </div>
        <div class="form-group">
          <label>Statut initial</label>
          <select name="statut">
            <option value="disponible">Disponible</option>
            <option value="indisponible">Indisponible</option>
          </select>
        </div>
      </div>
    </div>

    <div class="form-section">
      <div class="form-section-title">Compte de connexion</div>
      <div class="form-grid">
        <div class="form-group">
          <label>Mot de passe temporaire</label>
          <input type="password" name="pwd" placeholder="••••••••" />
        </div>
        <div class="form-group">
          <label>Confirmer</label>
          <input type="password" name="pwd_confirm" placeholder="••••••••" />
        </div>
      </div>
    </div>

    <div class="form-section">
      <div class="form-section-title">Compétences</div>
      <div class="form-group">
        <label>Compétences techniques</label>
        <div class="competences-list">
          <?php foreach ($competences as $comp): ?>
            <label class="competence-item">
              <input type="checkbox" name="competences[]" value="<?= $comp['id_competence'] ?>">
              <?= htmlspecialchars($comp['nom']) ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" placeholder="Informations complémentaires sur l'agent..."></textarea>
      </div>
    </div>

    <div class="form-actions">
      <a href="/NAYLOTH/public/agents" class="btn-cancel">Annuler</a>
      <button type="submit" class="btn-primary">Créer l'agent</button>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>