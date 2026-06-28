<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nayloth — Réinitialiser le mot de passe</title>
  <link rel="stylesheet" href="/NAYLOTH/assets/css/style_auth.css" />
</head>
<body>
<div class="page">

  <div class="panel-right" style="margin: auto;">
    <div class="login-box">

      <h1>Nouveau mot de passe</h1>
      <p class="login-subtitle">Choisissez votre nouveau mot de passe.</p>

      <?php if (isset($_SESSION['erreur'])): ?>
        <p style="color: red; font-size: 13px; margin-bottom: 12px;"><?= $_SESSION['erreur'] ?></p>
        <?php unset($_SESSION['erreur']); ?>
      <?php endif; ?>

      <form method="POST" action="/NAYLOTH/public/reinitialiser-mot-de-passe">

        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" />

        <div class="form-group">
          <label>Nouveau mot de passe</label>
          <input type="password" name="pwd" placeholder="••••••••" required />
        </div>

        <div class="form-group">
          <label>Confirmer le mot de passe</label>
          <input type="password" name="pwd_confirm" placeholder="••••••••" required />
        </div>

        <div class="divider"></div>

        <button type="submit" class="btn-login">Réinitialiser</button>

      </form>
    </div>
  </div>

</div>
</body>
</html>
