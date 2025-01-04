



<?php

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/login_processing_file.php';

// Redirige l'utilisateur vers la page d'accueil s'il est déjà connecté
if (is_user_logged_in()) {
    redirect_to('index.php');
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/css/auth.css"/>
    <title>Connexion</title>
</head>
<body>
<?php view('header') ?>
<main>
    <div class="container">
        <?php if (isset($errors['login'])) : ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($errors['login']) ?>
            </div>
        <?php endif ?>
        <div class="title__container">
            <h1 class="title">Connexion</h1>
            <h2 class="sub__title">Ravi de vous revoir parmi nous !</h2>
        </div>
        <form  class="flex flex-col form gap-2" action="login.php" method="post">
            <div class="form__control">
                <label for="username">Adresse email:</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($inputs['username'] ?? '') ?>">
                <small><?= htmlspecialchars($errors['username'] ?? '') ?></small>
            </div>
            <div class="form__control">
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password">
                <small><?= htmlspecialchars($errors['password'] ?? '') ?></small>
            </div>
            <div class="flex items-center justify-center">
                <button class="btn__login" type="submit">S'inscrire</button>
            </div>
        </form>
    </div>
</main>
<?php view('footer') ?>
</body>
</html>

