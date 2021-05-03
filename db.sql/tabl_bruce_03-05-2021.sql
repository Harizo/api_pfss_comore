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

-- Listage de la structure de la table pfss_db. aspects_env
DROP TABLE IF EXISTS `aspects_env`;
CREATE TABLE IF NOT EXISTS `aspects_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emplace_site` varchar(100) DEFAULT NULL,
  `etat_initial_recepteur` varchar(100) DEFAULT NULL,
  `classification_sous_projet` varchar(100) DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_aspects_env_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_aspects_env_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.aspects_env : ~0 rows (environ)
/*!40000 ALTER TABLE `aspects_env` DISABLE KEYS */;
INSERT INTO `aspects_env` (`id`, `emplace_site`, `etat_initial_recepteur`, `classification_sous_projet`, `id_sous_projet_localisation`) VALUES
	(2, 'emplacement', 'description etat', 'classification', 1);
/*!40000 ALTER TABLE `aspects_env` ENABLE KEYS */;

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
  PRIMARY KEY (`id`),
  KEY `FK_avenant_agep_contrat_agep` (`id_contrat_agep`),
  CONSTRAINT `FK_avenant_agep_contrat_agep` FOREIGN KEY (`id_contrat_agep`) REFERENCES `contrat_agep` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.avenant_agep : ~1 rows (environ)
/*!40000 ALTER TABLE `avenant_agep` DISABLE KEYS */;
INSERT INTO `avenant_agep` (`id`, `id_contrat_agep`, `numero_avenant`, `objet_avenant`, `montant_avenant`, `modalite_avenant`, `date_prevu_fin`, `noms_signataires`, `date_signature`, `statu`) VALUES
	(7, 2, 'avenant 1', 'objet', 2000, 'modalite', '2021-05-11', 'noms des', '2021-05-04', 'EN COURS');
/*!40000 ALTER TABLE `avenant_agep` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. calendrier_activites
DROP TABLE IF EXISTS `calendrier_activites`;
CREATE TABLE IF NOT EXISTS `calendrier_activites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activite` varchar(100) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `mois` varchar(50) DEFAULT NULL,
  `id_pac` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_calendrier_activites_pac` (`id_pac`),
  CONSTRAINT `FK_calendrier_activites_pac` FOREIGN KEY (`id_pac`) REFERENCES `pac` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.calendrier_activites : ~4 rows (environ)
/*!40000 ALTER TABLE `calendrier_activites` DISABLE KEYS */;
INSERT INTO `calendrier_activites` (`id`, `activite`, `numero`, `mois`, `id_pac`) VALUES
	(2, 'activite1', 1, 'Janvier', 1),
	(3, 'activite1', 2, 'Fevrier', 1),
	(4, 'activite2', 1, 'Mars', 1),
	(5, 'activite1', 3, 'Mars', 1);
/*!40000 ALTER TABLE `calendrier_activites` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. communaute
DROP TABLE IF EXISTS `communaute`;
CREATE TABLE IF NOT EXISTS `communaute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_zip` int(11) DEFAULT NULL,
  `id_commune` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `libelle` varchar(10) DEFAULT NULL,
  `nbr_population` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_communaute_zip` (`id_zip`),
  KEY `FK_communaute_see_commune` (`id_commune`),
  CONSTRAINT `FK_communaute_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_communaute_zip` FOREIGN KEY (`id_zip`) REFERENCES `zip` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.communaute : ~3 rows (environ)
/*!40000 ALTER TABLE `communaute` DISABLE KEYS */;
INSERT INTO `communaute` (`id`, `id_zip`, `id_commune`, `code`, `libelle`, `nbr_population`) VALUES
	(1, 1, 4, 'codeb', 'libelleb', 10),
	(2, 1, 4, 'code1', 'libelle1', 10),
	(3, 1, 48, 'code', 'libelle', 20);
