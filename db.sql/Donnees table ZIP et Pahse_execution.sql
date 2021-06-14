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
	(6, 'COV1', 'Tranche1', NULL, 35000, NULL, NULL, NULL, 0, 0, NULL, NULL, 33, 4),
	(7, 'COV2', 'Tranche2', NULL, 35000, NULL, NULL, NULL, 0, 0, NULL, NULL, 33, 4),
	(8, 'COV3', 'Tranche3', NULL, 35000, NULL, NULL, NULL, 0, 0, NULL, NULL, 33, 4),
	(9, 'IDB-1', 'Tranche1', NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, 50, 3),
	(10, 'IDB-2', 'Tranche2', NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, 50, 3);
/*!40000 ALTER TABLE `see_phaseexecution` ENABLE KEYS */;

-- Export de la structure de la table pfss_db. zip
DROP TABLE IF EXISTS `zip`;
CREATE TABLE IF NOT EXISTS `zip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Export de données de la table pfss_db.zip : ~8 rows (environ)
/*!40000 ALTER TABLE `zip` DISABLE KEYS */;
INSERT INTO `zip` (`id`, `code`, `libelle`) VALUES
	(1, 'ZIP1', 'ZIP1'),
	(2, 'ZIP2', 'ZIP2'),
	(3, 'ZIP3', 'ZIP3'),
	(4, 'ZIP4', 'ZIP4'),
	(5, 'ZIP5', 'ZIP5'),
	(6, 'ZIP6', 'ZIP6'),
	(7, 'ZIP7', 'ZIP7'),
	(8, 'ZIP8', 'ZIP8');
/*!40000 ALTER TABLE `zip` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
