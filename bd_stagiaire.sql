-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 15 déc. 2022 à 16:00
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_stagiaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `control_auto`
--

CREATE TABLE `control_auto` (
  `activation` int(1) NOT NULL,
  `heure` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `control_auto`
--

INSERT INTO `control_auto` (`activation`, `heure`) VALUES
(1, '17:32:00');

-- --------------------------------------------------------

--
-- Structure de la table `import_auto`
--

CREATE TABLE `import_auto` (
  `id` int(11) NOT NULL,
  `id_atm` int(11) NOT NULL,
  `file_date` date NOT NULL,
  `datetime_add` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `import_manuel`
--

CREATE TABLE `import_manuel` (
  `id` int(11) NOT NULL,
  `id_cmd` int(20) NOT NULL,
  `id_atm` int(11) NOT NULL,
  `file_date` date NOT NULL,
  `datetime_add` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `list_atm_confirmed`
--

CREATE TABLE `list_atm_confirmed` (
  `id_atm` int(11) NOT NULL,
  `terminal` int(9) UNSIGNED ZEROFILL NOT NULL,
  `work_station_name` varchar(50) NOT NULL,
  `ip_adress` varchar(50) NOT NULL,
  `mac_adress` varchar(20) NOT NULL,
  `date_add` datetime NOT NULL,
  `state` int(1) NOT NULL,
  `state_confirm` tinyint(1) NOT NULL,
  `execution_mode` int(11) NOT NULL,
  `execution_mode_version` varchar(30) NOT NULL,
  `last_version` varchar(30) NOT NULL,
  `last_connexion` datetime NOT NULL,
  `state_send_status` tinyint(1) NOT NULL,
  `state_parse_journal` tinyint(1) NOT NULL,
  `state_exec_command` tinyint(1) NOT NULL,
  `state_sleep_command` int(11) NOT NULL,
  `time_sleeping` int(11) NOT NULL,
  `type_gab` int(11) NOT NULL,
  `nbr_jr_file` int(11) NOT NULL,
  `state_send_image` tinyint(1) NOT NULL,
  `state_send_binaire` tinyint(1) NOT NULL,
  `state_upload` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `list_atm_confirmed`
--

INSERT INTO `list_atm_confirmed` (`id_atm`, `terminal`, `work_station_name`, `ip_adress`, `mac_adress`, `date_add`, `state`, `state_confirm`, `execution_mode`, `execution_mode_version`, `last_version`, `last_connexion`, `state_send_status`, `state_parse_journal`, `state_exec_command`, `state_sleep_command`, `time_sleeping`, `type_gab`, `nbr_jr_file`, `state_send_image`, `state_send_binaire`, `state_upload`) VALUES
(0, 000000000, '', '', '', '0000-00-00 00:00:00', 0, 0, 0, '', '', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1, 000001122, 'WSSCSS0002', '10.20.12.1', '18:60:24:A8:68:2D', '2020-07-16 12:13:08', 0, 1, 0, '', '', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `list_cmd`
--

CREATE TABLE `list_cmd` (
  `id_cmd` int(20) NOT NULL,
  `file_date` date DEFAULT NULL,
  `datetime_add` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login` varchar(20) NOT NULL,
  `state` int(2) NOT NULL,
  `id_atm` int(11) NOT NULL,
  `time_import_auto` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `state_description`
--

CREATE TABLE `state_description` (
  `state` int(2) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `state_description`
--

INSERT INTO `state_description` (`state`, `description`) VALUES
(1, 'Importation réussite '),
(2, 'Demande d\'importation'),
(3, 'Déjà importé'),
(4, 'Echec de t\'importation'),
(5, 'demande de consultation (fichier non trouvé)'),
(6, 'mise à jour de l\'heure du transfert automatique'),
(7, 'Liste les fichiers de tous les GABs '),
(8, 'demande de consultation (fichier trouvé)'),
(9, 'demande d\'activation du transfert automatique'),
(10, 'demande de desactivation du transfert automatique'),
(11, 'désactivation totale du transfert'),
(12, 'activation totale du transfert'),
(13, 'consultation de l\'état du GAB');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `iduser` int(4) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `etat` int(1) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`iduser`, `login`, `email`, `role`, `etat`, `pwd`) VALUES
(1, 'MOUSLIH', 'admin@gmail.com', 'ADMIN', 1, 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'user1', 'user1@gmail.com', 'SUPERVISEUR', 1, '202cb962ac59075b964b07152d234b70'),
(3, 'user2', 'user2@gmail.com', 'SUPERVISEUR', 0, 'e10adc3949ba59abbe56e057f20f883e'),
(4, 'user3', 'zineb.msl147@gmail.com', 'SUPERVISEUR', 1, '4a7d1ed414474e4033ac29ccb8653d9b'),
(5, 'user4', 'user4@gmail.com', 'SUPERVISEUR', 0, '202cb962ac59075b964b07152d234b70');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `import_auto`
--
ALTER TABLE `import_auto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_atm` (`id_atm`);

--
-- Index pour la table `import_manuel`
--
ALTER TABLE `import_manuel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cmd` (`id_cmd`),
  ADD KEY `id_atm` (`id_atm`);

--
-- Index pour la table `list_atm_confirmed`
--
ALTER TABLE `list_atm_confirmed`
  ADD PRIMARY KEY (`id_atm`),
  ADD KEY `FK_mode_execution_TO_list_atm_confirmed` (`execution_mode`);

--
-- Index pour la table `list_cmd`
--
ALTER TABLE `list_cmd`
  ADD PRIMARY KEY (`id_cmd`),
  ADD KEY `id_atm` (`id_atm`),
  ADD KEY `state` (`state`);

--
-- Index pour la table `state_description`
--
ALTER TABLE `state_description`
  ADD PRIMARY KEY (`state`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `import_manuel`
--
ALTER TABLE `import_manuel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `list_atm_confirmed`
--
ALTER TABLE `list_atm_confirmed`
  MODIFY `id_atm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100001;

--
-- AUTO_INCREMENT pour la table `list_cmd`
--
ALTER TABLE `list_cmd`
  MODIFY `id_cmd` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=457;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `iduser` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `import_auto`
--
ALTER TABLE `import_auto`
  ADD CONSTRAINT `import_auto_ibfk_1` FOREIGN KEY (`id_atm`) REFERENCES `list_atm_confirmed` (`id_atm`);

--
-- Contraintes pour la table `import_manuel`
--
ALTER TABLE `import_manuel`
  ADD CONSTRAINT `import_manuel_ibfk_1` FOREIGN KEY (`id_cmd`) REFERENCES `list_cmd` (`id_cmd`),
  ADD CONSTRAINT `import_manuel_ibfk_2` FOREIGN KEY (`id_atm`) REFERENCES `list_atm_confirmed` (`id_atm`);

--
-- Contraintes pour la table `list_cmd`
--
ALTER TABLE `list_cmd`
  ADD CONSTRAINT `list_cmd_ibfk_1` FOREIGN KEY (`id_atm`) REFERENCES `list_atm_confirmed` (`id_atm`),
  ADD CONSTRAINT `list_cmd_ibfk_2` FOREIGN KEY (`id_atm`) REFERENCES `list_atm_confirmed` (`id_atm`),
  ADD CONSTRAINT `list_cmd_ibfk_3` FOREIGN KEY (`state`) REFERENCES `state_description` (`state`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
