<?php $title = "Mangas recommandés"; ?>

<?php ob_start(); ?>

<div class="mangas_list">
<?php foreach ($mangas as $manga): ?>
    <a href="index.php?action=manga&id=<?= $manga['id'] ?>" class="manga_list">
        <h2><?= $manga['title'] ?></h2>
        <h3>
            <?php if(empty($manga['title_en'])): ?>
                <?= $manga['title'] ?>
            <?php else: ?>
                <?= $manga['title_en'] ?>
            <?php endif; ?>
        </h3>
        <img src="<?= $manga['poster_url']?>" alt="Affiche <?= $manga['title'] ?>" class="cover_image">
    </a>
<?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php') ?>