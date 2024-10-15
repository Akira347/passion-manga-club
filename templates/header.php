<header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="#">Mangas</a></li>
            <li><a href="#">Recommander</a></li>
            <?php if (isset($_SESSION['user'])) : ?>
                <li><a href="#"><?php echo $_SESSION['user']['nickname']; ?></a></li>
                <li><a href="index.php?action=logout"><img src="img/logout_min.jpg" alt="Déconnexion" class="logout"></a></li>
            <?php else : ?>
                <li><a href="index.php?action=login">Connexion</a></li>
            <?php endif; ?>
        </ul> 
    </nav>
</header>