/*!40000 ALTER TABLE `communaute` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. contrat_agep
DROP TABLE IF EXISTS `contrat_agep`;
CREATE TABLE IF NOT EXISTS `contrat_agep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agep` int(11) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  `numero_contrat` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.contrat_agep : ~5 rows (environ)
/*!40000 ALTER TABLE `contrat_agep` DISABLE KEYS */;
INSERT INTO `contrat_agep` (`id`, `id_agep`, `id_sous_projet`, `numero_contrat`, `objet_contrat`, `montant_contrat`, `montant_a_effectue_prevu`, `modalite_contrat`, `date_prevu_fin`, `noms_signataires`, `date_signature`, `statu`) VALUES
	(2, 19, 1, '2020/12/456/RAD/FDZ', 'objet', 123456, 75000, 'modalite du', '2021-04-03', 'noms', '2021-04-02', 'EN COURS'),
	(3, 19, 1, '2020/12/456/RAD/FDZ', 'objet2', 100000, 75000, 'modalite du contrat', '2021-05-12', 'noms des', '2021-05-02', 'RESILIE'),
	(4, 19, 2, '2020/12/456/RAD/FDZARSE', 'objet', 100, 315000, 'modalite du contrat', '2021-05-06', 'noms des', '2021-05-01', 'EN COURS'),
	(5, 19, 4, '2020/12/456/RAD/FDZTMNCCOVID', 'objet', 200, 105000, 'modalite du contrat', '2021-05-06', 'noms des', '2021-05-05', 'EN COURS'),
	(6, 19, 3, '2020/12/456/RAD/FDZIDB', 'objet', 1000, 315000, 'modalite du contrat', '2021-05-12', 'noms des', '2021-05-11', 'EN COURS');
/*!40000 ALTER TABLE `contrat_agep` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. convention_entretien
DROP TABLE IF EXISTS `convention_entretien`;
CREATE TABLE IF NOT EXISTS `convention_entretien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deux_parti_concernee` varchar(100) DEFAULT NULL,
  `objet` varchar(100) DEFAULT NULL,
  `montant_travaux` double DEFAULT NULL,
  `nom_signataire` varchar(100) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_convention_entretien_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_convention_entretien_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.convention_entretien : ~1 rows (environ)
/*!40000 ALTER TABLE `convention_entretien` DISABLE KEYS */;
INSERT INTO `convention_entretien` (`id`, `deux_parti_concernee`, `objet`, `montant_travaux`, `nom_signataire`, `date_signature`, `id_sous_projet_localisation`) VALUES
	(1, 'les deux ', 'objet', 20, 'noms des signataires', '2021-04-30', 4);
/*!40000 ALTER TABLE `convention_entretien` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. convention_idb
DROP TABLE IF EXISTS `convention_idb`;
CREATE TABLE IF NOT EXISTS `convention_idb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deux_parti_concernee` varchar(100) DEFAULT NULL,
  `objet` varchar(100) DEFAULT NULL,
  `montant_financement` double DEFAULT NULL,
  `nom_signataire` varchar(100) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `litige_conclusion` varchar(100) DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_convention_idb_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_convention_idb_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.convention_idb : ~1 rows (environ)
/*!40000 ALTER TABLE `convention_idb` DISABLE KEYS */;
INSERT INTO `convention_idb` (`id`, `deux_parti_concernee`, `objet`, `montant_financement`, `nom_signataire`, `date_signature`, `litige_conclusion`, `id_sous_projet_localisation`) VALUES
	(3, 'les deux', 'objet', 200, 'noms des signataires', '2021-04-30', 'litige et sa', 4);
/*!40000 ALTER TABLE `convention_idb` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. convention_mod
DROP TABLE IF EXISTS `convention_mod`;
CREATE TABLE IF NOT EXISTS `convention_mod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deux_parti_concernee` varchar(100) DEFAULT NULL,
  `objet` varchar(100) DEFAULT NULL,
  `date_prevu_recep` date DEFAULT NULL,
  `montant_travaux` double DEFAULT NULL,
  `nom_signataire` varchar(100) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_convention_mod_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_convention_mod_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.convention_mod : ~1 rows (environ)
/*!40000 ALTER TABLE `convention_mod` DISABLE KEYS */;
INSERT INTO `convention_mod` (`id`, `deux_parti_concernee`, `objet`, `date_prevu_recep`, `montant_travaux`, `nom_signataire`, `date_signature`, `id_sous_projet_localisation`) VALUES
	(3, 'les deux parties', 'objet', '2021-04-30', 20, 'noms des signataires', '2021-04-30', 4);
