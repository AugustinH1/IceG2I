-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 18 mai 2022 à 10:09
-- Version du serveur :  10.3.34-MariaDB-0ubuntu0.20.04.1
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `IceG2I`
--

-- --------------------------------------------------------

--
-- Structure de la table `Avis`
--

CREATE TABLE `Avis` (
  `id_avis` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `avis` varchar(1000) DEFAULT NULL,
  `note` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Avis`
--

INSERT INTO `Avis` (`id_avis`, `id_user`, `id_produit`, `avis`, `note`) VALUES
(1, 1, 1, 'Je les ai achetés, ils sont biens !', 5),
(2, 2, 1, 'Je vais les acheter aussi, merci pour ton commentaire', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Commande`
--

CREATE TABLE `Commande` (
  `id_commande` int(11) NOT NULL,
  `date` date NOT NULL,
  `etat_livraison` int(11) NOT NULL DEFAULT 0,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `code_postal` int(11) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `CB` varchar(16) NOT NULL,
  `CVV` int(11) NOT NULL,
  `date_expiration` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Commande`
--

INSERT INTO `Commande` (`id_commande`, `date`, `etat_livraison`, `nom`, `prenom`, `adresse`, `ville`, `code_postal`, `telephone`, `CB`, `CVV`, `date_expiration`, `id_user`) VALUES
(1, '2022-05-16', 1, 'VISEUR', 'Lara', '27 rue Pierre Mendes France', 'Annoeullin', 59112, '0782469503', '1234567891234567', 338, '2024-01-01', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Detail_commande`
--

CREATE TABLE `Detail_commande` (
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Detail_commande`
--

INSERT INTO `Detail_commande` (`id_commande`, `id_produit`, `quantite`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Entreprise`
--

CREATE TABLE `Entreprise` (
  `id_entreprise` int(11) NOT NULL,
  `nom_entreprise` varchar(50) NOT NULL,
  `siege_social` varchar(50) NOT NULL,
  `tel_entreprise` varchar(10) NOT NULL,
  `siret` varchar(14) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Entreprise`
--

INSERT INTO `Entreprise` (`id_entreprise`, `nom_entreprise`, `siege_social`, `tel_entreprise`, `siret`, `id_user`) VALUES
(1, 'IceG2I', '13 Rue Jean Souvraz, 62300 Lens', '0321748585', '23119098712315', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Panier`
--

CREATE TABLE `Panier` (
  `id_user` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Panier`
--

INSERT INTO `Panier` (`id_user`, `id_produit`, `quantite`) VALUES
(2, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Produit`
--

CREATE TABLE `Produit` (
  `id_produit` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `url_photo` varchar(500) NOT NULL,
  `prix` float NOT NULL,
  `niveau` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `pointure` int(11) NOT NULL,
  `marque` varchar(30) NOT NULL,
  `lames` varchar(50) NOT NULL,
  `poids` float NOT NULL,
  `id_entreprise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Produit`
--

INSERT INTO `Produit` (`id_produit`, `nom`, `description`, `url_photo`, `prix`, `niveau`, `type`, `pointure`, `marque`, `lames`, `poids`, `id_entreprise`) VALUES
(1, 'Patin Risport ELECTRA', 'Patins artistiques en cuir blanc avec talon en bois ', 'https://duckduckgo.com/?q=patin+electra+risport&t=raspberrypi&iax=images&ia=images&iai=https%3A%2F%2Fwww.lestelskates.com%2F5024%2Fpatin-completo-risport-electra-con-cuchillas-stifeld-synchro-patinaje-artistico-hielo.jpg', 270, 'amateur', 'artistique', 39, 'risport', 'mk blades sauts simples', 2, 1),
(2, 'Patin BAUER VAPOR X2.5', 'Quartiers polycarbone avec doublure en microfibre et mousse à la cheville à mémoire de forme pour un meilleur confort', 'https://duckduckgo.com/?q=patin+hockey&t=raspberrypi&iax=images&ia=images&iai=https%3A%2F%2Fwww.skatingpro.fr%2F1032%2Fpatin-bauer-vapor-x25-bauer.jpg', 130, 'novice', 'hockey', 45, 'Bauer', 'TUUK stainless acier', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passe` varchar(30) NOT NULL,
  `connecte` int(11) NOT NULL DEFAULT 0,
  `entreprise` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`id_user`, `email`, `username`, `passe`, `connecte`, `entreprise`) VALUES
(1, 'lara.viseur@ig2i.centralelille.fr', 'lara', 'Lara_mdp', 0, 1),
(2, 'augustin.husson@ig2i.centralelille.fr', 'augustin', 'Augustin_mdp', 1, 0),
(11, 'ah@gmail.com', 'ah', 'ah', 1, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Avis`
--
ALTER TABLE `Avis`
  ADD PRIMARY KEY (`id_avis`),
  ADD KEY `Avis_ibfk_1` (`id_user`),
  ADD KEY `Avis_ibfk_2` (`id_produit`);

--
-- Index pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `Commande_ibfk_1` (`id_user`);

--
-- Index pour la table `Detail_commande`
--
ALTER TABLE `Detail_commande`
  ADD PRIMARY KEY (`id_commande`,`id_produit`),
  ADD KEY `Detail_commande_ibfk_4` (`id_produit`);

--
-- Index pour la table `Entreprise`
--
ALTER TABLE `Entreprise`
  ADD PRIMARY KEY (`id_entreprise`),
  ADD KEY `Entreprise_ibfk_1` (`id_user`);

--
-- Index pour la table `Panier`
--
ALTER TABLE `Panier`
  ADD PRIMARY KEY (`id_user`,`id_produit`),
  ADD KEY `Panier_ibfk_2` (`id_produit`);

--
-- Index pour la table `Produit`
--
ALTER TABLE `Produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD KEY `Produit_ibfk_1` (`id_entreprise`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Avis`
--
ALTER TABLE `Avis`
  MODIFY `id_avis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Entreprise`
--
ALTER TABLE `Entreprise`
  MODIFY `id_entreprise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Produit`
--
ALTER TABLE `Produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Avis`
--
ALTER TABLE `Avis`
  ADD CONSTRAINT `Avis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`),
  ADD CONSTRAINT `Avis_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id_produit`);

--
-- Contraintes pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD CONSTRAINT `Commande_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`);

--
-- Contraintes pour la table `Detail_commande`
--
ALTER TABLE `Detail_commande`
  ADD CONSTRAINT `Detail_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `Commande` (`id_commande`),
  ADD CONSTRAINT `Detail_commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id_produit`),
  ADD CONSTRAINT `Detail_commande_ibfk_3` FOREIGN KEY (`id_commande`) REFERENCES `Commande` (`id_commande`),
  ADD CONSTRAINT `Detail_commande_ibfk_4` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id_produit`);

--
-- Contraintes pour la table `Entreprise`
--
ALTER TABLE `Entreprise`
  ADD CONSTRAINT `Entreprise_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`);

--
-- Contraintes pour la table `Panier`
--
ALTER TABLE `Panier`
  ADD CONSTRAINT `Panier_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`),
  ADD CONSTRAINT `Panier_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id_produit`),
  ADD CONSTRAINT `Panier_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`);

--
-- Contraintes pour la table `Produit`
--
ALTER TABLE `Produit`
  ADD CONSTRAINT `Produit_ibfk_1` FOREIGN KEY (`id_entreprise`) REFERENCES `Entreprise` (`id_entreprise`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
