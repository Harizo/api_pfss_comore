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

-- Listage de la structure de la table ogadc. activite_agr
DROP TABLE IF EXISTS `activite_agr`;
CREATE TABLE IF NOT EXISTS `activite_agr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type_agr` int(11) DEFAULT NULL,
  `id_tableau_recap_pac` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_activite_agr_tableau_recap_pac` (`id_tableau_recap_pac`),
  KEY `FK_activite_agr_type_agr` (`id_type_agr`),
  CONSTRAINT `FK_activite_agr_tableau_recap_pac` FOREIGN KEY (`id_tableau_recap_pac`) REFERENCES `tableau_recap_pac` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_activite_agr_type_agr` FOREIGN KEY (`id_type_agr`) REFERENCES `type_agr` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.activite_agr : ~0 rows (environ)
/*!40000 ALTER TABLE `activite_agr` DISABLE KEYS */;
INSERT INTO `activite_agr` (`id`, `id_type_agr`, `id_tableau_recap_pac`, `code`, `libelle`) VALUES
	(1, 1, 3, 'tyutyk', 'tyurtyu');
/*!40000 ALTER TABLE `activite_agr` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. activite_par
DROP TABLE IF EXISTS `activite_par`;
CREATE TABLE IF NOT EXISTS `activite_par` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_par` int(11) DEFAULT NULL,
  `activite` varchar(100) DEFAULT NULL,
  `nbr_menage` int(11) DEFAULT NULL,
  `bien_ressource` varchar(100) DEFAULT NULL,
  `mesure_compensatoire` varchar(100) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `calendrier_execution` varchar(100) DEFAULT NULL,
  `cout_estimatif` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_activite_par_plan_action_reinstallation` (`id_par`),
  CONSTRAINT `FK_activite_par_plan_action_reinstallation` FOREIGN KEY (`id_par`) REFERENCES `plan_action_reinstallation` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.activite_par : ~1 rows (environ)
/*!40000 ALTER TABLE `activite_par` DISABLE KEYS */;
INSERT INTO `activite_par` (`id`, `id_par`, `activite`, `nbr_menage`, `bien_ressource`, `mesure_compensatoire`, `responsable`, `calendrier_execution`, `cout_estimatif`) VALUES
	(2, 1, 'act', 20, 'bien', 'mesure', 'respo', 'cal', 20000);
/*!40000 ALTER TABLE `activite_par` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. aspects_env
DROP TABLE IF EXISTS `aspects_env`;
CREATE TABLE IF NOT EXISTS `aspects_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emplace_site` varchar(100) DEFAULT NULL,
  `etat_initial_recepteur` varchar(100) DEFAULT NULL,
  `classification_sous_projet` varchar(100) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_aspects_env_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_aspects_env_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.aspects_env : ~0 rows (environ)
/*!40000 ALTER TABLE `aspects_env` DISABLE KEYS */;
INSERT INTO `aspects_env` (`id`, `emplace_site`, `etat_initial_recepteur`, `classification_sous_projet`, `id_sous_projet`) VALUES
	(2, 'fghfghaaa', 'fghdfgh', 'fghdfh', 8);
/*!40000 ALTER TABLE `aspects_env` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. calendrier_activites
DROP TABLE IF EXISTS `calendrier_activites`;
CREATE TABLE IF NOT EXISTS `calendrier_activites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mois` int(11) DEFAULT NULL,
  `activite` varchar(100) DEFAULT NULL,
  `duree` float DEFAULT NULL,
  `id_pac` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_calendrier_activites_pac` (`id_pac`),
  CONSTRAINT `FK_calendrier_activites_pac` FOREIGN KEY (`id_pac`) REFERENCES `pac` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.calendrier_activites : ~0 rows (environ)
/*!40000 ALTER TABLE `calendrier_activites` DISABLE KEYS */;
INSERT INTO `calendrier_activites` (`id`, `mois`, `activite`, `duree`, `id_pac`) VALUES
	(1, 2, 'aaa', 12, 1);
/*!40000 ALTER TABLE `calendrier_activites` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. communaute
DROP TABLE IF EXISTS `communaute`;
CREATE TABLE IF NOT EXISTS `communaute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_zip` int(11) DEFAULT NULL,
  `id_commune` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `libelle` varchar(10) DEFAULT NULL,
  `nbr_personne` int(11) DEFAULT NULL,
  `representant` varchar(100) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `statut` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_communaute_zip` (`id_zip`),
  KEY `FK_communaute_see_commune` (`id_commune`),
  CONSTRAINT `FK_communaute_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_communaute_zip` FOREIGN KEY (`id_zip`) REFERENCES `zip` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.communaute : ~0 rows (environ)
/*!40000 ALTER TABLE `communaute` DISABLE KEYS */;
INSERT INTO `communaute` (`id`, `id_zip`, `id_commune`, `code`, `libelle`, `nbr_personne`, `representant`, `telephone`, `statut`) VALUES
	(1, NULL, 4, 'bvbn', 'vbnvcbn', 12, 'cvbvb', '1545', '1'),
	(2, 1, 4, 'code1', 'libelle1', 10, 'represen', '0234454', 'BENEFICIAIRE');
/*!40000 ALTER TABLE `communaute` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. composante_indicateur
DROP TABLE IF EXISTS `composante_indicateur`;
CREATE TABLE IF NOT EXISTS `composante_indicateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `id_type_indicateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_composante_indicateur_type_indicateur` (`id_type_indicateur`),
  CONSTRAINT `FK_composante_indicateur_type_indicateur` FOREIGN KEY (`id_type_indicateur`) REFERENCES `type_indicateur` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.composante_indicateur : ~0 rows (environ)
/*!40000 ALTER TABLE `composante_indicateur` DISABLE KEYS */;
/*!40000 ALTER TABLE `composante_indicateur` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. contrat_agep
DROP TABLE IF EXISTS `contrat_agep`;
CREATE TABLE IF NOT EXISTS `contrat_agep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agep` int(11) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  `numero_contrat` varchar(50) DEFAULT NULL,
  `objet_contrat` varchar(100) DEFAULT NULL,
  `montant_contrat` double DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.contrat_agep : ~1 rows (environ)
/*!40000 ALTER TABLE `contrat_agep` DISABLE KEYS */;
INSERT INTO `contrat_agep` (`id`, `id_agep`, `id_sous_projet`, `numero_contrat`, `objet_contrat`, `montant_contrat`, `modalite_contrat`, `date_prevu_fin`, `noms_signataires`, `date_signature`, `statu`) VALUES
	(2, 19, 1, '2020/12/456/RAD/FDZ', 'objet', 123456, 'modalite', '2021-04-03', 'noms', '2021-04-02', 'EN COURS');
