<?php $title = 'Connexion'; ?>
<?php ob_start(); ?>

<?php require('templates/login_form.php'); ?>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php') ?>