ALTER TABLE `menage` ADD COLUMN `situation_matrimoniale` SMALLINT NULL AFTER `motif_non_selection`;
ALTER TABLE `menage` ADD COLUMN `telephone_travailleur` VARCHAR(15) NULL AFTER `situation_matrimoniale`;
ALTER TABLE `menage` ADD COLUMN `telephone_suppleant` VARCHAR(15) NULL AFTER `telephone_travailleur`;
ALTER TABLE `indicateur` CHANGE COLUMN `code` `code` VARCHAR(20) NULL AFTER `id`;
ALTER TABLE `see_plainte`	ADD COLUMN `tranche_id` INT NULL DEFAULT NULL AFTER `telephone`;

CREATE TABLE `tableau_de_bord` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`type_tdb` VARCHAR(5) NULL DEFAULT NULL,
	`ile_id` INT NULL DEFAULT NULL,
	`vague` TINYINT NULL DEFAULT NULL,
	`indicateur_id` INT NULL DEFAULT NULL,
	`objectif_nombre` INT NULL DEFAULT NULL,
	`objectif_village` INT NULL DEFAULT NULL,
	`rang` TINYINT NULL DEFAULT NULL,
	`visible` TINYINT NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci';
CREATE TABLE `indicateur_tdb` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`description` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci';


