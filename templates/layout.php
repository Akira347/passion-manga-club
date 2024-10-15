<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="src/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <?php require_once('header.php'); ?>

        <h1>Passion Manga Club</h1>
        <div class="container">
            <?= $content ?>
        </div>
        
        <?php require_once('footer.php'); ?>
    </body>
</html>