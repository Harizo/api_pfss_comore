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

-- Listage de la structure de la table pfss_db. activite_realise_auparavant
DROP TABLE IF EXISTS `activite_realise_auparavant`;
CREATE TABLE IF NOT EXISTS `activite_realise_auparavant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.activite_realise_auparavant : ~8 rows (environ)
/*!40000 ALTER TABLE `activite_realise_auparavant` DISABLE KEYS */;
INSERT INTO `activite_realise_auparavant` (`id`, `description`) VALUES
	(1, 'Agriculture'),
	(2, 'Elevage'),
	(3, 'Pêche'),
	(4, 'Petit commerce'),
	(5, 'Restauration'),
	(6, 'Artisanat'),
	(7, 'Autres'),
	(8, 'Néant');
/*!40000 ALTER TABLE `activite_realise_auparavant` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. beneficiaire_formation_thematique_agex
DROP TABLE IF EXISTS `beneficiaire_formation_thematique_agex`;
CREATE TABLE IF NOT EXISTS `beneficiaire_formation_thematique_agex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation_thematique_agex` int(11) DEFAULT NULL,
  `id_groupe_ml_pl` int(11) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_beneficiaire_formation_thematique_agex` (`id_formation_thematique_agex`),
  KEY `FK_beneficiaire_groupe_ml_pl` (`id_groupe_ml_pl`),
  KEY `FK_beneficiaire_see_village` (`id_village`),
  CONSTRAINT `FK_beneficiaire_formation_thematique_agex` FOREIGN KEY (`id_formation_thematique_agex`) REFERENCES `formation_thematique_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_beneficiaire_groupe_ml_pl` FOREIGN KEY (`id_groupe_ml_pl`) REFERENCES `groupe_ml_pl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_beneficiaire_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.beneficiaire_formation_thematique_agex : ~1 rows (environ)
/*!40000 ALTER TABLE `beneficiaire_formation_thematique_agex` DISABLE KEYS */;
INSERT INTO `beneficiaire_formation_thematique_agex` (`id`, `id_formation_thematique_agex`, `id_groupe_ml_pl`, `id_village`) VALUES
	(1, 1, 2, 6);
/*!40000 ALTER TABLE `beneficiaire_formation_thematique_agex` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. besoin_formation
DROP TABLE IF EXISTS `besoin_formation`;
CREATE TABLE IF NOT EXISTS `besoin_formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_profilage_orientation` int(11) DEFAULT NULL,
  `type_formation` varchar(150) DEFAULT NULL,
  `profile_beneficiaire` varchar(150) DEFAULT NULL,
  `objectif_formation` varchar(150) DEFAULT NULL,
  `duree_formation` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_besoin_fiche_profilage` (`id_profilage_orientation`),
  CONSTRAINT `FK_besoin_fiche_profilage` FOREIGN KEY (`id_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.besoin_formation : ~0 rows (environ)
/*!40000 ALTER TABLE `besoin_formation` DISABLE KEYS */;
/*!40000 ALTER TABLE `besoin_formation` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. connaissance_experience_menage_detail
DROP TABLE IF EXISTS `connaissance_experience_menage_detail`;
CREATE TABLE IF NOT EXISTS `connaissance_experience_menage_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_activite_realise_auparavant` int(11) DEFAULT NULL,
  `id_fiche_profilage_orientation` int(11) DEFAULT NULL,
  `difficulte_rencontre` varchar(100) DEFAULT NULL,
  `nbr_annee_activite` smallint(6) DEFAULT NULL,
  `formation_acquise` longtext,
  `autre_activite_realise_auparavant` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_connaissance_activite_realise` (`id_activite_realise_auparavant`),
  KEY `FK_connaissance_fiche_profilage` (`id_fiche_profilage_orientation`),
  CONSTRAINT `FK_connaissance_activite_realise` FOREIGN KEY (`id_activite_realise_auparavant`) REFERENCES `activite_realise_auparavant` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_connaissance_fiche_profilage` FOREIGN KEY (`id_fiche_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.connaissance_experience_menage_detail : ~5 rows (environ)
/*!40000 ALTER TABLE `connaissance_experience_menage_detail` DISABLE KEYS */;
INSERT INTO `connaissance_experience_menage_detail` (`id`, `id_activite_realise_auparavant`, `id_fiche_profilage_orientation`, `difficulte_rencontre`, `nbr_annee_activite`, `formation_acquise`, `autre_activite_realise_auparavant`) VALUES
	(1, 1, 2, 'difficulte', 1, 'a:5:{i:0;s:3:"mar";i:1;s:3:"pep";i:2;s:3:"cul";i:3;s:8:"tra_act1";i:4;s:8:"aut_act1";}', NULL),
	(2, 2, 2, 'dif', 2, 'a:4:{i:0;s:3:"cap";i:1;s:3:"avi";i:2;s:3:"bov";i:3;s:8:"aut_act2";}', NULL),
	(3, 3, 2, 'difficulte3', 4, 'a:3:{i:0;s:8:"tra_act3";i:1;s:3:"tec";i:2;s:8:"aut_act3";}', NULL),
	(4, 4, 2, 'difficulte4', 3, 'N;', NULL),
	(5, 2, 1, 'difficulte', 3, 'a:1:{i:0;s:3:"bov";}', NULL);
/*!40000 ALTER TABLE `connaissance_experience_menage_detail` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. connaissance_experience_menage_entete
DROP TABLE IF EXISTS `connaissance_experience_menage_entete`;
CREATE TABLE IF NOT EXISTS `connaissance_experience_menage_entete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `niveau_formation` smallint(6) DEFAULT NULL,
  `autre_niveau_formation` varchar(100) DEFAULT NULL,
  `id_fiche_profilage_orientation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `FK_connaissance_fiche_profilage_entete` (`id_fiche_profilage_orientation`),
  CONSTRAINT `FK_connaissance_fiche_profilage_entete` FOREIGN KEY (`id_fiche_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.connaissance_experience_menage_entete : ~1 rows (environ)
/*!40000 ALTER TABLE `connaissance_experience_menage_entete` DISABLE KEYS */;
INSERT INTO `connaissance_experience_menage_entete` (`id`, `niveau_formation`, `autre_niveau_formation`, `id_fiche_profilage_orientation`) VALUES
	(1, 2, '', 2);
/*!40000 ALTER TABLE `connaissance_experience_menage_entete` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. consultant_ong
DROP TABLE IF EXISTS `consultant_ong`;
CREATE TABLE IF NOT EXISTS `consultant_ong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ile_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `raison_social` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `fonction_contact` varchar(50) DEFAULT NULL,
  `telephone_contact` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `nom_consultant` varchar(50) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `id_commune` int(11) DEFAULT NULL,
  `id_region` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_consultant_ong_see_ile` (`ile_id`),
  KEY `FK_consultant_ong_see_village` (`id_village`),
  KEY `FK_consultant_ong_see_commune` (`id_commune`),
  KEY `FK_consultant_ong_see_region` (`id_region`),
  CONSTRAINT `FK_consultant_ong_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_consultant_ong_see_ile` FOREIGN KEY (`ile_id`) REFERENCES `see_ile` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_consultant_ong_see_region` FOREIGN KEY (`id_region`) REFERENCES `see_region` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_consultant_ong_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.consultant_ong : ~3 rows (environ)
/*!40000 ALTER TABLE `consultant_ong` DISABLE KEYS */;
INSERT INTO `consultant_ong` (`id`, `ile_id`, `code`, `raison_social`, `contact`, `fonction_contact`, `telephone_contact`, `adresse`, `nom_consultant`, `id_village`, `id_commune`, `id_region`) VALUES
	(1, 2, 'REP_BES', 'consultant', 'contac', 'dfdfd', '123 456', 'adr', NULL, NULL, NULL, NULL),
	(2, 1, 'REP_MT', 'consu l 2', 'vvv', 'hhh', '456', 'dresse', NULL, NULL, NULL, NULL),
	(3, 4, 'code', 'raison', 'contact', 'fonction', '01452545', 'adresse', 'Nom consultant', NULL, NULL, NULL);
/*!40000 ALTER TABLE `consultant_ong` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_collection_donnee_ebe
DROP TABLE IF EXISTS `fiche_collection_donnee_ebe`;
CREATE TABLE IF NOT EXISTS `fiche_collection_donnee_ebe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_realisation_ebe` int(11) DEFAULT NULL,
  `id_theme_sensibilisation` int(11) DEFAULT NULL,
  `id_outils_utilise` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `localite` varchar(100) DEFAULT NULL,
  `nbr_femme` int(11) DEFAULT NULL,
  `nbr_homme` int(11) DEFAULT NULL,
  `nbr_enfant` int(11) DEFAULT NULL,
  `animateur` varchar(150) DEFAULT NULL,
  `observation` longtext,
  PRIMARY KEY (`id`),
  KEY `FK_fiche_collect_realisation_ebe` (`id_realisation_ebe`),
  KEY `FK_fiche_collect_theme_sensibilisation` (`id_theme_sensibilisation`),
  KEY `FK_fiche_co_outils_utilise_sensibilisation` (`id_outils_utilise`),
  CONSTRAINT `FK_fiche_co_outils_utilise_sensibilisation` FOREIGN KEY (`id_outils_utilise`) REFERENCES `outils_utilise_sensibilisation` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fiche_collect_realisation_ebe` FOREIGN KEY (`id_realisation_ebe`) REFERENCES `realisation_ebe` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fiche_collect_theme_sensibilisation` FOREIGN KEY (`id_theme_sensibilisation`) REFERENCES `theme_sensibilisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_collection_donnee_ebe : ~2 rows (environ)
/*!40000 ALTER TABLE `fiche_collection_donnee_ebe` DISABLE KEYS */;
INSERT INTO `fiche_collection_donnee_ebe` (`id`, `id_realisation_ebe`, `id_theme_sensibilisation`, `id_outils_utilise`, `date`, `localite`, `nbr_femme`, `nbr_homme`, `nbr_enfant`, `animateur`, `observation`) VALUES
	(3, 3, 3, 3, '2021-06-16', 'localite', 1, 12, 12, 'animateur', 'observation'),
	(4, 3, 2, 5, '2021-06-23', 'localite', 5, 12, 12, 'animateur', 'obser');
/*!40000 ALTER TABLE `fiche_collection_donnee_ebe` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_profilage_besoin_formation
DROP TABLE IF EXISTS `fiche_profilage_besoin_formation`;
CREATE TABLE IF NOT EXISTS `fiche_profilage_besoin_formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fiche_profilage_orientation` int(11) NOT NULL DEFAULT '0',
  `id_type_formation` int(11) DEFAULT NULL,
  `objectif` varchar(150) DEFAULT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `duree` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_besoin_for_theme_formation` (`id_type_formation`),
  KEY `FK_besoin_for_fiche_profilage` (`id_fiche_profilage_orientation`),
  CONSTRAINT `FK_besoin_for_fiche_profilage` FOREIGN KEY (`id_fiche_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_besoin_for_theme_formation` FOREIGN KEY (`id_type_formation`) REFERENCES `theme_formation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_profilage_besoin_formation : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_profilage_besoin_formation` DISABLE KEYS */;
INSERT INTO `fiche_profilage_besoin_formation` (`id`, `id_fiche_profilage_orientation`, `id_type_formation`, `objectif`, `profile`, `duree`) VALUES
	(2, 2, 3, 'objectif', 'ptofile', 2);
/*!40000 ALTER TABLE `fiche_profilage_besoin_formation` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_profilage_orientation
DROP TABLE IF EXISTS `fiche_profilage_orientation`;
CREATE TABLE IF NOT EXISTS `fiche_profilage_orientation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activite` varchar(150) DEFAULT NULL,
  `type_activite` smallint(6) DEFAULT NULL,
  `groupe` varchar(150) DEFAULT NULL,
  `id_fiche_profilage_orientation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_orienta_fiche_profilage` (`id_fiche_profilage_orientation`),
  CONSTRAINT `FK_orienta_fiche_profilage` FOREIGN KEY (`id_fiche_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_profilage_orientation : ~3 rows (environ)
/*!40000 ALTER TABLE `fiche_profilage_orientation` DISABLE KEYS */;
INSERT INTO `fiche_profilage_orientation` (`id`, `activite`, `type_activite`, `groupe`, `id_fiche_profilage_orientation`) VALUES
	(1, 'activi', 1, 'groupe', 2),
	(2, 'activi', 2, 'groupe', 2),
	(3, 'activi3', 1, 'groupe3', 2);
/*!40000 ALTER TABLE `fiche_profilage_orientation` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_profilage_orientation_entete
DROP TABLE IF EXISTS `fiche_profilage_orientation_entete`;
CREATE TABLE IF NOT EXISTS `fiche_profilage_orientation_entete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_village` int(11) DEFAULT NULL,
  `date_remplissage` date DEFAULT NULL,
  `id_agex` int(11) DEFAULT NULL,
  `id_menage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_profilage_see_village` (`id_village`),
  KEY `FK_profilage_see_agex` (`id_agex`),
  KEY `FK_profilage_menage` (`id_menage`),
  CONSTRAINT `FK_profilage_menage` FOREIGN KEY (`id_menage`) REFERENCES `menage` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_profilage_see_agex` FOREIGN KEY (`id_agex`) REFERENCES `see_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_profilage_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_profilage_orientation_entete : ~4 rows (environ)
/*!40000 ALTER TABLE `fiche_profilage_orientation_entete` DISABLE KEYS */;
INSERT INTO `fiche_profilage_orientation_entete` (`id`, `id_village`, `date_remplissage`, `id_agex`, `id_menage`) VALUES
	(1, 6, '2021-06-08', 17, 1),
	(2, 6, '2021-06-04', 17, 2),
	(3, 6, '2021-06-10', 17, 4),
	(4, 6, '2021-06-30', 17, 7);
/*!40000 ALTER TABLE `fiche_profilage_orientation_entete` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_profilage_ressource
DROP TABLE IF EXISTS `fiche_profilage_ressource`;
CREATE TABLE IF NOT EXISTS `fiche_profilage_ressource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `etat` varchar(50) DEFAULT NULL,
  `id_fiche_profilage_orientation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ressource_pro_fiche_profilage` (`id_fiche_profilage_orientation`),
  CONSTRAINT `FK_ressource_pro_fiche_profilage` FOREIGN KEY (`id_fiche_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_profilage_ressource : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_profilage_ressource` DISABLE KEYS */;
INSERT INTO `fiche_profilage_ressource` (`id`, `designation`, `quantite`, `etat`, `id_fiche_profilage_orientation`) VALUES
	(1, 'desig', 10, 'dispo', 2);
/*!40000 ALTER TABLE `fiche_profilage_ressource` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_supervision_formation_ebe
DROP TABLE IF EXISTS `fiche_supervision_formation_ebe`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_formation_ebe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_village` int(11) DEFAULT NULL,
  `date_supervision` date DEFAULT NULL,
  `nom_missionaire` varchar(100) DEFAULT NULL,
  `nom_ml_cps` varchar(100) DEFAULT NULL,
  `id_agex` int(11) DEFAULT NULL,
  `id_theme_sensibilisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_supervision_ebe_see_village` (`id_village`),
  KEY `FK_supervision_ebe_see_agex` (`id_agex`),
  KEY `FK_supervision_ebe_theme_sensibilisation` (`id_theme_sensibilisation`),
  CONSTRAINT `FK_supervision_ebe_see_agex` FOREIGN KEY (`id_agex`) REFERENCES `see_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_supervision_ebe_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_supervision_ebe_theme_sensibilisation` FOREIGN KEY (`id_theme_sensibilisation`) REFERENCES `theme_sensibilisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_supervision_formation_ebe : ~2 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_formation_ebe` DISABLE KEYS */;
INSERT INTO `fiche_supervision_formation_ebe` (`id`, `id_village`, `date_supervision`, `nom_missionaire`, `nom_ml_cps`, `id_agex`, `id_theme_sensibilisation`) VALUES
	(1, 6, '2021-06-09', 'miss', 'ml pl', 17, 1),
	(2, 6, '2021-06-02', 'missionnaire', 'ml', 17, 2);
/*!40000 ALTER TABLE `fiche_supervision_formation_ebe` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_supervision_formation_ebe_conclusion
DROP TABLE IF EXISTS `fiche_supervision_formation_ebe_conclusion`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_formation_ebe_conclusion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` longtext,
  `id_fiche_supervision` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__fiche_supervision_formation_ebe` (`id_fiche_supervision`),
  CONSTRAINT `FK__fiche_supervision_formation_ebe` FOREIGN KEY (`id_fiche_supervision`) REFERENCES `fiche_supervision_formation_ebe` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_supervision_formation_ebe_conclusion : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_formation_ebe_conclusion` DISABLE KEYS */;
INSERT INTO `fiche_supervision_formation_ebe_conclusion` (`id`, `description`, `id_fiche_supervision`) VALUES
	(1, 'conclusions', 2);
/*!40000 ALTER TABLE `fiche_supervision_formation_ebe_conclusion` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_supervision_formation_ebe_planning
DROP TABLE IF EXISTS `fiche_supervision_formation_ebe_planning`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_formation_ebe_planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fiche_supervision` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `planning` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ebe_fiche_supervision` (`id_fiche_supervision`),
  CONSTRAINT `FK_ebe_fiche_supervision` FOREIGN KEY (`id_fiche_supervision`) REFERENCES `fiche_supervision_formation_ebe` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_supervision_formation_ebe_planning : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_formation_ebe_planning` DISABLE KEYS */;
INSERT INTO `fiche_supervision_formation_ebe_planning` (`id`, `id_fiche_supervision`, `date_debut`, `date_fin`, `planning`) VALUES
	(1, 2, '2021-06-01', '2021-06-11', 'planning acti');
/*!40000 ALTER TABLE `fiche_supervision_formation_ebe_planning` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_supervision_formation_ebe_point_verifier
DROP TABLE IF EXISTS `fiche_supervision_formation_ebe_point_verifier`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_formation_ebe_point_verifier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fiche_supervision` int(11) DEFAULT NULL,
  `point_verifier` varchar(250) DEFAULT NULL,
  `appreciation` varchar(50) DEFAULT NULL,
  `solution` varchar(250) DEFAULT NULL,
  `observation` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_supervision_ebe_fiche` (`id_fiche_supervision`),
  CONSTRAINT `FK_supervision_ebe_fiche` FOREIGN KEY (`id_fiche_supervision`) REFERENCES `fiche_supervision_formation_ebe` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_supervision_formation_ebe_point_verifier : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_formation_ebe_point_verifier` DISABLE KEYS */;
INSERT INTO `fiche_supervision_formation_ebe_point_verifier` (`id`, `id_fiche_supervision`, `point_verifier`, `appreciation`, `solution`, `observation`) VALUES
	(1, 2, 'point', 'OUI', 'solutions', 'observations');
/*!40000 ALTER TABLE `fiche_supervision_formation_ebe_point_verifier` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_supervision_formation_ml_cps
DROP TABLE IF EXISTS `fiche_supervision_formation_ml_cps`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_formation_ml_cps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_village` int(11) DEFAULT NULL,
  `date_supervision` date DEFAULT NULL,
  `nom_missionaire` varchar(150) DEFAULT NULL,
  `id_agex` int(11) DEFAULT NULL,
  `nom_ml_cps` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fiche_supervision_mcps_see_village` (`id_village`),
  KEY `FK_fiche_supervision_mcps_see_agex` (`id_agex`),
  CONSTRAINT `FK_fiche_supervision_mcps_see_agex` FOREIGN KEY (`id_agex`) REFERENCES `see_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fiche_supervision_mcps_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_supervision_formation_ml_cps : ~2 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_formation_ml_cps` DISABLE KEYS */;
INSERT INTO `fiche_supervision_formation_ml_cps` (`id`, `id_village`, `date_supervision`, `nom_missionaire`, `id_agex`, `nom_ml_cps`) VALUES
	(1, 6, '2021-06-01', 'azora', 17, 'sdfsdfqdsf'),
	(2, 6, '2021-06-09', 'hhhhh5', 17, 'hhhhhhh');
/*!40000 ALTER TABLE `fiche_supervision_formation_ml_cps` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_supervision_formation_ml_cps_planning
DROP TABLE IF EXISTS `fiche_supervision_formation_ml_cps_planning`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_formation_ml_cps_planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fiche_supervision` int(11) DEFAULT NULL,
  `planning` varchar(250) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_planning_fiche_supervision_f` (`id_fiche_supervision`),
  CONSTRAINT `FK_planning_fiche_supervision_f` FOREIGN KEY (`id_fiche_supervision`) REFERENCES `fiche_supervision_formation_ml_cps` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_supervision_formation_ml_cps_planning : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_formation_ml_cps_planning` DISABLE KEYS */;
INSERT INTO `fiche_supervision_formation_ml_cps_planning` (`id`, `id_fiche_supervision`, `planning`, `date_debut`, `date_fin`) VALUES
	(1, 1, 'planning', '2021-06-02', '2021-06-11');
/*!40000 ALTER TABLE `fiche_supervision_formation_ml_cps_planning` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_supervision_formation_ml_cps_point_verifier
DROP TABLE IF EXISTS `fiche_supervision_formation_ml_cps_point_verifier`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_formation_ml_cps_point_verifier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fiche_supervision` int(11) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `point_verifier` varchar(250) DEFAULT NULL,
  `prevision` varchar(150) DEFAULT NULL,
  `reelle` varchar(150) DEFAULT NULL,
  `observation` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_point_fiche_supervision` (`id_fiche_supervision`),
  CONSTRAINT `FK_point_fiche_supervision` FOREIGN KEY (`id_fiche_supervision`) REFERENCES `fiche_supervision_formation_ml_cps` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_supervision_formation_ml_cps_point_verifier : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_formation_ml_cps_point_verifier` DISABLE KEYS */;
INSERT INTO `fiche_supervision_formation_ml_cps_point_verifier` (`id`, `id_fiche_supervision`, `description`, `point_verifier`, `prevision`, `reelle`, `observation`) VALUES
	(1, 1, 'description', 'point', 'prevision', 'reele', 'observa');
/*!40000 ALTER TABLE `fiche_supervision_formation_ml_cps_point_verifier` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_supervision_formation_ml_cps_probleme
DROP TABLE IF EXISTS `fiche_supervision_formation_ml_cps_probleme`;
CREATE TABLE IF NOT EXISTS `fiche_supervision_formation_ml_cps_probleme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fiche_supervision` int(11) DEFAULT NULL,
  `probleme` varchar(250) DEFAULT NULL,
  `solution` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_probleme_fiche_supervision` (`id_fiche_supervision`),
  CONSTRAINT `FK_probleme_fiche_supervision` FOREIGN KEY (`id_fiche_supervision`) REFERENCES `fiche_supervision_formation_ml_cps` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fiche_supervision_formation_ml_cps_probleme : ~1 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_formation_ml_cps_probleme` DISABLE KEYS */;
INSERT INTO `fiche_supervision_formation_ml_cps_probleme` (`id`, `id_fiche_supervision`, `probleme`, `solution`) VALUES
	(1, 1, 'proble', 'solu');
/*!40000 ALTER TABLE `fiche_supervision_formation_ml_cps_probleme` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. formation_ml
DROP TABLE IF EXISTS `formation_ml`;
CREATE TABLE IF NOT EXISTS `formation_ml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(150) DEFAULT NULL,
  `id_commune` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `lieu` varchar(100) DEFAULT NULL,
  `formateur` varchar(100) DEFAULT NULL,
  `date_edition` date DEFAULT NULL,
  `outils_didactique` varchar(200) DEFAULT NULL,
  `probleme` varchar(250) DEFAULT NULL,
  `solution` varchar(250) DEFAULT NULL,
  `id_contrat_agex` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__see_commune` (`id_commune`),
  KEY `FK_formation_ml_contrat_ugp_agex` (`id_contrat_agex`),
  CONSTRAINT `FK__see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_formation_ml_contrat_ugp_agex` FOREIGN KEY (`id_contrat_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.formation_ml : ~2 rows (environ)
/*!40000 ALTER TABLE `formation_ml` DISABLE KEYS */;
INSERT INTO `formation_ml` (`id`, `description`, `id_commune`, `numero`, `date_debut`, `date_fin`, `lieu`, `formateur`, `date_edition`, `outils_didactique`, `probleme`, `solution`, `id_contrat_agex`) VALUES
	(1, 'presentation', 6, 1, '2021-06-01', '2021-06-02', 'lieu2', 'formtateur', '2021-05-21', 'outilts', 'probleme', 'solution', 6),
	(2, 'presentation2', 6, 2, '2021-06-09', '1970-01-01', 'lieu2', 'formtateur2', '2021-06-09', 'outilts2', 'pro2', 'solution', 6);
/*!40000 ALTER TABLE `formation_ml` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. formation_ml_repartition
DROP TABLE IF EXISTS `formation_ml_repartition`;
CREATE TABLE IF NOT EXISTS `formation_ml_repartition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation_ml` int(11) DEFAULT NULL,
  `num_groupe` int(11) DEFAULT NULL,
  `date_formation` date DEFAULT NULL,
  `nbr_ml` int(11) DEFAULT NULL,
  `lieu_formation` varchar(50) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_repartition_formation_ml` (`id_formation_ml`),
  CONSTRAINT `FK_repartition_formation_ml` FOREIGN KEY (`id_formation_ml`) REFERENCES `formation_ml` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.formation_ml_repartition : ~2 rows (environ)
/*!40000 ALTER TABLE `formation_ml_repartition` DISABLE KEYS */;
INSERT INTO `formation_ml_repartition` (`id`, `id_formation_ml`, `num_groupe`, `date_formation`, `nbr_ml`, `lieu_formation`, `responsable`) VALUES
	(1, 1, 1, '2021-06-02', 100, 'lieu1', 'respon'),
	(2, 1, 2, '2021-06-03', 15, 'lieu2', 'responsable2');
/*!40000 ALTER TABLE `formation_ml_repartition` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. formation_ml_repartition_village
DROP TABLE IF EXISTS `formation_ml_repartition_village`;
CREATE TABLE IF NOT EXISTS `formation_ml_repartition_village` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_village` int(11) DEFAULT NULL,
  `id_formation_ml_repartition` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_village_see_village` (`id_village`),
  KEY `FK_village_formation_ml_repartition` (`id_formation_ml_repartition`),
  CONSTRAINT `FK_village_formation_ml_repartition` FOREIGN KEY (`id_formation_ml_repartition`) REFERENCES `formation_ml_repartition` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_village_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.formation_ml_repartition_village : ~1 rows (environ)
/*!40000 ALTER TABLE `formation_ml_repartition_village` DISABLE KEYS */;
INSERT INTO `formation_ml_repartition_village` (`id`, `id_village`, `id_formation_ml_repartition`) VALUES
	(1, 6, 1);
/*!40000 ALTER TABLE `formation_ml_repartition_village` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. formation_thematique_agex
DROP TABLE IF EXISTS `formation_thematique_agex`;
CREATE TABLE IF NOT EXISTS `formation_thematique_agex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme_sensibilisation` int(11) DEFAULT NULL,
  `id_contrat_agex` int(11) DEFAULT NULL,
  `date_debut_prevu` date DEFAULT NULL,
  `date_fin_prevu` date DEFAULT NULL,
  `date_debut_realisation` date DEFAULT NULL,
  `date_fin_realisation` date DEFAULT NULL,
  `nbr_beneficiaire_cible` int(11) DEFAULT NULL,
  `formateur` varchar(50) DEFAULT NULL,
  `observation` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_formation_thema_theme_sensibilisation` (`id_theme_sensibilisation`),
  KEY `FK_formation_thema_contrat_ugp_agex` (`id_contrat_agex`),
  CONSTRAINT `FK_formation_thema_contrat_ugp_agex` FOREIGN KEY (`id_contrat_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_formation_thema_theme_sensibilisation` FOREIGN KEY (`id_theme_sensibilisation`) REFERENCES `theme_sensibilisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.formation_thematique_agex : ~1 rows (environ)
/*!40000 ALTER TABLE `formation_thematique_agex` DISABLE KEYS */;
INSERT INTO `formation_thematique_agex` (`id`, `id_theme_sensibilisation`, `id_contrat_agex`, `date_debut_prevu`, `date_fin_prevu`, `date_debut_realisation`, `date_fin_realisation`, `nbr_beneficiaire_cible`, `formateur`, `observation`) VALUES
	(1, 1, 6, '2021-06-03', '2021-06-03', '2021-06-03', '2021-06-07', 12, 'formtzteur', 'observation');
/*!40000 ALTER TABLE `formation_thematique_agex` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. livrable_ong_encadrement
DROP TABLE IF EXISTS `livrable_ong_encadrement`;
CREATE TABLE IF NOT EXISTS `livrable_ong_encadrement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agex` int(11) DEFAULT NULL,
  `id_contrat_agex` int(11) DEFAULT NULL,
  `id_commune` int(11) DEFAULT NULL,
  `mission` varchar(250) DEFAULT NULL,
  `outil_travail` varchar(250) DEFAULT NULL,
  `methodologie` varchar(250) DEFAULT NULL,
  `planning` longtext,
  `date_edition` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_livrable_ong_see_agex` (`id_agex`),
  KEY `FK_livrable_ong_contrat_ugp_agex` (`id_contrat_agex`),
  KEY `FK_livrable_ong_see_commune` (`id_commune`),
  CONSTRAINT `FK_livrable_ong_contrat_ugp_agex` FOREIGN KEY (`id_contrat_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_livrable_ong_see_agex` FOREIGN KEY (`id_agex`) REFERENCES `see_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_livrable_ong_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.livrable_ong_encadrement : ~2 rows (environ)
/*!40000 ALTER TABLE `livrable_ong_encadrement` DISABLE KEYS */;
INSERT INTO `livrable_ong_encadrement` (`id`, `id_agex`, `id_contrat_agex`, `id_commune`, `mission`, `outil_travail`, `methodologie`, `planning`, `date_edition`) VALUES
	(1, 17, 5, 6, 'mission', 'outils de', 'methode', 'planning', '2021-06-09'),
	(2, 17, 6, 6, 'mission2', 'outils de2', 'methode2', '-planning2\n-planning3\n-planning3', '2021-06-10');
/*!40000 ALTER TABLE `livrable_ong_encadrement` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. livrable_ong_encadrement_village
DROP TABLE IF EXISTS `livrable_ong_encadrement_village`;
CREATE TABLE IF NOT EXISTS `livrable_ong_encadrement_village` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_livrable_ong_encadrement` int(11) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_liv_village_livrable_ong_encadrement` (`id_livrable_ong_encadrement`),
  KEY `FK_liv_village_see_village` (`id_village`),
  CONSTRAINT `FK_liv_village_livrable_ong_encadrement` FOREIGN KEY (`id_livrable_ong_encadrement`) REFERENCES `livrable_ong_encadrement` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_liv_village_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.livrable_ong_encadrement_village : ~1 rows (environ)
/*!40000 ALTER TABLE `livrable_ong_encadrement_village` DISABLE KEYS */;
INSERT INTO `livrable_ong_encadrement_village` (`id`, `id_livrable_ong_encadrement`, `id_village`) VALUES
	(1, 1, 1);
/*!40000 ALTER TABLE `livrable_ong_encadrement_village` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. orientation
DROP TABLE IF EXISTS `orientation`;
CREATE TABLE IF NOT EXISTS `orientation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_profilage_orientation` int(11) DEFAULT NULL,
  `activite` varchar(150) DEFAULT NULL,
  `type_activite` smallint(6) DEFAULT NULL,
  `secteur` varchar(100) DEFAULT NULL,
  `groupe` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_orientation_fiche_profilage` (`id_profilage_orientation`),
  CONSTRAINT `FK_orientation_fiche_profilage` FOREIGN KEY (`id_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.orientation : ~0 rows (environ)
/*!40000 ALTER TABLE `orientation` DISABLE KEYS */;
/*!40000 ALTER TABLE `orientation` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. outils_communication_ml
DROP TABLE IF EXISTS `outils_communication_ml`;
CREATE TABLE IF NOT EXISTS `outils_communication_ml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outils_communication` longtext,
  `id_formation_ml` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__outils_formation_ml` (`id_formation_ml`),
  CONSTRAINT `FK__outils_formation_ml` FOREIGN KEY (`id_formation_ml`) REFERENCES `formation_ml` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.outils_communication_ml : ~1 rows (environ)
/*!40000 ALTER TABLE `outils_communication_ml` DISABLE KEYS */;
INSERT INTO `outils_communication_ml` (`id`, `outils_communication`, `id_formation_ml`) VALUES
	(1, 'a:2:{i:0;s:8:"depliant";i:1;s:17:"spot_audio_visuel";}', 1);
/*!40000 ALTER TABLE `outils_communication_ml` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. outils_utilise_sensibilisation
DROP TABLE IF EXISTS `outils_utilise_sensibilisation`;
CREATE TABLE IF NOT EXISTS `outils_utilise_sensibilisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.outils_utilise_sensibilisation : ~6 rows (environ)
/*!40000 ALTER TABLE `outils_utilise_sensibilisation` DISABLE KEYS */;
INSERT INTO `outils_utilise_sensibilisation` (`id`, `description`) VALUES
	(1, 'Boite à image '),
	(2, 'Affiche'),
	(3, 'Roll up '),
	(4, ' Dépliant '),
	(5, 'Bâche'),
	(6, 'Brochure');
/*!40000 ALTER TABLE `outils_utilise_sensibilisation` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. pac
DROP TABLE IF EXISTS `pac`;
CREATE TABLE IF NOT EXISTS `pac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ile` int(11) DEFAULT '0',
  `id_region` int(11) DEFAULT '0',
  `id_commune` int(11) DEFAULT '0',
  `id_village` int(11) DEFAULT NULL,
  `id_zip` int(11) DEFAULT '0',
  `id_type_agr` int(11) DEFAULT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `milieu_physique` varchar(100) DEFAULT NULL,
  `condition_climatique` varchar(100) DEFAULT NULL,
  `diffi_socio_eco` varchar(100) DEFAULT NULL,
  `infra_pub_soc` varchar(100) DEFAULT NULL,
  `analyse_pro` varchar(100) DEFAULT NULL,
  `identi_prio_arse` varchar(100) DEFAULT NULL,
  `marche_loc_reg_arse` varchar(100) DEFAULT NULL,
  `description_activite` varchar(100) DEFAULT NULL,
  `estimation_besoin` varchar(100) DEFAULT NULL,
  `etude_eco` varchar(100) DEFAULT NULL,
  `structure_appui` varchar(100) DEFAULT NULL,
  `impact_env` varchar(100) DEFAULT NULL,
  `impact_sociau` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pac_see_ile` (`id_ile`),
  KEY `FK_pac_see_region` (`id_region`),
  KEY `FK_pac_see_commune` (`id_commune`),
  KEY `FK_pac_zip` (`id_zip`),
  KEY `FK_pac_see_village` (`id_village`),
  KEY `FK_pac_type_agr` (`id_type_agr`),
  CONSTRAINT `FK_pac_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pac_see_ile` FOREIGN KEY (`id_ile`) REFERENCES `see_ile` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pac_see_region` FOREIGN KEY (`id_region`) REFERENCES `see_region` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pac_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pac_type_agr` FOREIGN KEY (`id_type_agr`) REFERENCES `type_agr` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pac_zip` FOREIGN KEY (`id_zip`) REFERENCES `zip` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.pac : ~2 rows (environ)
/*!40000 ALTER TABLE `pac` DISABLE KEYS */;
INSERT INTO `pac` (`id`, `id_ile`, `id_region`, `id_commune`, `id_village`, `id_zip`, `id_type_agr`, `libelle`, `milieu_physique`, `condition_climatique`, `diffi_socio_eco`, `infra_pub_soc`, `analyse_pro`, `identi_prio_arse`, `marche_loc_reg_arse`, `description_activite`, `estimation_besoin`, `etude_eco`, `structure_appui`, `impact_env`, `impact_sociau`) VALUES
	(1, 4, 13, 39, NULL, 1, NULL, NULL, 'AEER', 'EREZR', 'ZERER', 'ZERER', 'ZEREZR', '565', '457', '45', 'FGHFG', 'FGHGF', 'FGHG', 'FGHDGF', 'FGHFGH'),
	(2, 1, 1, 6, NULL, 1, NULL, NULL, 'AEER', 'EREZR', 'ZERER', 'ZERER', 'ZEREZR', '565', '457', '45', 'FGHFG', 'FGHGF', 'FGHG', 'FGHDGF', 'FGHFGH');
/*!40000 ALTER TABLE `pac` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. pac_detail
DROP TABLE IF EXISTS `pac_detail`;
CREATE TABLE IF NOT EXISTS `pac_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  `besoin` varchar(150) DEFAULT NULL,
  `duree` float DEFAULT NULL,
  `cout` double DEFAULT NULL,
  `calendrier_activite` varchar(150) DEFAULT NULL,
  `id_pac` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__pac_pac_detail` (`id_pac`),
  CONSTRAINT `FK__pac_pac_detail` FOREIGN KEY (`id_pac`) REFERENCES `pac` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.pac_detail : ~0 rows (environ)
/*!40000 ALTER TABLE `pac_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `pac_detail` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. participant_formation_ml
DROP TABLE IF EXISTS `participant_formation_ml`;
CREATE TABLE IF NOT EXISTS `participant_formation_ml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation_ml` int(11) DEFAULT NULL,
  `nom` varchar(250) DEFAULT NULL,
  `fonction` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_parti_formation_ml` (`id_formation_ml`),
  CONSTRAINT `FK_parti_formation_ml` FOREIGN KEY (`id_formation_ml`) REFERENCES `formation_ml` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.participant_formation_ml : ~1 rows (environ)
/*!40000 ALTER TABLE `participant_formation_ml` DISABLE KEYS */;
INSERT INTO `participant_formation_ml` (`id`, `id_formation_ml`, `nom`, `fonction`) VALUES
	(1, 1, 'RALAIBETARAFINA1', 'PRESIDENTE');
/*!40000 ALTER TABLE `participant_formation_ml` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. participant_realisation_ebe
DROP TABLE IF EXISTS `participant_realisation_ebe`;
CREATE TABLE IF NOT EXISTS `participant_realisation_ebe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_realisation_ebe` int(11) DEFAULT NULL,
  `id_menage` int(11) DEFAULT NULL,
  `date_presence` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_participant_realisation_ebe` (`id_realisation_ebe`),
  KEY `FK_participant_realisation_ebe_menage` (`id_menage`),
  CONSTRAINT `FK_participant_realisation_ebe` FOREIGN KEY (`id_realisation_ebe`) REFERENCES `realisation_ebe` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_participant_realisation_ebe_menage` FOREIGN KEY (`id_menage`) REFERENCES `menage` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.participant_realisation_ebe : ~2 rows (environ)
/*!40000 ALTER TABLE `participant_realisation_ebe` DISABLE KEYS */;
INSERT INTO `participant_realisation_ebe` (`id`, `id_realisation_ebe`, `id_menage`, `date_presence`) VALUES
	(4, 3, 1, '2021-06-10'),
	(5, 3, 2, '2021-06-18');
/*!40000 ALTER TABLE `participant_realisation_ebe` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. pges
DROP TABLE IF EXISTS `pges`;
CREATE TABLE IF NOT EXISTS `pges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bureau_etude` varchar(100) DEFAULT NULL,
  `ref_contrat` varchar(100) DEFAULT NULL,
  `description_env` varchar(100) DEFAULT NULL,
  `composante_zone_susce` varchar(100) DEFAULT NULL,
  `probleme_env` varchar(100) DEFAULT NULL,
  `mesure_envisage` varchar(100) DEFAULT NULL,
  `observation` varchar(100) DEFAULT NULL,
  `nom_prenom_etablissement` varchar(100) DEFAULT NULL,
  `nom_prenom_validation` varchar(100) DEFAULT NULL,
  `date_etablissement` date DEFAULT NULL,
  `date_visa_ugp` date DEFAULT NULL,
  `nom_prenom_ugp` varchar(100) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `id_infrastructure` int(11) DEFAULT NULL,
  `montant_total` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pges_sous_projet` (`id_sous_projet`),
  KEY `FK_pges_see_village` (`id_village`),
  KEY `FK_pges_infrastructure` (`id_infrastructure`),
  CONSTRAINT `FK_pges_infrastructure` FOREIGN KEY (`id_infrastructure`) REFERENCES `infrastructure` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pges_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pges_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.pges : ~0 rows (environ)
/*!40000 ALTER TABLE `pges` DISABLE KEYS */;
/*!40000 ALTER TABLE `pges` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. pges_phases
DROP TABLE IF EXISTS `pges_phases`;
CREATE TABLE IF NOT EXISTS `pges_phases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `impacts` varchar(100) DEFAULT NULL,
  `mesures` varchar(100) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `calendrier_execution` varchar(100) DEFAULT NULL,
  `cout_estimatif` double DEFAULT NULL,
  `id_pges` int(11) DEFAULT NULL,
  `phase` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pges_phases_pges` (`id_pges`),
  CONSTRAINT `FK_pges_phases_pges` FOREIGN KEY (`id_pges`) REFERENCES `pges` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.pges_phases : ~0 rows (environ)
/*!40000 ALTER TABLE `pges_phases` DISABLE KEYS */;
/*!40000 ALTER TABLE `pges_phases` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. planning_ebe
DROP TABLE IF EXISTS `planning_ebe`;
CREATE TABLE IF NOT EXISTS `planning_ebe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  `id_groupe_ml_pl` int(11) DEFAULT NULL,
  `date_ebe` date DEFAULT NULL,
  `duree` float DEFAULT NULL,
  `lieu` varchar(100) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `id_theme_sensibilisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_planning_groupe_ml_pl` (`id_groupe_ml_pl`),
  KEY `FK_planning_theme_sensibilisation` (`id_theme_sensibilisation`),
  KEY `FK_planning_see_village` (`id_village`),
  CONSTRAINT `FK_planning_groupe_ml_pl` FOREIGN KEY (`id_groupe_ml_pl`) REFERENCES `groupe_ml_pl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_planning_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_planning_theme_sensibilisation` FOREIGN KEY (`id_theme_sensibilisation`) REFERENCES `theme_sensibilisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.planning_ebe : ~2 rows (environ)
/*!40000 ALTER TABLE `planning_ebe` DISABLE KEYS */;
INSERT INTO `planning_ebe` (`id`, `numero`, `id_groupe_ml_pl`, `date_ebe`, `duree`, `lieu`, `id_village`, `id_theme_sensibilisation`) VALUES
	(2, 1, 1, '2021-06-08', 20, 'lieu2', 6, 1),
	(3, 2, 1, '2021-06-09', 10, 'lieu2', 6, 2);
/*!40000 ALTER TABLE `planning_ebe` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. realisation_ebe
DROP TABLE IF EXISTS `realisation_ebe`;
CREATE TABLE IF NOT EXISTS `realisation_ebe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `but_regroupement` varchar(150) DEFAULT NULL,
  `date_regroupement` date DEFAULT NULL,
  `date_edition` date DEFAULT NULL,
  `materiel` varchar(150) DEFAULT NULL,
  `lieu` varchar(150) DEFAULT NULL,
  `id_groupe_ml_pl` int(11) DEFAULT NULL,
  `id_contrat_agex` int(11) DEFAULT NULL,
  `id_espace_bien_etre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_realisation_ebe_groupe_ml_pl` (`id_groupe_ml_pl`),
  KEY `FK_realisation_ebe_contrat_ugp_agex` (`id_contrat_agex`),
  KEY `FK_realisation_ebe_espace_bien_etre` (`id_espace_bien_etre`),
  CONSTRAINT `FK_realisation_ebe_contrat_ugp_agex` FOREIGN KEY (`id_contrat_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_realisation_ebe_espace_bien_etre` FOREIGN KEY (`id_espace_bien_etre`) REFERENCES `espace_bien_etre` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_realisation_ebe_groupe_ml_pl` FOREIGN KEY (`id_groupe_ml_pl`) REFERENCES `groupe_ml_pl` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.realisation_ebe : ~3 rows (environ)
/*!40000 ALTER TABLE `realisation_ebe` DISABLE KEYS */;
INSERT INTO `realisation_ebe` (`id`, `but_regroupement`, `date_regroupement`, `date_edition`, `materiel`, `lieu`, `id_groupe_ml_pl`, `id_contrat_agex`, `id_espace_bien_etre`) VALUES
	(1, 'but', '2021-06-29', '2021-06-21', 'materiel1', 'lieu2', 2, 6, 1),
	(2, 'but', '2021-06-08', NULL, 'materiel', 'lieu2', 2, 6, 1),
	(3, 'but', '2021-06-11', '2021-06-09', 'materi', 'lieu1', 2, 6, 1);
/*!40000 ALTER TABLE `realisation_ebe` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. ressources_disponibles
DROP TABLE IF EXISTS `ressources_disponibles`;
CREATE TABLE IF NOT EXISTS `ressources_disponibles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_profilage_orientation` int(11) NOT NULL DEFAULT '0',
  `designation` varchar(100) DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `etat` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ressource_fiche_profilage` (`id_profilage_orientation`),
  CONSTRAINT `FK_ressource_fiche_profilage` FOREIGN KEY (`id_profilage_orientation`) REFERENCES `fiche_profilage_orientation_entete` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.ressources_disponibles : ~0 rows (environ)
/*!40000 ALTER TABLE `ressources_disponibles` DISABLE KEYS */;
/*!40000 ALTER TABLE `ressources_disponibles` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. see_phaseexecution
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table pfss_db.see_phaseexecution : ~3 rows (environ)
/*!40000 ALTER TABLE `see_phaseexecution` DISABLE KEYS */;
INSERT INTO `see_phaseexecution` (`id`, `Code`, `Phase`, `montantalloue`, `indemnite`, `datedebut`, `datefin`, `programme_id`, `a_ete_modifie`, `supprime`, `userid`, `datemodification`, `pourcentage`, `id_sous_projet`) VALUES
	(1, 'P1', 'Etape1', NULL, 1000, '2016-04-05 09:00:00', '2016-04-13 09:00:00', 1, 1, 0, 5, '2018-09-04 15:28:26', NULL, NULL),
	(2, 'P3', 'Etape 3', NULL, 1000, '2016-08-09 18:00:00', '2016-09-09 18:00:00', 1, 1, 0, NULL, NULL, NULL, NULL),
	(3, 'P2', 'Etape 2', NULL, 1000, '2017-03-18 06:14:12', '2017-03-18 06:14:12', 1, 1, 0, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `see_phaseexecution` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. theme_formation_ebe
DROP TABLE IF EXISTS `theme_formation_ebe`;
CREATE TABLE IF NOT EXISTS `theme_formation_ebe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activite` varchar(200) DEFAULT NULL,
  `id_theme_sensibilisation` int(11) DEFAULT NULL,
  `id_realisation_ebe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_theme_realisation_ebe` (`id_realisation_ebe`),
  KEY `FK_theme_formation_ebe_theme_sensibilisation` (`id_theme_sensibilisation`),
  CONSTRAINT `FK_theme_formation_ebe_theme_sensibilisation` FOREIGN KEY (`id_theme_sensibilisation`) REFERENCES `theme_sensibilisation` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_theme_realisation_ebe` FOREIGN KEY (`id_realisation_ebe`) REFERENCES `realisation_ebe` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.theme_formation_ebe : ~2 rows (environ)
/*!40000 ALTER TABLE `theme_formation_ebe` DISABLE KEYS */;
INSERT INTO `theme_formation_ebe` (`id`, `activite`, `id_theme_sensibilisation`, `id_realisation_ebe`) VALUES
	(1, 'activitee', 1, 1),
	(2, '', 2, 1);
/*!40000 ALTER TABLE `theme_formation_ebe` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. theme_formation_ml
DROP TABLE IF EXISTS `theme_formation_ml`;
CREATE TABLE IF NOT EXISTS `theme_formation_ml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme_sensibilisation` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `date_formation` date DEFAULT NULL,
  `id_formation_ml` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__theme_sensibilisation` (`id_theme_sensibilisation`),
  KEY `FK__formation_ml` (`id_formation_ml`),
  CONSTRAINT `FK__formation_ml` FOREIGN KEY (`id_formation_ml`) REFERENCES `formation_ml` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK__theme_sensibilisation` FOREIGN KEY (`id_theme_sensibilisation`) REFERENCES `theme_sensibilisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.theme_formation_ml : ~1 rows (environ)
/*!40000 ALTER TABLE `theme_formation_ml` DISABLE KEYS */;
INSERT INTO `theme_formation_ml` (`id`, `id_theme_sensibilisation`, `numero`, `date_formation`, `id_formation_ml`) VALUES
	(1, 1, 1, '2021-06-03', 1);
/*!40000 ALTER TABLE `theme_formation_ml` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
