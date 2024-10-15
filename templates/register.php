<?php $title = 'Inscription'; ?>

<!-- Formulaire d'inscription -->
<form action="index.php?action=register" method="POST" enctype="multipart/form-data">
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

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php');