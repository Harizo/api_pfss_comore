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

-- Listage de la structure de la table pfss_db. contrat_agep
DROP TABLE IF EXISTS `contrat_agep`;
CREATE TABLE IF NOT EXISTS `contrat_agep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agep` int(11) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  `numero_contrat` varchar(250) DEFAULT NULL,
  `numero_ordre` varchar(250) DEFAULT NULL,
  `objet_contrat` varchar(100) DEFAULT NULL,
  `montant_contrat` double DEFAULT NULL,
  `montant_a_effectue_prevu` double DEFAULT NULL,
  `modalite_contrat` varchar(100) DEFAULT NULL,
  `date_prevu_fin` date DEFAULT NULL,
  `noms_signataires` varchar(100) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `statu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__see_agent` (`id_agep`),
  KEY `FK__sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK__see_agent` FOREIGN KEY (`id_agep`) REFERENCES `see_agent` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK__sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.contrat_agep : ~5 rows (environ)
/*!40000 ALTER TABLE `contrat_agep` DISABLE KEYS */;
INSERT INTO `contrat_agep` (`id`, `id_agep`, `id_sous_projet`, `numero_contrat`, `numero_ordre`, `objet_contrat`, `montant_contrat`, `montant_a_effectue_prevu`, `modalite_contrat`, `date_prevu_fin`, `noms_signataires`, `date_signature`, `statu`) VALUES
	(2, 19, 1, '2020/12/456/RAD/FDZ', NULL, 'objet', 123456, 75000, 'modalite du', '2021-04-03', 'noms', '2021-04-02', 'EN COURS'),
	(3, 19, 1, '2020/12/456/RAD/FDZ', NULL, 'objet2', 100000, 75000, 'modalite du contrat', '2021-05-12', 'noms des', '2021-05-02', 'RESILIE'),
	(5, 19, 4, '2020/12/456/RAD/FDZTMNCCOVID', NULL, 'objet', 200, 105000, 'modalite du contrat', '2021-05-06', 'noms des', '2021-05-05', 'EN COURS'),
	(6, 19, 3, '2020/12/456/RAD/FDZIDB', NULL, 'objet', 1000, 315000, 'modalite du contrat', '2021-05-12', 'noms des', '2021-05-11', 'EN COURS'),
	(7, 19, 2, 'identi/ARSE/1', '1', 'objet du contrat', 3150000, 3150000, 'modalite', '2021-07-15', 'noms des', '2021-07-07', 'EN COURS');
/*!40000 ALTER TABLE `contrat_agep` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_profilage_orientation
DROP TABLE IF EXISTS `fiche_profilage_orientation`;
CREATE TABLE IF NOT EXISTS `fiche_profilage_orientation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activite` varchar(150) DEFAULT NULL,
  `type_activite` smallint(6) DEFAULT NULL,
  `secteur` varchar(150) DEFAULT NULL,
  `groupe` varchar(150) DEFAULT NULL,
  `id_fiche_profilage_orientation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_orienta_fiche_profilage` (`id_fiche_profilage_orientation`),
  CONSTRAINT `FK_orienta_fiche_profilage` FOREIGN KEY (`id_fiche_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_profilage_orientation : ~3 rows (environ)
/*!40000 ALTER TABLE `fiche_profilage_orientation` DISABLE KEYS */;
INSERT INTO `fiche_profilage_orientation` (`id`, `activite`, `type_activite`, `secteur`, `groupe`, `id_fiche_profilage_orientation`) VALUES
	(1, 'activi', 1, 'secteur', 'groupe', 2),
	(2, 'activi', 2, NULL, 'groupe', 2),
	(3, 'activi3', 1, NULL, 'groupe3', 2);
/*!40000 ALTER TABLE `fiche_profilage_orientation` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. formation_thematique_agex
DROP TABLE IF EXISTS `formation_thematique_agex`;
CREATE TABLE IF NOT EXISTS `formation_thematique_agex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme_sensibilisation` int(11) DEFAULT NULL,
  `id_contrat_agex` int(11) DEFAULT NULL,
  `contenu` varchar(250) DEFAULT NULL,
  `objectif` varchar(250) DEFAULT NULL,
  `methodologie` varchar(250) DEFAULT NULL,
  `materiel` varchar(250) DEFAULT NULL,
  `duree` float DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_formation_thema_theme_sensibilisation` (`id_theme_sensibilisation`),
  KEY `FK_formation_thema_contrat_ugp_agex` (`id_contrat_agex`),
  CONSTRAINT `FK_formation_thema_contrat_ugp_agex` FOREIGN KEY (`id_contrat_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_formation_thema_theme_sensibilisation` FOREIGN KEY (`id_theme_sensibilisation`) REFERENCES `theme_sensibilisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.formation_thematique_agex : ~3 rows (environ)
/*!40000 ALTER TABLE `formation_thematique_agex` DISABLE KEYS */;
INSERT INTO `formation_thematique_agex` (`id`, `id_theme_sensibilisation`, `id_contrat_agex`, `contenu`, `objectif`, `methodologie`, `materiel`, `duree`, `date`) VALUES
	(1, 1, 5, 'contenu', 'objectif', 'methodologie', 'materiel', 45, '2021-07-12');
