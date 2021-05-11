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

-- Listage de la structure de la table pfss_db. infrastructure
DROP TABLE IF EXISTS `infrastructure`;
CREATE TABLE IF NOT EXISTS `infrastructure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type_infrastructure` int(11) DEFAULT NULL,
  `code_numero` varchar(50) DEFAULT NULL,
  `code_passation` varchar(50) DEFAULT NULL,
  `libelle` varchar(10) DEFAULT NULL,
  `id_village` int(11) DEFAULT NULL,
  `statu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_infrastructure_type_infrastructure` (`id_type_infrastructure`),
  KEY `FK_infrastructure_see_village` (`id_village`),
  CONSTRAINT `FK_infrastructure_see_village` FOREIGN KEY (`id_village`) REFERENCES `see_village` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_infrastructure_type_infrastructure` FOREIGN KEY (`id_type_infrastructure`) REFERENCES `type_infrastructure` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.infrastructure : ~2 rows (environ)
/*!40000 ALTER TABLE `infrastructure` DISABLE KEYS */;
INSERT INTO `infrastructure` (`id`, `id_type_infrastructure`, `code_numero`, `code_passation`, `libelle`, `id_village`, `statu`) VALUES
	(1, 1, 'code2', NULL, 'libelle2', 6, 'ELIGIBLE'),
	(2, 1, 'codep2', NULL, 'libellep2', 6, 'ELIGIBLE'),
	(4, 1, 'code11', 'code passation', 'libelle1', 6, 'CHOISI');
/*!40000 ALTER TABLE `infrastructure` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. type_infrastructure
DROP TABLE IF EXISTS `type_infrastructure`;
CREATE TABLE IF NOT EXISTS `type_infrastructure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pfss_db.type_infrastructure : ~2 rows (environ)
/*!40000 ALTER TABLE `type_infrastructure` DISABLE KEYS */;
INSERT INTO `type_infrastructure` (`id`, `code`, `libelle`) VALUES
	(1, 'code', 'libelle'),
	(2, 'code2', 'libelle2');
/*!40000 ALTER TABLE `type_infrastructure` ENABLE KEYS */;

