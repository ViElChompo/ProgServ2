<?php

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

/**
 * Authentifie un utilisateur avec un nom d'utilisateur et un mot de passe.
 */
function login(string $username, string $password): bool
{
    $user = find_user_by_username($username);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(); // Sécurise la session contre les attaques de fixation de session
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];

        return true;
    }

    return false;
}

/**
 * Récupère un utilisateur par son nom d'utilisateur depuis la base de données.
 */
function find_user_by_username(string $username)
{
    $sql = 'SELECT id, username, password FROM users WHERE username = :username';
    $statement = db()->prepare($sql);
    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC); // Retourne les données de l'utilisateur ou false
}

/**
 * Vérifie si un utilisateur est connecté.
 */
function is_user_logged_in(): bool
{
    return isset($_SESSION['username']);
}

/**
 * Fonction utilitaire pour rediriger avec des données flashées.
 */
function redirect_with(string $location, array $data): void
{
    foreach ($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
    redirect_to($location);
}

/**
 * Récupère et efface des données flashées de la session.
 */
function session_flash(...$keys): array
{
    $values = [];
    foreach ($keys as $key) {
        if (isset($_SESSION[$key])) {
            $values[$key] = $_SESSION[$key];
            unset($_SESSION[$key]);
        } else {
            $values[$key] = null;
        }
    }
    return $values;
}

/**
 * Redirige vers une URL donnée.
 */
function redirect_to(string $url): void
{
    header("Location: $url");
    exit;
}

if (is_user_logged_in()) {
    redirect_to('index.php');
}