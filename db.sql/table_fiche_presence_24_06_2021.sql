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

-- Listage de la structure de la table pfss_db. fiche_presence_formation_ml
DROP TABLE IF EXISTS `fiche_presence_formation_ml`;
CREATE TABLE IF NOT EXISTS `fiche_presence_formation_ml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_formation_ml` int(11) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `id_groupe_ml_pl` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_presence_groupe_part_formation_ml` (`id_formation_ml`),
  KEY `FK_presence_groupe_part_see_village` (`id_village`),
  KEY `FK_presence_groupe_part_groupe_ml_pl` (`id_groupe_ml_pl`),
  CONSTRAINT `FK_presence_groupe_part_formation_ml` FOREIGN KEY (`id_formation_ml`) REFERENCES `formation_ml` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_presence_groupe_part_groupe_ml_pl` FOREIGN KEY (`id_groupe_ml_pl`) REFERENCES `groupe_ml_pl` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_presence_groupe_part_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
