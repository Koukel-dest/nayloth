<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nayloth — Connexion</title>
  <link rel="stylesheet" href="/NAYLOTH/assets/css/style_auth.css" />
</head>
<body>
<div class="page">

  <!-- PANNEAU GAUCHE -->
  <div class="panel-left">
    <div>
      <div class="brand-logo">NAYLOTH</div>
      <div class="brand-tagline">Plateforme de gestion interne<br>de votre ESN</div>
    </div>

    <div class="panel-center">
      <h2>Trois profils,<br>un seul outil.</h2>
      <div class="profiles">
        <div class="profile-item">
          <div class="profile-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
          </div>
          <div class="profile-text">
            <h4>Agent</h4>
            <p>Accède à ses affectations et son profil de compétences.</p>
          </div>
        </div>
        <div class="profile-item">
          <div class="profile-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
          </div>
          <div class="profile-text">
            <h4>Manager</h4>
            <p>Gère les affectations des agents sur les contrats clients.</p>
          </div>
        </div>
        <div class="profile-item">
          <div class="profile-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
          </div>
          <div class="profile-text">
            <h4>Administrateur</h4>
            <p>Gère les profils agents et les contrats avec les clients.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="panel-footer">Usage interne uniquement — Projet Nayloth 2025</div>
  </div>

  <!-- PANNEAU DROIT -->
  <div class="panel-right">
    <div class="login-box">

      <h1>Connexion</h1>
      <p class="login-subtitle">Identifiez-vous pour accéder à votre espace.</p>

      <?php if (isset($_SESSION['erreur'])): ?>
        <p style="color: red; font-size: 13px; margin-bottom: 12px;"><?= $_SESSION['erreur'] ?></p>
        <?php unset($_SESSION['erreur']); ?>
      <?php endif; ?>

      <form method="POST" action="/NAYLOTH/public/login">

        <div class="form-group">
          <label>Adresse e-mail</label>
          <input type="email" name="email" placeholder="prenom.nom@nayloth.fr" />
        </div>

        <div class="form-group">
          <label>Mot de passe</label>
          <input type="password" name="pwd" placeholder="••••••••" />
          <div class="forgot"><a href="#">Mot de passe oublié ?</a></div>
        </div>

        <div class="divider"></div>

        <button type="submit" class="btn-login">Se connecter</button>

      </form>
    </div>
  </div>

</div>
</body>
</html>