-- Listage de la structure de la table pfss_db. utilisateur
DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ile` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT NULL,
  `date_modification` timestamp NULL DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `token` text,
  `roles` longtext,
  `etat_connexion` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 3` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Listage des données de la table pfss_db.utilisateur : ~13 rows (environ)
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` (`id`, `id_ile`, `nom`, `prenom`, `email`, `password`, `date_creation`, `date_modification`, `enabled`, `token`, `roles`, `etat_connexion`) VALUES
	(1, 2, 'Rajaonarisoa', 'Harizo', 'rajaonarisoazo@gmail.com', '7d517d525c9d15886516270d997bbf8195158049', '2019-06-20 09:51:09', '2019-06-20 09:51:09', 1, '164a343bb0c24f9ff4187c01c417ec78374dd883242b272307cc11c6156bcceb', 'a:8:{i:0;s:4:"USER";i:1;s:5:"ADMIN";i:2;s:3:"DDB";i:3;s:3:"TTM";i:4;s:3:"RPT";i:5;s:3:"MDF";i:6;s:3:"AJT";i:7;s:3:"SPR";}', 0),
	(2, 2, 'Harizo', 'rajaonarisoa', 'rj@gmail.com', '09b4af440c5e17e02e5d0a2618aed25eca4b0332', '2019-06-21 07:50:35', '2019-06-21 07:50:35', 1, '7bd7a1a9158182f08a70077136d13ef6b78b4ff150fcd5c0f3739192b22db257', 'a:4:{i:0;s:4:"USER";i:1;s:5:"ADMIN";i:2;s:3:"AJT";i:3;s:3:"MDF";}', 0),
	(3, 2, 'Minister de la Sante', 'Direction de la Solidarité', 'mini.solidarite@gmail.com', '02b1eb470763ee78c2c5a9b377d9be1219d93981', '2019-06-25 06:41:15', '2019-06-25 06:41:15', 1, '8deaee357084a0d4bf74f5def483ec86e10bddebee4b8840fa55f315169f26d4', 'a:3:{i:0;s:4:"USER";i:1;s:3:"TTM";i:2;s:3:"RPT";}', 0),
	(4, 2, 'Anrifouddine', 'Ahmed', 'anrifouddine@yahoo.fr', '423a1aec6ba479397e21a3f656c9cd44b4e22170', '2019-06-25 06:42:05', '2019-06-25 06:42:05', 1, '6723bf45cd2f19c7474214c51beb5c7adcc5fa4d7a292199fab60324713af2f8', 'a:2:{i:0;s:4:"USER";i:1;s:3:"TTM";}', 0),
	(5, 2, 'Benzamil', 'Ali Said', 'alisaidbenzamil@gmail.com', '935e8bef790394133fbc86680691eaa963cd86da', '2019-06-25 06:44:14', '2019-06-25 06:44:14', 1, 'afef2279ff174486595390d8344b20e1c629c53befdecacfbe2b8ff5babcaeec', 'a:2:{i:0;s:4:"USER";i:1;s:3:"TTM";}', 0),
	(6, 2, 'Hassani', 'Aymane', 'aym.kom7@gmail.com', '24cdc39d621946ccecce84cf7f38a16909abbe40', '2019-06-25 06:44:20', '2019-06-25 06:44:20', 1, 'cdc1bf562ed7d308fdf51d47d99a57209e482c712336f928ea9408eb9e680180', 'a:2:{i:0;s:4:"USER";i:1;s:3:"TTM";}', 0),
	(7, 2, 'mariama', 'abidina', 'mariamaabidina@gmail.com', '0794a5c7e497910d682bf2c54c66cc30760c0221', '2019-06-25 06:44:53', '2019-06-25 06:44:53', 1, 'e5592b5e175a0f85c0402e0f667a8bdcf19bff6093abdf0228e08ad0712d096b', 'a:2:{i:0;s:4:"USER";i:1;s:3:"TTM";}', 0),
	(8, 2, 'ADMINITRATEUR', 'KAMARDINE', 'kamardine1985@yahoo.fr', '53b5603ebe0c1fdfedafdcc64f8332028b8350e6', '2019-06-25 07:47:19', '2019-06-25 07:47:19', 1, '9ca7f76dd1ba54b38777e6fb0004566b6cb962f0cc2e3a070860e3d7fb446bc8', 'a:4:{i:0;s:4:"USER";i:1;s:3:"DDB";i:2;s:5:"ADMIN";i:3;s:3:"TTM";}', 0),
	(9, 2, 'fatoumia', 'assoumani', 'faouass15@yahoo.com', '4de1e8047d4c636e47f47e41b51d29998f52d44b', '2019-06-26 07:28:34', '2019-06-26 07:28:34', 1, '4019659a3420cfdcfa5f953cf8933579d7147a0f8d6f8138f498c00880910c40', 'a:1:{i:0;s:4:"USER";}', 0),
	(10, 2, 'Fatoumia', 'assoumani', 'fatouass15@yahoo.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2019-06-26 07:31:51', '2019-06-26 07:31:51', 1, 'ff6e1aae2cf565fb526e560b2a5a545e7bbd1ba76474aef97e52b2ac08446457', 'a:2:{i:0;s:4:"USER";i:1;s:3:"TTM";}', 0),
	(11, 2, 'Gerard', 'Jean', 'jean@gmail.com', '70c881d4a26984ddce795f6f71817c9cf4480e79', '2019-08-21 10:21:45', '2019-08-21 10:21:45', 0, '6f98445ba5a0e1f80e7dcdc90bf61a28489fdaf73d31cf86c06652723160ead3', 'a:1:{i:0;s:4:"USER";}', 0),
	(12, 2, 'Gerard', 'Jean', 'jean@yahoo.fr', '70c881d4a26984ddce795f6f71817c9cf4480e79', '2019-08-21 10:30:34', '2019-08-21 10:30:34', 1, 'b365e2f09c1761b226bf9d021eaf142a5441f6d209b7354ce601a3e34a7a4607', 'a:4:{i:0;s:4:"USER";i:1;s:3:"DDB";i:2;s:3:"MDF";i:3;s:3:"AJT";}', 0),
	(13, 2, 'TESTE NOM', 'TUTO PRENOM', 'tuto@mail.com', '7d517d525c9d15886516270d997bbf8195158049', '2021-04-28 10:43:49', '2021-04-28 10:43:49', 0, 'd80836d676d9d755a8567e39135a179e2421001219f33d46d219ebedf2a9c0c8', 'a:1:{i:0;s:4:"USER";}', 0),
	(14, 4, 'RALAIBETARAFINA', 'Bruce', 'brucetarafina@gmail.com', '925c7332a8c820faa0d0167ac6d2b64281113173', '2021-05-09 10:17:41', '2021-05-09 10:17:41', 1, '8260497ba52fa6590eb20b856cc988f8760c73dae3f33321e305e42ae26f4151', 'a:8:{i:0;s:4:"USER";i:1;s:5:"ADMIN";i:2;s:3:"DDB";i:3;s:3:"TTM";i:4;s:3:"RPT";i:5;s:3:"MDF";i:6;s:3:"AJT";i:7;s:3:"SPR";}', 0);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
