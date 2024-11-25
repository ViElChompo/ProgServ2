<?php

// Définition des constantes de connexion à la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'auth');
define('DB_USER', 'victor');
define('DB_PASSWORD', '1234db!');

// Fonction pour se connecter à la base de données via PDO
function db(): PDO
{
    try {
        echo 'On passe par là';
        // Création de la connexion PDO avec les constantes de configuration
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
            DB_USER,
            DB_PASSWORD
        );
        // Configuration du mode de gestion des erreurs
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;
    } catch (PDOException $e) {
        // En cas d'erreur, affichage du message d'erreur et arrêt du script
        die('Connection failed: ' . $e->getMessage());
    }
}

// Fonction pour vérifier l'unicité d'une valeur dans la base de données
function is_unique($value, $column, $table, $db_column)
{
    // Récupérer la connexion à la base de données
    $pdo = db();

    // Préparer la requête SQL pour vérifier si la valeur existe dans la colonne spécifiée
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE $db_column = :value");
    $stmt->execute(['value' => $value]);

    // Retourne true si la valeur est unique (c'est-à-dire qu'elle n'existe pas dans la base de données)
    return $stmt->fetchColumn() == 0;
}

// Fonction de validation des filtres de données (exemple)
function getFilters(): array
{
    return [
        'string' => [
            'filter' => FILTER_CALLBACK,
            'options' => fn($value) => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'),
        ],
        'email' => FILTER_SANITIZE_EMAIL,
        'int' => FILTER_SANITIZE_NUMBER_INT,
        'float' => FILTER_SANITIZE_NUMBER_FLOAT,
        'url' => FILTER_SANITIZE_URL,
    ];
}

// Fonction pour appliquer les filtres de validation
function sanitize(array $inputs, array $fields = [], int $default_filter = FILTER_CALLBACK, bool $trim = true): array
{
    // Récupérer les filtres définis
    $filters = getFilters();

    // Appliquer les filtres spécifiés pour chaque champ
    if ($fields) {
        $options = array_map(fn($field) => $filters[$field], $fields);
        $data = filter_var_array($inputs, $options);
    } else {
        // Appliquer un filtre par défaut (htmlspecialchars dans ce cas)
        $data = filter_var_array($inputs, [
            'filter' => FILTER_CALLBACK,
            'options' => fn($value) => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'),
        ]);
    }

    // Optionnellement, appliquer la fonction de trim (suppression des espaces)
    return $trim ? array_trim($data) : $data;
}

// Fonction pour effectuer un trim récursif des chaînes dans un tableau
function array_trim(array $items): array
{
    return array_map(function ($item) {
        if (is_string($item)) {
            return trim($item);
        } elseif (is_array($item)) {
            return array_trim($item);
        } else {
            return $item;
        }
    }, $items);
}

?>
