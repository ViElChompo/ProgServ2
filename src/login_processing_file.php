<?php

require_once __DIR__ . '/bootstrap.php';

$inputs = [];
$errors = [];

if (is_post_request()) {
    [$inputs, $errors] = filter($_POST, [
        'username' => 'string | required',
        'password' => 'string | required'
    ]);

    if ($errors) {
        redirect_with('login.php', [
            'errors' => $errors,
            'inputs' => $inputs
        ]);
    }

    // Tentative de connexion
    if (!login($inputs['username'], $inputs['password'])) {
        $errors['login'] = 'Invalid username or password';

        redirect_with('login.php', [
            'errors' => $errors,
            'inputs' => $inputs
        ]);
    }

    // Connexion réussie, redirige vers la page d'accueil
    redirect_to('index.php');
} elseif (is_get_request()) {
    [$errors, $inputs] = session_flash('errors', 'inputs');
}

// Si l'utilisateur est déjà connecté, redirige vers la page d'accueil
if (is_user_logged_in()) {
    redirect_to('index.php');
}
