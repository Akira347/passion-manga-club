<!-- Formulaire de connexion, on garde l'origine (from et id s'il y en a un) pour rediriger l'utilisateur vers la page où il était lors de sa connexion -->
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
            <input type="hidden" name="redirect_url" value="<?php echo isset($current_page) ? $current_page : ''; ?>">
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