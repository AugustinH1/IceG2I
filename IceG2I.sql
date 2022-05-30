-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 30 mai 2022 à 16:26
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
(17, 23, 5, 'Est ce qu\'ils sont bien ?', NULL),
(18, 23, 6, NULL, 5),
(19, 23, 6, 'Je les ai achetés : ils sont supers !', NULL),
(20, 21, 5, 'Ils sont très biens : n\'hésite pas si tu as des questions !', NULL),
(21, 23, 15, 'Ayant 40 ans et de petits pieds, ces patins me vont a ravir', NULL),
(22, 23, 15, NULL, 5);

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
(7, '2022-05-30', 2, 'Husson', 'Augustin', '12 rue jean Souvraz', 'Lens', 62300, '0782120424', '1234567890123456', 333, '2022-12-25', 23),
(9, '2022-05-30', 0, 'Husson', 'Augustin', '12 rue jean Souvraz', 'Lens', 62300, '0782120424', '1234567890123456', 333, '2022-12-25', 23),
(10, '2022-05-30', 2, 'HUSSON', 'Augustin', 'Ig2i', 'Lens', 62300, '0782120424', '0354768912310978', 123, '2022-06-04', 23);

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
(7, 6, 1),
(9, 10, 2),
(9, 13, 1),
(10, 15, 1);

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
(5, 'Bauer', 'Exeter Etat Unis', '0147243133', '12345678912345', 21),
(6, 'CCM', 'PARIS', '0000000000', '02345678912345', 22),
(7, 'Risport', '31044 Montebelluna Province of Treviso, Italy', '0423616611', '85910648258564', 24),
(8, 'Edea', ' 8 Boulevard Pierre et Marie Curie, 05000 GAP', '0492558123', '38590163849036', 25),
(9, 'jackson', 'Wshington Etats Unis', '0147582947', '83947205793616', 26),
(10, 'patintropbien', 'Lens', '1182180000', '69696969696969', 27);

-- --------------------------------------------------------

--
-- Structure de la table `Panier`
--

