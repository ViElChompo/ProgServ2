



<?php

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/login_processing_file.php';

// Redirige l'utilisateur vers la page d'accueil s'il est déjà connecté
if (is_user_logged_in()) {
    redirect_to('index.php');
}

?>

<?php view('header', ['title' => 'Login']) ?>

<?php if (isset($errors['login'])) : ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($errors['login']) ?>
    </div>
<?php endif ?>

<form action="login.php" method="post">
    <h1>Login</h1>
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($inputs['username'] ?? '') ?>">
        <small><?= htmlspecialchars($errors['username'] ?? '') ?></small>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <small><?= htmlspecialchars($errors['password'] ?? '') ?></small>
    </div>
    <section>
        <button type="submit">Login</button>
        <a href="register.php">Register</a>
    </section>
</form>

<?php view('footer') ?>