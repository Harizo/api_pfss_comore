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

-- Listage de la structure de la table pfss_db. avenant_agep
DROP TABLE IF EXISTS `avenant_agep`;
CREATE TABLE IF NOT EXISTS `avenant_agep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrat_agep` int(11) DEFAULT NULL,
  `numero_avenant` varchar(50) DEFAULT NULL,
  `objet_avenant` varchar(100) DEFAULT NULL,
  `montant_avenant` double DEFAULT NULL,
  `modalite_avenant` varchar(100) DEFAULT NULL,
  `date_prevu_fin` date DEFAULT NULL,
  `noms_signataires` varchar(100) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `statu` varchar(50) DEFAULT NULL,
  `type_avenant` varchar(50) DEFAULT NULL,
  `observation` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_avenant_agep_contrat_agep` (`id_contrat_agep`),
  CONSTRAINT `FK_avenant_agep_contrat_agep` FOREIGN KEY (`id_contrat_agep`) REFERENCES `contrat_agep` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.avenant_agep : ~2 rows (environ)
/*!40000 ALTER TABLE `avenant_agep` DISABLE KEYS */;
INSERT INTO `avenant_agep` (`id`, `id_contrat_agep`, `numero_avenant`, `objet_avenant`, `montant_avenant`, `modalite_avenant`, `date_prevu_fin`, `noms_signataires`, `date_signature`, `statu`, `type_avenant`, `observation`) VALUES
	(7, 2, 'avenant 1', 'objet', 2000, 'modalite', '2021-05-11', 'noms des', '2021-05-04', 'EN COURS', 'DELAI', 'observation'),
	(8, 6, 'avenant pp', 'objet', 1000, 'modalite', '2021-05-20', 'noms des', '2021-05-05', 'EN COURS', 'FINANCIER', NULL);
/*!40000 ALTER TABLE `avenant_agep` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. etat_paiement_agep
DROP TABLE IF EXISTS `etat_paiement_agep`;
CREATE TABLE IF NOT EXISTS `etat_paiement_agep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_ordre_paiement` varchar(50) DEFAULT NULL,
  `activite_concerne` varchar(50) DEFAULT NULL,
  `id_menage` int(11) DEFAULT NULL,
  `id_contrat_agep` int(11) DEFAULT NULL,
  `tranche` int(11) DEFAULT NULL,
  `pourcentage` float DEFAULT NULL,
  `montant_percu` double DEFAULT NULL,
  `date_paiement` date DEFAULT NULL,
  `moyen_transfert` varchar(50) DEFAULT NULL,
  `situation_paiement` varchar(50) DEFAULT NULL,
  `id_ile` int(11) DEFAULT NULL,
  `id_region` int(11) DEFAULT NULL,
  `id_commune` int(11) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `id_communaute` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_etat_paiement_agep_menage` (`id_menage`),
  KEY `FK_etat_paiement_agep_contrat_agep` (`id_contrat_agep`),
  KEY `FK_etat_paiement_agep_see_ile` (`id_ile`),
  KEY `FK_etat_paiement_agep_see_region` (`id_region`),
  KEY `FK_etat_paiement_agep_see_commune` (`id_commune`),
  KEY `FK_etat_paiement_agep_see_village` (`id_village`),
  KEY `FK_etat_paiement_agep_communaute_2` (`id_communaute`),
  CONSTRAINT `FK_etat_paiement_agep_communaute_2` FOREIGN KEY (`id_communaute`) REFERENCES `communaute` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_etat_paiement_agep_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_etat_paiement_agep_see_ile` FOREIGN KEY (`id_ile`) REFERENCES `see_ile` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_etat_paiement_agep_see_region` FOREIGN KEY (`id_region`) REFERENCES `see_region` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_etat_paiement_agep_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.etat_paiement_agep : ~7 rows (environ)
