-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           10.1.13-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win32
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Listage de la structure de la table pfss_db. fiche_supervision_mlpl
DROP TABLE IF EXISTS `fiche_supervision_mlpl`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_mlpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_groupemlpl` int(11) DEFAULT NULL,
  `id_consultant_ong` int(11) DEFAULT NULL,
  `type_supervision` varchar(150) DEFAULT NULL,
  `personne_rencontree` varchar(100) DEFAULT NULL,
  `organisation_consultant` varchar(100) DEFAULT NULL,
  `planning_activite_consultant` varchar(255) DEFAULT NULL,
  `nom_missionnaire` varchar(100) DEFAULT NULL,
  `date_supervision` date DEFAULT NULL,
  `date_prevue_debut` date DEFAULT NULL,
  `date_prevue_fin` date DEFAULT NULL,
  `nom_representant_mlpl` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fiche_supervision_mlpl_groupe_ml_pl` (`id_groupemlpl`),
  KEY `FK_fiche_supervision_mlpl_consultant_ong` (`id_consultant_ong`),
  CONSTRAINT `FK_fiche_supervision_mlpl_consultant_ong` FOREIGN KEY (`id_consultant_ong`) REFERENCES `consultant_ong` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fiche_supervision_mlpl_groupe_ml_pl` FOREIGN KEY (`id_groupemlpl`) REFERENCES `groupe_ml_pl` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.fiche_supervision_mlpl : ~0 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_mlpl` DISABLE KEYS */;
/*!40000 ALTER TABLE `fiche_supervision_mlpl` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. livrable_mlpl
DROP TABLE IF EXISTS `livrable_mlpl`;
CREATE TABLE IF NOT EXISTS `livrable_mlpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrat_consultant` int(11) DEFAULT NULL,
  `id_groupemlpl` int(11) DEFAULT NULL,
  `activite_concernee` varchar(150) DEFAULT NULL,
  `intitule_livrable` varchar(150) DEFAULT NULL,
  `date_prevue_remise` date DEFAULT NULL,
  `date_effective_reception` date DEFAULT NULL,
  `intervenant` varchar(150) DEFAULT NULL,
  `nbr_commune_touchee` int(11) DEFAULT NULL,
  `nbr_village_touchee` int(11) DEFAULT NULL,
  `observation` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_livrable_mlpl_contrat_consultant_ong` (`id_contrat_consultant`),
  KEY `FK_livrable_mlpl_groupe_ml_pl` (`id_groupemlpl`),
  CONSTRAINT `FK_livrable_mlpl_contrat_consultant_ong` FOREIGN KEY (`id_contrat_consultant`) REFERENCES `contrat_consultant_ong` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_livrable_mlpl_groupe_ml_pl` FOREIGN KEY (`id_groupemlpl`) REFERENCES `groupe_ml_pl` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.livrable_mlpl : ~1 rows (environ)
/*!40000 ALTER TABLE `livrable_mlpl` DISABLE KEYS */;
INSERT INTO `livrable_mlpl` (`id`, `id_contrat_consultant`, `id_groupemlpl`, `activite_concernee`, `intitule_livrable`, `date_prevue_remise`, `date_effective_reception`, `intervenant`, `nbr_commune_touchee`, `nbr_village_touchee`, `observation`) VALUES
	(2, 6, 2, 'activite', 'intitule', '2021-03-03', '2021-04-02', 'intervenant', 100, 10, 'observation');
/*!40000 ALTER TABLE `livrable_mlpl` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. point_a_verifier_mlpl
DROP TABLE IF EXISTS `point_a_verifier_mlpl`;
CREATE TABLE IF NOT EXISTS `point_a_verifier_mlpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fiche_supervision_mlpl` int(11) DEFAULT NULL,
  `intitule_verifie` varchar(150) DEFAULT NULL,
  `appreciation` varchar(150) DEFAULT NULL,
  `solution` varchar(150) DEFAULT NULL,
  `observation` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_point_a_verifier_mlpl_fiche_supervision_mlpl` (`id_fiche_supervision_mlpl`),
  CONSTRAINT `FK_point_a_verifier_mlpl_fiche_supervision_mlpl` FOREIGN KEY (`id_fiche_supervision_mlpl`) REFERENCES `fiche_supervision_mlpl` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.point_a_verifier_mlpl : ~1 rows (environ)
/*!40000 ALTER TABLE `point_a_verifier_mlpl` DISABLE KEYS */;
INSERT INTO `point_a_verifier_mlpl` (`id`, `id_fiche_supervision_mlpl`, `intitule_verifie`, `appreciation`, `solution`, `observation`) VALUES
	(1, 1, 'intitule', 'apreciation', 'solution recom', 'observation');
/*!40000 ALTER TABLE `point_a_verifier_mlpl` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. point_controle_mlpl
DROP TABLE IF EXISTS `point_controle_mlpl`;
CREATE TABLE IF NOT EXISTS `point_controle_mlpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_livrable_mlpl` int(11) DEFAULT NULL,
  `intitule` varchar(150) DEFAULT NULL,
  `resultat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_point_controle_mlpl_livrable_mlpl` (`id_livrable_mlpl`),
  CONSTRAINT `FK_point_controle_mlpl_livrable_mlpl` FOREIGN KEY (`id_livrable_mlpl`) REFERENCES `livrable_mlpl` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.point_controle_mlpl : ~1 rows (environ)
/*!40000 ALTER TABLE `point_controle_mlpl` DISABLE KEYS */;
INSERT INTO `point_controle_mlpl` (`id`, `id_livrable_mlpl`, `intitule`, `resultat`) VALUES
	(1, 2, 'intitule point', 'OUI');
/*!40000 ALTER TABLE `point_controle_mlpl` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. probleme_solution_mlpl
DROP TABLE IF EXISTS `probleme_solution_mlpl`;
CREATE TABLE IF NOT EXISTS `probleme_solution_mlpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fiche_supervision_mlpl` int(11) DEFAULT NULL,
  `probleme` varchar(150) DEFAULT NULL,
  `solution` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_probleme_rencontres_fiche_supervision_mlpl` (`id_fiche_supervision_mlpl`),
  CONSTRAINT `FK_probleme_rencontres_fiche_supervision_mlpl` FOREIGN KEY (`id_fiche_supervision_mlpl`) REFERENCES `fiche_supervision_mlpl` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.probleme_solution_mlpl : ~1 rows (environ)
/*!40000 ALTER TABLE `probleme_solution_mlpl` DISABLE KEYS */;
INSERT INTO `probleme_solution_mlpl` (`id`, `id_fiche_supervision_mlpl`, `probleme`, `solution`) VALUES
	(1, 1, 'probleme', 'solution propose');
/*!40000 ALTER TABLE `probleme_solution_mlpl` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
