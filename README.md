# passion-manga-club
Site de recommandations de Mangas entre passionnés pour Apprentissage dev web

Ceci est mon projet fil rouge d'autoformation, je vais décrire l'évolution de mon code via le système d'étiquettes de Git, afin de suivre le projet de
ses balbutiements (PHP procédural) jusqu'à sa version finale (Symfony) en passant par ses différentes transformations (POO, MVC, namespaces, routeur, layout, autoloading, Exceptions, etc.)
au fur et à mesure de l'avancement de la formation.

Voici les étiquettes :
<ul>
<li><a href="https://github.com/Akira347/passion-manga-club/tree/v0.1">v0.1 - PHP procédural : Authentification</a></li>
<li><a href="https://github.com/Akira347/passion-manga-club/tree/v0.2">v0.2 - Transformation du code existant vers POO/MVC</a></li>
<li>
    <a href="https://github.com/Akira347/passion-manga-club/tree/v1.0">v1.0 - Optimisation et Implémentation des fonctionnalités de Recherche, de Recommandation et d'affichages de Mangas recommandés</a> :
    <ul>
        <li>Ajout de la fonction d'autoload pour require_once nos classes uniquement lorsqu'on en a besoin,</li>
        <li>Ajout de Composer et de son autoload notamment pour Guzzle 7 à des fins de requêtage sur l'API autour des Mangas utilisant Graph QL : Anilist,</li>
        <li>Header : remplacement de l'onglet Recommander par une barre de Recherche visant à chercher les mangas présents en base de données et sur l'API pour que le visiteur puisse Recommander un manga,</li>
        <li>Ajout de la fonctionnalité de Recommandation qui ajoute le manga et la review à la bdd uniquement si le visiteur est connecté,</li>
        <li>Affichage du formulaire de connexion à la place du formulaire de recommandation si le visiteur n'est pas connecté,</li>
        <li>Ajout de la fonctionnalité d'affichage des mangas recommandés par les utilisateurs dans l'onglet Mangas,</li>
        <li>Affichage des recommandations lors de la consultation d'un manga recommandé, début développement fonctionnalité Review.</li>
    </ul>
</li>