/*!40000 ALTER TABLE `etat_paiement_agep` DISABLE KEYS */;
INSERT INTO `etat_paiement_agep` (`id`, `numero_ordre_paiement`, `activite_concerne`, `id_menage`, `id_contrat_agep`, `tranche`, `pourcentage`, `montant_percu`, `date_paiement`, `moyen_transfert`, `situation_paiement`, `id_ile`, `id_region`, `id_commune`, `id_village`, `id_communaute`) VALUES
	(3, '1', 'ARSE', 381, 4, 1, 10, 31500, '2021-05-01', 'moyen', 'situation', 4, 13, 38, 37, NULL),
	(4, '1', 'ACT', 38, 2, 1, 50, 37500, '2021-05-01', 'moyen', 'situation', 4, 13, 38, 40, NULL),
	(5, '1', 'TMNC-COVID-19', 395, 5, 1, 0, 105000, '2021-05-01', 'moyen', 'situation', 4, 13, 38, 40, NULL),
	(6, '1', 'IDB', 395, 6, 1, 10, 31500, '2021-05-01', 'moyen', 'situ', 1, 4, 8, NULL, 2),
	(8, '2', 'ARSE', 418, 4, 2, 70, 220500, '2021-05-02', 'moyen', 'situation', 4, 13, 38, 37, NULL),
	(9, '2', 'TMNC-COVID-19', 395, 5, 2, 0, 35000, '2021-05-05', 'moyen', 'situation', 4, 13, 38, 40, NULL),
	(10, '2', 'ACT', 30, 2, 2, 50, 37500, '2021-04-22', 'moyen', 'situation', 4, 13, 38, 40, NULL),
	(11, '1', 'ACT', 14, 2, 1, 50, 37500, '0000-00-00', 'moyen de', 'situation', 1, 1, 6, 6, NULL);
/*!40000 ALTER TABLE `etat_paiement_agep` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. infrastructure
DROP TABLE IF EXISTS `infrastructure`;
CREATE TABLE IF NOT EXISTS `infrastructure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type_infrastructure` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `libelle` varchar(10) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `statu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_infrastructure_type_infrastructure` (`id_type_infrastructure`),
  KEY `FK_infrastructure_see_village` (`id_village`),
  CONSTRAINT `FK_infrastructure_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_infrastructure_type_infrastructure` FOREIGN KEY (`id_type_infrastructure`) REFERENCES `type_infrastructure` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.infrastructure : ~2 rows (environ)
/*!40000 ALTER TABLE `infrastructure` DISABLE KEYS */;
INSERT INTO `infrastructure` (`id`, `id_type_infrastructure`, `code`, `libelle`, `id_village`, `statu`) VALUES
	(1, 1, 'code', 'libelle', 6, 'ELIGIBLE'),
	(2, 1, 'codep2', 'libellep2', 6, 'CHOISI');
/*!40000 ALTER TABLE `infrastructure` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.pges : ~3 rows (environ)
/*!40000 ALTER TABLE `pges` DISABLE KEYS */;
INSERT INTO `pges` (`id`, `bureau_etude`, `ref_contrat`, `description_env`, `composante_zone_susce`, `probleme_env`, `mesure_envisage`, `observation`, `nom_prenom_etablissement`, `nom_prenom_validation`, `date_etablissement`, `date_visa_ugp`, `nom_prenom_ugp`, `id_sous_projet`) VALUES
	(1, 'bureau', 'refcontrat', 'description', 'composante', 'probleme envv', 'mesure', 'observation', 'nom', 'nom', '2021-04-07', '2021-04-01', 'nom', 1),
	(2, 'bureau2', 'ef_contrat2', 'description2', 'composante2', 'probleme2', 'mesure2', 'observatio2', 'nom2', 'nom2', '2021-04-06', '2021-04-09', 'nom2', 2),
	(3, 'BE', 'ref contrat', 'description', 'composante', 'probleme', 'mesure', 'observation', 'nom', 'nom', '2021-05-01', '2021-05-01', 'nom', 3),
	(4, 'BE', 'refe', 'description', 'composante', 'probleme', 'mesure', 'observ', 'noms', 'nom', '2021-05-01', '2021-05-02', 'nom', 1);
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
	(1, 'description', 'impact', 'mesure', 'responsable', 'calendrier', 1000, 1);
