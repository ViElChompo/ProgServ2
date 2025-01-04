<?php

require_once '../src/bootstrap.php';
require_once '../src/register.php';

// Vérifie si l'utilisateur est déjà connecté
if (is_user_logged_in()) {
    // Redirige l'utilisateur connecté vers la page d'accueil (index.php)
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
    <title>S'inscrire</title>
</head>
<body>
<?php view('header') ?>
<main>
    <div class="container">
        <div class="title__container">
            <h1 class="title">Inscription</h1>
            <h2 class="sub__title">Rejoignez nous pour découvrir toutes les resources</h2>
        </div>
        <form class="flex flex-col form gap-2" action="register.php" method="post">
            <div class="form__control">
                <label for="username">Nom d'utilisateur:</label>
                <input
                        type="text"
                        name="username"
                        id="username"
                        value="<?= $inputs['username'] ?? '' ?>"
                        class="<?= error_class($errors, 'username') ?>"
                >
                <small><?= $errors['username'] ?? '' ?></small>
            </div>
                <div class="form__control">
                    <label for="email">Addresse mail:</label>
                    <input
                            type="email"
                            name="email"
                            id="email"
                            value="<?= $inputs['email'] ?? '' ?>"
                            class="<?= error_class($errors, 'email') ?>"
                    >
                    <small><?= $errors['email'] ?? '' ?></small>
                </div>
            <div class="flex flex-row gap-4">

                <div class="form__control">
                    <label for="password">Mot de passe:</label>
                    <input
                            type="password"
                            name="password"
                            id="password"
                            value="<?= $inputs['password'] ?? '' ?>"
                            class="<?= error_class($errors, 'password') ?>">
                    <!-- Champ pour le mot de passe, pré-rempli si disponible, et classe d'erreur si nécessaire -->
                    <small><?= $errors['password'] ?? '' ?></small>
                    <!-- Affiche un message d'erreur pour le champ "password", si nécessaire -->
                </div>
                <!-- Champ pour la confirmation du mot de passe -->
                <div class="form__control">
                    <label for="password2">Vérification du mot de passe</label>
                    <input
                            type="password"
                            name="password2"
                            id="password2"
                            value="<?= $inputs['password2'] ?? '' ?>"
                            class="<?= error_class($errors, 'password2') ?>">
                    <!-- Champ pour la confirmation du mot de passe -->
                    <small><?= $errors['password2'] ?? '' ?></small>
                    <!-- Affiche un message d'erreur pour le champ "password2", si nécessaire -->
                </div>
            </div>
            <!-- Case à cocher pour accepter les conditions d'utilisation -->
            <div class="form__control">
                <label for="agree">
                    <input
                            type="checkbox"
                            name="agree"
                            id="agree"
                            value="1"
                        <?= $inputs['agree'] ?? '' ?> /> <!-- Case à cocher pour accepter les conditions -->
                    Je suis d'accord avec
                    <a href="#" title="term of services">Les conditions d'utilisations</a>
                    <!-- Lien vers les conditions d'utilisation -->
                </label>
                <small><?= $errors['agree'] ?? '' ?></small>
                <!-- Affiche un message d'erreur pour la case à cocher "agree", si nécessaire -->
            </div>
            <div class="flex items-center justify-center">
                <button class="btn__register" type="submit">S'inscrire</button> <!-- Bouton pour soumettre les informations du formulaire -->
            </div>
        </form>
    </div>
</main>
<?php view('footer') ?>
</body>
</html>

