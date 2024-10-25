<?php $title = "Recherche '". $search ."'"; ?>

<?php ob_start(); ?>

<h2>Recommandés sur le site :</h2>
<section class="mangas_list">
    <?php if (empty($mangas)): ?>
        <h3>Ce manga n'est pas encore recommandé sur le site, retrouve-le ci-dessous et recommande-le à la communauté si tu le souhaites</h3>
    <?php endif; ?>

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
</section><br>

<h2>Recommander un manga :</h2>
<section class="mangas_list">
    <?php foreach ($mangasApi as $manga): ?>
        <a href="index.php?action=recommend&id=<?= $manga['id'] ?>" class="manga_list">
            <h2><?= $manga['title']['romaji'] ?></h2>
            <h3>
                <?php if(empty($manga['title']['english'])): ?>
                    <?= $manga['title']['romaji'] ?>
                <?php else: ?>
                    <?= $manga['title']['english'] ?>
                <?php endif; ?>
            </h3>
            <img src="<?= $manga['coverImage']['extraLarge']?>" alt="Affiche <?= $manga['title']['romaji'] ?>" class="cover_image">
        </a>
    <?php endforeach; ?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php') ?>