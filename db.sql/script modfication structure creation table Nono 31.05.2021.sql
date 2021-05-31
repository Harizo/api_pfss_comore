USE pfss_db;
CREATE TABLE `visite_domicile_raison` (
	`id` INT NULL AUTO_INCREMENT,
	`id_visite` INT NULL DEFAULT NULL,
	`id_raison_visite_domicile` INT NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci';
CREATE TABLE `visite_domicile_menage` (
	`id` INT NULL AUTO_INCREMENT,
	`id_visite` INT NULL DEFAULT NULL,
	`id_menage` INT NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci';
CREATE TABLE `espace_bien_etre` (
	`id` INT NULL AUTO_INCREMENT,
	`description` VARCHAR(100) NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci';
CREATE TABLE `liste_variable_individu` (
	`id` INT NULL AUTO_INCREMENT,
	`description` VARCHAR(100) NULL DEFAULT NULL,
	`code` VARCHAR(10) NULL DEFAULT NULL,
	`choix_unique` SMALLINT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
;
CREATE TABLE `variable_individu` (
	`id` INT NULL AUTO_INCREMENT,
	`id_liste_variable_individu` INT NULL DEFAULT NULL,
	`description` VARCHAR(100) NULL DEFAULT NULL,
	`code` VARCHAR(10) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
;

ALTER TABLE `liste_ml_pl`	ADD COLUMN `sexe` VARCHAR(1) NULL DEFAULT NULL AFTER `fonction`;
ALTER TABLE `liste_ml_pl`	ADD COLUMN `age` SMALLINT NULL DEFAULT NULL AFTER `sexe`;
ALTER TABLE `liste_ml_pl`	ADD COLUMN `lien_de_parente` SMALLINT NULL DEFAULT NULL AFTER `age`;
RENAME TABLE `fiche_supervision` TO `fiche_supervision_mlpl`;
ALTER TABLE `fiche_supervision_mlpl` ADD COLUMN `id_groupemlpl` INT(11) NULL DEFAULT NULL AFTER `id_contrat`;
ALTER TABLE `menage_beneficiaire`	ADD COLUMN `motif_sortie` VARCHAR(150) NULL DEFAULT NULL AFTER `date_sortie`;
ALTER TABLE `see_plainte` 	ADD COLUMN `telephone` VARCHAR(25) NULL DEFAULT NULL AFTER `statut`;
ALTER TABLE `visite_domicile` CHANGE COLUMN `objet_visite` `objet_visite` TEXT NULL DEFAULT NULL AFTER `menage_id`;
ALTER TABLE `groupe_ml_pl` ADD COLUMN `id_menage` INT NULL DEFAULT NULL AFTER `date_creation`;
ALTER TABLE `groupe_ml_pl` ADD COLUMN `nom_prenom_ml_pl` VARCHAR(100) NULL DEFAULT NULL AFTER `id_menage`;

ALTER TABLE `visite_domicile` DROP COLUMN `menage_id`;
ALTER TABLE `groupe_ml_pl`  ADD COLUMN `sexe` VARCHAR(1) NULL DEFAULT NULL AFTER `village_id`;
ALTER TABLE `groupe_ml_pl`	ADD COLUMN `age` SMALLINT NULL DEFAULT NULL AFTER `sexe`;
ALTER TABLE `groupe_ml_pl`	ADD COLUMN `lien_de_parente` SMALLINT NULL DEFAULT NULL AFTER `age`;
ALTER TABLE `groupe_ml_pl`	ADD COLUMN `telephone` VARCHAR(20) NULL DEFAULT NULL AFTER `lien_de_parente`;
ALTER TABLE `menage` ADD COLUMN `motif_non_selection` TEXT NULL DEFAULT NULL AFTER `antenne_parabolique_enquete`;
ALTER TABLE `menage` ADD COLUMN `lien_travailleur` INT(11) NULL DEFAULT NULL AFTER `agetravailleur`;
ALTER TABLE `menage` ADD COLUMN `lien_suppleant` INT(11) NULL DEFAULT NULL AFTER `agesuppliant`;