/*!40000 ALTER TABLE `pges_phases` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet
DROP TABLE IF EXISTS `sous_projet`;
CREATE TABLE IF NOT EXISTS `sous_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `nature` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `objectif` varchar(100) DEFAULT NULL,
  `duree` float DEFAULT NULL,
  `id_par` int(11) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_plan_action_reinstallation` (`id_par`),
  CONSTRAINT `FK_sous_projet_plan_action_reinstallation` FOREIGN KEY (`id_par`) REFERENCES `plan_action_reinstallation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.sous_projet : ~4 rows (environ)
/*!40000 ALTER TABLE `sous_projet` DISABLE KEYS */;
INSERT INTO `sous_projet` (`id`, `code`, `nature`, `type`, `description`, `objectif`, `duree`, `id_par`, `montant`) VALUES
	(1, 'ACT', 'nature', 'ACT', 'Argent Contre Travail', 'objectif', 1, 1, 10000),
	(2, 'ARSE', 'nature', 'ARSE', 'Activités de Réinsertion Socio-Economique', 'objectif', 30, 1, NULL),
	(3, 'IDB', 'nature', 'IDB', 'Réhabilitation Infrastructure de Base', 'objectif', 30, 1, NULL),
	(4, 'COVID-19', 'nature', 'COVID-19', 'COVID-19', 'objectif', 30, 1, NULL);
/*!40000 ALTER TABLE `sous_projet` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet_localisation
DROP TABLE IF EXISTS `sous_projet_localisation`;
CREATE TABLE IF NOT EXISTS `sous_projet_localisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `presentantion_communaute` varchar(200) DEFAULT NULL,
  `ref_dgsc` varchar(100) DEFAULT NULL,
  `nbr_menage_participant` int(11) DEFAULT NULL,
  `nbr_menage_beneficiaire` int(11) DEFAULT NULL,
  `nbr_menage_nonparticipant` int(11) DEFAULT NULL,
  `population_total` int(11) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  `id_ile` int(11) DEFAULT NULL,
  `id_region` int(11) DEFAULT NULL,
  `id_commune` int(11) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `id_communaute` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_localisation_sous_projet` (`id_sous_projet`),
  KEY `FK_sous_projet_localisation_see_ile` (`id_ile`),
  KEY `FK_sous_projet_localisation_see_region` (`id_region`),
  KEY `FK_sous_projet_localisation_see_commune` (`id_commune`),
  KEY `FK_sous_projet_localisation_see_village` (`id_village`),
  KEY `FK_sous_projet_localisation_communaute` (`id_communaute`),
  CONSTRAINT `FK_sous_projet_localisation_communaute` FOREIGN KEY (`id_communaute`) REFERENCES `communaute` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sous_projet_localisation_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sous_projet_localisation_see_ile` FOREIGN KEY (`id_ile`) REFERENCES `see_ile` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sous_projet_localisation_see_region` FOREIGN KEY (`id_region`) REFERENCES `see_region` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sous_projet_localisation_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sous_projet_localisation_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_localisation : ~6 rows (environ)
/*!40000 ALTER TABLE `sous_projet_localisation` DISABLE KEYS */;
INSERT INTO `sous_projet_localisation` (`id`, `presentantion_communaute`, `ref_dgsc`, `nbr_menage_participant`, `nbr_menage_beneficiaire`, `nbr_menage_nonparticipant`, `population_total`, `id_sous_projet`, `id_ile`, `id_region`, `id_commune`, `id_village`, `id_communaute`) VALUES
	(1, 'presentation', 'ref_dgsc', 90, 100, 15, 10, 1, 4, 13, 38, 40, NULL),
	(2, '', 'refarse', 0, 22, 0, 0, 2, 1, 1, 4, 3, NULL),
	(4, 'presentationidb', 'ref', 0, 3, 0, 30, 3, 1, 1, 6, 6, 3),
	(5, '', 'refcovid', 0, 44, 0, 0, 4, 4, 14, 42, 54, NULL),
	(6, 'pre', 'ref', 0, 40, 0, 10, 2, 1, 1, 6, 6, NULL),
	(7, 'p', 'r', 0, 50, 10, 50, 2, 1, 1, 6, 6, NULL);
/*!40000 ALTER TABLE `sous_projet_localisation` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
