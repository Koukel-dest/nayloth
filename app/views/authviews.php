<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (isset($_SESSION['erreur'])): ?>
    <p><?= $_SESSION['erreur'] ?></p>
    <?php unset($_SESSION['erreur']); ?>
<?php endif; ?>

<form method="POST" action="/NAYLOTH/public/login">
    <label>Email</label>
    <input type="email" name="email">

    <label>Mot de passe</label>
    <input type="password" name="pwd">

    <button type="submit">Se connecter</button>
</form>
</body>
</html>