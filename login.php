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
    <link href="style/login.css" rel="stylesheet">
    <title>Connexion</title>
</head>
<body>
    <?php require_once(__DIR__.'/incl/header.php'); ?>

    <div class="container">
        <?php if (isset($_SESSION['user'])) : ?>
            <?php 
                redirectToUrl('index.php');
            ?>
        <?php else : ?>
            <!-- Formulaire de connexion -->
            <form action="login_submit.php" method="POST">
                <fieldset>
                    <legend>Connexion</legend>
                    <div>
                        <label for="identifiant">E-mail ou Pseudo</label>
                        <input type="text" name="identifiant" id="identifiant" required autofocus>
                    </div>
                    <div>
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="div_submit">
                        <input type="submit" class="btn_submit" value="Se connecter">
                    </div>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message">
                            <?php 
                                echo $_SESSION['error']; 
                                unset($_SESSION['error']); // Supprime le message d'erreur après affichage
                            ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <a href="#">Identifiant ou mot de passe oublié ?</a>
                    </div>
                    <div>
                        <a href="register.php">Pas ce compte ? Inscrivez-vous</a>
                    </div>
                </fieldset>
            </form>
        <?php endif; ?>
    </div>

    <?php require_once(__DIR__.'/incl/footer.php'); ?>
</body>
</body>
</html>