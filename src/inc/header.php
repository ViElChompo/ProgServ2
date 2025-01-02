<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css"> 
  <link rel="stylesheet" href="../css/style-header.css">
  <link rel="stylesheet" href="style.css">
    <title><?= $title ?? 'Home' ?></title>
</head>


<body>
 <!-- Code pour le header  -->

 <header class="main-header">
    <div class="container">
        <a href="index.php" class="logo">
            <img src="placeholder-logo.png" alt="Logo">
        </a>
        <nav class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="bibliotheque.php">Bibliothèque</a>
        </nav>
        <div class="auth-links">
            <a href="register.php" class="button">S'inscrire</a>
            <a href="login.php" class="button">Se connecter</a>
        </div>
    </div>
</header>

<main>
    
    <?php flash()?>