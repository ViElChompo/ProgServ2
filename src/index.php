<?php 
require __DIR__ .'/../src/bootstrap.php';
require_login();
?>
<?php view('header', ['title' => 'Dashboard']) ?>
<p>Welcome <?= current_user() ?> <a href="logout.php">Logout</a></p>
<?php view('footer') ?>



<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
