<?php $title = 'Connexion'; ?>
<?php ob_start(); ?>

<!-- Formulaire de connexion -->
<form action="index.php?action=login" method="POST">
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
            <a href="index.php?action=register">Pas ce compte ? Inscrivez-vous</a>
        </div>
    </fieldset>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php') ?>