/*!40000 ALTER TABLE `contrat_agep` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. convention_entretien
DROP TABLE IF EXISTS `convention_entretien`;
CREATE TABLE IF NOT EXISTS `convention_entretien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deux_parti_concernee` varchar(100) DEFAULT NULL,
  `objet` varchar(100) DEFAULT NULL,
  `montant_travaux` double DEFAULT NULL,
  `nom_signataire` varchar(100) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_convention_entretien_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_convention_entretien_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.convention_entretien : ~0 rows (environ)
/*!40000 ALTER TABLE `convention_entretien` DISABLE KEYS */;
INSERT INTO `convention_entretien` (`id`, `deux_parti_concernee`, `objet`, `montant_travaux`, `nom_signataire`, `date_signature`, `id_sous_projet`) VALUES
	(3, 'les deuc3', 'objet3', 200, 'nom33', '2021-03-16', 1);
/*!40000 ALTER TABLE `convention_entretien` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. convention_idb
DROP TABLE IF EXISTS `convention_idb`;
CREATE TABLE IF NOT EXISTS `convention_idb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deux_parti_concernee` varchar(100) DEFAULT NULL,
  `objet` varchar(100) DEFAULT NULL,
  `montant_financement` double DEFAULT NULL,
  `nom_signataire` varchar(100) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `litige_conclusion` varchar(100) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_convention_idb_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_convention_idb_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.convention_idb : ~0 rows (environ)
/*!40000 ALTER TABLE `convention_idb` DISABLE KEYS */;
INSERT INTO `convention_idb` (`id`, `deux_parti_concernee`, `objet`, `montant_financement`, `nom_signataire`, `date_signature`, `litige_conclusion`, `id_sous_projet`) VALUES
	(2, 'les deuc', 'objet', 100000, 'nomm', '2021-11-03', 'litige', 1);
/*!40000 ALTER TABLE `convention_idb` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. convention_mod
DROP TABLE IF EXISTS `convention_mod`;
CREATE TABLE IF NOT EXISTS `convention_mod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deux_parti_concernee` varchar(100) DEFAULT NULL,
  `objet` varchar(100) DEFAULT NULL,
  `date_prevu_recep` date DEFAULT NULL,
  `montant_travaux` double DEFAULT NULL,
  `nom_signataire` varchar(100) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_convention_mod_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_convention_mod_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.convention_mod : ~0 rows (environ)
/*!40000 ALTER TABLE `convention_mod` DISABLE KEYS */;
INSERT INTO `convention_mod` (`id`, `deux_parti_concernee`, `objet`, `date_prevu_recep`, `montant_travaux`, `nom_signataire`, `date_signature`, `id_sous_projet`) VALUES
	(2, 'les deuc2', 'objet2', '2021-03-16', 100, 'nom', '2021-03-09', 1);
/*!40000 ALTER TABLE `convention_mod` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. etude_env
DROP TABLE IF EXISTS `etude_env`;
CREATE TABLE IF NOT EXISTS `etude_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `introduction` varchar(100) DEFAULT NULL,
  `description_sour_recep` varchar(100) DEFAULT NULL,
  `description_impacts` varchar(100) DEFAULT NULL,
  `mesure` varchar(100) DEFAULT NULL,
  `plan_gestion` varchar(100) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_etude_env_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_etude_env_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.etude_env : ~0 rows (environ)
/*!40000 ALTER TABLE `etude_env` DISABLE KEYS */;
INSERT INTO `etude_env` (`id`, `introduction`, `description_sour_recep`, `description_impacts`, `mesure`, `plan_gestion`, `id_sous_projet`) VALUES
	(1, 'intro', 'descrip', 'descrip', 'mesure', 'plan', 1);
