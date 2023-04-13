-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 avr. 2023 à 21:30
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `alkiff`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `id_panier` int(11) DEFAULT NULL,
  `totale` int(11) DEFAULT NULL,
  `valide` tinyint(1) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_prod` int(11) NOT NULL DEFAULT 1,
  `content` varchar(250) NOT NULL,
  `d` date NOT NULL DEFAULT current_timestamp(),
  `mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentpub`
--

CREATE TABLE `commentpub` (
  `id_pub` int(11) NOT NULL,
  `id_comment` int(30) NOT NULL,
  `comment_pub` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `idEvenement` int(11) NOT NULL,
  `nomEvenement` varchar(255) NOT NULL,
  `descriptionEvenement` varchar(255) NOT NULL,
  `dateEvenement` date NOT NULL,
  `prixEvenement` double NOT NULL,
  `nbreParticipantMax` int(11) NOT NULL,
  `nbreParticipant` int(11) DEFAULT NULL,
  `id_userE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id_pannier` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_pannier`, `id_user`) VALUES
(68, 68);

-- --------------------------------------------------------

--
-- Structure de la table `panier produit`
--

CREATE TABLE `panier produit` (
  `id_pannier` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `quantite` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

CREATE TABLE `participation` (
  `idParticipation` int(11) NOT NULL,
  `idUserPart` int(11) NOT NULL,
  `idEvent` int(11) NOT NULL,
  `dateParticipation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_product` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `product_description` text NOT NULL,
  `product_photo` varchar(250) NOT NULL,
  `product_price` float NOT NULL,
  `addeddate` date NOT NULL DEFAULT current_timestamp(),
  `related_artist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `id_pub` int(11) NOT NULL,
  `titre_pub` varchar(50) NOT NULL,
  `texte_pub` varchar(50) NOT NULL,
  `photo_pub` varchar(50) NOT NULL,
  `date_pub` date NOT NULL DEFAULT current_timestamp(),
  `id_userB` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `solde`
--

CREATE TABLE `solde` (
  `id_solde` int(11) DEFAULT NULL,
  `taux` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `first_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `gender`, `role`) VALUES
(39, 'a', 'b', 'abir', '$2a$10$RmILdKD22F/slBSy5UEHPOLebC2GffLxiPhTmjLIVY4J9OO.GdzvC', 'admin.admin@gmail.com', 1245, 'femme', 'ADMIN'),
(43, '', '', '', '$2a$10$0iSoDalJ/tPfPLQdgY/nY.NM6td6i3lVlYuqfWhY.FAf4sO1nsIkq', '', 1245, '', 'Client'),
(45, 'sawsen', 'labidi', 'sawseen', '$2a$10$VpXNXIw/J7auIBJvYAQ04e4HOEUUGbch/axMi5RMLowXZu0Mv4L6q', 'sawsen.ab@gmail.com', 1245, 'femme', 'Client'),
(47, '', '', '', '$2a$10$0uSpwq0FJ/eeEuHFX1IHrOeZra1XoNbPXV9MsXYRLkCm97b9VPZRi', '', 1245, '', 'Client'),
(48, 'danger', 'saf', 'safd', '$2a$10$aWTBV5mBNCY/jESiM/6d5.KBu84Q3zkonMeLcLbhZwNyeYS0gRRj2', 'dangersaf@gmail.com', 1245, 'homme', 'Client'),
(49, 'safwen', 'labidi', 'saf', '$2a$10$CyNtGxp9A4hJujMwMDqZYO1MSt0Wx4P3b7KrWlEHk/H4HQhEpAQ66', 'safabidi@gmail.com', 1245, 'homme', 'Client'),
(50, 'abiir', 'd', 'abyr', '$2a$10$uOwqSk4hMfpCcvGME5qJQOPiJwvJsKvNsw.JbeecAgVHB4yqhQdwi', 'abi.khlifi@esprit.tn', 1245, 'femme', 'Client'),
(51, 'loolo', 'lilo', 'lolilo', '$2a$10$5li3mKTmqSU5iwky3FeK9eGVJetKThlwLnMBgMfqUjzx6lGepd.uq', 'abir.khlifi@esprit.tn', 1245, 'homme', 'Client'),
(52, 'loolo', 'lilo', 'lolilo', '$2a$10$nzYWTfLHY121QEaUF6QQ.eGS8V.kVjJYILTpo5hag0oI0hMFiKKn6', 'abir.khlifi@esprit.tn', 1245, 'homme', 'Client'),
(53, '', '', '', '$2a$10$KlXIVDjYSmHiqi8NzcezIubZLMatcZFSD0V9htAohBM.PQQv4iGle', '', 1245, '', 'Client'),
(54, 'dfkdh', 'dshfkduh', 'jdkv', '$2a$10$WBHuq.NXtS0sT.4Ao5omUOF5xwlK5.MkDtFywq9LaZTOrS8V5ayde', 'abir.khlifi@esprit.tn', 1245, 'femme', 'Client'),
(55, 'heeloo', 'hey', 'heeyyy', '$2a$10$O6M25A45IY7gx4Hxe79IBeR0VCd0yVpq12X58CycHuuFRjVOWKzFq', 'hello@esprit.tn', 1245, 'femme', 'Client'),
(56, 'abirrr', 'kheelifi', 'khk', '$2a$10$2ZjX2Nv.UsabiAb4u8VWyupnM.x9SDTKFNkFjvVZXXUqgrIKHq/x2', 'abir.khlifi@esprit.tn', 1245, 'femme', 'Client'),
(57, 'vjhdfjk', 'njkj', 'nkbhujb', '$2a$10$SzN3z74/FTHcv1jU/5yVxO.HPb6HCV09ECUXT6RukONEh4h7uC29m', 'abir.khlifi@esprit.tn', 1245, 'fememme', 'Client'),
(58, 'vjhdfjk', 'njkj', 'nkbhujb', '$2a$10$.L/yrdO69WreLB.7Lk4KMuvSCxv2O1mA6pROm6bXS1jKq3PgChiX6', 'abir.khlifi@esprit.tn', 1245, 'fememme', 'Client'),
(59, 'vjhdfjk', 'njkj', 'nkbhujb', '$2a$10$YIClc/ixq7B5o6Aiz5KKHe4a74w2W3bPizGZCZFg9EerIvcoGTAfq', 'abdelwahab.bahouri@esprit.tn', 1245, 'fememme', 'Client'),
(60, 'h', 'h', 'u', '$2a$10$w4yQwJzmJR9nNYF0wYDtj.peTjF40y/91Bjl1qJKG6yIWTrRKdeay', 'abdelwahab.bahouri@esprit.tn', 1245, 'jkjh', 'Client'),
(61, 'abirrr', 'abi', 'abirkh', '$2a$10$LEFyO0hUWllrFU.KFYIyyuqNuU4/oWUrgPE65MommwkreMHGAMRju', 'abir.khlifi@esprit.tn', 1245, 'femme', 'Client'),
(62, 'saraahh', 'zayati', 'sarahzayati', '$2a$10$TNUAzfOUGKy6uQCAzZUZJuYcBBQ467EIqny5Nhi7n3kKQIepbzYuu', 'sarah.zayati@esprit.tn', 1245, 'femme', 'Client'),
(63, 'bob', 'bob', 'bob', '$2a$10$Wpmy2InLxudN6n48e/RAo.0hd8zuHvd37AbRSsCa.E7tu8Vn.UI1C', 'bob@zrg.gerg', 1245, 'df', 'Client'),
(64, 'siwsiw', 'bokh', 'bokhbokh', '$2a$10$2y/yyIo8nlTSjkC8z/SVhuahgpE9ESsCBxfOvYLrEaqGT5qgFPUle', 'siw@siw.tn', 1245, 'f', 'Client'),
(65, '', '', '', '$2a$10$HKjgrSBnOfO3a60Zul/AXOmeAFT/KeP69GvkH9VfmgBUREekZ11AW', '', 1245, '', 'Client'),
(66, 'sarah5324', 'sarah', 'sarah', '$2a$10$XjbIce9tMftrXHYi6QKqeevotT4fe8cy1UdNSlGRwPFRtrVbS1U/K', 'sarah123@gazeaz.faze', 1245, 'bi', 'Client'),
(68, 'test', 'test', 'test', '$2a$10$6hwMDxnuctcTxeSDlu2kdeiv6XZltUTn1nqcQz1OJqGuulHMFvuK6', 'test@test.test', 1245, 'test', 'Client');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `fk_panier` (`id_panier`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_prod` (`id_prod`);

--
-- Index pour la table `commentpub`
--
ALTER TABLE `commentpub`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_pub` (`id_pub`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`idEvenement`),
  ADD KEY `id_userE` (`id_userE`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id_pannier`),
  ADD KEY `fk_user` (`id_user`);

--
-- Index pour la table `panier produit`
--
ALTER TABLE `panier produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_panier` (`id_pannier`),
  ADD KEY `fk_produit` (`id_produit`);

--
-- Index pour la table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`idParticipation`),
  ADD KEY `fk_idUserPart` (`idUserPart`),
  ADD KEY `fk_idEvent` (`idEvent`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `related_artist` (`related_artist`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id_pub`),
  ADD KEY `id_userB` (`id_userB`);

--
-- Index pour la table `solde`
--
ALTER TABLE `solde`
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `commentpub`
--
ALTER TABLE `commentpub`
  MODIFY `id_comment` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `idEvenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id_pannier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `panier produit`
--
ALTER TABLE `panier produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `participation`
--
ALTER TABLE `participation`
  MODIFY `idParticipation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `id_pub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_prod`) REFERENCES `produits` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ibfk_3` FOREIGN KEY (`id_panier`) REFERENCES `panier produit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentpub`
--
ALTER TABLE `commentpub`
  ADD CONSTRAINT `commentpub_ibfk_1` FOREIGN KEY (`id_pub`) REFERENCES `publication` (`id_pub`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commentpub_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`id_userE`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier produit`
--
ALTER TABLE `panier produit`
  ADD CONSTRAINT `panier produit_ibfk_1` FOREIGN KEY (`id_pannier`) REFERENCES `panier` (`id_pannier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `panier produit_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `fk_idEvent` FOREIGN KEY (`idEvent`) REFERENCES `evenement` (`idEvenement`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idUserPart` FOREIGN KEY (`idUserPart`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`related_artist`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `publication_ibfk_1` FOREIGN KEY (`id_userB`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `solde`
--
ALTER TABLE `solde`
  ADD CONSTRAINT `solde_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
