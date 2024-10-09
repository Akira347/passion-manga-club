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
    <link href="style/register.css" rel="stylesheet">
    <title>Inscription</title>
</head>
<body>
    <?php require_once(__DIR__.'/incl/header.php'); ?>

    <div class="container">
        <?php if (isset($_SESSION['user'])) : ?>
            <?php 
                redirectToUrl('index.php');
            ?>
        <?php else : ?>
            <!-- Formulaire d'inscription -->
            <form action="register_submit.php" method="POST" enctype="multipart/data-form">
                <fieldset>
                    <legend>Inscription</legend>
                    <div>
                        <label for="nickname">Pseudo (*)</label>
                        <input type="text" name="nickname" id="nickname" autofocus required>
                    </div>
                    <div>
                        <label for="e-mail">E-mail (*)</label>
                        <input type="email" name="e-mail" id="e-mail" required>
                    </div>
                    <div>
                        <label for="password">Mot de passe (*)</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div>
                        <label for="avatar">Avatar</label>
                        <input type="file" name="avatar" id="avatar">
                    </div>
                </fieldset>
                <div class="div_submit">
                    <input type="submit" class="btn_submit" value="Envoyer">
                </div>
            </form>
        <?php endif; ?>
    </div>

    <?php require_once(__DIR__.'/incl/footer.php'); ?>
</body>
</body>
</html>