CREATE TABLE `Panier` (
  `id_user` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `Produit`
--

CREATE TABLE `Produit` (
  `id_produit` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
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
(5, 'Bauer Patins de Hockey Supreme S35', 'Le patin de hockey Bauer Supreme S35 est parfait pour le joueur de hockey récréatif! Il a été développé avec un 3D Poly Carbonate Quarter, ce qui lui donne plus de flexibilité, un confort d\'entrée de gamme et un effet visuel. Il a une languette en maille de 30 onces pour plus de confort pendant le patinage. Le fer est en acier inoxydable de sorte qu\'il offre un bon rapport qualité-prix. Le patin est prêt à démarrer et disponible en différentes tailles et niveaux.', 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcR3vd5mbbhtWYoReJwdzEp2XHD07MuByEx-zByvuZ9zHKy4E3Kr15gyD0vTAFLrlxpLs4TlZVgaJv4rOIIUcwJnmkRLXLu8Ng-kOgHlW7f7z7CQl1sIYFLBNg', 141.13, 'amateur', 'hokey', 44, 'Bauer', 'hokey', 400, 5),
(6, 'Bauer Patins de Hockey sur glace NSX Adulte', 'Le NSX Skate Senior de la célèbre marque Bauer est un super patin à glace pour les loisirs. Ce beau patin d’excellente qualité est spécialement conçu pour offrir un confort optimal et assurer une grande vitesse. Il est équipé d’un rembourrage des chevilles de forme anatomique, d’une languette en feutre en deux parties avec protection du métatarse et d’une semelle confortable EVA. Bref: ce patin ne te laissera pas tomber. Les patins sont livrés affûtés.', 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcREcmn4q8xOZ0m4StjfHpA3D_n8NT1YtHGT4_hrX_5Br-jbp8GoJIPe9Vf1g_F4u8fnMuONpDWA9ddZaR9tuWc5OSel8O3lrHN8Bq7BFTpxkiR9a3XpfxVb', 99.95, 'debutant', 'hokey', 44, 'Bauer', 'hokey', 300, 5),
(7, 'Bauer Patins de Hockey sur glace NSX Adulte', 'Le NSX Skate Senior de la célèbre marque Bauer est un super patin à glace pour les loisirs. Ce beau patin d’excellente qualité est spécialement conçu pour offrir un confort optimal et assurer une grande vitesse. Il est équipé d’un rembourrage des chevilles de forme anatomique, d’une languette en feutre en deux parties avec protection du métatarse et d’une semelle confortable EVA. Bref: ce patin ne te laissera pas tomber. Les patins sont livrés affûtés.', 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcREcmn4q8xOZ0m4StjfHpA3D_n8NT1YtHGT4_hrX_5Br-jbp8GoJIPe9Vf1g_F4u8fnMuONpDWA9ddZaR9tuWc5OSel8O3lrHN8Bq7BFTpxkiR9a3XpfxVb', 99.95, 'debutant', 'hokey', 45, 'Bauer', 'hokey', 300, 5),
(8, 'CCM Super Tacks 9370', 'Patins CCM Super Tacks 9370 pour les joueurs en recherchent de performances.\r\n\r\nDoublure intérieur en micro fibre HD avec protection contre l’abrasion durazone.\r\nSemelle extérieure en plastique haute résistance\r\nLanguette asymétrique avec protection anti morsure de lacets.\r\nFeutre de 7 mm avec couches de renforcement pour un confort et une protection accrus.\r\nLame en acier inoxydable CCM XS SUPPORT SPEEDBLADE XS', 'https://promoglace.com/8786-large_default/patins-ccm-super-tacks-9370.jpg', 239.95, 'amateur', 'hokey', 39, 'CCM', 'hokey', 350, 6),
(9, 'CCM Patins de Hockey Ribcor 74K', 'Les patins de hockey pour senior Ribcor 74K Sr de CCM proposent une conception raffinée offrant l\'équilibre parfait entre confort, ajustement et performance. Composés de quartiers en composite synthétique avec technologie d\'injection, ces patins proposent une bonne rigidité structurelle. La languette en feutre offre une protection gaufrée contre la pression des lacets et procure un confort amélioré. Le porte-lame Speedblade 4.0 propose une durabilité éprouvée avec un angle d\'attaque plus prononcé pour faciliter les enjambées et les virages', 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcTBQk8ssbD2vqujWRSzQ4bDbhHBqrgfcSLiZu2E6D4yPbCXNNjIVs4uKIUmYO5yzUAI5jWJYtk7EN6kX0-6bramG8cqw_PgVzMq-hYRLZPR7aW2DoxRFOtZ&amp;usqp=CAY', 149, 'confirmé', 'hokey', 47, 'CCM', 'hokey', 250, 6),
(10, 'Risport Electra', 'One of Risport’s best sellers, Electra offers the stability and comfort required for those who want to refine their figures and double and single jumps without sacrificing the touch of elegance integral to the sport. \r\n', 'https://stifeldshop.com/1514-superlarge_default/figure-skates-risport-electra-with-stifeld-synchro-stifeld-blades.jpg', 270, 'amateur', 'artistique', 39, 'risport', 'mk flight sauts simples', 500, 7),
(11, 'RF3 Pro', 'Le RF3 PRO apporte toutes les fonctionnalités du modèle RF1 ELITE pour accompagner les jeunes patineurs dans leur évolution, offrant un confort exceptionnel et des performances de haut niveau.', 'https://lamaisondupatin.fr/1030-large_default/rf3-pro.jpg', 290, 'confirmé', 'artistique', 37, 'risport', 'triple saut', 900, 7),
(12, 'EDEA Tempo lame balance', 'Bottine légère avec revêtement synthétique, anti abrasion et imperméabilisé.\r\nintérieur synthétique anti-bactérien\r\nSemelle fine et légère, pour un meilleur controle, microaérée', 'https://eisprinzessin.at/media/image/product/24690/md/edea-skate-motivo-inkl-balance-kufe.jpg', 140, 'débutant', 'artistique', 40, 'edea', 'lame balance', 600, 8),
(13, 'EDEA piano', 'Système anti-choc révolutionnaire qui permet une absorption des impacts incomparable.\r\nVerrou au talon pour une meilleure position du pied et gagner plus de contrôle\r\nLe Piano : ergonomique adapté à  la courbe du pied,  donnant au patineur une meilleure sensation et plus de contrôle de leurs mouvements tout en réduisant également les tensions.', 'https://i.pinimg.com/originals/87/84/3c/87843cd26ea71b2c600065274b495d8b.png', 650, 'professionnel', 'artistique', 39, 'edea', 'triple/quad', 800, 8),
(14, 'JACKSON artiste', 'Softer topline for increased comfort\r\nMicrofiber lining with memory foam ankle padding\r\nFlex notch for added flexibility\r\nFoam backed vinyl and mesh comfort tongue\r\nStylized PVC outsole for easy care\r\nFactory sharpened Ultima Mark IV all purpose chrome blade attached with screws', 'https://image.jimcdn.com/app/cms/image/transf/none/path/sbcec88f5dd0ce047/image/ic3cd16f5a0cde0bc/version/1562174105/image.jpg', 180, 'novice', 'artistique', 36, 'jackson', 'sauts simples', 700, 9),
(15, 'Nijdam Patin à glace enfant ajustable chausson semi-soft 3121', 'Déjà affûté ! Chausson semi-soft en trois pièces, ajustables sur 3 pointures au moyen d’un bouton pressoir à la cheville, deux boucles de serrage double-face avec fermeture rapide à serrure, chausson intérieur amovible en polyamide mesh, doublé de polyester, support patin synthétique à lames en acier inoxydable.\r\n', 'https://achatdeluge.fr/wp-content/uploads/2015/08/nijdam3121.jpg', 49, 'enfant', 'enfant', 33, 'Nijdam', 'vitesse', 250, 10);

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
(1, 'lara.viseur@ig2i.centralelille.fr', 'lara', 'Lara_mdp', 0, 0),
(2, 'augustin.husson@ig2i.centralelille.fr', 'augustin', 'Augustin_mdp', 1, 0),
(21, 'Bauer@Bauer.com', 'Bauer', 'Bauer', 0, 1),
(22, 'CCM@CCM.com', 'CCM', 'CCM', 1, 1),
(23, 'ah@gmail.com', 'ah', 'ah', 0, 0),
(24, 'risport@risort.com', 'risport', 'risport', 0, 1),
(25, 'edea@edea.com', 'elea', 'elea', 0, 1),
(26, 'jackson@jackson.com', 'jackson', 'jackson', 0, 1),
(27, 'patintropbien@patintropbien.com', 'patintropbien', 'patintropbien', 0, 1);

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
  MODIFY `id_avis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Entreprise`
--
ALTER TABLE `Entreprise`
  MODIFY `id_entreprise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Produit`
--
ALTER TABLE `Produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
