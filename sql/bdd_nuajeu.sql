-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 05 sep. 2025 à 08:09
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd_nuajeu`
--

-- --------------------------------------------------------

--
-- Structure de la table `carte`
--

CREATE TABLE `carte` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `rarity` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `size` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `carte`
--

INSERT INTO `carte` (`id`, `name`, `rarity`, `category`, `size`) VALUES
(1, 'chemtrail', 'common', '?', 2000),
(2, 'nebuleuse', 'secret', 'espace', 2e17),
(3, 'nuage?', 'rare', '?', 1.5),
(4, 'nuage_craftmine', 'rare', 'nuajeux videos', 1000),
(5, 'nuage_de_fumee', 'rare', 'humeur', 800),
(6, 'nuage_de_mots', 'common', 'nuajeu de mots', 1),
(7, 'nuage_enerve', 'common', 'humeur', 800),
(8, 'nuage_fatigue', 'common', 'humeur', 800),
(9, 'nuage_de_lait', 'common', 'nuajeu de mots', 0.05),
(10, 'lion', 'common', 'nuanimaux', 2500),
(11, 'nuage_heureux', 'common', 'humeur', 800),
(12, 'nuage_triste', 'common', 'humeur', 800),
(13, 'prout', 'rare', 'troll', 0.2),
(14, 'tete_dans_les_nuages', 'common', 'nuajeu de mots', 0.3);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_collection`
--

CREATE TABLE `user_collection` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `carte`
--
ALTER TABLE `carte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_collection`
--
ALTER TABLE `user_collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `card_id` (`card_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `carte`
--
ALTER TABLE `carte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user_collection`
--
ALTER TABLE `user_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `user_collection`
--
ALTER TABLE `user_collection`
  ADD CONSTRAINT `user_collection_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_collection_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `carte` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
