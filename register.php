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
            <form action="register_submit.php" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Inscription</legend>

                    <?php if (isset($_SESSION['error_nickname_already_exist'])) : ?>
                    <div class="error_nickname">
                        <?php 
                            echo $_SESSION['error_nickname_already_exist']; 
                            unset($_SESSION['error_nickname_already_exist']); // Supprime le message d'erreur après affichage
                        ?>
                    </div>
                    <?php endif; ?>
                    <div>
                        <label for="nickname">Pseudo (*)</label>
                        <input type="text" name="nickname" id="nickname"
                            <?php
                                if (isset($_SESSION['nickname_already_exist']) && $_SESSION['nickname_already_exist'] === true) {
                                    echo 'class="input_error"';
                                    unset($_SESSION['nickname_already_exist']);
                                }

                                if (isset($_SESSION['nickname'])) {
                                    echo 'value='.$_SESSION['nickname'];
                                }
                            ?>
                            autofocus required>
                    </div>
                    <div>
                        <label for="e-mail">E-mail (*)</label>
                        <input type="email" name="e-mail" id="e-mail" <?php if (isset($_SESSION['email'])) { echo 'value='.$_SESSION['email']; } ?> required>
                    </div>
                    <div>
                        <label for="password">Mot de passe (*)</label>
                        <input type="password" name="password" id="password" <?php if (isset($_SESSION['password'])) { echo 'value='.$_SESSION['password']; } ?> required>
                    </div>
                    <!-- <div>
                        <label for="avatar">Avatar</label>
                        <input type="file" name="avatar" id="avatar">
                    </div> -->
                    <div class="div_submit">
                        <input type="submit" class="btn_submit" value="S'inscrire">
                    </div>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message">
                            <?php 
                                echo $_SESSION['error']; 
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                </fieldset>
            </form>
        <?php endif; ?>
    </div>

    <?php require_once(__DIR__.'/incl/footer.php'); ?>
</body>
</body>
</html>