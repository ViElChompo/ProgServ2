<?php

// Définition des constantes pour les messages flash
const FLASH = 'FLASH_MESSAGES'; // Clé principale pour stocker les messages flash dans la session

// Types de messages flash possibles
const FLASH_ERROR = 'error'; // Type d'erreur
const FLASH_WARNING = 'warning'; // Type d'avertissement
const FLASH_INFO = 'info'; // Type d'information
const FLASH_SUCCESS = 'success'; // Type de succès

/**
 * Créer un message flash et l'ajouter à la session
 *
 * @param string $name Nom du message flash
 * @param string $message Contenu du message
 * @param string $type Type du message (error, warning, info, success)
 * @return void
 */
function create_flash_message(string $name, string $message, string $type): void
{
    // Supprime un message existant avec le même nom dans la session
    if (isset($_SESSION[FLASH][$name])) {
        unset($_SESSION[FLASH][$name]); // Suppression du message précédent s'il existe
    }

    // Ajoute le nouveau message flash à la session
    $_SESSION[FLASH][$name] = ['message' => $message, 'type' => $type];
}

/**
 * Formater un message flash pour l'affichage
 *
 * @param array $flash_message Le message flash sous forme de tableau (avec message et type)
 * @return string Le message flash formaté en HTML
 */
function format_flash_message(array $flash_message): string
{
    // Retourne un message flash formaté en HTML avec la classe appropriée en fonction du type
    return sprintf('<div class="alert alert-%s">%s</div>',
        $flash_message['type'], // Type de message (success, warning, etc.)
        $flash_message['message'] // Le contenu du message
    );
}

/**
 * Afficher un message flash spécifique
 *
 * @param string $name Nom du message flash à afficher
 * @return void
 */
function display_flash_message(string $name): void
{
    // Vérifie si le message flash existe dans la session
    if (!isset($_SESSION[FLASH][$name])) {
        return; // Si aucun message avec ce nom, rien à faire
    }

    // Récupère le message flash depuis la session
    $flash_message = $_SESSION[FLASH][$name];

    // Supprime le message flash de la session après l'avoir affiché
    unset($_SESSION[FLASH][$name]);

    // Affiche le message flash formaté
    echo format_flash_message($flash_message);
}

/**
 * Afficher tous les messages flash
 *
 * @return void
 */
function display_all_flash_messages(): void
{
    // Vérifie si des messages flash existent dans la session
    if (!isset($_SESSION[FLASH])) {
        return; // Si aucun message flash n'est présent, rien à faire
    }

    // Récupère tous les messages flash
    $flash_messages = $_SESSION[FLASH];

    // Supprime tous les messages flash de la session après les avoir affichés
    unset($_SESSION[FLASH]);

    // Affiche tous les messages flash formatés
    foreach ($flash_messages as $flash_message) {
        echo format_flash_message($flash_message);
    }
}

/**
 * Gérer les messages flash : création ou affichage
 *
 * @param string $name Le nom du message flash
 * @param string $message Le contenu du message flash
 * @param string $type Le type du message (error, warning, info, success)
 * @return void
 */
function flash(string $name = '', string $message = '', string $type = ''): void
{
    // Si tous les paramètres sont fournis, créer un message flash
    if ($name !== '' && $message !== '' && $type !== '') {
        create_flash_message($name, $message, $type);
    }
    // Si seul le nom est fourni, afficher ce message flash
    elseif ($name !== '' && $message === '' && $type === '') {
        display_flash_message($name);
    }
    // Si aucun paramètre n'est fourni, afficher tous les messages flash
    elseif ($name === '' && $message === '' && $type === '') {
        display_all_flash_messages();
    }
}
