<?php
    session_start();
    require_once(__DIR__ . '/config/mysql.php');
    require_once(__DIR__ . '/database_connect.php');
    require_once(__DIR__ . '/variables.php');
    require_once(__DIR__ . '/functions.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once(__DIR__.'/incl/link.php'); ?>
    <title>P M C - Accueil</title>
</head>
<body>
    <?php require_once(__DIR__.'/incl/header.php'); ?>
        
    <div class="container">
        
    </div>

    <?php require_once(__DIR__.'/incl/footer.php'); ?>
</body>
</html>