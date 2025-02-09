-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 09 fév. 2025 à 15:51
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
-- Base de données : `quiz_coda`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$hOW5rbyKkCo4fOL196lXJ.N9PgNp1vhQgi9FahxNyTza50UXsDWaG');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Culturel'),
(2, 'Mathématiques'),
(3, 'Sciences'),
(4, 'Histoire'),
(5, 'Cinéma'),
(6, 'Jeux Vidéo');

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `good_response` text NOT NULL,
  `bad_responses` text NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question`, `description`, `good_response`, `bad_responses`, `point`) VALUES
(1, 1, 'Quelle est la capitale de la France ?', 'Capitale de pays', 'Paris', 'Londres, Berlin, Rome', 1),
(2, 1, 'Qui a peint la Joconde ?', 'Art et peinture', 'Léonard de Vinci', 'Michel-Ange, Van Gogh, Picasso', 1),
(3, 1, 'Quelle est la planète la plus proche du Soleil ?', 'Astronomie', 'Mercure', 'Vénus, Mars, Jupiter', 1),
(4, 1, 'En quelle année a eu lieu la Révolution Française ?', 'Histoire Française', '1789', '1776, 1804, 1914', 1),
(5, 1, 'Quel est le plus grand océan du monde ?', 'Géographie des océans', 'Océan Pacifique', 'Océan Atlantique, Océan Indien, Océan Arctique', 1),
(6, 2, 'Combien font 7 x 8 ?', '', '56', '48, 64, 49', 1),
(7, 2, 'Quelle est la racine carrée de 81 ?', '', '9', '8, 7, 10', 1),
(8, 2, 'Combien de côtés possède un hexagone ?', '', '6', '5, 8, 7', 1),
(9, 2, 'Quel est le résultat de 12 ÷ 4 ?', '', '3', '4, 2, 5', 1),
(10, 2, 'Que vaut π (Pi) approximativement ?', '', '3.14', '3.15, 2.72, 3.16', 1),
(11, 3, 'Quel est l’élément chimique représenté par le symbole O ?', '', 'Oxygène', 'Or, Osmium, Argent', 1),
(12, 3, 'Quelle est la vitesse de la lumière dans le vide ?', '', '300 000 km/s', '150 000 km/s, 3 000 km/s, 1 000 km/s', 1),
(13, 3, 'Quel organe humain filtre le sang ?', '', 'Reins', 'Foie, Poumons, Cœur', 1),
(14, 3, 'Quelle est la formule chimique de l’eau ?', '', 'H2O', 'CO2, O2, H2', 1),
(15, 3, 'Quel gaz est essentiel pour la respiration humaine ?', '', 'Oxygène', 'Azote, Hélium, Hydrogène', 1),
(16, 4, 'Qui était le premier président des États-Unis ?', '', 'George Washington', 'Abraham Lincoln, Thomas Jefferson, John Adams', 1),
(17, 4, 'Quelle guerre a eu lieu de 1914 à 1918 ?', '', 'Première Guerre mondiale', 'Deuxième Guerre mondiale, Guerre froide, Guerre de Cent Ans', 1),
(18, 4, 'Qui a écrit « L’Art de la guerre » ?', '', 'Sun Tzu', 'Confucius, Aristote, Machiavel', 1),
(19, 4, 'En quelle année est tombé le mur de Berlin ?', '', '1989', '1990, 1988, 1991', 1),
(20, 4, 'Quel pays a été dirigé par Napoléon Bonaparte ?', '', 'France', 'Espagne, Italie, Angleterre', 1),
(21, 5, 'Quel film a remporté l’Oscar du meilleur film en 1994 ?', '', 'Forrest Gump', 'Pulp Fiction, Le Roi Lion, Les Évadés', 1),
(22, 5, 'Qui a réalisé le film « Titanic » ?', '', 'James Cameron', 'Steven Spielberg, Martin Scorsese, Christopher Nolan', 1),
(23, 5, 'Dans quel film peut-on entendre la réplique « Je suis ton père » ?', '', 'Star Wars : L’Empire contre-attaque', 'Star Wars : Un nouvel espoir, Star Wars : Le retour du Jedi, Star Wars : La menace fantôme', 3),
(24, 5, 'Quel acteur joue le rôle principal dans « Iron Man » ?', '', 'Robert Downey Jr.', 'Chris Evans, Chris Hemsworth, Mark Ruffalo', 1),
(25, 5, 'Quel est le nom du célèbre robot dans le film « WALL-E » ?', '', 'WALL-E', 'EVE, R2-D2, BB-8', 1),
(26, 1, 'Combien de continents existe-t-il ?', 'Géographie globale', '7', '6, 8, 5', 1),
(27, 6, '', '', '', '', 1),
(28, 6, 'Zelda', '', '', '', 1),
(29, 6, 'Link', '', '', '', 1),
(30, 6, 'Ganondorf', '', '', '', 1),
(34, 12, 'efz', '', 'ef\'t', '\'éef, efz\'rt', 1),
(35, 13, 'hgrh', '', 'gbrzb', 'htehn', 1),
(36, 14, 'Quelle est la couleur emblématique de Mario ?', '', 'Rouge', 'Bleu, Vert, Jaune', 1),
(37, 14, 'Dans quelle série de jeux vidéo trouve-t-on Link et la princesse Zelda ?', '', 'The Legend of Zelda', 'Final Fantasy, Metroid, Fire Emblem', 1),
(38, 14, 'Quel Pokémon est considéré comme la mascotte officielle de la franchise ?', '', 'Pikachu', 'Bulbizarre, Rondoudou, Mewtwo', 1),
(39, 14, 'Quel est le nom de la console portable lancée par Nintendo en 1989 ?', '', 'Game Boy', 'Nintendo DS, Game Gear, PlayStation Portable', 1),
(40, 14, 'Quel est le nom du compagnon de Donkey Kong dans plusieurs de ses aventures ?', '', 'Diddy Kong', 'Kiddy Kong, Dixie Kong, Cranky Kong', 1),
(41, 14, 'Quel est le nom du principal antagoniste de Mario, souvent associé à des châteaux et des flammes ?', '', 'Bowser', 'Ganondorf, King K. Rool, Dr. Eggman', 1),
(42, 14, 'Dans \"Splatoon\", comment se déplacent les Inklings sous forme de calmar ?', '', 'En nageant dans l\'encre', 'En volant dans l\'air, En sautant sur des plateformes, En roulant comme des roues', 1),
(43, 14, 'Quel personnage est connu pour absorber ses ennemis et copier leurs pouvoirs ?', '', 'Kirby', 'Meta Knight, Waddle Dee, Yoshi', 1),
(44, 14, 'Dans \"Animal Crossing\", quel personnage gère généralement les prêts immobiliers pour votre maison ?', '', 'Tom Nook', 'Isabelle, K.K. Slider, Resetti', 1),
(45, 14, 'Quel jeu Nintendo se déroule dans une arène où des personnages célèbres s\'affrontent ?', '', 'Super Smash Bros', 'Mario Kart, Fire Emblem, Arms', 1);

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `name_quiz` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `creator` text NOT NULL,
  `categorie` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`id`, `name_quiz`, `enabled`, `description`, `creator`, `categorie`) VALUES
(1, 'Culture Générale', 1, 'Testez vos connaissances générales.', 'admin', 'Culturel'),
(2, 'Mathématiques', 1, 'Êtes-vous aussi bon en maths comme vous le prétendais ?', 'admin', 'Mathématiques'),
(3, 'Sciences', 1, 'Découvrez le monde des sciences.', 'admin', 'Sciences'),
(4, 'Histoire', 1, 'Explorez les grands moments de l’histoire.', 'admin', 'Histoire'),
(5, 'Cinéma', 1, 'Testez vos connaissances sur le cinéma.', 'admin', 'Cinéma'),
(6, 'ujb', 0, 'hbîbibjhubô', 'hylien', '0'),
(8, '(et', 0, '(tre', '(\"trgefd', '0'),
(9, '(et', 0, '(tre', '(\"trgefd', '0'),
(12, 'zerf', 1, 'ezr', 'é\'ef', '1'),
(13, 'ht', 0, 'thbzqyhg', 'nhbrg', '1'),
(14, 'Univers Nintendo', 1, 'Testez vos connaissances sur l\'univers Nintendo avec ce quiz à choix multiples. Trouvez la bonne réponse parmi les 4 propositions !', 'Darlit0', 'Jeux Vidéo');

-- --------------------------------------------------------

--
-- Structure de la table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `results`
--

INSERT INTO `results` (`id`, `quiz_id`, `score`, `created_at`) VALUES
(1, 4, 0, '2025-01-09 15:47:05'),
(2, 5, 0, '2025-01-09 15:47:08'),
(3, 1, 0, '2025-01-09 15:47:10'),
(4, 1, 0, '2025-01-09 15:47:11'),
(5, 1, 0, '2025-01-09 15:47:11'),
(6, 1, 0, '2025-01-09 15:47:11'),
(7, 1, 0, '2025-01-09 15:47:11');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