/*!40000 ALTER TABLE `convention_mod` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.etat_paiement_agep : ~7 rows (environ)
/*!40000 ALTER TABLE `etat_paiement_agep` DISABLE KEYS */;
INSERT INTO `etat_paiement_agep` (`id`, `numero_ordre_paiement`, `activite_concerne`, `id_menage`, `id_contrat_agep`, `tranche`, `pourcentage`, `montant_percu`, `date_paiement`, `moyen_transfert`, `situation_paiement`, `id_ile`, `id_region`, `id_commune`, `id_village`, `id_communaute`) VALUES
	(3, '1', 'ARSE', 381, 4, 1, 10, 31500, '2021-05-01', 'moyen', 'situation', 4, 13, 38, 37, NULL),
	(4, '1', 'ACT', 38, 2, 1, 50, 37500, '2021-05-01', 'moyen', 'situation', 4, 13, 38, 40, NULL),
	(5, '1', 'TMNC-COVID-19', 395, 5, 1, 0, 105000, '2021-05-01', 'moyen', 'situation', 4, 13, 38, 40, NULL),
	(6, '1', 'IDB', 395, 6, 1, 10, 31500, '2021-05-01', 'moyen', 'situ', 1, 4, 8, NULL, 2),
	(8, '2', 'ARSE', 418, 4, 2, 70, 220500, '2021-05-02', 'moyen', 'situation', 4, 13, 38, 37, NULL),
	(9, '2', 'TMNC-COVID-19', 395, 5, 2, 0, 35000, '2021-05-05', 'moyen', 'situation', 4, 13, 38, 40, NULL),
	(10, '2', 'ACT', 30, 2, 2, 50, 37500, '2021-04-22', 'moyen', 'situation', 4, 13, 38, 40, NULL);
/*!40000 ALTER TABLE `etat_paiement_agep` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. etude_env
DROP TABLE IF EXISTS `etude_env`;
CREATE TABLE IF NOT EXISTS `etude_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `introduction` varchar(100) DEFAULT NULL,
  `description_sour_recep` varchar(100) DEFAULT NULL,
  `description_impacts` varchar(100) DEFAULT NULL,
  `mesure` varchar(100) DEFAULT NULL,
  `plan_gestion` varchar(100) DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_etude_env_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_etude_env_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.etude_env : ~1 rows (environ)
/*!40000 ALTER TABLE `etude_env` DISABLE KEYS */;
INSERT INTO `etude_env` (`id`, `introduction`, `description_sour_recep`, `description_impacts`, `mesure`, `plan_gestion`, `id_sous_projet_localisation`) VALUES
	(2, 'intro', 'description', 'decsription', 'mesure', 'plan', 4);
/*!40000 ALTER TABLE `etude_env` ENABLE KEYS */;

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
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fiche_env_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_fiche_env_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.fiche_env : ~0 rows (environ)
/*!40000 ALTER TABLE `fiche_env` DISABLE KEYS */;
INSERT INTO `fiche_env` (`id`, `intitule_sousprojet`, `bureau_etude`, `ref_contrat`, `composante_sousprojet`, `composante_zone_susce`, `probleme_env`, `mesure_envisage`, `justification_classe_env`, `observation`, `date_visa_rt`, `date_visa_ugp`, `date_visa_be`, `id_sous_projet_localisation`) VALUES
	(1, NULL, 'bureau', 'ref', 'composante sous projet', 'composante zone', 'probleme', 'mesure', 'justificatif', 'observation', '2021-04-07', '2021-04-07', '2021-04-08', 4);
/*!40000 ALTER TABLE `fiche_env` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. filtration_env
DROP TABLE IF EXISTS `filtration_env`;
CREATE TABLE IF NOT EXISTS `filtration_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secretariat` varchar(100) DEFAULT NULL,
  `cout_estime_sous_projet` double DEFAULT NULL,
  `envergure_sous_projet` varchar(100) DEFAULT NULL,
  `ouvrage_prevu` varchar(100) DEFAULT NULL,
  `environnement_naturel` varchar(100) DEFAULT NULL,
  `date_visa_rt_ibd` date DEFAULT NULL,
  `date_visa_res` date DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_filtration_env_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_filtration_env_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.filtration_env : ~0 rows (environ)
/*!40000 ALTER TABLE `filtration_env` DISABLE KEYS */;
INSERT INTO `filtration_env` (`id`, `secretariat`, `cout_estime_sous_projet`, `envergure_sous_projet`, `ouvrage_prevu`, `environnement_naturel`, `date_visa_rt_ibd`, `date_visa_res`, `id_sous_projet_localisation`) VALUES
	(1, 'secretariat', 1000, 'envergure', 'ouvrage prevu', 'environnement', '0000-00-00', '2021-04-22', 1);