/*!40000 ALTER TABLE `etude_env` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. fiche_env
DROP TABLE IF EXISTS `fiche_env`;
CREATE TABLE IF NOT EXISTS `fiche_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule_sousprojet` varchar(100) DEFAULT NULL,
  `bureau_etude` varchar(100) DEFAULT NULL,
  `ref_contrat` varchar(100) DEFAULT NULL,
  `composante_sousprojet` varchar(100) DEFAULT NULL,
  `localisation_sousprojet` varchar(100) DEFAULT NULL,
  `localisation_geo` varchar(100) DEFAULT NULL,
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

-- Listage des données de la table ogadc.fiche_env : ~2 rows (environ)
/*!40000 ALTER TABLE `fiche_env` DISABLE KEYS */;
INSERT INTO `fiche_env` (`id`, `intitule_sousprojet`, `bureau_etude`, `ref_contrat`, `composante_sousprojet`, `localisation_sousprojet`, `localisation_geo`, `composante_zone_susce`, `probleme_env`, `mesure_envisage`, `justification_classe_env`, `observation`, `date_visa_rt`, `date_visa_ugp`, `date_visa_be`, `id_sous_projet`) VALUES
	(1, 'inti', 'burea', 'reffer', 'rcompo', 'local', 'loac geo', 'compo', 'problr', 'mesure', '456', 'ouu', '2021-03-03', '2021-03-03', '2021-03-04', 1),
	(4, 'inti2', 'burea2', 'reffer2', 'rcompo2', 'local2', 'loac geo2', 'compo2', 'problr2', 'mesure2', 'just2', 'ou2', '2021-03-05', '2021-03-10', '2021-03-10', 1),
	(5, NULL, 'cvbcbxcaaa', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', 'cvbcvb', '2021-09-03', '2021-10-03', '2021-11-03', 8);
/*!40000 ALTER TABLE `fiche_env` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. filtration_env
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
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_filtration_env_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_filtration_env_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.filtration_env : ~0 rows (environ)
/*!40000 ALTER TABLE `filtration_env` DISABLE KEYS */;
INSERT INTO `filtration_env` (`id`, `secretariat`, `cout_estime_sous_projet`, `envergure_sous_projet`, `ouvrage_prevu`, `environnement_naturel`, `date_visa_rt_ibd`, `date_visa_res`, `id_sous_projet`) VALUES
	(1, 'dfgsdfg', 123445, 'ghjgh', 'fghdfh', 'fghdgfh', '2021-03-10', '2021-03-19', 8);
/*!40000 ALTER TABLE `filtration_env` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. indicateur
DROP TABLE IF EXISTS `indicateur`;
CREATE TABLE IF NOT EXISTS `indicateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `frequence` varchar(150) DEFAULT NULL,
  `utilisation` varchar(150) DEFAULT NULL,
  `unite` varchar(100) DEFAULT NULL,
  `id_composante_indicateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_indicateur_composante_indicateur` (`id_composante_indicateur`),
  CONSTRAINT `FK_indicateur_composante_indicateur` FOREIGN KEY (`id_composante_indicateur`) REFERENCES `composante_indicateur` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.indicateur : ~0 rows (environ)
/*!40000 ALTER TABLE `indicateur` DISABLE KEYS */;
/*!40000 ALTER TABLE `indicateur` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. pac
DROP TABLE IF EXISTS `pac`;
CREATE TABLE IF NOT EXISTS `pac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ile` int(11) DEFAULT '0',
  `id_region` int(11) DEFAULT '0',
  `id_commune` int(11) DEFAULT '0',
  `id_zip` int(11) DEFAULT '0',
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
  CONSTRAINT `FK_pac_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pac_see_ile` FOREIGN KEY (`id_ile`) REFERENCES `see_ile` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pac_see_region` FOREIGN KEY (`id_region`) REFERENCES `see_region` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pac_zip` FOREIGN KEY (`id_zip`) REFERENCES `zip` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.pac : ~2 rows (environ)
/*!40000 ALTER TABLE `pac` DISABLE KEYS */;
INSERT INTO `pac` (`id`, `id_ile`, `id_region`, `id_commune`, `id_zip`, `milieu_physique`, `condition_climatique`, `diffi_socio_eco`, `infra_pub_soc`, `analyse_pro`, `identi_prio_arse`, `marche_loc_reg_arse`, `description_activite`, `estimation_besoin`, `etude_eco`, `structure_appui`, `impact_env`, `impact_sociau`) VALUES
	(1, 4, 13, 39, 1, 'AEER', 'EREZR', 'ZERER', 'ZERER', 'ZEREZR', '565', '457', '45', 'FGHFG', 'FGHGF', 'FGHG', 'FGHDGF', 'FGHFGH'),
	(2, 1, 1, 6, 1, 'AEER', 'EREZR', 'ZERER', 'ZERER', 'ZEREZR', '565', '457', '45', 'FGHFG', 'FGHGF', 'FGHG', 'FGHDGF', 'FGHFGH');
/*!40000 ALTER TABLE `pac` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. plan_action_reinstallation
DROP TABLE IF EXISTS `plan_action_reinstallation`;
CREATE TABLE IF NOT EXISTS `plan_action_reinstallation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(150) DEFAULT NULL,
  `ser` varchar(150) DEFAULT NULL,
  `date_elaboration` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.plan_action_reinstallation : ~2 rows (environ)
/*!40000 ALTER TABLE `plan_action_reinstallation` DISABLE KEYS */;
INSERT INTO `plan_action_reinstallation` (`id`, `intitule`, `ser`, `date_elaboration`) VALUES
	(1, 'Intitulé plan', 'ser', '2021-03-17'),
	(2, 'intitule2', 'ser', '2021-03-11');
/*!40000 ALTER TABLE `plan_action_reinstallation` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. plan_gestion_env
DROP TABLE IF EXISTS `plan_gestion_env`;
CREATE TABLE IF NOT EXISTS `plan_gestion_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `impacts` varchar(100) DEFAULT NULL,
  `mesures` varchar(100) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `calendrier_execution` varchar(100) DEFAULT NULL,
  `cout_estimatif` double DEFAULT NULL,
  `id_fiche_env` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_plan_gestion_env_fiche_env` (`id_fiche_env`),
  CONSTRAINT `FK_plan_gestion_env_fiche_env` FOREIGN KEY (`id_fiche_env`) REFERENCES `fiche_env` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.plan_gestion_env : ~2 rows (environ)
/*!40000 ALTER TABLE `plan_gestion_env` DISABLE KEYS */;
INSERT INTO `plan_gestion_env` (`id`, `impacts`, `mesures`, `responsable`, `calendrier_execution`, `cout_estimatif`, `id_fiche_env`) VALUES
	(1, 'impact', 'mesure', 'respo', 'calendri', 10000, 1),
	(2, 'impact2', 'mesure2', 'respo3', 'cqlendir2', 50000, 1);
/*!40000 ALTER TABLE `plan_gestion_env` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. problemes_env
DROP TABLE IF EXISTS `problemes_env`;
CREATE TABLE IF NOT EXISTS `problemes_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(10) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `id_aspects_env` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_probleme_env_aspects_env` (`id_aspects_env`),
  CONSTRAINT `FK_probleme_env_aspects_env` FOREIGN KEY (`id_aspects_env`) REFERENCES `aspects_env` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.problemes_env : ~0 rows (environ)
/*!40000 ALTER TABLE `problemes_env` DISABLE KEYS */;
/*!40000 ALTER TABLE `problemes_env` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sauvegarde_env
DROP TABLE IF EXISTS `sauvegarde_env`;
CREATE TABLE IF NOT EXISTS `sauvegarde_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_evaluation_pre` varchar(100) DEFAULT NULL,
  `checklist_evaluation_pre` varchar(100) DEFAULT NULL,
  `resultats` varchar(100) DEFAULT NULL,
  `methodologie` varchar(100) DEFAULT NULL,
  `mesures_environnement` varchar(100) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sauvegarde_env_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_sauvegarde_env_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sauvegarde_env : ~0 rows (environ)
/*!40000 ALTER TABLE `sauvegarde_env` DISABLE KEYS */;
/*!40000 ALTER TABLE `sauvegarde_env` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. see_agent
DROP TABLE IF EXISTS `see_agent`;
CREATE TABLE IF NOT EXISTS `see_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `raison_social` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nom_contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `titre_contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `numero_phone_contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `adresse` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.see_agent : ~0 rows (environ)
/*!40000 ALTER TABLE `see_agent` DISABLE KEYS */;
INSERT INTO `see_agent` (`id`, `identifiant`, `raison_social`, `nom_contact`, `titre_contact`, `numero_phone_contact`, `adresse`) VALUES
	(19, 'identi', 'raison', 'nom', 'titre', '0344564564', 'adresse');
/*!40000 ALTER TABLE `see_agent` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. see_village
DROP TABLE IF EXISTS `see_village`;
CREATE TABLE IF NOT EXISTS `see_village` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commune_id` int(11) DEFAULT NULL,
  `Code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Village` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `programme_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `nbrpopulation` int(11) DEFAULT NULL,
  `a_ete_modifie` tinyint(4) DEFAULT '0',
  `supprime` tinyint(4) DEFAULT '0',
  `userid` int(11) DEFAULT NULL,
  `datemodification` datetime DEFAULT NULL,
  `id_zip` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_727BCF7F131A4F72` (`commune_id`),
  KEY `IDX_727BCF7F62BB7AEE` (`programme_id`),
  KEY `IDX_727BCF7F9F2C3FAB` (`zone_id`),
  KEY `FK_see_village_zip` (`id_zip`),
  CONSTRAINT `FK_see_village_zip` FOREIGN KEY (`id_zip`) REFERENCES `zip` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=320 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table ogadc.see_village : ~318 rows (environ)
/*!40000 ALTER TABLE `see_village` DISABLE KEYS */;
INSERT INTO `see_village` (`id`, `commune_id`, `Code`, `Village`, `programme_id`, `zone_id`, `nbrpopulation`, `a_ete_modifie`, `supprime`, `userid`, `datemodification`, `id_zip`) VALUES
	(1, 6, 'VIL01010101', 'Fomboni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(2, 4, 'VIL01010201', 'Boingoma', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(3, 4, 'VIL01010202', 'Bandaressalame', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(4, 4, 'VIL01010203', 'Djoezi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(5, 6, 'VIL01010301', 'M\'Batsé', 1, 1, NULL, 0, 0, NULL, NULL, NULL),
	(6, 6, 'VIL01010302', 'Hoani', 1, 1, NULL, 0, 0, NULL, NULL, NULL),
	(7, 6, 'VIL01010303', 'Domoni', 1, 1, NULL, 0, 0, NULL, NULL, NULL),
	(8, 7, 'VIL01020101', 'Hamba', 1, 16, NULL, 0, 0, NULL, NULL, NULL),
	(9, 7, 'VIL01020102', 'Barakani', 1, 16, NULL, 0, 0, NULL, NULL, NULL),
	(10, 7, 'VIL01020103', 'Miringoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(11, 7, 'VIL01020105', 'Ouallah 2', 1, 14, NULL, 0, 0, NULL, NULL, NULL),
	(12, 7, 'VIL01020104', 'Ouallah 1', 1, 14, NULL, 0, 0, NULL, NULL, NULL),
	(13, 8, 'VIL01020201', 'Mirémani', 1, 14, NULL, 0, 0, NULL, NULL, NULL),
	(14, 8, 'VIL01020202', 'Nioumachoi', 1, 14, NULL, 0, 0, NULL, NULL, NULL),
	(15, 8, 'VIL01020203', 'N\'drondroni', 1, 14, NULL, 0, 0, NULL, NULL, NULL),
	(16, 8, 'VIL01020204', 'N\'Dréméyani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(17, 9, 'VIL01030101', 'Siri Ziroudani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(18, 9, 'VIL01030102', 'Wanani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(19, 9, 'VIL01030103', 'M\'Lambada', 1, 15, NULL, 0, 0, NULL, NULL, NULL),
	(20, 9, 'VIL01030104', 'N\'Kangani', 1, 15, NULL, 0, 0, NULL, NULL, NULL),
	(21, 9, 'VIL01030105', 'Hagnamoida', 1, 15, NULL, 0, 0, NULL, NULL, NULL),
	(22, 9, 'VIL01030106', 'Itsamia', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(23, 9, 'VIL01030107', 'Hamavouna', 1, 15, NULL, 0, 0, NULL, NULL, NULL),
	(24, 10, 'VIL02010101', 'Moroni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(25, 11, 'VIL02010201', 'Mkazi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(26, 11, 'VIL02010202', 'Mvouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(27, 11, 'VIL02010203', 'Mavingouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(28, 12, 'VIL02010301', 'Vouvouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(29, 12, 'VIL02010302', 'M\'Dé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(30, 12, 'VIL02010303', 'Selea', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(31, 12, 'VIL02010304', 'Nioumadzaha', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(32, 12, 'VIL02010305', 'Moindzaza Djoumbé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(33, 12, 'VIL02010306', 'Mboudadjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(34, 12, 'VIL02010307', 'Daoeni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(35, 12, 'VIL02010308', 'Dzahani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(36, 12, 'VIL02010309', 'Boueni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(37, 38, 'VIL03010101', 'Mutsamudu', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(38, 38, 'VIL03010102', 'Pagé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(39, 38, 'VIL03010103', 'Mwamwa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(40, 38, 'VIL03010104', 'Chiconi 1', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(41, 39, 'VIL03010201', 'Mirontsy', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(42, 40, 'VIL03010301', 'M\'jimandra', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(43, 40, 'VIL03010302', 'Ankibani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(44, 40, 'VIL03010303', 'Chirocamba', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(45, 40, 'VIL03010304', 'Maweni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(46, 40, 'VIL03010305', 'Chikoni 2', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(47, 40, 'VIL03010306', 'Mpouzini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(48, 40, 'VIL03010307', 'Bandra Oupepo', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(49, 41, 'VIL03010401', 'Bandrani ya Mtsangani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(50, 41, 'VIL03010403', 'Saandani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(51, 41, 'VIL03010402', 'Chitrouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(52, 41, 'VIL03010404', 'Mjamaoué', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(53, 42, 'VIL03020101', 'Ouani ville', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(54, 42, 'VIL03020102', 'Barakani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(55, 42, 'VIL03020103', 'Nyatranga', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(56, 42, 'VIL03020104', 'Tanambao', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(57, 43, 'VIL03020201', 'Bazimini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(58, 43, 'VIL03020202', 'Nkoki', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(59, 43, 'VIL03020203', 'Patsy', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(60, 44, 'VIL03020301', 'Tsembéhou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(61, 44, 'VIL03020302', 'Dindri', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(62, 44, 'VIL03020303', 'Chandra', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(63, 45, 'VIL03030101', 'Domoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(64, 45, 'VIL03030102', 'Limbi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(65, 45, 'VIL03030103', 'Bweladungu', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(66, 46, 'VIL03030201', 'Ngandzalé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(67, 46, 'VIl03030202', 'Outsa', 1, 1, NULL, 0, 0, NULL, NULL, NULL),
	(68, 46, 'VIL03030203', 'Salamani', 1, 1, NULL, 0, 0, NULL, NULL, NULL),
	(69, 46, 'VIL03030204', 'Ouzini', 1, 1, NULL, 0, 0, NULL, NULL, NULL),
	(70, 47, 'VIL03030301', 'Koni Djodjo', 1, 4, NULL, 0, 0, NULL, NULL, NULL),
	(71, 47, 'VIL03030302', 'Koni Ngani', 1, 4, NULL, 0, 0, NULL, NULL, NULL),
	(72, 47, 'VIL03030303', 'Hacipenda', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(73, 47, 'VIL03030304', 'Gégé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(74, 48, 'VIL03030401', 'Bamabao Mtsanga', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(75, 48, 'VIL03030402', 'Mromagi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(76, 48, 'VIL03030403', 'Ongoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(77, 48, 'VIL03030404', 'Mahalé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(78, 49, 'VIL03030501', 'Harembo I', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(79, 49, 'VIL03030502', 'Harembo II', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(80, 49, 'VIL03030503', 'Hajoho', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(81, 49, 'VIL03030504', 'Jimlimé', 1, 2, NULL, 0, 0, NULL, NULL, NULL),
	(82, 50, 'VIL03040101', 'Adda Daweni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(83, 50, 'VIL03040102', 'Jandza', 1, 1, NULL, 0, 0, NULL, NULL, NULL),
	(84, 50, 'VIL03040103', 'Mannyassini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(85, 50, 'VIL03040104', 'Kangani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(86, 51, 'VIL03040201', 'Mrémani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(87, 51, 'VIL03040202', 'Badracouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(88, 51, 'VIL03040203', 'M\'Rijou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(89, 51, 'VIL03040204', 'Daji', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(90, 52, 'VIL03040301', 'Ongonjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(91, 52, 'VIL03040302', 'Kiyo', 1, 6, NULL, 0, 0, NULL, NULL, NULL),
	(92, 52, 'VIL03040303', 'Komoni', 1, 6, NULL, 0, 0, NULL, NULL, NULL),
	(93, 52, 'VIL03040304', 'Mirondroni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(94, 52, 'VIL03040305', 'Trindrini', 1, 6, NULL, 0, 0, NULL, NULL, NULL),
	(95, 53, 'VIL03040401', 'Shaweni', 1, 5, NULL, 0, 0, NULL, NULL, NULL),
	(96, 53, 'VIL03040402', 'Hamchaco', 1, 5, NULL, 0, 0, NULL, NULL, NULL),
	(97, 53, 'VIL03040403', 'Sadapoini', 1, 5, NULL, 0, 0, NULL, NULL, NULL),
	(98, 53, 'VIL03040404', 'Nounga', 1, 5, NULL, 0, 0, NULL, NULL, NULL),
	(99, 53, 'VIL03040405', 'Mnadzichumwe', 1, 5, NULL, 0, 0, NULL, NULL, NULL),
	(100, 54, 'VIL03040501', 'Mramani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(101, 54, 'VIL03040502', 'Hantsahi', 1, 5, NULL, 0, 0, NULL, NULL, NULL),
	(102, 54, 'VIL03040503', 'Nyamboimro', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(103, 54, 'VIL03040504', 'Dziani', 1, 6, NULL, 0, 0, NULL, NULL, NULL),
	(104, 55, 'VIL03050101', 'Sima Ville', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(105, 55, 'VIL03050102', 'Kavani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(106, 55, 'VIL03050103', 'Bimbini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(107, 55, 'VIL03050104', 'Boungouéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(108, 55, 'VIL03050105', 'Mirongani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(109, 55, 'VIL03050106', 'Milembéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(110, 56, 'VIL03050201', 'Mromhouli', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(111, 56, 'VIL03050202', 'Mahararé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(112, 56, 'VIL03050203', 'Hasimpao', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(113, 56, 'VIL03050204', 'Shitsangasheli', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(114, 56, 'VIL03050205', 'Vassi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(115, 56, 'VIL03050206', 'Iméré', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(116, 56, 'VIL03050207', 'Dzindri', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(117, 56, 'VIL03050208', 'Vouani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(118, 56, 'VIL03050209', 'Darsalam', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(119, 56, 'VIL03050210', 'Bandrani ya vouani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(120, 56, 'VIL03050211', 'Chirové', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(121, 56, 'VIL03050212', 'Marontroni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(122, 56, 'VIL03050213', 'Salamani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(123, 56, 'VIL03050214', 'Imere ya Gawani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(124, 57, 'VIL03050301', 'Moya', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(125, 57, 'VIL03050302', 'Kowet', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(126, 57, 'VIL03050303', 'Pomoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(127, 57, 'VIL03050304', 'Nindri', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(128, 57, 'VIL03050305', 'Lingoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(129, 57, 'VIL03050306', 'Maweni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(130, 13, 'VIL02010401', 'Iconi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(131, 13, 'VIL02010402', 'Mbachilé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(132, 13, 'VIL02010403', 'Moindzaza Mboini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(133, 13, 'VIL02010404', 'Ndrouani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(134, 13, 'VIL02010405', 'Séréhini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(135, 14, 'VIL02020101', 'Mitsoudjé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(136, 14, 'VIL02020102', 'Troumbéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(137, 14, 'VIL02020103', 'Chouani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(138, 14, 'VIL02020104', 'Djoumoichongo', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(139, 14, 'VIL02020105', 'Bangoui', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(140, 14, 'VIL02020106', 'Nkomioni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(141, 14, 'VIL02020107', 'Salimani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(142, 15, 'VIL02020201', 'Singani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(143, 15, 'VIL02020202', 'Mdjoiezi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(144, 15, 'VIL02020203', 'Hetsa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(145, 15, 'VIL02020204', 'Bambani', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(146, 15, 'VIL02020205', 'Dzahadjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(147, 16, 'VIL02030101', 'Dembeni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(148, 16, 'VIL02030102', 'Mdjankagnoi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(149, 16, 'VIL02030103', 'Mboundé Ya Mboini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(150, 16, 'VIL02030104', 'Mlimani', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(151, 16, 'VIL02030105', 'Panda', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(152, 16, 'VIL02030106', 'Mindradou', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(153, 16, 'VIL02030107', 'Mandzissani', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(154, 16, 'VIL02030108', 'Tsinimoichongo', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(155, 16, 'VIL02030109', 'Kandzilé', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(156, 16, 'VIL02030110', 'Makorani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(157, 16, 'VIL02030111', 'Itsoundzou', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(158, 17, 'VIL02030201', 'Ouizioini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(159, 17, 'VIL020302', 'Ifoundihé Chadjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(160, 17, 'VIL02030203', 'Ifoundihé Chamboini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(161, 17, 'VIL02030204', 'Dima', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(162, 17, 'VIL02030205', 'Nkourani ia Sima', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(163, 17, 'VIL02030206', 'Domoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(164, 17, 'VIL02030207', 'Dzoidjou', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(165, 17, 'VIL02030208', 'Famaré', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(166, 18, 'VIL02040101', 'Foumbouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(167, 18, 'VIL02040102', 'Koimbani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(168, 18, 'VIL02040103', 'Malé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(169, 18, 'VIL02040104', 'Midjendjeni', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(170, 18, 'VIL02040105', 'Ourovéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(171, 18, 'VIL02040106', 'Ndzouani', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(172, 18, 'VIL02040107', 'Chindini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(173, 18, 'VIL02040108', 'Simamboini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(174, 18, 'VIL02040109', 'Dzahadjou', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(175, 18, 'VIL02040110', 'Mohoro', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(176, 18, 'VIL02040111', 'Nyoumadzaha-Mvoumbari', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(177, 19, 'VIL02040201', 'Bandamadji', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(178, 19, 'VIL02040202', 'Bandandaoueni', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(179, 19, 'VIL02040203', 'Tsinimoipanga', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(180, 19, 'VIL02040204', 'Oungoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(181, 19, 'VIL02040205', 'Pidjani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(182, 20, 'VIL02040301', 'Simboussa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(183, 20, 'VIL02040302', 'Inané', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(184, 20, 'VIL02040303', 'Ngambeni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(185, 20, 'VIL02040304', 'Bandamadji Lakouboini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(186, 20, 'VIL02040305', 'Dar Salama', 1, 9, NULL, 0, 0, NULL, NULL, NULL),
	(187, 20, 'VIL02040306', 'Mlali', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(188, 20, 'VIL02040307', 'Ngnouma Milima', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(189, 20, 'VIL02040308', 'Nkourani Mkanga', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(190, 20, 'VIL02040309', 'Didjoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(191, 20, 'VIL02040310', 'Kové', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(192, 21, 'VIL02050101', 'Koimbani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(193, 21, 'VIL02050102', 'Irohé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(194, 21, 'VIL02050103', 'Boeuni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(195, 21, 'VIL02050104', 'Dzahadjou', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(196, 21, 'VIL02050105', 'Sada', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(197, 21, 'VIL02050106', 'Sadani', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(198, 21, 'VIL02050107', 'Chomoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(199, 21, 'VIL02050108', 'Samba Madi', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(200, 21, 'VIL02050109', 'Chamro', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(201, 21, 'VIL02050110', 'Sima', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(202, 22, 'VIL02050201', 'Itsikouid', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(203, 22, 'VIL02050202', 'Dzahani', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(204, 22, 'VIL02050203', 'Kouhani', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(205, 22, 'VIL02050204', 'Mtsamdou', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(206, 22, 'VIL02050205', 'Hambou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(207, 22, 'VIL02050206', 'Hasendje', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(208, 23, 'VIL02050301', 'Mtsangadjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(209, 23, 'VIL02050302', 'Foumboudzivouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(210, 23, 'VIL02050303', 'Mboudé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(211, 23, 'VIL02050304', 'Midjindzé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(212, 23, 'VIL02050305', 'Madjoma', 1, 12, NULL, 0, 0, NULL, NULL, NULL),
	(213, 23, 'VIL02050306', 'Idjoindradja', 1, 12, NULL, 0, 0, NULL, NULL, NULL),
	(214, 23, 'VIL02050307', 'Idjinkoundzi', 1, 12, NULL, 0, 0, NULL, NULL, NULL),
	(215, 23, 'VIL02050308', 'Maoueni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(216, 23, 'VIL02050309', 'Mirereni', 1, 12, NULL, 0, 0, NULL, NULL, NULL),
	(218, 23, 'VIL02050311', 'Sidjou', 1, 10, NULL, 0, 0, NULL, NULL, NULL),
	(219, 23, 'VIL02050312', 'Rehemani', 1, 12, NULL, 0, 0, NULL, NULL, NULL),
	(220, 24, 'VIL02060101', 'Mbéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(221, 24, 'VIL02060102', 'Séléani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(222, 24, 'VIL02060103', 'Salimani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(223, 24, 'VIL02060104', 'Sada Shihouwé', 1, 13, NULL, 0, 0, NULL, NULL, NULL),
	(224, 24, 'VIL02060105', 'Sada Mhuwamboi', 1, 13, NULL, 0, 0, NULL, NULL, NULL),
	(225, 24, 'VIL02060106', 'Bouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(226, 24, 'VIL02060107', 'Heroumbili', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(227, 24, 'VIL02060108', 'Batou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(228, 24, 'VIL02060109', 'Nkourani', 1, 13, NULL, 0, 0, NULL, NULL, NULL),
	(229, 24, 'VIL02060110', 'Ifoundihé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(230, 24, 'VIL02060111', 'Mnoungou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(231, 25, 'VIL02060201', 'Dimadjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(232, 25, 'VIL02060202', 'Nyadombwéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(233, 25, 'VIL02060203', 'Mdjihari', 1, 13, NULL, 0, 0, NULL, NULL, NULL),
	(234, 25, 'VIL02060204', 'Moidja', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(235, 25, 'VIL02060205', 'Banbadjani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(236, 25, 'VIL02060206', 'Ngolé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(237, 25, 'VIL02060207', 'Itandzéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(238, 25, 'VIL02060208', 'Ouellah', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(239, 25, 'VIL02060209', 'Hadjambou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(240, 26, 'VIL02060301', 'Madjeouéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(241, 26, 'VIL02060302', 'Sadani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(242, 26, 'VIL02060303', 'Trélézini', 1, 13, NULL, 0, 0, NULL, NULL, NULL),
	(243, 26, 'VIL02060304', 'Chézani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(244, 26, 'VIL02060305', 'Ndroudé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(245, 26, 'VIL02060306', 'Nyumamilima', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(246, 26, 'VIL02060307', 'Hatsindzi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(247, 26, 'VIL02060308', 'Bandamadji', 1, 13, NULL, 0, 0, NULL, NULL, NULL),
	(248, 27, 'VIL02070101', 'Bangoi Kouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(249, 27, 'VIL02070102', 'Batsa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(250, 27, 'VIL02070103', 'Ouzio', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(251, 27, 'VIL02070104', 'Ivoini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(252, 28, 'VIL02070201', 'Ouemani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(253, 28, 'VIL02070202', 'Koua', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(254, 28, 'VIL02070203', 'Ouellah', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(255, 29, 'VIL02070301', 'Mémboimboini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(256, 29, 'VIL02070302', 'Hadawa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(257, 29, 'VIL02070303', 'Fassi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(258, 29, 'VIL02070304', 'Mitsamiouli', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(259, 29, 'VIL02070305', 'Nkourani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(260, 29, 'VIL02070306', 'Ndzaouzé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(261, 30, 'VIL02070401', 'Bangoi Mafsankowa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(262, 30, 'VIL02070402', 'Mémboidjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(263, 30, 'VIL02070403', 'Pidjani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(264, 30, 'VIL02070404', 'Songomani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(265, 30, 'VIL02070405', 'Toyifa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(266, 30, 'VIL02070406', 'Ntsadjéni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(267, 30, 'VIL02070407', 'Founga', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(268, 30, 'VIL02070408', 'Ouhozi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(269, 31, 'VIL02070501', 'Djomani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(270, 31, 'VIL02070502', 'Chamlé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(271, 31, 'VIL02070503', 'Vouvouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(272, 31, 'VIL02070504', 'Mandza', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(273, 31, 'VIL02070505', 'Mdjoiézi', 1, 8, NULL, 0, 0, NULL, NULL, NULL),
	(274, 31, 'VIL02070506', 'Helendjé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(275, 31, 'VIL02070507', 'Douniani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(276, 31, 'VIL02070508', 'Koua', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(277, 32, 'VIL02070601', 'Ntsaoueni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(278, 32, 'VIL02070602', 'Ivembeni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(279, 32, 'VIL02070603', 'Djongoé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(280, 32, 'VIL02070604', 'Maoueni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(281, 32, 'VIL02070605', 'Simboussa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(282, 32, 'VIL02070606', 'Ntsoralé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(283, 32, 'VIL02070607', 'Domoidjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(284, 32, 'VIL02070608', 'Domoimboini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(285, 32, 'VIL02070609', 'Moidja', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(286, 33, 'VIL02080101', 'Hahaya', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(287, 33, 'VIL02080102', 'Bouenindi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(288, 33, 'VIL02080103', 'Mbambani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(289, 33, 'VIL02080104', 'Mbaleni', 1, 8, NULL, 0, 0, NULL, NULL, NULL),
	(290, 33, 'VIL02080105', 'Oussivo', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(291, 33, 'VIL02080109', 'Milevani', 1, 8, NULL, 0, 0, NULL, NULL, NULL),
	(292, 33, 'VIL02080108', 'Bibavou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(293, 33, 'VIL02080107', 'Diboini', 1, 8, NULL, 0, 0, NULL, NULL, NULL),
	(294, 33, 'VIL02080106', 'Mbangani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(295, 34, 'VIL02080201', 'Batsa', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(296, 34, 'VIL02080202', 'Vanamboini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(297, 34, 'VIL02080203', 'Vanadjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(298, 34, 'VIL02080204', 'Mhandani', 1, 8, NULL, 0, 0, NULL, NULL, NULL),
	(299, 34, 'VIL02080205', 'Dzahadjou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(300, 34, 'VIL02080206', 'Vounambadani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(301, 35, 'VIL02080301', 'Itsandra Mdjini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(302, 35, 'VIL02080302', 'Salimani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(303, 35, 'VIL02080303', 'Samba Mbodoni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(304, 35, 'VIL02080304', 'Dzahani la Tsidjé', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(305, 35, 'VIL02080305', 'Maoueni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(306, 35, 'VIL02080306', 'Mirontsi', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(307, 35, 'VIL02080307', 'Bandamadji', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(308, 35, 'VIL02080308', 'Dimadjou', 1, 8, NULL, 0, 0, NULL, NULL, NULL),
	(309, 36, 'VIL02080401', 'Dzahani II', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(310, 36, 'VIL02080402', 'Bahani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(311, 36, 'VIL02080405', 'Samba Nkouni', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(312, 36, 'VIL02080404', 'Ouellah', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(313, 36, 'VIL02080403', 'Sima', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(314, 37, 'VIL02080501', 'Ntsoudjini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(315, 37, 'VIL02080502', 'Hantsambou', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(316, 37, 'VIL02080503', 'Milembini', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(317, 37, 'VIL02080504', 'Zivandani', 1, NULL, NULL, 0, 0, NULL, NULL, NULL),
	(318, 25, 'VIL02060210', 'Mbatsé', 1, 13, NULL, 0, 0, NULL, NULL, NULL),
	(319, 50, 'VIL0340105', 'Bandralajandza', 1, 1, NULL, 0, 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `see_village` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet
DROP TABLE IF EXISTS `sous_projet`;
CREATE TABLE IF NOT EXISTS `sous_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `intitule` varchar(100) DEFAULT NULL,
  `nature` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `description_activite` varchar(100) DEFAULT NULL,
  `presentantion_communaute` varchar(100) DEFAULT NULL,
  `ref_dgsc` varchar(100) DEFAULT NULL,
  `nbr_menage_participant` int(11) DEFAULT NULL,
  `nbr_menage_nonparticipant` int(11) DEFAULT NULL,
  `population_total` int(11) DEFAULT NULL,
  `objectif` varchar(100) DEFAULT NULL,
  `duree` float DEFAULT NULL,
  `id_par` int(11) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `id_communaute` int(11) DEFAULT NULL,
  `id_commune` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_plan_action_reinstallation` (`id_par`),
  KEY `FK_sous_projet_see_village` (`id_village`),
  KEY `FK_sous_projet_communaute` (`id_communaute`),
  KEY `FK_sous_projet_see_commune` (`id_commune`),
  CONSTRAINT `FK_sous_projet_communaute` FOREIGN KEY (`id_communaute`) REFERENCES `communaute` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sous_projet_plan_action_reinstallation` FOREIGN KEY (`id_par`) REFERENCES `plan_action_reinstallation` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sous_projet_see_commune` FOREIGN KEY (`id_commune`) REFERENCES `see_commune` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sous_projet_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.sous_projet : ~5 rows (environ)
/*!40000 ALTER TABLE `sous_projet` DISABLE KEYS */;
INSERT INTO `sous_projet` (`id`, `code`, `intitule`, `nature`, `type`, `description`, `description_activite`, `presentantion_communaute`, `ref_dgsc`, `nbr_menage_participant`, `nbr_menage_nonparticipant`, `population_total`, `objectif`, `duree`, `id_par`, `id_village`, `id_communaute`, `id_commune`) VALUES
	(1, 'ACT', NULL, NULL, NULL, 'Argent Contre Travail', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
	(2, 'ARSE', NULL, NULL, NULL, 'Activités de Réinsertion Socio-Economique', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'IDB', NULL, NULL, NULL, 'Réhabilitation Infrastructure de Base', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
	(4, 'COVID-19', NULL, NULL, NULL, 'COVID-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
	(8, 'gggdfgs', 'intitule', 'nature', 'IDB', 'dfgsdfg', 'dfgsdfg', 'dfgdf', 'dfgdf', 12, 12, 12, 'hjkghjk', 11, 1, NULL, 1, 4),
	(9, 'code', 'sdfdf', 'sdfsdf', 'ACT', 'aaaaaa', 'dfsdf', 'sdfsdf', 'sdfsdf', 12, 12, 12, 'hjh', 1, 2, 3, NULL, 4);
/*!40000 ALTER TABLE `sous_projet` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet_depenses
DROP TABLE IF EXISTS `sous_projet_depenses`;
CREATE TABLE IF NOT EXISTS `sous_projet_depenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(10) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `pourcentage` float DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_depenses_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_sous_projet_depenses_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sous_projet_depenses : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_depenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `sous_projet_depenses` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet_indicateurs
DROP TABLE IF EXISTS `sous_projet_indicateurs`;
CREATE TABLE IF NOT EXISTS `sous_projet_indicateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personne` varchar(50) DEFAULT NULL,
  `nombre` int(11) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_indicateurs_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_sous_projet_indicateurs_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sous_projet_indicateurs : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_indicateurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `sous_projet_indicateurs` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet_main_oeuvre
DROP TABLE IF EXISTS `sous_projet_main_oeuvre`;
CREATE TABLE IF NOT EXISTS `sous_projet_main_oeuvre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activite` varchar(100) DEFAULT NULL,
  `main_oeuvre` int(11) DEFAULT NULL,
  `post_travail` varchar(100) DEFAULT NULL,
  `remuneration_jour` double DEFAULT NULL,
  `nbr_jour` float DEFAULT NULL,
  `remuneration_total` double DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_main_oeuvre_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_sous_projet_main_oeuvre_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sous_projet_main_oeuvre : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_main_oeuvre` DISABLE KEYS */;
/*!40000 ALTER TABLE `sous_projet_main_oeuvre` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet_materiels
DROP TABLE IF EXISTS `sous_projet_materiels`;
CREATE TABLE IF NOT EXISTS `sous_projet_materiels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(10) DEFAULT NULL,
  `unite` varchar(100) DEFAULT NULL,
  `quantite` double DEFAULT NULL,
  `prix_unitaire` double DEFAULT NULL,
  `prix_total` double DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_materiels_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_sous_projet_materiels_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sous_projet_materiels : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_materiels` DISABLE KEYS */;
/*!40000 ALTER TABLE `sous_projet_materiels` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet_planning
DROP TABLE IF EXISTS `sous_projet_planning`;
CREATE TABLE IF NOT EXISTS `sous_projet_planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `phase_activite` varchar(100) DEFAULT NULL,
  `numero_phase` int(11) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_planning_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_sous_projet_planning_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sous_projet_planning : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_planning` DISABLE KEYS */;
INSERT INTO `sous_projet_planning` (`id`, `code`, `phase_activite`, `numero_phase`, `id_sous_projet`) VALUES
	(1, 'demarrage', 'demarrage', 1, 8);
/*!40000 ALTER TABLE `sous_projet_planning` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet_planning_activite
DROP TABLE IF EXISTS `sous_projet_planning_activite`;
CREATE TABLE IF NOT EXISTS `sous_projet_planning_activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semaine` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `id_planning` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_planning_activite_sous_projet_planning` (`id_planning`),
  CONSTRAINT `FK_sous_projet_planning_activite_sous_projet_planning` FOREIGN KEY (`id_planning`) REFERENCES `sous_projet_planning` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sous_projet_planning_activite : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_planning_activite` DISABLE KEYS */;
INSERT INTO `sous_projet_planning_activite` (`id`, `semaine`, `description`, `id_planning`) VALUES
	(1, 'semaine1', 'dsdeseaa', 1);
/*!40000 ALTER TABLE `sous_projet_planning_activite` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet_resultats
DROP TABLE IF EXISTS `sous_projet_resultats`;
CREATE TABLE IF NOT EXISTS `sous_projet_resultats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_resultats_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_sous_projet_resultats_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sous_projet_resultats : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_resultats` DISABLE KEYS */;
/*!40000 ALTER TABLE `sous_projet_resultats` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. sous_projet_travaux
DROP TABLE IF EXISTS `sous_projet_travaux`;
CREATE TABLE IF NOT EXISTS `sous_projet_travaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activites` varchar(10) DEFAULT NULL,
  `unite` varchar(100) DEFAULT NULL,
  `quantite` double DEFAULT NULL,
  `observation` varchar(100) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sous_projet_travaux_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_sous_projet_travaux_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.sous_projet_travaux : ~0 rows (environ)
/*!40000 ALTER TABLE `sous_projet_travaux` DISABLE KEYS */;
/*!40000 ALTER TABLE `sous_projet_travaux` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. tableau_impacts
DROP TABLE IF EXISTS `tableau_impacts`;
CREATE TABLE IF NOT EXISTS `tableau_impacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sources_sousprojets` varchar(100) DEFAULT NULL,
  `localisation` varchar(100) DEFAULT NULL,
  `nature_recepteur` varchar(100) DEFAULT NULL,
  `composante_recepteur` varchar(100) DEFAULT NULL,
  `impacts` varchar(100) DEFAULT NULL,
  `nature_impact` varchar(100) DEFAULT NULL,
  `degre_impact` varchar(100) DEFAULT NULL,
  `effet_impact` varchar(100) DEFAULT NULL,
  `id_etude_env` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__etude_env` (`id_etude_env`),
  CONSTRAINT `FK__etude_env` FOREIGN KEY (`id_etude_env`) REFERENCES `etude_env` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.tableau_impacts : ~0 rows (environ)
/*!40000 ALTER TABLE `tableau_impacts` DISABLE KEYS */;
INSERT INTO `tableau_impacts` (`id`, `sources_sousprojets`, `localisation`, `nature_recepteur`, `composante_recepteur`, `impacts`, `nature_impact`, `degre_impact`, `effet_impact`, `id_etude_env`) VALUES
	(1, 'soutce', 'loca', 'nature', 'recepte', 'impavt', 'natue', 'desgre', 'effettt', 1);
/*!40000 ALTER TABLE `tableau_impacts` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. tableau_mesure_pges
DROP TABLE IF EXISTS `tableau_mesure_pges`;
CREATE TABLE IF NOT EXISTS `tableau_mesure_pges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activites_sousprojets` varchar(100) DEFAULT NULL,
  `impacts` varchar(100) DEFAULT NULL,
  `mesure` varchar(100) DEFAULT NULL,
  `responsables` varchar(100) DEFAULT NULL,
  `estimation_cout` double DEFAULT NULL,
  `timing` varchar(100) DEFAULT NULL,
  `id_etude_env` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tableau_mesure_pges_etude_env` (`id_etude_env`),
  CONSTRAINT `FK_tableau_mesure_pges_etude_env` FOREIGN KEY (`id_etude_env`) REFERENCES `etude_env` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.tableau_mesure_pges : ~0 rows (environ)
/*!40000 ALTER TABLE `tableau_mesure_pges` DISABLE KEYS */;
INSERT INTO `tableau_mesure_pges` (`id`, `activites_sousprojets`, `impacts`, `mesure`, `responsables`, `estimation_cout`, `timing`, `id_etude_env`) VALUES
	(1, 'actuvi', 'impact', 'mesue', 'resp', 100000, 'timinh', 1);
/*!40000 ALTER TABLE `tableau_mesure_pges` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. type_indicateur
DROP TABLE IF EXISTS `type_indicateur`;
CREATE TABLE IF NOT EXISTS `type_indicateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.type_indicateur : ~0 rows (environ)
/*!40000 ALTER TABLE `type_indicateur` DISABLE KEYS */;
INSERT INTO `type_indicateur` (`id`, `code`, `libelle`) VALUES
	(1, 'code1', 'libelle1');
/*!40000 ALTER TABLE `type_indicateur` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. zip
DROP TABLE IF EXISTS `zip`;
CREATE TABLE IF NOT EXISTS `zip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Listage des données de la table ogadc.zip : ~0 rows (environ)
/*!40000 ALTER TABLE `zip` DISABLE KEYS */;
INSERT INTO `zip` (`id`, `code`, `libelle`) VALUES
	(1, 'zip1', 'zip1');
/*!40000 ALTER TABLE `zip` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
