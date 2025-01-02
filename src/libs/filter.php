<?php

/**
 * Sanitize and validate data
 * Fonction pour assainir et valider les données
 * @param array $data Les données à traiter
 * @param array $fields Les règles de validation et de nettoyage des champs
 * @param array $messages Messages d'erreur personnalisés pour chaque champ
 * @return array Un tableau contenant les données assainies et les erreurs éventuelles
 */
function filter(array $data, array $fields, array $messages = []): array
{
    // Initialisation des tableaux pour les règles de nettoyage et de validation
    $sanitization = []; // Règles de nettoyage
    $validation = []; // Règles de validation

    // Extraction des règles de nettoyage et de validation pour chaque champ
    foreach ($fields as $field => $rules) {
        // Si les règles contiennent un pipe (séparateur entre nettoyage et validation)
        if (strpos($rules, '|')) {
            // Sépare les règles en deux (nettoyage et validation) et les assigne aux tableaux correspondants
            [$sanitization[$field], $validation[$field]] = explode('|', $rules, 2);
        } else {
            // Si une seule règle est donnée (uniquement pour le nettoyage)
            $sanitization[$field] = $rules;
        }
    }

    // Assainir les données en appliquant les règles de nettoyage
    $inputs = sanitize($data, $sanitization); // Utilise la fonction 'sanitize' pour nettoyer les données selon les règles définies

    // Valider les données assainies en appliquant les règles de validation
    $errors = validate($inputs, $validation, $messages); // Utilise la fonction 'validate' pour valider les données

    // Retourner les données assainies et les erreurs éventuelles
    return [$inputs, $errors];
}