/*!40000 ALTER TABLE `filtration_env` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sauvegarde_env
DROP TABLE IF EXISTS `sauvegarde_env`;
CREATE TABLE IF NOT EXISTS `sauvegarde_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_evaluation_pre` varchar(100) DEFAULT NULL,
  `checklist_evaluation_pre` varchar(100) DEFAULT NULL,
  `resultats` varchar(100) DEFAULT NULL,
  `methodologie` varchar(100) DEFAULT NULL,
  `mesures_environnement` varchar(100) DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sauvegarde_env_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_sauvegarde_env_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sauvegarde_env : ~1 rows (environ)
/*!40000 ALTER TABLE `sauvegarde_env` DISABLE KEYS */;
INSERT INTO `sauvegarde_env` (`id`, `info_evaluation_pre`, `checklist_evaluation_pre`, `resultats`, `methodologie`, `mesures_environnement`, `id_sous_projet_localisation`) VALUES
	(3, 'evaluation', 'check list', 'resultat', 'methodologie', 'mesure', 4);
/*!40000 ALTER TABLE `sauvegarde_env` ENABLE KEYS */;

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
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_plan_action_reinstallation` (`id_par`),
  CONSTRAINT `FK_sous_projet_plan_action_reinstallation` FOREIGN KEY (`id_par`) REFERENCES `plan_action_reinstallation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.sous_projet : ~4 rows (environ)
/*!40000 ALTER TABLE `sous_projet` DISABLE KEYS */;
INSERT INTO `sous_projet` (`id`, `code`, `nature`, `type`, `description`, `objectif`, `duree`, `id_par`) VALUES
	(1, 'ACT', 'nature', 'ACT', 'Argent Contre Travail', 'objectif', 1, 1),
	(2, 'ARSE', 'nature', 'ARSE', 'Activités de Réinsertion Socio-Economique', 'objectif', 30, 1),
	(3, 'IDB', 'nature', 'IDB', 'Réhabilitation Infrastructure de Base', 'objectif', 30, 1),
	(4, 'COVID-19', 'nature', 'COVID-19', 'COVID-19', 'objectif', 30, 1);
/*!40000 ALTER TABLE `sous_projet` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet_depenses
DROP TABLE IF EXISTS `sous_projet_depenses`;
CREATE TABLE IF NOT EXISTS `sous_projet_depenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(10) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `pourcentage` float DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_depenses_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_sous_projet_depenses_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_depenses : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_depenses` DISABLE KEYS */;
INSERT INTO `sous_projet_depenses` (`id`, `designation`, `montant`, `pourcentage`, `id_sous_projet_localisation`) VALUES
	(1, 'designatio', 20, 10, 4);
/*!40000 ALTER TABLE `sous_projet_depenses` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet_indicateurs
DROP TABLE IF EXISTS `sous_projet_indicateurs`;
CREATE TABLE IF NOT EXISTS `sous_projet_indicateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personne` varchar(50) DEFAULT NULL,
  `nombre` int(11) DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_indicateurs_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_sous_projet_indicateurs_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_indicateurs : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_indicateurs` DISABLE KEYS */;
INSERT INTO `sous_projet_indicateurs` (`id`, `personne`, `nombre`, `id_sous_projet_localisation`) VALUES
	(1, 'personne beneficiaire', 200, 4);
/*!40000 ALTER TABLE `sous_projet_indicateurs` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_localisation : ~4 rows (environ)
/*!40000 ALTER TABLE `sous_projet_localisation` DISABLE KEYS */;
INSERT INTO `sous_projet_localisation` (`id`, `presentantion_communaute`, `ref_dgsc`, `nbr_menage_participant`, `nbr_menage_beneficiaire`, `nbr_menage_nonparticipant`, `population_total`, `id_sous_projet`, `id_ile`, `id_region`, `id_commune`, `id_village`, `id_communaute`) VALUES
	(1, 'presentation', 'ref_dgsc', 90, 100, 15, 10, 1, 4, 13, 38, 40, NULL),
	(2, '', 'refarse', 0, 22, 0, 0, 2, 1, 1, 4, 3, NULL),
	(4, 'presentationidb', 'ref', 0, 3, 0, 30, 3, 2, 2, 10, NULL, 3),
	(5, '', 'refcovid', 0, 44, 0, 0, 4, 4, 14, 42, 54, NULL);
/*!40000 ALTER TABLE `sous_projet_localisation` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet_main_oeuvre
DROP TABLE IF EXISTS `sous_projet_main_oeuvre`;
CREATE TABLE IF NOT EXISTS `sous_projet_main_oeuvre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activite` varchar(100) DEFAULT NULL,
  `main_oeuvre` int(11) DEFAULT NULL,
  `post_travail` varchar(100) DEFAULT NULL,
  `remuneration_jour` double DEFAULT NULL,
  `nbr_jour` float DEFAULT NULL,
  `remuneration_total` double DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_main_oeuvre_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_sous_projet_main_oeuvre_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_main_oeuvre : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_main_oeuvre` DISABLE KEYS */;
