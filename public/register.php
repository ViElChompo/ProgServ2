


<?php

    require_once '../src/bootstrap.php'; 
    require_once '../src/register.php'; 

    // Vérifie si l'utilisateur est déjà connecté
    if (is_user_logged_in()) {
        // Redirige l'utilisateur connecté vers la page d'accueil (index.php)
        redirect_to('index.php');
    }
?>

<!-- Affiche le header de la page, en passant un titre personnalisé pour la page d'enregistrement -->
<?php view('header', ['title' => 'Register']) ?>

<!-- Formulaire d'inscription pour un nouvel utilisateur -->
<form action="register.php" method="post">
    <h1>Sign Up</h1> <!-- Titre du formulaire -->

    <!-- Champ pour le nom d'utilisateur -->
    <div>
        <label for="username">Username:</label>
        <input 
            type="text" 
            name="username" 
            id="username" 
            value="<?= $inputs['username'] ?? '' ?>" 
            class="<?= error_class($errors, 'username') ?>"> <!-- Affiche la valeur entrée précédemment et ajoute une classe d'erreur si nécessaire -->
        <small><?= $errors['username'] ?? '' ?></small> <!-- Affiche un message d'erreur pour le champ "username", si nécessaire -->
    </div>

    <!-- Champ pour l'email -->
    <div>
        <label for="email">Email:</label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            value="<?= $inputs['email'] ?? '' ?>" 
            class="<?= error_class($errors, 'email') ?>"> <!-- Affiche l'email pré-rempli et une classe d'erreur, si présente -->
        <small><?= $errors['email'] ?? '' ?></small> <!-- Affiche un message d'erreur pour le champ "email", si nécessaire -->
    </div>

    <!-- Champ pour le mot de passe -->
    <div>
        <label for="password">Password:</label>
        <input 
            type="password" 
            name="password" 
            id="password" 
            value="<?= $inputs['password'] ?? '' ?>" 
            class="<?= error_class($errors, 'password') ?>"> <!-- Champ pour le mot de passe, pré-rempli si disponible, et classe d'erreur si nécessaire -->
        <small><?= $errors['password'] ?? '' ?></small> <!-- Affiche un message d'erreur pour le champ "password", si nécessaire -->
    </div>

    <!-- Champ pour la confirmation du mot de passe -->
    <div>
        <label for="password2">Password Again:</label>
        <input 
            type="password" 
            name="password2" 
            id="password2" 
            value="<?= $inputs['password2'] ?? '' ?>" 
            class="<?= error_class($errors, 'password2') ?>"> <!-- Champ pour la confirmation du mot de passe -->
        <small><?= $errors['password2'] ?? '' ?></small> <!-- Affiche un message d'erreur pour le champ "password2", si nécessaire -->
    </div>

    <!-- Case à cocher pour accepter les conditions d'utilisation -->
    <div>
        <label for="agree">
            <input 
                type="checkbox" 
                name="agree" 
                id="agree" 
                value="1" 
                <?= $inputs['agree'] ?? '' ?> /> <!-- Case à cocher pour accepter les conditions -->
            I agree with the 
            <a href="#" title="term of services">term of services</a> <!-- Lien vers les conditions d'utilisation -->
        </label>
        <small><?= $errors['agree'] ?? '' ?></small> <!-- Affiche un message d'erreur pour la case à cocher "agree", si nécessaire -->
    </div>

    <!-- Bouton de soumission du formulaire -->
    <button type="submit">Register</button> <!-- Bouton pour soumettre les informations du formulaire -->

    <!-- Lien vers la page de connexion pour les utilisateurs déjà enregistrés -->
    <footer>Already a member? <a href="login.php">Login here</a></footer>

</form>

<!-- Affiche le footer de la page -->
<?php view('footer') ?>


