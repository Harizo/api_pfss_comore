-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           10.1.13-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win32
-- HeidiSQL Version:             10.0.0.5460
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Listage de la structure de la table pfss_db. fiche_plan_relevement_identification
DROP TABLE IF EXISTS `fiche_plan_relevement_identification`;
CREATE TABLE IF NOT EXISTS `fiche_plan_relevement_identification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_remplissage` date DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `id_menage` int(11) DEFAULT NULL,
  `composition_menage` varchar(255) DEFAULT '',
  `id_agex` int(11) DEFAULT NULL,
  `representant_comite_protection_social` varchar(255) DEFAULT '',
  `representant_agex` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_plan_relevement_identification : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_plan_relevement_identification` DISABLE KEYS */;
INSERT INTO `fiche_plan_relevement_identification` (`id`, `date_remplissage`, `id_village`, `id_menage`, `composition_menage`, `id_agex`, `representant_comite_protection_social`, `representant_agex`) VALUES
	(2, '2021-06-08', 214, 205, 'compo', 17, 'representant cps 2', 'Mr Jean'),
	(3, '2021-06-01', 214, 218, 'compo', 17, 'representant cps', 'Consultant');
/*!40000 ALTER TABLE `fiche_plan_relevement_identification` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_plan_relevement_objdesc_quatre
DROP TABLE IF EXISTS `fiche_plan_relevement_objdesc_quatre`;
CREATE TABLE IF NOT EXISTS `fiche_plan_relevement_objdesc_quatre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_identification` int(11) NOT NULL,
  `risque_eventuelle` varchar(255) NOT NULL DEFAULT '',
  `solution_prevu` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_identificationquatr` (`id_identification`),
  CONSTRAINT `id_identificationquatr` FOREIGN KEY (`id_identification`) REFERENCES `fiche_plan_relevement_identification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_plan_relevement_objdesc_quatre : ~2 rows (environ)
/*!40000 ALTER TABLE `fiche_plan_relevement_objdesc_quatre` DISABLE KEYS */;
INSERT INTO `fiche_plan_relevement_objdesc_quatre` (`id`, `id_identification`, `risque_eventuelle`, `solution_prevu`) VALUES
	(2, 2, 'teste risque', 'teste solution');
/*!40000 ALTER TABLE `fiche_plan_relevement_objdesc_quatre` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_plan_relevement_objdesc_trois
DROP TABLE IF EXISTS `fiche_plan_relevement_objdesc_trois`;
CREATE TABLE IF NOT EXISTS `fiche_plan_relevement_objdesc_trois` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_identification` int(11) NOT NULL,
  `formation` varchar(255) NOT NULL DEFAULT '',
  `encadrement` varchar(255) NOT NULL DEFAULT '',
  `suivi` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_identificationtrois` (`id_identification`),
  CONSTRAINT `id_identificationtrois` FOREIGN KEY (`id_identification`) REFERENCES `fiche_plan_relevement_identification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_plan_relevement_objdesc_trois : ~2 rows (environ)
/*!40000 ALTER TABLE `fiche_plan_relevement_objdesc_trois` DISABLE KEYS */;
INSERT INTO `fiche_plan_relevement_objdesc_trois` (`id`, `id_identification`, `formation`, `encadrement`, `suivi`) VALUES
	(2, 2, 'Teste formation', 'Teste encadrement', 'Teste suivi');
/*!40000 ALTER TABLE `fiche_plan_relevement_objdesc_trois` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_plan_relevement_objdesc_un_deux
DROP TABLE IF EXISTS `fiche_plan_relevement_objdesc_un_deux`;
CREATE TABLE IF NOT EXISTS `fiche_plan_relevement_objdesc_un_deux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_identification` int(11) NOT NULL,
  `objectif` text NOT NULL,
  `cycle` tinyint(4) NOT NULL DEFAULT '0',
  `disponibilite_intrant` tinyint(4) NOT NULL DEFAULT '0',
  `disponibilite_terrain` tinyint(4) NOT NULL DEFAULT '0',
  `capacite_technique` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_identification` (`id_identification`),
  CONSTRAINT `id_identification` FOREIGN KEY (`id_identification`) REFERENCES `fiche_plan_relevement_identification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_plan_relevement_objdesc_un_deux : ~2 rows (environ)
/*!40000 ALTER TABLE `fiche_plan_relevement_objdesc_un_deux` DISABLE KEYS */;
INSERT INTO `fiche_plan_relevement_objdesc_un_deux` (`id`, `id_identification`, `objectif`, `cycle`, `disponibilite_intrant`, `disponibilite_terrain`, `capacite_technique`) VALUES
	(1, 2, 'teste ok', 9, 1, 1, 0),
	(3, 3, 'lol', 9, 0, 0, 0);
