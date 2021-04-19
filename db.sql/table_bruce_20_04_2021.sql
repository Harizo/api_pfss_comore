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
  PRIMARY KEY (`id`),
  KEY `FK_consultant_ong_see_ile` (`ile_id`),
  CONSTRAINT `FK_consultant_ong_see_ile` FOREIGN KEY (`ile_id`) REFERENCES `see_ile` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.consultant_ong : ~2 rows (environ)
/*!40000 ALTER TABLE `consultant_ong` DISABLE KEYS */;
INSERT INTO `consultant_ong` (`id`, `ile_id`, `code`, `raison_social`, `contact`, `fonction_contact`, `telephone_contact`, `adresse`, `nom_consultant`) VALUES
	(1, 2, 'REP_BES', 'consultant', 'contac', 'dfdfd', '123 456', 'adr', NULL),
	(2, 1, 'REP_MT', 'consu l 2', 'vvv', 'hhh', '456', 'dresse', NULL),
	(3, 4, 'code', 'raison', 'contact', 'fonction', '01452545', 'adresse', 'Nom consultant');
/*!40000 ALTER TABLE `consultant_ong` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fichepresence_bienetre
DROP TABLE IF EXISTS `fichepresence_bienetre`;
CREATE TABLE IF NOT EXISTS `fichepresence_bienetre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_ligne` int(11) DEFAULT NULL,
  `id_groupe_ml_pl` int(11) DEFAULT NULL,
  `menage_id` int(11) DEFAULT NULL,
  `enfant_moins_six_ans` tinyint(4) DEFAULT NULL,
  `date_presence` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fichepresence_bienetre_groupe_ml_pl` (`id_groupe_ml_pl`),
  KEY `FK_fichepresence_bienetre_menage` (`menage_id`),
  CONSTRAINT `FK_fichepresence_bienetre_groupe_ml_pl` FOREIGN KEY (`id_groupe_ml_pl`) REFERENCES `groupe_ml_pl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fichepresence_bienetre_menage` FOREIGN KEY (`menage_id`) REFERENCES `menage` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.fichepresence_bienetre : ~0 rows (environ)
/*!40000 ALTER TABLE `fichepresence_bienetre` DISABLE KEYS */;
INSERT INTO `fichepresence_bienetre` (`id`, `numero_ligne`, `id_groupe_ml_pl`, `menage_id`, `enfant_moins_six_ans`, `date_presence`) VALUES
	(2, 1, 2, 9326, 2, '2021-04-01');