INSERT INTO `sous_projet_main_oeuvre` (`id`, `activite`, `main_oeuvre`, `post_travail`, `remuneration_jour`, `nbr_jour`, `remuneration_total`, `id_sous_projet_localisation`) VALUES
	(1, 'activite', 2, 'poste', 20, 2, 40, 4);
/*!40000 ALTER TABLE `sous_projet_main_oeuvre` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet_materiels
DROP TABLE IF EXISTS `sous_projet_materiels`;
CREATE TABLE IF NOT EXISTS `sous_projet_materiels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(10) DEFAULT NULL,
  `unite` varchar(100) DEFAULT NULL,
  `quantite` double DEFAULT NULL,
  `prix_unitaire` double DEFAULT NULL,
  `prix_total` double DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_materiels_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_sous_projet_materiels_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_materiels : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_materiels` DISABLE KEYS */;
INSERT INTO `sous_projet_materiels` (`id`, `designation`, `unite`, `quantite`, `prix_unitaire`, `prix_total`, `id_sous_projet_localisation`) VALUES
	(1, 'dsignatio', 'sdfsf', 2, 2, 4, 4);
/*!40000 ALTER TABLE `sous_projet_materiels` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet_planning
DROP TABLE IF EXISTS `sous_projet_planning`;
CREATE TABLE IF NOT EXISTS `sous_projet_planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `phase_activite` varchar(100) DEFAULT NULL,
  `numero_phase` int(11) DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_planning_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_sous_projet_planning_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_planning : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_planning` DISABLE KEYS */;
INSERT INTO `sous_projet_planning` (`id`, `code`, `phase_activite`, `numero_phase`, `id_sous_projet_localisation`) VALUES
	(1, 'code', 'phase activite', 2, 4);
/*!40000 ALTER TABLE `sous_projet_planning` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet_resultats
DROP TABLE IF EXISTS `sous_projet_resultats`;
CREATE TABLE IF NOT EXISTS `sous_projet_resultats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_resultats_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_sous_projet_resultats_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_resultats : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_resultats` DISABLE KEYS */;
INSERT INTO `sous_projet_resultats` (`id`, `description`, `quantite`, `id_sous_projet_localisation`) VALUES
	(1, 'description', 200, 4);
/*!40000 ALTER TABLE `sous_projet_resultats` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. sous_projet_travaux
DROP TABLE IF EXISTS `sous_projet_travaux`;
CREATE TABLE IF NOT EXISTS `sous_projet_travaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activites` varchar(10) DEFAULT NULL,
  `unite` varchar(100) DEFAULT NULL,
  `quantite` double DEFAULT NULL,
  `observation` varchar(100) DEFAULT NULL,
  `id_sous_projet_localisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_travaux_sous_projet_localisation` (`id_sous_projet_localisation`),
  CONSTRAINT `FK_sous_projet_travaux_sous_projet_localisation` FOREIGN KEY (`id_sous_projet_localisation`) REFERENCES `sous_projet_localisation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table pfss_db.sous_projet_travaux : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_travaux` DISABLE KEYS */;
INSERT INTO `sous_projet_travaux` (`id`, `activites`, `unite`, `quantite`, `observation`, `id_sous_projet_localisation`) VALUES
	(2, 'activite', 'unite', 2, 'observation', 4);
/*!40000 ALTER TABLE `sous_projet_travaux` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. tableau_recap_pac
DROP TABLE IF EXISTS `tableau_recap_pac`;
CREATE TABLE IF NOT EXISTS `tableau_recap_pac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `besoin` varchar(100) DEFAULT NULL,
  `cout` double DEFAULT NULL,
  `duree` double DEFAULT NULL,
  `id_pac` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__pac` (`id_pac`),
  CONSTRAINT `FK__pac` FOREIGN KEY (`id_pac`) REFERENCES `pac` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.tableau_recap_pac : ~3 rows (environ)
/*!40000 ALTER TABLE `tableau_recap_pac` DISABLE KEYS */;
INSERT INTO `tableau_recap_pac` (`id`, `besoin`, `cout`, `duree`, `id_pac`) VALUES
	(1, 'les besoins', 20, 2, 1),
	(2, 'les besois', 2, 2, 2),
	(3, 'les besoin2', 4, 4, 2);
/*!40000 ALTER TABLE `tableau_recap_pac` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
