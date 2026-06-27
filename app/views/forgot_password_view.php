<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nayloth — Mot de passe oublié</title>
  <link rel="stylesheet" href="/NAYLOTH/assets/css/style_auth.css" />
</head>
<body>
<div class="page">

  <div class="panel-right" style="margin: auto;">
    <div class="login-box">

      <h1>Mot de passe oublié</h1>
      <p class="login-subtitle">Indiquez votre email, vous recevrez un lien pour réinitialiser votre mot de passe.</p>

      <?php if (isset($_SESSION['erreur'])): ?>
        <p style="color: red; font-size: 13px; margin-bottom: 12px;"><?= $_SESSION['erreur'] ?></p>
        <?php unset($_SESSION['erreur']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['info'])): ?>
        <p style="color: green; font-size: 13px; margin-bottom: 12px;"><?= $_SESSION['info'] ?></p>
        <?php unset($_SESSION['info']); ?>
      <?php endif; ?>

      <form method="POST" action="/NAYLOTH/public/mot-de-passe-oublie">

        <div class="form-group">
          <label>Adresse e-mail</label>
          <input type="email" name="email" placeholder="prenom.nom@nayloth.fr" required />
        </div>

        <div class="divider"></div>

        <button type="submit" class="btn-login">Envoyer le lien</button>

      </form>
    </div>
  </div>

</div>
</body>
</html>
