-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 25 oct. 2024 à 17:23
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `passion_manga_club`
--

-- --------------------------------------------------------

--
-- Structure de la table `mangas`
--

CREATE TABLE `mangas` (
  `id` int(11) NOT NULL,
  `api_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `title_en` varchar(256) DEFAULT NULL,
  `poster_url` varchar(256) DEFAULT NULL,
  `synopsis` text NOT NULL,
  `release_date` date NOT NULL,
  `rating` float NOT NULL,
  `up_vote` int(11) NOT NULL,
  `down_vote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mangas`
--

INSERT INTO `mangas` (`id`, `api_id`, `title`, `title_en`, `poster_url`, `synopsis`, `release_date`, `rating`, `up_vote`, `down_vote`) VALUES
(17, 30013, 'ONE PIECE', 'One Piece', 'https://s4.anilist.co/file/anilistcdn/media/manga/cover/large/bx30013-ulXvn0lzWvsz.jpg', 'As a child, Monkey D. Luffy was inspired to become a pirate by listening to the tales of the buccaneer \"Red-Haired\" Shanks. But his life changed when Luffy accidentally ate the Gum-Gum Devil Fruit and gained the power to stretch like rubber...at the cost of never being able to swim again! Years later, still vowing to become the king of the pirates, Luffy sets out on his adventure...one guy alone in a rowboat, in search of the legendary \"One Piece,\" said to be the greatest treasure in the world...\n<br><br>\n(Source: Viz Media)', '1997-07-22', 91, 0, 0),
(19, 117802, 'ONE PIECE episode A', 'One Piece: Ace’s Story—The Manga', 'https://s4.anilist.co/file/anilistcdn/media/manga/cover/large/bx117802-CsCjUyuG4lSB.jpg', 'A manga adaptation of the novel \'One Piece: Ace\'s Story\', drawn by Boichi.\n<br><br>\n<i>Note: Chapter count includes two special one-shots: \"ONE PIECE: Roronoa Zoro, Umi ni Chiru\" and \"Nami vs Kalifa\".<i>', '2020-09-16', 79, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `user_id` int(11) NOT NULL,
  `manga_id` int(11) NOT NULL,
  `review` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`user_id`, `manga_id`, `review`, `date`) VALUES
(13, 17, 'Malgré son énorme popularité ce manga reste un must have pour les grands et les petits !', '2024-10-25'),
(13, 19, 'Oui pour le manga One Piece mais oui aussi pour ce super Volume ! Allez-y, je vous le recommande fortement.', '2024-10-25');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `register_date` date NOT NULL,
  `url_avatar` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `register_date`, `url_avatar`) VALUES
(5, 'Akira34', 'eric_f@gmail.com', '$2y$10$i5mOtaEN6riRgVq2zsWPj.FGLbG3hGQN056wpcSfrGClJwMl3oTeO', '2024-10-09', NULL),
(6, 'Akira', 'skate@gmail.com', '$2y$10$b/Stn4OYhPPOW4z7ZMDDieCmRIb3mAq3LGYl6QoWhZ2ZxhPPr7zii', '2024-10-15', NULL),
(13, 'Akira347', 'ska@gmail.com', '$2y$10$6f/C1FNEw1698h9x7GY1BOuOGXP6URte2bLmh.6Uop9Won08JwrzG', '2024-10-25', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `mangas`
--
ALTER TABLE `mangas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_id` (`api_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`user_id`,`manga_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `mangas`
--
ALTER TABLE `mangas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `mangas` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
