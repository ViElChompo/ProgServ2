<?php

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'auth');
define('DB_USER', 'victor');
define('DB_PASSWORD', '1234db!');

// Fonction pour se connecter à la base de données
function db(): PDO
{
    try {
        // Connexion PDO avec les constantes définies
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
            DB_USER,
            DB_PASSWORD
        );
        // Gestion des erreurs
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;
    } catch (PDOException $e) {
        // Si une erreur survient, arrêter le script et afficher l'erreur
        die('Connection failed: ' . $e->getMessage());
    }
}

// Messages d'erreur par défaut pour la validation
const DEFAULT_VALIDATION_ERRORS = [
    'required' => 'The %s is required',
    'email' => 'The %s is not a valid email address',
    'min' => 'The %s must have at least %s characters',
    'max' => 'The %s must have at most %s characters',
    'between' => 'The %s must have between %d and %d characters',
    'same' => 'The %s must match with %s',
    'alphanumeric' => 'The %s should have only letters and numbers',
    'secure' => 'The %s must have between 8 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character',
    'unique' => 'The %s already exists',
];

// Fonction pour valider les champs
function validate(array $data, array $fields, array $messages = []): array
{
    $split = fn($str, $separator) => array_map('trim', explode($separator, $str));

    // Messages de validation personnalisés
    $rule_messages = array_filter($messages, fn($message) => is_string($message));
    $validation_errors = array_merge(DEFAULT_VALIDATION_ERRORS, $rule_messages);

    $errors = [];

    foreach ($fields as $field => $option) {
        $rules = $split($option, '|');
        foreach ($rules as $rule) {
            $params = [];
            if (strpos($rule, ':')) {
                [$rule_name, $param_str] = $split($rule, ':');
                $params = $split($param_str, ',');
            } else {
                $rule_name = trim($rule);
            }

            $fn = 'is_' . $rule_name;
            if (is_callable($fn)) {
                $pass = $fn($data, $field, ...$params);
                if (!$pass) {
                    $errors[$field] = sprintf(
                        $messages[$field][$rule_name] ?? $validation_errors[$rule_name],
                        $field,
                        ...$params
                    );
                }
            }
        }
    }

    return $errors;
}

// Fonction pour valider si le champ est requis
function is_required(array $data, string $field): bool
{
    return isset($data[$field]) && trim($data[$field]) !== '';
}

// Fonction pour valider si le champ est un email valide
function is_email(array $data, string $field): bool
{
    if (empty($data[$field])) {
        return true;
    }
    return filter_var($data[$field], FILTER_VALIDATE_EMAIL);
}

// Fonction pour valider la longueur minimale
function is_min(array $data, string $field, int $min): bool
{
    return isset($data[$field]) && mb_strlen($data[$field]) >= $min;
}

// Fonction pour valider la longueur maximale
function is_max(array $data, string $field, int $max): bool
{
    return isset($data[$field]) && mb_strlen($data[$field]) <= $max;
}

// Fonction pour valider une longueur entre un minimum et un maximum
function is_between(array $data, string $field, int $min, int $max): bool
{
    $len = mb_strlen($data[$field] ?? '');
    return $len >= $min && $len <= $max;
}

// Fonction pour valider si deux champs sont identiques
function is_same(array $data, string $field, string $other): bool
{
    return isset($data[$field], $data[$other]) && $data[$field] === $data[$other];
}

// Fonction pour valider si le champ est alphanumérique
function is_alphanumeric(array $data, string $field): bool
{
    return isset($data[$field]) && ctype_alnum($data[$field]);
}

// Fonction pour valider si le mot de passe est sécurisé
function is_secure(array $data, string $field): bool
{
    if (empty($data[$field])) {
        return false;
    }
    $pattern = "#.*^(?=.{8,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";
    return preg_match($pattern, $data[$field]);
}

// Fonction pour vérifier si un champ est unique dans la base de données
function is_unique(array $data, string $field, string $table, string $column): bool
{
    if (empty($data[$field])) {
        return true;
    }

    $sql = "SELECT $column FROM $table WHERE $column = :value";
    $stmt = db()->prepare($sql);
    $stmt->bindValue(":value", $data[$field]);
    $stmt->execute();

    return $stmt->fetchColumn() === false;
}

?>
