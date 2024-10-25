<header>
    <nav>
        <ul>
            <li>
                <!-- Formulaire de recherche de manga -->
                <form action="index.php?action=search" method="POST">
                    <!--
                        Il faudra ajouter une icône cliquable d'aspect Loupe afin que la soumission du formulaire puisse se faire à la souris ou en focus du bouton icon loupe
                        et non pas juste au clavier avec la touche Entrée
                        De préférence à droite de la barre de recherche pour des questions d'accessibilité
                    -->
                    <!-- <i class="bi bi-search"></i> -->
                    <label for="search" class="hidden">Recherche de manga</label>
                    <input class="form-control" type="text" placeholder="Rechercher un manga" name="search" id="search">
                </form>
            </li>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="index.php?action=mangas">Mangas</a></li>
            <?php if (isset($_SESSION['user'])) : ?>
                <li><a href="#"><?php echo $_SESSION['user']['nickname']; ?></a></li>
                <li><a href="index.php?action=logout"><img src="src/img/logout_min.jpg" alt="Déconnexion" class="logout"></a></li>
            <?php else : ?>
                <li><a href="index.php?action=login">Connexion</a></li>
            <?php endif; ?>
        </ul> 
    </nav>
</header>