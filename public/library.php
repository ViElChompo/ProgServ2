<?php
require_once '../src/bootstrap.php';

if (!is_user_logged_in()) {
    redirect_to('login.php');
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css"/>
    <title>Bibliothèque</title>
</head>
<body>
<?php view('header') ?>
<main>
    <h1>Bibliothèque</h1>
    <!-- TODO : AJOUTER LA PAGE Bibliothèque -->
</main>
<?php view('footer') ?>
</body>
</html>

