Voici le fichier réécrit avec des commentaires détaillés pour chaque section : 

```php
<?php

// Définition des constantes de connexion à la base de données
define('DB_HOST', 'localhost'); // Hôte de la base de données
define('DB_NAME', 'auth'); // Nom de la base de données
define('DB_USER', 'victor'); // Nom d'utilisateur pour la connexion
define('DB_PASSWORD', '1234db!'); // Mot de passe pour la connexion

// Fonction pour se connecter à la base de données via PDO
function db(): PDO
{
    try {
        echo 'On passe par là'; // Message de débogage pour indiquer que la tentative de connexion est en cours
        // Création de l'objet PDO pour se connecter à la base de données
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', // Chaîne DSN (Data Source Name)
            DB_USER, // Utilisateur pour la connexion
            DB_PASSWORD // Mot de passe associé
        );
        // Définir le mode de gestion des erreurs de PDO sur "exception"
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Permet de lever des exceptions en cas d'erreurs

        return $pdo; // Retourne l'objet PDO pour pouvoir l'utiliser dans d'autres fonctions
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, affiche un message et termine le script
        die('Connection failed: ' . $e->getMessage()); // Affiche le message d'erreur
    }
}

// Fonction pour vérifier si une valeur est unique dans une colonne donnée d'une table
function is_unique($value, $column, $table, $db_column)
{
    // Récupérer une connexion à la base de données
    $pdo = db(); // Appelle la fonction db() pour établir une connexion

    // Préparer une requête SQL pour compter les occurrences de la valeur spécifiée
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE $db_column = :value"); // Requête préparée avec un paramètre nommé
    $stmt->execute(['value' => $value]); // Exécute la requête en associant la valeur au paramètre

    // Retourne true si la valeur est unique (elle n'existe pas dans la base de données)
    return $stmt->fetchColumn() == 0; // fetchColumn() retourne le nombre de lignes correspondant
}

// Fonction qui définit les filtres pour la validation des données
function getFilters(): array
{
    return [
        'string' => [
            'filter' => FILTER_CALLBACK, // Utilise un filtre de type callback
            'options' => fn($value) => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), // Échappe les caractères spéciaux
        ],
        'email' => FILTER_SANITIZE_EMAIL, // Filtre pour nettoyer les adresses email
        'int' => FILTER_SANITIZE_NUMBER_INT, // Filtre pour nettoyer les nombres entiers
        'float' => FILTER_SANITIZE_NUMBER_FLOAT, // Filtre pour nettoyer les nombres à virgule
        'url' => FILTER_SANITIZE_URL, // Filtre pour nettoyer les URLs
    ];
}

// Fonction pour appliquer des filtres de validation à des données d'entrée
function sanitize(array $inputs, array $fields = [], int $default_filter = FILTER_CALLBACK, bool $trim = true): array
{
    // Récupérer les filtres définis dans la fonction getFilters()
    $filters = getFilters(); // Appelle la fonction pour récupérer les options de filtre

    // Appliquer les filtres aux champs spécifiés ou utiliser un filtre par défaut
    if ($fields) {
        // Si des champs spécifiques sont fournis, applique les filtres correspondants
        $options = array_map(fn($field) => $filters[$field], $fields); // Associe chaque champ à son filtre
        $data = filter_var_array($inputs, $options); // Applique les filtres aux données d'entrée
    } else {
        // Si aucun champ spécifique n'est fourni, applique un filtre par défaut
        $data = filter_var_array($inputs, [
            'filter' => FILTER_CALLBACK, // Utilise un filtre de type callback
            'options' => fn($value) => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), // Échappe les caractères spéciaux
        ]);
    }

    // Si la suppression des espaces est activée, applique un trim récursif
    return $trim ? array_trim($data) : $data; // Retourne les données filtrées, avec ou sans trim
}

// Fonction pour supprimer récursivement les espaces autour des chaînes dans un tableau
function array_trim(array $items): array
{
    return array_map(function ($item) {
        if (is_string($item)) {
            return trim($item); // Supprime les espaces au début et à la fin pour les chaînes
        } elseif (is_array($item)) {
            return array_trim($item); // Appelle la fonction récursivement pour les sous-tableaux
        }
        return $item; // Retourne l'élément tel quel s'il n'est pas une chaîne ou un tableau
    }, $items);
}