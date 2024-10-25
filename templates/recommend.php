<?php $title = $manga['title']['romaji']; ?>

<?php ob_start(); ?>

<div class="align_center">
    <h2><?= $manga['title']['romaji'] ?></h2>
    <h3><?= $manga['title']['english'] ?></h3>
    <img src="<?= $manga['coverImage']['extraLarge'] ?>" alt="Affiche de <?= $manga['title']['romaji'] ?>">
    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) : ?>
        <p>
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </p>
    <?php else: ?>
        <?php if (isset($_SESSION['user'])): ?>
            <form action="index.php?action=recommend&id=<?= $id ?>" method="POST">
                <fieldset>
                    <legend>Recommandation</legend>
                    <label for="recommendMessage" class="hidden">Message de recommandation</label>
                    <textarea id="recommendMessage" name="recommendMessage" cols="40" row="50" placeholder="Message de recommandation"></textarea>
                    <input type="submit" value="Envoyer" class="btn_submit">
                </fieldset>
            </form>
        <?php else: ?>
            <div>
                <p>Si vous souhaitez recommander ce manga à la communauté, veuillez vous connecter avant :</p>
            </div>
            <!-- Le visiteur doit être connecté s'il souhaite recommandé un manga, on lui affiche donc le formulaire de connexion et on le redirige vers la page de recommendation de ce manga via le contrôleur login -->
            <?php $current_page = $_SERVER['REQUEST_URI']; ?>
            
            <?php require('templates/login_form.php') ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php') ?>