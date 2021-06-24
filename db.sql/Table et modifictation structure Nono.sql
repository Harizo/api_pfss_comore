-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           10.1.13-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour pfss_db
CREATE DATABASE IF NOT EXISTS `pfss_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pfss_db`;

-- Export de la structure de la table pfss_db. see_phaseexecution
DROP TABLE IF EXISTS `see_phaseexecution`;
CREATE TABLE IF NOT EXISTS `see_phaseexecution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Phase` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `montantalloue` int(11) DEFAULT NULL,
  `indemnite` int(11) DEFAULT NULL,
  `datedebut` datetime DEFAULT NULL,
  `datefin` datetime DEFAULT NULL,
  `programme_id` int(11) DEFAULT NULL,
  `a_ete_modifie` tinyint(4) NOT NULL DEFAULT '0',
  `supprime` tinyint(4) DEFAULT '0',
  `userid` int(11) DEFAULT NULL,
  `datemodification` datetime DEFAULT NULL,
  `pourcentage` float DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_61896A3B62BB7AEE` (`programme_id`),
  KEY `FK_see_phaseexecution_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_see_phaseexecution_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table pfss_db.see_phaseexecution : ~10 rows (environ)
/*!40000 ALTER TABLE `see_phaseexecution` DISABLE KEYS */;
INSERT INTO `see_phaseexecution` (`id`, `Code`, `Phase`, `montantalloue`, `indemnite`, `datedebut`, `datefin`, `programme_id`, `a_ete_modifie`, `supprime`, `userid`, `datemodification`, `pourcentage`, `id_sous_projet`) VALUES
	(1, 'ARSE1', 'Tranche1', NULL, 31500, '2016-04-05 09:00:00', '2016-04-13 09:00:00', 1, 1, 0, 5, '2018-09-04 15:28:26', 10, 2),
	(2, 'ARSE2', 'Tranche2', NULL, 220500, '2016-08-09 18:00:00', '2016-09-09 18:00:00', 1, 1, 0, NULL, NULL, 70, 2),
	(3, 'ARSE3', 'Tranche3', NULL, 63000, '2017-03-18 06:14:12', '2017-03-18 06:14:12', 1, 1, 0, NULL, NULL, 20, 2),
	(4, 'ACT1', 'Tranche1', NULL, 1000, NULL, NULL, NULL, 0, 0, NULL, NULL, 50, 1),
	(5, 'ACT2', 'Tranche2', NULL, 1000, NULL, NULL, NULL, 0, 0, NULL, NULL, 50, 1),
	(6, 'COV1', 'Tranche1', NULL, 35000, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 4),
	(7, 'COV2', 'Tranche2', NULL, 35000, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 4),
	(8, 'COV3', 'Tranche3', NULL, 35000, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 4),
	(9, 'IDB-1', 'Tranche1', NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, 50, 3),
	(10, 'IDB-2', 'Tranche2', NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, 50, 3);
/*!40000 ALTER TABLE `see_phaseexecution` ENABLE KEYS */;

-- Export de la structure de la table pfss_db. see_plainte
DROP TABLE IF EXISTS `see_plainte`;
CREATE TABLE IF NOT EXISTS `see_plainte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_serveur_cenrale` int(11) DEFAULT NULL,
  `menage_id` int(11) DEFAULT NULL,
  `activite_id` int(11) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  `cellulederecours_id` int(11) DEFAULT NULL,
  `typeplainte_id` int(11) DEFAULT NULL,
  `solution_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `programme_id` int(11) DEFAULT NULL,
  `Objet` longtext COLLATE utf8_unicode_ci,
  `datedepot` date DEFAULT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomplaignant` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresseplaignant` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `responsableenregistrement` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mesureprise` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateresolution` date DEFAULT NULL,
  `statut` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tranche_id` int(11) DEFAULT NULL,
  `a_ete_modifie` tinyint(4) NOT NULL DEFAULT '0',
  `supprime` tinyint(4) DEFAULT '0',
  `userid` int(11) DEFAULT NULL,
  `datemodification` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E49B59DA75E5878B` (`menage_id`),
  KEY `IDX_E49B59DA9B0F88B1` (`activite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table pfss_db.see_plainte : ~1 rows (environ)
/*!40000 ALTER TABLE `see_plainte` DISABLE KEYS */;
INSERT INTO `see_plainte` (`id`, `id_serveur_cenrale`, `menage_id`, `activite_id`, `id_sous_projet`, `cellulederecours_id`, `typeplainte_id`, `solution_id`, `village_id`, `programme_id`, `Objet`, `datedepot`, `reference`, `nomplaignant`, `adresseplaignant`, `responsableenregistrement`, `mesureprise`, `dateresolution`, `statut`, `telephone`, `tranche_id`, `a_ete_modifie`, `supprime`, `userid`, `datemodification`) VALUES
	(1, NULL, 204, NULL, 4, NULL, 1, 2, 214, 0, 'ménage inscrit sur la liste des ménages mais non présélectionné', '2021-01-01', 'COVID-19-CIBL-NGZ-OIC-DIM-IDJ-', 'Kourati Combo', 'KOSSOVO', 'UGP', 'hghghghghghghgh', NULL, '', '', NULL, 1, 0, 7, NULL);
/*!40000 ALTER TABLE `see_plainte` ENABLE KEYS */;

-- Export de la structure de la table pfss_db. situation_matrimoniale
DROP TABLE IF EXISTS `situation_matrimoniale`;
CREATE TABLE IF NOT EXISTS `situation_matrimoniale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Export de données de la table pfss_db.situation_matrimoniale : ~3 rows (environ)
/*!40000 ALTER TABLE `situation_matrimoniale` DISABLE KEYS */;
INSERT INTO `situation_matrimoniale` (`id`, `description`) VALUES
	(1, 'célibataire'),
	(2, 'marié(e)'),
	(3, 'veuf(ve)'),
	(4, 'divorcé(e)');
/*!40000 ALTER TABLE `situation_matrimoniale` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