/*!40000 ALTER TABLE `fichepresence_bienetre` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. fiche_env
DROP TABLE IF EXISTS `fiche_env`;
CREATE TABLE IF NOT EXISTS `fiche_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule_sousprojet` varchar(100) DEFAULT NULL,
  `bureau_etude` varchar(100) DEFAULT NULL,
  `ref_contrat` varchar(100) DEFAULT NULL,
  `composante_sousprojet` varchar(100) DEFAULT NULL,
  `composante_zone_susce` varchar(100) DEFAULT NULL,
  `probleme_env` varchar(100) DEFAULT NULL,
  `mesure_envisage` varchar(100) DEFAULT NULL,
  `justification_classe_env` varchar(100) DEFAULT NULL,
  `observation` varchar(100) DEFAULT NULL,
  `date_visa_rt` date DEFAULT NULL,
  `date_visa_ugp` date DEFAULT NULL,
  `date_visa_be` date DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fiche_env_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_fiche_env_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.fiche_env : ~3 rows (environ)
/*!40000 ALTER TABLE `fiche_env` DISABLE KEYS */;
INSERT INTO `fiche_env` (`id`, `intitule_sousprojet`, `bureau_etude`, `ref_contrat`, `composante_sousprojet`, `composante_zone_susce`, `probleme_env`, `mesure_envisage`, `justification_classe_env`, `observation`, `date_visa_rt`, `date_visa_ugp`, `date_visa_be`, `id_sous_projet`) VALUES
	(1, 'inti', 'burea', 'reffer', 'rcompo', 'compo', 'problr', 'mesure', '456', 'ouu', '2021-03-03', '2021-03-03', '2021-03-04', 1),
	(4, 'inti2', 'burea2', 'reffer2', 'rcompo2', 'compo2', 'problr2', 'mesure2', 'just2', 'ou2', '2021-03-05', '2021-03-10', '2021-03-10', 1),
	(5, NULL, 'cvbcbxcaaa', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', '2021-09-03', '2021-10-03', '2021-11-03', 8);
/*!40000 ALTER TABLE `fiche_env` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.fiche_supervision_mlpl : ~0 rows (environ)
/*!40000 ALTER TABLE `fiche_supervision_mlpl` DISABLE KEYS */;
INSERT INTO `fiche_supervision_mlpl` (`id`, `id_groupemlpl`, `id_consultant_ong`, `type_supervision`, `personne_rencontree`, `organisation_consultant`, `planning_activite_consultant`, `nom_missionnaire`, `date_supervision`, `date_prevue_debut`, `date_prevue_fin`, `nom_representant_mlpl`) VALUES
	(1, 2, 3, 'type', 'personne', 'organisation', 'planning activite', 'nom mission', '2021-04-07', '2021-04-08', '2021-04-09', 'nom');
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

-- Listage des données de la table pfss_db.livrable_mlpl : ~0 rows (environ)
/*!40000 ALTER TABLE `livrable_mlpl` DISABLE KEYS */;
INSERT INTO `livrable_mlpl` (`id`, `id_contrat_consultant`, `id_groupemlpl`, `activite_concernee`, `intitule_livrable`, `date_prevue_remise`, `date_effective_reception`, `intervenant`, `nbr_commune_touchee`, `nbr_village_touchee`, `observation`) VALUES
	(2, 6, 2, 'activite', 'intitule', '2021-03-03', '2021-04-02', 'intervenant', 100, 10, 'observation');
/*!40000 ALTER TABLE `livrable_mlpl` ENABLE KEYS */;

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
  PRIMARY KEY (`id`),
  KEY `FK_pges_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_pges_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.pges : ~2 rows (environ)
/*!40000 ALTER TABLE `pges` DISABLE KEYS */;
INSERT INTO `pges` (`id`, `bureau_etude`, `ref_contrat`, `description_env`, `composante_zone_susce`, `probleme_env`, `mesure_envisage`, `observation`, `nom_prenom_etablissement`, `nom_prenom_validation`, `date_etablissement`, `date_visa_ugp`, `nom_prenom_ugp`, `id_sous_projet`) VALUES
	(1, 'bureau', 'refcontrat', 'description', 'composante', 'probleme', 'mesure', 'observation', 'nom', 'nom', '2021-04-07', '2021-04-01', 'nom', 1),
	(2, 'bureau2', 'ef_contrat2', 'description2', 'composante2', 'probleme2', 'mesure2', 'observatio2', 'nom2', 'nom2', '2021-04-06', '2021-04-09', 'nom2', 2);
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
  PRIMARY KEY (`id`),
  KEY `FK_pges_phases_pges` (`id_pges`),
  CONSTRAINT `FK_pges_phases_pges` FOREIGN KEY (`id_pges`) REFERENCES `pges` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.pges_phases : ~0 rows (environ)
/*!40000 ALTER TABLE `pges_phases` DISABLE KEYS */;
INSERT INTO `pges_phases` (`id`, `description`, `impacts`, `mesures`, `responsable`, `calendrier_execution`, `cout_estimatif`, `id_pges`) VALUES
	(1, 'description', 'impact', 'mesure', 'responsable', 'calendrier', 111111, 1);
/*!40000 ALTER TABLE `pges_phases` ENABLE KEYS */;

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

-- Listage des données de la table pfss_db.point_a_verifier_mlpl : ~0 rows (environ)
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

-- Listage des données de la table pfss_db.point_controle_mlpl : ~0 rows (environ)
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

-- Listage des données de la table pfss_db.probleme_solution_mlpl : ~0 rows (environ)
/*!40000 ALTER TABLE `probleme_solution_mlpl` DISABLE KEYS */;
INSERT INTO `probleme_solution_mlpl` (`id`, `id_fiche_supervision_mlpl`, `probleme`, `solution`) VALUES
	(1, 1, 'probleme', 'solution propose');
/*!40000 ALTER TABLE `probleme_solution_mlpl` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
