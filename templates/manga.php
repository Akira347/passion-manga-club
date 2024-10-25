<?php $title = $manga['title']; ?>

<?php ob_start(); ?>

<div class="align_center">
    <h2><?= $manga['title'] ?></h2>
    <h3><?= $manga['title_en'] ?></h3>
    <img src="<?= $manga['poster_url'] ?>" alt="Affiche de <?= $manga['title'] ?>">
</div>

<div class="reviews">
    <h2>Recommandations :</h2>
    <?php foreach($reviews as $review) : ?>
        <h3><?= $review['nickname'] ?> le <?= $review['date'] ?></h3>
        <p><?= $review['review'] ?></p>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php') ?>