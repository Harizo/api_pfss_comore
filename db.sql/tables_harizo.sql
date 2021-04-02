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

-- Listage de la structure de la table ogadc. contrat_ugp_agex
USE ogadc;
DROP TABLE IF EXISTS `contrat_ugp_agex`;
CREATE TABLE IF NOT EXISTS `contrat_ugp_agex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_contrat` varchar(50) NOT NULL DEFAULT '',
  `id_agex` int(11) DEFAULT NULL,
  `id_sous_projet` int(11) DEFAULT NULL,
  `objet_contrat` text,
  `montant_contrat` float DEFAULT '0',
  `date_signature` date DEFAULT NULL,
  `date_prevu_fin_contrat` date DEFAULT NULL,
  `status_contrat` varchar(50) DEFAULT '',
  `note_resiliation` text,
  `etat_validation` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_contrat_ugp_agex_see_agex` (`id_agex`),
  KEY `FK_contrat_ugp_agex_sous_projet` (`id_sous_projet`),
  CONSTRAINT `FK_contrat_ugp_agex_see_agex` FOREIGN KEY (`id_agex`) REFERENCES `see_agex` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_contrat_ugp_agex_sous_projet` FOREIGN KEY (`id_sous_projet`) REFERENCES `sous_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.contrat_ugp_agex : ~0 rows (environ)
/*!40000 ALTER TABLE `contrat_ugp_agex` DISABLE KEYS */;
INSERT INTO `contrat_ugp_agex` (`id`, `numero_contrat`, `id_agex`, `id_sous_projet`, `objet_contrat`, `montant_contrat`, `date_signature`, `date_prevu_fin_contrat`, `status_contrat`, `note_resiliation`, `etat_validation`) VALUES
	(5, '2020/12/456/RAD/FDZ', 17, 1, 'Le Client accepte de mettre à la disposition du Consultant la somme de……………………………….. (en lettres et en chiffres) pour financer le sous- projet suivant les clauses décrites ci-dessous. Ce montant inclut la rémunération forfaitaire duConsultant qui s’élève à ….. (en lettres et en chiffres)', 250000, '2021-03-18', '2021-05-03', 'En cours', '', 0);
/*!40000 ALTER TABLE `contrat_ugp_agex` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. contrat_ugp_agex_modalite_payement
DROP TABLE IF EXISTS `contrat_ugp_agex_modalite_payement`;
CREATE TABLE IF NOT EXISTS `contrat_ugp_agex_modalite_payement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrat_ugp_agex` int(11) NOT NULL,
  `poucentage` int(11) NOT NULL DEFAULT '0',
  `montant` float NOT NULL DEFAULT '0',
  `numero_tranche` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_contrat_ugp_agex_modalite_payement_contrat_ugp_agex` (`id_contrat_ugp_agex`),
  CONSTRAINT `FK_contrat_ugp_agex_modalite_payement_contrat_ugp_agex` FOREIGN KEY (`id_contrat_ugp_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.contrat_ugp_agex_modalite_payement : ~1 rows (environ)
/*!40000 ALTER TABLE `contrat_ugp_agex_modalite_payement` DISABLE KEYS */;
INSERT INTO `contrat_ugp_agex_modalite_payement` (`id`, `id_contrat_ugp_agex`, `poucentage`, `montant`, `numero_tranche`) VALUES
	(5, 5, 50, 125000, 1);
/*!40000 ALTER TABLE `contrat_ugp_agex_modalite_payement` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. contrat_ugp_agex_signataires
DROP TABLE IF EXISTS `contrat_ugp_agex_signataires`;
CREATE TABLE IF NOT EXISTS `contrat_ugp_agex_signataires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrat_ugp_agex` int(11) DEFAULT NULL,
  `nom_signataire` varchar(255) DEFAULT '',
  `titre_signatire` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK_contrat_ugp_agex_signataires_contrat_ugp_agex` (`id_contrat_ugp_agex`),
  CONSTRAINT `FK_contrat_ugp_agex_signataires_contrat_ugp_agex` FOREIGN KEY (`id_contrat_ugp_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.contrat_ugp_agex_signataires : ~0 rows (environ)
/*!40000 ALTER TABLE `contrat_ugp_agex_signataires` DISABLE KEYS */;
INSERT INTO `contrat_ugp_agex_signataires` (`id`, `id_contrat_ugp_agex`, `nom_signataire`, `titre_signatire`) VALUES
	(2, 5, 'RAJ', 'DEV');
/*!40000 ALTER TABLE `contrat_ugp_agex_signataires` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. depense_agex
DROP TABLE IF EXISTS `depense_agex`;
CREATE TABLE IF NOT EXISTS `depense_agex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrat_ugp_agex` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `objet_depense` text,
  `montant_categ_un` float DEFAULT '0',
  `montant_categ_deux` float DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_depense_agex_contrat_ugp_agex` (`id_contrat_ugp_agex`),
  CONSTRAINT `FK_depense_agex_contrat_ugp_agex` FOREIGN KEY (`id_contrat_ugp_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.depense_agex : ~0 rows (environ)
/*!40000 ALTER TABLE `depense_agex` DISABLE KEYS */;
INSERT INTO `depense_agex` (`id`, `id_contrat_ugp_agex`, `date`, `objet_depense`, `montant_categ_un`, `montant_categ_deux`) VALUES
	(1, 5, '2021-03-24', 'objet de la depense effectuer par l\'agex', 25000, 56000);
/*!40000 ALTER TABLE `depense_agex` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. etat_paiement_depense
DROP TABLE IF EXISTS `etat_paiement_depense`;
CREATE TABLE IF NOT EXISTS `etat_paiement_depense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrat_ugp_agex` int(11) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `designation` varchar(100) DEFAULT '',
  `montant_recu` float DEFAULT '0',
  `montant_depense` float DEFAULT '0',
  `reliquat` float DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_etat_paiement_depense_contrat_ugp_agex` (`id_contrat_ugp_agex`),
  CONSTRAINT `FK_etat_paiement_depense_contrat_ugp_agex` FOREIGN KEY (`id_contrat_ugp_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.etat_paiement_depense : ~3 rows (environ)
/*!40000 ALTER TABLE `etat_paiement_depense` DISABLE KEYS */;
INSERT INTO `etat_paiement_depense` (`id`, `id_contrat_ugp_agex`, `date_debut`, `date_fin`, `designation`, `montant_recu`, `montant_depense`, `reliquat`) VALUES
	(2, 5, '2021-03-10', '2021-04-07', 'fghfghfgh', 20, 10, 10),
	(3, 5, '2021-03-03', '2021-03-24', 'ok', 50, 20, 10),
	(4, 5, '2021-03-19', '2021-03-19', 'go', 10000000000, 20000000, 5000000);
/*!40000 ALTER TABLE `etat_paiement_depense` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp
DROP TABLE IF EXISTS `mdp`;
CREATE TABLE IF NOT EXISTS `mdp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL COMMENT 'arse ou act',
  `intitule_micro_projet` varchar(255) NOT NULL DEFAULT '',
  `numero_vague_zip` tinyint(4) NOT NULL,
  `cout_total_sous_projet` float NOT NULL,
  `cout_total_agr` float NOT NULL,
  `renumeration_enex` float NOT NULL,
  `date_approbation_ser_deg` date NOT NULL,
  `objectif_micro_projet` text NOT NULL,
  `description_sous_projet` text NOT NULL,
  `context_justification` text NOT NULL,
  `mdp_cout_investissement_agr` float DEFAULT NULL,
  `mdp_cout_investissement_agr_formation` float DEFAULT NULL,
  `etat_validation` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp : ~0 rows (environ)
/*!40000 ALTER TABLE `mdp` DISABLE KEYS */;
INSERT INTO `mdp` (`id`, `type`, `intitule_micro_projet`, `numero_vague_zip`, `cout_total_sous_projet`, `cout_total_agr`, `renumeration_enex`, `date_approbation_ser_deg`, `objectif_micro_projet`, `description_sous_projet`, `context_justification`, `mdp_cout_investissement_agr`, `mdp_cout_investissement_agr_formation`, `etat_validation`) VALUES
	(1, 'ARSE', 'intutleuprj', 5, 500000, 600000, 700000, '2021-03-17', 'obj mprj ok', 'desc prj', 'cntx', 800000, 900000, 0);
/*!40000 ALTER TABLE `mdp` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_agr_maraichere
DROP TABLE IF EXISTS `mdp_agr_maraichere`;
CREATE TABLE IF NOT EXISTS `mdp_agr_maraichere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) DEFAULT NULL,
  `type` text,
  `localite` varchar(50) DEFAULT NULL,
  `activite` varchar(50) DEFAULT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `quantite` float DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_mdp_agr_maraichere_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_agr_maraichere_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_agr_maraichere : ~1 rows (environ)
/*!40000 ALTER TABLE `mdp_agr_maraichere` DISABLE KEYS */;
INSERT INTO `mdp_agr_maraichere` (`id`, `id_mdp`, `type`, `localite`, `activite`, `unite`, `quantite`) VALUES
	(1, 1, 'AGR production de maraichère Nombre100', 'gdfgsdfg', 'sdfgsdfgsd', 'fgsdfgsdfg', 200),
	(2, 1, 'Stage de formation au centre de Ouani en electricité', 'teste localité', 'teste activité', 'Séance', 25);
/*!40000 ALTER TABLE `mdp_agr_maraichere` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_communaute
DROP TABLE IF EXISTS `mdp_communaute`;
CREATE TABLE IF NOT EXISTS `mdp_communaute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) NOT NULL,
  `id_communaute` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_communaute_communaute` (`id_communaute`),
  KEY `FK_mdp_communaute_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_communaute_communaute` FOREIGN KEY (`id_communaute`) REFERENCES `communaute` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_mdp_communaute_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_communaute : ~2 rows (environ)
/*!40000 ALTER TABLE `mdp_communaute` DISABLE KEYS */;
INSERT INTO `mdp_communaute` (`id`, `id_mdp`, `id_communaute`) VALUES
	(2, 1, 1),
	(4, 1, 2);
/*!40000 ALTER TABLE `mdp_communaute` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_delai
DROP TABLE IF EXISTS `mdp_delai`;
CREATE TABLE IF NOT EXISTS `mdp_delai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) NOT NULL,
  `localite` varchar(50) NOT NULL DEFAULT '',
  `nbr_beneficiaire` int(11) NOT NULL,
  `personne_jour` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_delai_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_delai_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_delai : ~2 rows (environ)
/*!40000 ALTER TABLE `mdp_delai` DISABLE KEYS */;
INSERT INTO `mdp_delai` (`id`, `id_mdp`, `localite`, `nbr_beneficiaire`, `personne_jour`) VALUES
	(1, 1, 'teste', 50, 6),
	(2, 1, 'teste 2', 100, 15);
/*!40000 ALTER TABLE `mdp_delai` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_description_activite
DROP TABLE IF EXISTS `mdp_description_activite`;
CREATE TABLE IF NOT EXISTS `mdp_description_activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) NOT NULL,
  `description_activite` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_description_activite_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_description_activite_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_description_activite : ~0 rows (environ)
/*!40000 ALTER TABLE `mdp_description_activite` DISABLE KEYS */;
INSERT INTO `mdp_description_activite` (`id`, `id_mdp`, `description_activite`) VALUES
	(1, 1, 'a. Mise en place d’une parcelle de production de tomate');
/*!40000 ALTER TABLE `mdp_description_activite` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_duree_planning
DROP TABLE IF EXISTS `mdp_duree_planning`;
CREATE TABLE IF NOT EXISTS `mdp_duree_planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) NOT NULL,
  `designation_activite` varchar(100) NOT NULL,
  `numero_semaine` tinyint(4) NOT NULL,
  `numero_jour` tinyint(4) NOT NULL,
  `valeur` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_mdp_duree_planning_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_duree_planning_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_duree_planning : ~2 rows (environ)
/*!40000 ALTER TABLE `mdp_duree_planning` DISABLE KEYS */;
INSERT INTO `mdp_duree_planning` (`id`, `id_mdp`, `designation_activite`, `numero_semaine`, `numero_jour`, `valeur`) VALUES
	(1, 1, '1- production de tomate', 1, 1, 1),
	(2, 1, '2-petit commerce', 1, 2, 1);
/*!40000 ALTER TABLE `mdp_duree_planning` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_estimation_depense
DROP TABLE IF EXISTS `mdp_estimation_depense`;
CREATE TABLE IF NOT EXISTS `mdp_estimation_depense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `dziani` varchar(50) DEFAULT NULL,
  `kiyo` varchar(50) DEFAULT NULL,
  `komoni` varchar(50) DEFAULT NULL,
  `trindrini` varchar(50) DEFAULT NULL,
  `prix_unitaire` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_estimation_depense_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_estimation_depense_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_estimation_depense : ~0 rows (environ)
/*!40000 ALTER TABLE `mdp_estimation_depense` DISABLE KEYS */;
INSERT INTO `mdp_estimation_depense` (`id`, `id_mdp`, `designation`, `unite`, `quantite`, `dziani`, `kiyo`, `komoni`, `trindrini`, `prix_unitaire`, `total`) VALUES
	(1, 1, 'teste', 'L', 10, '1', 'kjkj', 'kjk', 'kj', 2500, 5000);
/*!40000 ALTER TABLE `mdp_estimation_depense` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_formation
DROP TABLE IF EXISTS `mdp_formation`;
CREATE TABLE IF NOT EXISTS `mdp_formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) NOT NULL,
  `theme` text NOT NULL,
  `duree` varchar(50) NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `nbr_beneficiaire` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_mdp_formation_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_formation_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_formation : ~0 rows (environ)
/*!40000 ALTER TABLE `mdp_formation` DISABLE KEYS */;
INSERT INTO `mdp_formation` (`id`, `id_mdp`, `theme`, `duree`, `lieu`, `nbr_beneficiaire`) VALUES
	(1, 1, 'theme', '5 semaine', 'Moroni', 120);
/*!40000 ALTER TABLE `mdp_formation` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_indicateur
DROP TABLE IF EXISTS `mdp_indicateur`;
CREATE TABLE IF NOT EXISTS `mdp_indicateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) DEFAULT NULL,
  `categorie_travailleur` varchar(50) DEFAULT NULL,
  `numero_semaine` tinyint(4) DEFAULT NULL,
  `nombre` int(11) DEFAULT NULL,
  `lieu` varchar(50) DEFAULT NULL COMMENT 'dziany,kiyo ou komoni',
  PRIMARY KEY (`id`),
  KEY `FK_mdp_indicateur_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_indicateur_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_indicateur : ~1 rows (environ)
/*!40000 ALTER TABLE `mdp_indicateur` DISABLE KEYS */;
INSERT INTO `mdp_indicateur` (`id`, `id_mdp`, `categorie_travailleur`, `numero_semaine`, `nombre`, `lieu`) VALUES
	(1, 1, 'Travailleur Principal', 1, 15, 'Dziani');
/*!40000 ALTER TABLE `mdp_indicateur` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_magasin_vente
DROP TABLE IF EXISTS `mdp_magasin_vente`;
CREATE TABLE IF NOT EXISTS `mdp_magasin_vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) DEFAULT NULL,
  `localite` varchar(50) DEFAULT NULL,
  `activite` varchar(50) DEFAULT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `quantite` float DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_mdp_magasin_vente_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_magasin_vente_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_magasin_vente : ~0 rows (environ)
/*!40000 ALTER TABLE `mdp_magasin_vente` DISABLE KEYS */;
/*!40000 ALTER TABLE `mdp_magasin_vente` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_recap_depense
DROP TABLE IF EXISTS `mdp_recap_depense`;
CREATE TABLE IF NOT EXISTS `mdp_recap_depense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL COMMENT 'dépense ou rénumération agex',
  `libelle` varchar(50) DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `pourcentage` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_recap_depense_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_recap_depense_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_recap_depense : ~1 rows (environ)
/*!40000 ALTER TABLE `mdp_recap_depense` DISABLE KEYS */;
INSERT INTO `mdp_recap_depense` (`id`, `id_mdp`, `categorie`, `libelle`, `montant`, `pourcentage`) VALUES
	(1, 1, 'Catégorie I - Dépenses', '1.1 préparation', 657200, 9);
/*!40000 ALTER TABLE `mdp_recap_depense` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_rentabilite_financiere_agr
DROP TABLE IF EXISTS `mdp_rentabilite_financiere_agr`;
CREATE TABLE IF NOT EXISTS `mdp_rentabilite_financiere_agr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `investissement` varchar(50) NOT NULL,
  `estimation_quantitatif` varchar(50) NOT NULL,
  `estimation_recette` varchar(50) NOT NULL,
  `benefice_attends` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_rentabilite_financiere_agr_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_rentabilite_financiere_agr_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_rentabilite_financiere_agr : ~1 rows (environ)
/*!40000 ALTER TABLE `mdp_rentabilite_financiere_agr` DISABLE KEYS */;
INSERT INTO `mdp_rentabilite_financiere_agr` (`id`, `id_mdp`, `designation`, `investissement`, `estimation_quantitatif`, `estimation_recette`, `benefice_attends`) VALUES
	(1, 1, 'teste', '2000', '25', '2', '25000');
/*!40000 ALTER TABLE `mdp_rentabilite_financiere_agr` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_resultat_attendu
DROP TABLE IF EXISTS `mdp_resultat_attendu`;
CREATE TABLE IF NOT EXISTS `mdp_resultat_attendu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `lieu` varchar(50) DEFAULT NULL COMMENT 'dziany,kiyo ou komoni',
  `prevu` int(11) DEFAULT NULL,
  `realise` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_resultat_attendu_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_resultat_attendu_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_resultat_attendu : ~1 rows (environ)
/*!40000 ALTER TABLE `mdp_resultat_attendu` DISABLE KEYS */;
INSERT INTO `mdp_resultat_attendu` (`id`, `id_mdp`, `description`, `unite`, `lieu`, `prevu`, `realise`) VALUES
	(1, 1, 'Construction banquette avec enherbement', 'm²', 'Komoni', 7000, 0);
/*!40000 ALTER TABLE `mdp_resultat_attendu` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_suivi_indicateur
DROP TABLE IF EXISTS `mdp_suivi_indicateur`;
CREATE TABLE IF NOT EXISTS `mdp_suivi_indicateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) DEFAULT NULL,
  `type_indicateur` varchar(50) DEFAULT NULL COMMENT 'envirronnemental et social,autres',
  `indicateur` text,
  `lieu` varchar(100) DEFAULT NULL,
  `valeur_reference` varchar(50) DEFAULT NULL,
  `valeur_mesure` varchar(50) DEFAULT NULL,
  `explications` text,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_suivi_indicateur_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_suivi_indicateur_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_suivi_indicateur : ~1 rows (environ)
/*!40000 ALTER TABLE `mdp_suivi_indicateur` DISABLE KEYS */;
INSERT INTO `mdp_suivi_indicateur` (`id`, `id_mdp`, `type_indicateur`, `indicateur`, `lieu`, `valeur_reference`, `valeur_mesure`, `explications`) VALUES
	(1, 1, 'Environnemental et social', 'Sensibilisation, formation des travailleurs sur les règles de bonne conduite, leur droit et leur devoir', 'Dziani', '1 séance', '', '');
/*!40000 ALTER TABLE `mdp_suivi_indicateur` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. mdp_type_agr
DROP TABLE IF EXISTS `mdp_type_agr`;
CREATE TABLE IF NOT EXISTS `mdp_type_agr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mdp` int(11) NOT NULL,
  `localite` varchar(50) NOT NULL,
  `type_agr` varchar(100) NOT NULL,
  `beneficiaire` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mdp_type_agr_mdp` (`id_mdp`),
  CONSTRAINT `FK_mdp_type_agr_mdp` FOREIGN KEY (`id_mdp`) REFERENCES `mdp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.mdp_type_agr : ~0 rows (environ)
/*!40000 ALTER TABLE `mdp_type_agr` DISABLE KEYS */;
INSERT INTO `mdp_type_agr` (`id`, `id_mdp`, `localite`, `type_agr`, `beneficiaire`) VALUES
	(1, 1, 'teste', 'Production maraichère', 100);
/*!40000 ALTER TABLE `mdp_type_agr` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. pv_remise_agex
DROP TABLE IF EXISTS `pv_remise_agex`;
CREATE TABLE IF NOT EXISTS `pv_remise_agex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contrat_ugp_agex` int(11) NOT NULL DEFAULT '0',
  `nom_representant_cps` varchar(255) NOT NULL DEFAULT '',
  `date_remise` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pv_remise_agex_contrat_ugp_agex` (`id_contrat_ugp_agex`),
  CONSTRAINT `FK_pv_remise_agex_contrat_ugp_agex` FOREIGN KEY (`id_contrat_ugp_agex`) REFERENCES `contrat_ugp_agex` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.pv_remise_agex : ~0 rows (environ)
/*!40000 ALTER TABLE `pv_remise_agex` DISABLE KEYS */;
INSERT INTO `pv_remise_agex` (`id`, `id_contrat_ugp_agex`, `nom_representant_cps`, `date_remise`) VALUES
	(2, 5, 'JEAN', '2021-03-24');
/*!40000 ALTER TABLE `pv_remise_agex` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. pv_remise_details_agex
DROP TABLE IF EXISTS `pv_remise_details_agex`;
CREATE TABLE IF NOT EXISTS `pv_remise_details_agex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pv_remise_agex` int(11) NOT NULL,
  `intitule` varchar(100) NOT NULL DEFAULT '',
  `nombre` int(11) NOT NULL DEFAULT '0',
  `observation` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK_pv_remise_agex_details_pv_remise_agex` (`id_pv_remise_agex`),
  CONSTRAINT `FK_pv_remise_agex_details_pv_remise_agex` FOREIGN KEY (`id_pv_remise_agex`) REFERENCES `pv_remise_agex` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table ogadc.pv_remise_details_agex : ~0 rows (environ)
/*!40000 ALTER TABLE `pv_remise_details_agex` DISABLE KEYS */;
INSERT INTO `pv_remise_details_agex` (`id`, `id_pv_remise_agex`, `intitule`, `nombre`, `observation`) VALUES
	(1, 2, 'Lit', 5, 'RAS');
/*!40000 ALTER TABLE `pv_remise_details_agex` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. see_agent
DROP TABLE IF EXISTS `see_agent`;
CREATE TABLE IF NOT EXISTS `see_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ile_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `Code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Contact` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Representant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Telephone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `programme_id` int(11) DEFAULT NULL,
  `a_ete_modifie` tinyint(4) NOT NULL DEFAULT '0',
  `supprime` tinyint(4) DEFAULT '0',
  `userid` int(11) DEFAULT NULL,
  `datemodification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_73D3F7819F2C3FAB` (`zone_id`),
  KEY `IDX_73D3F78162BB7AEE` (`programme_id`),
  CONSTRAINT `FK_73D3F78162BB7AEE` FOREIGN KEY (`programme_id`) REFERENCES `see_programme` (`id`),
  CONSTRAINT `FK_73D3F7819F2C3FAB` FOREIGN KEY (`zone_id`) REFERENCES `see_zone` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table ogadc.see_agent : ~8 rows (environ)
/*!40000 ALTER TABLE `see_agent` DISABLE KEYS */;
INSERT INTO `see_agent` (`id`, `ile_id`, `zone_id`, `Code`, `Nom`, `Contact`, `Representant`, `Telephone`, `programme_id`, `a_ete_modifie`, `supprime`, `userid`, `datemodification`) VALUES
	(1, 4, NULL, 'AGP001', 'Nom agp', '32767', 'REP agp', '1233', 1, 0, 0, NULL, NULL),
	(2, 2, NULL, 'AGP003', 'MECK NTSAWENI', 'CONT', 'REP3', 'TELEPHONE', 1, 0, 0, NULL, NULL),
	(3, 4, NULL, '001', 'MECK WANI', '', 'ABDOU', '', 1, 0, 0, NULL, NULL),
	(5, 2, NULL, 'AGP-NGZ', 'MECK KOIMBANI', 'union des mecks', 'Directeur Général', '7738020', 1, 0, 0, NULL, NULL),
	(6, 1, NULL, 'AGP', 'Union des MECK', '7738020', 'Directeur Général', '', 1, 0, 0, NULL, NULL),
	(7, 1, NULL, 'AGP2', 'MECK  FOMBONI', '7738020', 'Directeur Général', '7738020', 1, 0, 0, NULL, NULL),
	(8, 4, NULL, 'AGP3', 'MECK DOMONI', 'ALFEINE', 'GERANT', '7738020', 1, 0, 0, NULL, NULL),
	(9, 2, NULL, 'AGP004', 'MECK FOUMBUNI', '', 'Directeur Général', '', 1, 0, 0, NULL, NULL);
/*!40000 ALTER TABLE `see_agent` ENABLE KEYS */;

-- Listage de la structure de la table ogadc. see_agex
DROP TABLE IF EXISTS `see_agex`;
CREATE TABLE IF NOT EXISTS `see_agex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant_agex` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `intervenant_agex` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nom_contact_agex` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `titre_contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `numero_phone_contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `adresse_agex` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table ogadc.see_agex : ~1 rows (environ)
/*!40000 ALTER TABLE `see_agex` DISABLE KEYS */;
INSERT INTO `see_agex` (`id`, `identifiant_agex`, `Nom`, `intervenant_agex`, `nom_contact_agex`, `titre_contact`, `numero_phone_contact`, `adresse_agex`) VALUES
	(17, 'Teste id', 'DENOM TSTE', 'Consultant', 'Randria', 'TITRE', '0323212321', 'TANA');
/*!40000 ALTER TABLE `see_agex` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