/*!40000 ALTER TABLE `fiche_plan_relevement_objdesc_un_deux` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_plan_relevement_plan_production_deux
DROP TABLE IF EXISTS `fiche_plan_relevement_plan_production_deux`;
CREATE TABLE IF NOT EXISTS `fiche_plan_relevement_plan_production_deux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_identification` int(11) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT 'depense ou produit',
  `designation` varchar(255) NOT NULL DEFAULT '',
  `unite` varchar(10) NOT NULL DEFAULT '',
  `quantite` float NOT NULL DEFAULT '0',
  `prix_unitaire` float NOT NULL DEFAULT '0',
  `montant` float NOT NULL DEFAULT '0',
  `numero_materiel` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_identdeux` (`id_identification`),
  CONSTRAINT `id_identdeux` FOREIGN KEY (`id_identification`) REFERENCES `fiche_plan_relevement_identification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_plan_relevement_plan_production_deux : ~4 rows (environ)
/*!40000 ALTER TABLE `fiche_plan_relevement_plan_production_deux` DISABLE KEYS */;
INSERT INTO `fiche_plan_relevement_plan_production_deux` (`id`, `id_identification`, `type`, `designation`, `unite`, `quantite`, `prix_unitaire`, `montant`, `numero_materiel`) VALUES
	(12, 2, 'produit', 'sdfsdf', 'sdfsdf', 6, 2000, 12000, '5'),
	(13, 2, 'depense', 'design 1', 'u1', 2.5, 1500, 3750, '5'),
	(15, 2, 'depense', 'design2', 'u2', 2.5, 5, 12.5, '5');
/*!40000 ALTER TABLE `fiche_plan_relevement_plan_production_deux` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_plan_relevement_plan_production_trois
DROP TABLE IF EXISTS `fiche_plan_relevement_plan_production_trois`;
CREATE TABLE IF NOT EXISTS `fiche_plan_relevement_plan_production_trois` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_identification` int(11) NOT NULL,
  `activite` varchar(255) DEFAULT '',
  `lieu_production` varchar(255) DEFAULT '',
  `lieu_approvisionnement_intrant` varchar(255) DEFAULT '',
  `lieu_ecoulement_produit` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK1trois` (`id_identification`),
  CONSTRAINT `FK1trois` FOREIGN KEY (`id_identification`) REFERENCES `fiche_plan_relevement_identification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_plan_relevement_plan_production_trois : ~0 rows (environ)
/*!40000 ALTER TABLE `fiche_plan_relevement_plan_production_trois` DISABLE KEYS */;
INSERT INTO `fiche_plan_relevement_plan_production_trois` (`id`, `id_identification`, `activite`, `lieu_production`, `lieu_approvisionnement_intrant`, `lieu_ecoulement_produit`) VALUES
	(1, 2, 'teste act', 'lieu prod', 'lieu appro', 'lieu eccoul');
/*!40000 ALTER TABLE `fiche_plan_relevement_plan_production_trois` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_plan_relevement_plan_production_un
DROP TABLE IF EXISTS `fiche_plan_relevement_plan_production_un`;
CREATE TABLE IF NOT EXISTS `fiche_plan_relevement_plan_production_un` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_identification` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL DEFAULT '',
  `materiel_entrant` varchar(255) NOT NULL DEFAULT '',
  `unite` varchar(10) NOT NULL DEFAULT '',
  `disponible` varchar(10) NOT NULL DEFAULT '0',
  `achercher` varchar(255) NOT NULL DEFAULT '',
  `acheter_ou` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FKun` (`id_identification`),
  CONSTRAINT `FKun` FOREIGN KEY (`id_identification`) REFERENCES `fiche_plan_relevement_identification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_plan_relevement_plan_production_un : ~0 rows (environ)
/*!40000 ALTER TABLE `fiche_plan_relevement_plan_production_un` DISABLE KEYS */;
INSERT INTO `fiche_plan_relevement_plan_production_un` (`id`, `id_identification`, `numero`, `materiel_entrant`, `unite`, `disponible`, `achercher`, `acheter_ou`) VALUES
	(1, 2, '2', 'teste materiel', 'unite', 'Oui', 'teste a chercher', 'teste ou');
/*!40000 ALTER TABLE `fiche_plan_relevement_plan_production_un` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
