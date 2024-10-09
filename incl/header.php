<header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="mangas_list.php">Mangas</a></li>
            <li><a href="create_review.php">Recommander</a></li>
            <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php else : ?>
                <li><a href="login.php">Connexion</a></li>
            <?php endif; ?>
        </ul> 
    </nav>
</header>