/*!40000 ALTER TABLE `formation_thematique_agex` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. formation_thematique_agex_activite
DROP TABLE IF EXISTS `formation_thematique_agex_activite`;
CREATE TABLE IF NOT EXISTS `formation_thematique_agex_activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme_formation` int(11) DEFAULT NULL,
  `id_theme_formation_detail` int(11) DEFAULT NULL,
  `id_contrat_agex` int(11) DEFAULT NULL,
  `contenu` varchar(250) DEFAULT NULL,
  `objectif` varchar(250) DEFAULT NULL,
  `methodologie` varchar(250) DEFAULT NULL,
  `materiel` varchar(250) DEFAULT NULL,
  `duree` float DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_formation_activite_theme_fo` (`id_theme_formation`),
  KEY `FK_formation_activite_theme_detail` (`id_theme_formation_detail`),
  KEY `FK_formation_activite_contrat_ugp_agex` (`id_contrat_agex`),
  CONSTRAINT `FK_formation_activite_contrat_ugp_agex` FOREIGN KEY (`id_contrat_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_formation_activite_theme_detail` FOREIGN KEY (`id_theme_formation_detail`) REFERENCES `theme_formation_detail` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_formation_activite_theme_fo` FOREIGN KEY (`id_theme_formation`) REFERENCES `theme_formation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.formation_thematique_agex_activite : ~1 rows (environ)
/*!40000 ALTER TABLE `formation_thematique_agex_activite` DISABLE KEYS */;
INSERT INTO `formation_thematique_agex_activite` (`id`, `id_theme_formation`, `id_theme_formation_detail`, `id_contrat_agex`, `contenu`, `objectif`, `methodologie`, `materiel`, `duree`, `date`) VALUES
	(1, 3, 4, 5, 'contenu', 'objectif', 'methodologie', 'materiel', 45, '2021-07-13');
/*!40000 ALTER TABLE `formation_thematique_agex_activite` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. formation_thematique_suivi_agex_activite
DROP TABLE IF EXISTS `formation_thematique_suivi_agex_activite`;
CREATE TABLE IF NOT EXISTS `formation_thematique_suivi_agex_activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme_formation` int(11) DEFAULT NULL,
  `id_contrat_agex` int(11) DEFAULT NULL,
  `periode_prevu` varchar(150) DEFAULT NULL,
  `periode_realisation` varchar(150) DEFAULT NULL,
  `beneficiaire` varchar(250) DEFAULT NULL,
  `nbr_beneficiaire_cible` int(11) DEFAULT NULL,
  `nbr_participant` int(11) DEFAULT NULL,
  `nbr_femme` int(11) DEFAULT NULL,
  `formateur` varchar(100) DEFAULT NULL,
  `observation` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_formation_suivi_theme_formation` (`id_theme_formation`),
  KEY `FK_formation_suivi_theme_contrat_agex` (`id_contrat_agex`),
  CONSTRAINT `FK_formation_suivi_theme_contrat_agex` FOREIGN KEY (`id_contrat_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_formation_suivi_theme_formation` FOREIGN KEY (`id_theme_formation`) REFERENCES `theme_formation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.formation_thematique_suivi_agex_activite : ~2 rows (environ)
/*!40000 ALTER TABLE `formation_thematique_suivi_agex_activite` DISABLE KEYS */;
INSERT INTO `formation_thematique_suivi_agex_activite` (`id`, `id_theme_formation`, `id_contrat_agex`, `periode_prevu`, `periode_realisation`, `beneficiaire`, `nbr_beneficiaire_cible`, `nbr_participant`, `nbr_femme`, `formateur`, `observation`) VALUES
	(3, 3, 5, 'periode', 'periode', 'bene', 4, 4, 4, 'formateur', 'observat');
/*!40000 ALTER TABLE `formation_thematique_suivi_agex_activite` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. formation_thematique_suivi_agex_macc
DROP TABLE IF EXISTS `formation_thematique_suivi_agex_macc`;
CREATE TABLE IF NOT EXISTS `formation_thematique_suivi_agex_macc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme_sensibilisation` int(11) DEFAULT NULL,
  `id_contrat_agex` int(11) DEFAULT NULL,
  `periode_prevu` varchar(150) DEFAULT NULL,
  `periode_realisation` varchar(150) DEFAULT NULL,
  `beneficiaire` varchar(250) DEFAULT NULL,
  `nbr_beneficiaire_cible` int(11) DEFAULT NULL,
  `nbr_participant` int(11) DEFAULT NULL,
  `nbr_femme` int(11) DEFAULT NULL,
  `formateur` varchar(100) DEFAULT NULL,
  `observation` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_formation_suivi_theme_sen` (`id_theme_sensibilisation`),
  KEY `FK_formation_suivi_agex_contrat_agex` (`id_contrat_agex`),
  CONSTRAINT `FK_formation_suivi_agex_contrat_agex` FOREIGN KEY (`id_contrat_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_formation_suivi_theme_sen` FOREIGN KEY (`id_theme_sensibilisation`) REFERENCES `theme_sensibilisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.formation_thematique_suivi_agex_macc : ~2 rows (environ)
/*!40000 ALTER TABLE `formation_thematique_suivi_agex_macc` DISABLE KEYS */;
INSERT INTO `formation_thematique_suivi_agex_macc` (`id`, `id_theme_sensibilisation`, `id_contrat_agex`, `periode_prevu`, `periode_realisation`, `beneficiaire`, `nbr_beneficiaire_cible`, `nbr_participant`, `nbr_femme`, `formateur`, `observation`) VALUES
	(1, 1, 5, 'periode prevu', 'periode', 'beneficiaire', 100, 50, 50, 'formateur', 'observation');
/*!40000 ALTER TABLE `formation_thematique_suivi_agex_macc` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
