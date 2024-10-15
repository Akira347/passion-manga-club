<header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="#">Mangas</a></li>
            <li><a href="#">Recommander</a></li>
            <?php if (isset($_SESSION['user'])) : ?>
                <li><a href="#"><?php echo $_SESSION['user']['nickname']; ?></a></li>
                <li><a href="logout.php"><img src="img/logout_min.jpg" alt="Déconnexion" class="logout"></a></li>
            <?php else : ?>
                <li><a href="login.php">Connexion</a></li>
            <?php endif; ?>
        </ul> 
    </nav>
</header>