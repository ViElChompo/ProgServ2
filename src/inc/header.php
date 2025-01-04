<header class="header">
    <a href="/index.php" class="logo">
        <img src="images/logo_brainwave.png" alt="Logo"/>
    </a>
    <input class="menu-btn" type="checkbox" id="menu-btn"/>
    <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
    <ul class="menu">
        <li><a href="/index.php">Accueil</a></li>
        <li><a href="/library.php">Bibliothèque</a></li>
        <?php
        if (is_user_logged_in()) {
            ?>
            <li><a class="btn__parameters" href="/parameters.php" id="parameter">Paramêtre</a></li>
            <li><a class="btn__logout" href="/logout.php" id="disconnect">Se déconnecter</a></li>
            <?php
        } else {
            ?>
            <li><a class="btn__register" href="/register.php" id="inscrire">S'inscrire</a></li>
            <li><a class="btn__login" href="/login.php" id="connecter">Se connecter</a></li>
            <?php
        }
        ?>

    </ul>
</header>