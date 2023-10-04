-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour cartraderdb
CREATE DATABASE IF NOT EXISTS `cartraderdb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cartraderdb`;

-- Listage de la structure de la table cartraderdb. factures
CREATE TABLE IF NOT EXISTS `factures` (
  `id_facture` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `path_facture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reservation_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_facture`),
  KEY `factures_reservation_id_foreign` (`reservation_id`),
  KEY `factures_client_id_foreign` (`client_id`),
  KEY `factures_created_by_foreign` (`created_by`),
  CONSTRAINT `factures_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `factures_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `factures_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id_reservation`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.factures : ~1 rows (environ)
/*!40000 ALTER TABLE `factures` DISABLE KEYS */;
INSERT INTO `factures` (`id_facture`, `path_facture`, `reservation_id`, `client_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(3, '/storage/factures/1650999954.png', 17, 6, 1, '2022-04-26 19:05:54', '2022-04-26 19:05:54');
/*!40000 ALTER TABLE `factures` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.failed_jobs : ~0 rows (environ)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. gestionnaires_societes
CREATE TABLE IF NOT EXISTS `gestionnaires_societes` (
  `id_gestionnaire_societe` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gestionnaire_id` bigint(20) unsigned DEFAULT NULL,
  `societe_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_gestionnaire_societe`),
  KEY `gestionnaires_societes_gestionnaire_id_foreign` (`gestionnaire_id`),
  KEY `gestionnaires_societes_societe_id_foreign` (`societe_id`),
  CONSTRAINT `gestionnaires_societes_gestionnaire_id_foreign` FOREIGN KEY (`gestionnaire_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gestionnaires_societes_societe_id_foreign` FOREIGN KEY (`societe_id`) REFERENCES `societes` (`id_societe`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.gestionnaires_societes : ~2 rows (environ)
/*!40000 ALTER TABLE `gestionnaires_societes` DISABLE KEYS */;
INSERT INTO `gestionnaires_societes` (`id_gestionnaire_societe`, `gestionnaire_id`, `societe_id`, `created_at`, `updated_at`) VALUES
	(2, 3, 3, '2022-04-14 19:08:41', '2022-04-14 19:08:41');
/*!40000 ALTER TABLE `gestionnaires_societes` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. images
CREATE TABLE IF NOT EXISTS `images` (
  `id_image` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `path_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voiture_id` bigint(20) unsigned DEFAULT NULL,
  `societe_id` bigint(20) unsigned DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_image`),
  KEY `images_voiture_id_foreign` (`voiture_id`),
  KEY `images_societe_id_foreign` (`societe_id`),
  KEY `images_created_by_foreign` (`created_by`),
  CONSTRAINT `images_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `images_societe_id_foreign` FOREIGN KEY (`societe_id`) REFERENCES `societes` (`id_societe`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `images_voiture_id_foreign` FOREIGN KEY (`voiture_id`) REFERENCES `voitures` (`id_voiture`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.images : ~4 rows (environ)
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` (`id_image`, `path_image`, `voiture_id`, `societe_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, '/storage/images/1200px-Toyota_Carina_E_front_20071006.jpg', 1, 3, 1, '2022-04-24 22:05:36', '2022-04-24 22:05:36'),
	(2, '/storage/images/2015-Toyota-RAV4-10-32t0s70xf62kliv8giayoa.jpg', 1, 3, 1, '2022-04-24 22:05:36', '2022-04-24 22:05:36'),
	(3, '/storage/images/2021BMS21000101.jpg', 1, 3, 1, '2022-04-24 22:05:36', '2022-04-24 22:05:36'),
	(4, '/storage/images/7959_1.jpg', 1, 3, 1, '2022-04-24 22:05:36', '2022-04-24 22:05:36');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. marques
CREATE TABLE IF NOT EXISTS `marques` (
  `id_marque` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_marque` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_marque` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_marque`),
  UNIQUE KEY `marques_code_marque_unique` (`code_marque`),
  KEY `marques_created_by_foreign` (`created_by`),
  CONSTRAINT `marques_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.marques : ~7 rows (environ)
/*!40000 ALTER TABLE `marques` DISABLE KEYS */;
INSERT INTO `marques` (`id_marque`, `nom_marque`, `slug_marque`, `code_marque`, `status_marque`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Toyota', 'marque-toyota', 'MARQUE-933145', 1, 1, '2022-04-14 15:08:35', '2022-04-14 15:08:35'),
	(2, 'Mazda', 'marque-mazda', 'MARQUE-307825', 1, 1, '2022-04-14 15:08:44', '2022-04-14 15:08:44'),
	(3, 'Bmw', 'marque-bmw', 'MARQUE-091169', 1, 1, '2022-04-14 15:08:54', '2022-04-14 15:08:54'),
	(4, 'Honda', 'marque-honda', 'MARQUE-441397', 1, 1, '2022-04-14 15:09:04', '2022-04-14 15:09:04'),
	(5, 'Mercedez Benz', 'marque-mercedez-benz', 'MARQUE-493571', 1, 1, '2022-04-14 15:09:13', '2022-04-14 15:09:13'),
	(6, 'Nissan', 'marque-nissan', 'MARQUE-782562', 1, 1, '2022-04-15 13:37:11', '2022-04-15 13:37:11');
/*!40000 ALTER TABLE `marques` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.migrations : ~14 rows (environ)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_04_06_192509_create_syslogs_table', 1),
	(6, '2022_04_06_193753_create_marques_table', 1),
	(7, '2022_04_07_014904_create_modeles_table', 1),
	(8, '2022_04_07_142259_create_parkings_table', 1),
	(9, '2022_04_08_140846_create_societes_table', 1),
	(10, '2022_04_08_163023_create_voitures_table', 1),
	(11, '2022_04_11_175945_create_reservations_table', 1),
	(12, '2022_04_13_014749_create_services_table', 1),
	(13, '2022_04_13_015357_create_images_table', 1),
	(14, '2022_04_14_144711_create_users_societes_table', 2),
	(15, '2022_04_14_145050_create_gestionnaires_societes_table', 3),
	(16, '2022_04_17_161939_create_images_table', 4),
	(17, '2022_04_17_173033_create_reservations_table', 5),
	(18, '2022_04_22_191035_create_factures_table', 6),
	(19, '2022_04_22_192204_create_factures_table', 7),
	(20, '2022_04_26_194455_create_password_resets_table', 8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. modeles
CREATE TABLE IF NOT EXISTS `modeles` (
  `id_modele` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_modele` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_modele` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_modele` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_modele` tinyint(1) NOT NULL DEFAULT '1',
  `marque_id` bigint(20) unsigned DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_modele`),
  UNIQUE KEY `modeles_code_modele_unique` (`code_modele`),
  KEY `modeles_marque_id_foreign` (`marque_id`),
  KEY `modeles_created_by_foreign` (`created_by`),
  CONSTRAINT `modeles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `modeles_marque_id_foreign` FOREIGN KEY (`marque_id`) REFERENCES `marques` (`id_marque`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.modeles : ~8 rows (environ)
/*!40000 ALTER TABLE `modeles` DISABLE KEYS */;
INSERT INTO `modeles` (`id_modele`, `nom_modele`, `slug_modele`, `code_modele`, `status_modele`, `marque_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Carina 3', 'modele-carina-3', 'MODELE-990380', 1, 1, 1, '2022-04-14 15:09:30', '2022-04-14 15:09:30'),
	(2, 'E46', 'modele-e46', 'MODELE-178658', 1, 3, 1, '2022-04-14 15:09:44', '2022-04-14 15:09:44'),
	(3, 'Avensis', 'modele-avensis', 'MODELE-678723', 1, 1, 1, '2022-04-14 15:09:58', '2022-04-14 15:09:58'),
	(4, 'X5', 'modele-x5', 'MODELE-512353', 1, 3, 1, '2022-04-14 15:10:12', '2022-04-14 15:10:12'),
	(5, 'Rav4', 'modele-rav4', 'MODELE-320159', 1, 1, 1, '2022-04-14 15:11:36', '2022-04-14 15:11:36'),
	(6, 'Juke', 'modele-juke', 'MODELE-018334', 1, 6, 1, '2022-04-15 13:37:32', '2022-04-15 13:37:32'),
	(7, 'Rogue', 'modele-rogue', 'MODELE-977278', 1, 6, 1, '2022-04-15 13:37:45', '2022-04-15 13:37:45'),
	(8, 'Almera', 'modele-almera', 'MODELE-243771', 1, 6, 1, '2022-04-15 13:38:11', '2022-04-17 01:42:22');
/*!40000 ALTER TABLE `modeles` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. parkings
CREATE TABLE IF NOT EXISTS `parkings` (
  `id_parking` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_parking` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_parking` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_parking` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_parking` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_parking`),
  UNIQUE KEY `parkings_code_parking_unique` (`code_parking`),
  KEY `parkings_created_by_foreign` (`created_by`),
  CONSTRAINT `parkings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.parkings : ~4 rows (environ)
/*!40000 ALTER TABLE `parkings` DISABLE KEYS */;
INSERT INTO `parkings` (`id_parking`, `nom_parking`, `slug_parking`, `code_parking`, `status_parking`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Park bkf', 'park-bkf', 'PARC-345520', 1, 1, '2022-04-14 15:01:41', '2022-04-14 15:01:41'),
	(2, 'Entreprise Union', 'entreprise-union', 'PARC-991052', 1, 1, '2022-04-14 15:01:50', '2022-04-14 15:01:50'),
	(3, 'GTA', 'gta', 'PARC-457253', 1, 1, '2022-04-14 15:02:01', '2022-04-14 15:02:01');
/*!40000 ALTER TABLE `parkings` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id_password_reset` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `reset_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_password_reset`),
  KEY `password_resets_user_id_foreign` (`user_id`),
  CONSTRAINT `password_resets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.password_resets : ~0 rows (environ)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.personal_access_tokens : ~0 rows (environ)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id_reservation` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_reservation` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix_reservation` int(11) DEFAULT NULL,
  `service_reservation` text COLLATE utf8mb4_unicode_ci,
  `status_reservation` tinyint(1) NOT NULL DEFAULT '0',
  `status_annulation` tinyint(4) NOT NULL DEFAULT '0',
  `voiture_id` bigint(20) unsigned DEFAULT NULL,
  `societe_id` bigint(20) unsigned DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `motif_reservation` text COLLATE utf8mb4_unicode_ci,
  `facture_reservation` text COLLATE utf8mb4_unicode_ci,
  `token_payement` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `reservations_voiture_id_foreign` (`voiture_id`),
  KEY `reservations_societe_id_foreign` (`societe_id`),
  KEY `reservations_created_by_foreign` (`created_by`),
  CONSTRAINT `reservations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reservations_societe_id_foreign` FOREIGN KEY (`societe_id`) REFERENCES `societes` (`id_societe`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reservations_voiture_id_foreign` FOREIGN KEY (`voiture_id`) REFERENCES `voitures` (`id_voiture`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.reservations : ~3 rows (environ)
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` (`id_reservation`, `code_reservation`, `prix_reservation`, `service_reservation`, `status_reservation`, `status_annulation`, `voiture_id`, `societe_id`, `created_by`, `motif_reservation`, `facture_reservation`, `token_payement`, `created_at`, `updated_at`) VALUES
	(15, 'RESERV-64945327', 200, '["4","3"]', 0, 0, 6, 1, 6, NULL, NULL, 'q65qF2cRwxSk9h3uDS0h', '2022-04-26 16:20:51', '2022-04-26 16:20:51'),
	(16, 'RESERV-08040531', 200, 'null', 0, 0, 6, 1, 6, NULL, NULL, 'msPyPx7kO4Do9y9WurrW', '2022-04-26 16:31:42', '2022-04-26 16:31:42'),
	(17, 'RESERV-39142352', 200, '["2","1"]', 1, 0, 5, 1, 6, NULL, 'https://paydunya.com/checkout/receipt/pdf/msmcndbf7qX75X9gLFZm.pdf', 'msmcndbf7qX75X9gLFZm', '2022-04-26 17:40:51', '2022-04-26 18:16:22');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. services
CREATE TABLE IF NOT EXISTS `services` (
  `id_service` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_service`),
  UNIQUE KEY `services_code_service_unique` (`code_service`),
  KEY `services_created_by_foreign` (`created_by`),
  CONSTRAINT `services_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.services : ~4 rows (environ)
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id_service`, `code_service`, `nom_service`, `slug_service`, `status_service`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'SERVICE-407720', 'Transit', 'service-transit', '1', 1, '2022-04-14 15:55:52', '2022-04-14 15:55:52'),
	(2, 'SERVICE-421366', 'Douane', 'service-douane', '1', 1, '2022-04-14 15:56:01', '2022-04-14 15:56:01'),
	(3, 'SERVICE-460134', 'Plaque d\'immatriculation', 'service-plaque-dimmatriculation', '1', 1, '2022-04-14 15:56:10', '2022-04-14 15:56:10'),
	(4, 'SERVICE-480143', 'Convoyage', 'service-convoyage', '1', 1, '2022-04-14 15:56:19', '2022-04-14 15:56:19');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. societes
CREATE TABLE IF NOT EXISTS `societes` (
  `id_societe` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_societe` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_societe` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_societe1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_societe2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug_societe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_societe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_societe` tinyint(1) NOT NULL DEFAULT '1',
  `parking_id` bigint(20) unsigned NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_societe`),
  UNIQUE KEY `societes_code_societe_unique` (`code_societe`),
  KEY `societes_parking_id_foreign` (`parking_id`),
  KEY `societes_created_by_foreign` (`created_by`),
  CONSTRAINT `societes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `societes_parking_id_foreign` FOREIGN KEY (`parking_id`) REFERENCES `parkings` (`id_parking`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.societes : ~4 rows (environ)
/*!40000 ALTER TABLE `societes` DISABLE KEYS */;
INSERT INTO `societes` (`id_societe`, `nom_societe`, `adresse_societe`, `telephone_societe1`, `telephone_societe2`, `slug_societe`, `code_societe`, `status_societe`, `parking_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Zoetechgroup', 'Lome Togo', '93075913', NULL, 'societe-zoetechgroup', 'SOCIETE-785230', 1, 2, 1, '2022-04-14 15:02:18', '2022-04-14 15:02:18'),
	(2, 'Ahuefa', 'Agoe Legbassito', '96851230', NULL, 'societe-ahuefa', 'SOCIETE-243431', 1, 2, 1, '2022-04-14 19:07:28', '2022-04-14 19:07:28'),
	(3, 'Daos Corporation', 'Agoe Telessou', '96852312', NULL, 'societe-daos-corporation', 'SOCIETE-097053', 1, 3, 1, '2022-04-14 19:07:55', '2022-04-14 19:07:55');
/*!40000 ALTER TABLE `societes` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. syslogs
CREATE TABLE IF NOT EXISTS `syslogs` (
  `id_syslog` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status_log` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_log` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_log` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_syslog`),
  KEY `syslogs_created_by_foreign` (`created_by`),
  CONSTRAINT `syslogs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.syslogs : ~160 rows (environ)
/*!40000 ALTER TABLE `syslogs` DISABLE KEYS */;
INSERT INTO `syslogs` (`id_syslog`, `status_log`, `content_log`, `ip_log`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'SUCCESS', 'Enregistrement du parc Park bkf avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:01:41', '2022-04-14 15:01:41'),
	(2, 'SUCCESS', 'Enregistrement du parc Entreprise Union avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:01:50', '2022-04-14 15:01:50'),
	(3, 'SUCCESS', 'Enregistrement du parc GTA avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:02:01', '2022-04-14 15:02:01'),
	(4, 'SUCCESS', 'Enregistrement de la sociète Zoetechgroup avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:02:18', '2022-04-14 15:02:18'),
	(5, 'SUCCESS', 'Enregistrement du gestionnaire Kothor Axel avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:02:58', '2022-04-14 15:02:58'),
	(6, 'SUCCESS', 'Enregistrement de la marque Toyota avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:08:35', '2022-04-14 15:08:35'),
	(7, 'SUCCESS', 'Enregistrement de la marque Mazda avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:08:44', '2022-04-14 15:08:44'),
	(8, 'SUCCESS', 'Enregistrement de la marque Bmw avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:08:54', '2022-04-14 15:08:54'),
	(9, 'SUCCESS', 'Enregistrement de la marque Honda avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:09:05', '2022-04-14 15:09:05'),
	(10, 'SUCCESS', 'Enregistrement de la marque Mercedez Benz avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:09:13', '2022-04-14 15:09:13'),
	(11, 'SUCCESS', 'Enregistrement du modele Carina 3 avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:09:30', '2022-04-14 15:09:30'),
	(12, 'SUCCESS', 'Enregistrement du modele E46 avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:09:44', '2022-04-14 15:09:44'),
	(13, 'SUCCESS', 'Enregistrement du modele Avensis avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:09:58', '2022-04-14 15:09:58'),
	(14, 'SUCCESS', 'Enregistrement du modele X5 avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:10:12', '2022-04-14 15:10:12'),
	(15, 'SUCCESS', 'Enregistrement du modele Rav4 avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:11:36', '2022-04-14 15:11:36'),
	(16, 'SUCCESS', 'Enregistrement de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:41:50', '2022-04-14 15:41:50'),
	(17, 'SUCCESS', 'Enregistrement de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:43:35', '2022-04-14 15:43:35'),
	(18, 'SUCCESS', 'Enregistrement de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:43:44', '2022-04-14 15:43:44'),
	(19, 'SUCCESS', 'Enregistrement de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:44:03', '2022-04-14 15:44:03'),
	(20, 'SUCCESS', 'Suppression de la voiture dans le système', '127.0.0.1', 1, '2022-04-14 15:47:00', '2022-04-14 15:47:00'),
	(21, 'SUCCESS', 'Suppression de la voiture dans le système', '127.0.0.1', 1, '2022-04-14 15:47:09', '2022-04-14 15:47:09'),
	(22, 'SUCCESS', 'Enregistrement de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:48:57', '2022-04-14 15:48:57'),
	(23, 'SUCCESS', 'Enregistrement de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:50:26', '2022-04-14 15:50:26'),
	(24, 'SUCCESS', 'Enregistrement du service Transit avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:55:52', '2022-04-14 15:55:52'),
	(25, 'SUCCESS', 'Enregistrement du service Douane avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:56:01', '2022-04-14 15:56:01'),
	(26, 'SUCCESS', 'Enregistrement du service Plaque d\'immatriculation avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:56:10', '2022-04-14 15:56:10'),
	(27, 'SUCCESS', 'Enregistrement du service Convoyage avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 15:56:19', '2022-04-14 15:56:19'),
	(28, 'SUCCESS', 'Enregistrement de la sociète Ahuefa avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 19:07:28', '2022-04-14 19:07:28'),
	(29, 'SUCCESS', 'Enregistrement de la sociète Daos Corporation avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 19:07:55', '2022-04-14 19:07:55'),
	(30, 'SUCCESS', 'Enregistrement du gestionnaire Fondey Omar avec succes dans le système.', '127.0.0.1', 1, '2022-04-14 19:08:41', '2022-04-14 19:08:41'),
	(31, 'SUCCESS', 'Enregistrement du parc Toto avec succes dans le système.', '127.0.0.1', 1, '2022-04-15 13:27:10', '2022-04-15 13:27:10'),
	(32, 'SUCCESS', 'Enregistrement de la sociète SocieteTata avec succes dans le système.', '127.0.0.1', 1, '2022-04-15 13:27:59', '2022-04-15 13:27:59'),
	(33, 'SUCCESS', 'Suppression de la sociète SocieteTata dans le système', '127.0.0.1', 1, '2022-04-15 13:35:57', '2022-04-15 13:35:57'),
	(34, 'SUCCESS', 'Enregistrement de la marque Nissan avec succes dans le système.', '127.0.0.1', 1, '2022-04-15 13:37:11', '2022-04-15 13:37:11'),
	(35, 'SUCCESS', 'Enregistrement du modele Juke avec succes dans le système.', '127.0.0.1', 1, '2022-04-15 13:37:32', '2022-04-15 13:37:32'),
	(36, 'SUCCESS', 'Enregistrement du modele Rogue avec succes dans le système.', '127.0.0.1', 1, '2022-04-15 13:37:45', '2022-04-15 13:37:45'),
	(37, 'SUCCESS', 'Enregistrement du modele Almera avec succes dans le système.', '127.0.0.1', 1, '2022-04-15 13:38:11', '2022-04-15 13:38:11'),
	(39, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:00:46', '2022-04-16 22:00:46'),
	(40, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:03:18', '2022-04-16 22:03:18'),
	(41, 'SUCCESS', 'Enregistrement de la marque dhgdhjgd avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:05:45', '2022-04-16 22:05:45'),
	(42, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:06:18', '2022-04-16 22:06:18'),
	(43, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:26:06', '2022-04-16 22:26:06'),
	(44, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:28:51', '2022-04-16 22:28:51'),
	(45, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:32:01', '2022-04-16 22:32:01'),
	(46, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:34:23', '2022-04-16 22:34:23'),
	(47, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:35:30', '2022-04-16 22:35:30'),
	(48, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 22:56:35', '2022-04-16 22:56:35'),
	(49, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:10:04', '2022-04-16 23:10:04'),
	(50, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:14:16', '2022-04-16 23:14:16'),
	(51, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:15:29', '2022-04-16 23:15:29'),
	(52, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:19:22', '2022-04-16 23:19:22'),
	(53, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:20:39', '2022-04-16 23:20:39'),
	(54, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:22:48', '2022-04-16 23:22:48'),
	(55, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:25:20', '2022-04-16 23:25:20'),
	(56, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:26:36', '2022-04-16 23:26:36'),
	(57, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:28:08', '2022-04-16 23:28:08'),
	(58, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:40:21', '2022-04-16 23:40:21'),
	(59, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:42:52', '2022-04-16 23:42:52'),
	(60, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:54:38', '2022-04-16 23:54:38'),
	(61, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-16 23:56:34', '2022-04-16 23:56:34'),
	(62, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 00:03:18', '2022-04-17 00:03:18'),
	(63, 'SUCCESS', 'Suppression de l\'image de la voiture dans le système', '127.0.0.1', 1, '2022-04-17 00:32:53', '2022-04-17 00:32:53'),
	(64, 'SUCCESS', 'Suppression de l\'image de la voiture dans le système', '127.0.0.1', 1, '2022-04-17 00:33:08', '2022-04-17 00:33:08'),
	(65, 'SUCCESS', 'Suppression de l\'image de la voiture dans le système', '127.0.0.1', 1, '2022-04-17 00:33:32', '2022-04-17 00:33:32'),
	(66, 'SUCCESS', 'Suppression de l\'image de la voiture dans le système', '127.0.0.1', 1, '2022-04-17 00:33:40', '2022-04-17 00:33:40'),
	(67, 'SUCCESS', 'Enregistrement de la marque mhghg avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:08:10', '2022-04-17 01:08:10'),
	(68, 'SUCCESS', 'Suppression de la marque dhgdhjgd dans le système', '127.0.0.1', 1, '2022-04-17 01:09:39', '2022-04-17 01:09:39'),
	(69, 'SUCCESS', 'Suppression de la marque mhghg dans le système', '127.0.0.1', 1, '2022-04-17 01:09:47', '2022-04-17 01:09:47'),
	(70, 'SUCCESS', 'Enregistrement de la marque hghjggkj avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:09:59', '2022-04-17 01:09:59'),
	(71, 'SUCCESS', 'Enregistrement de la marque okljhgvtb avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:11:28', '2022-04-17 01:11:28'),
	(72, 'SUCCESS', 'Suppression de la marque hghjggkj dans le système', '127.0.0.1', 1, '2022-04-17 01:13:22', '2022-04-17 01:13:22'),
	(73, 'SUCCESS', 'Suppression de la marque okljhgvtb dans le système', '127.0.0.1', 1, '2022-04-17 01:13:35', '2022-04-17 01:13:35'),
	(74, 'SUCCESS', 'Mise à jour de la marque Kiass avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:16:22', '2022-04-17 01:16:22'),
	(75, 'SUCCESS', 'Mise à jour de la marque Kia avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:16:42', '2022-04-17 01:16:42'),
	(76, 'SUCCESS', 'Mise à jour de la marque Kia avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:16:44', '2022-04-17 01:16:44'),
	(86, 'SUCCESS', 'Enregistrement de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:49:15', '2022-04-17 01:49:15'),
	(87, 'SUCCESS', 'Mise à jour de la voiture Toyota Avensis avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:53:47', '2022-04-17 01:53:47'),
	(88, 'SUCCESS', 'Mise à jour de la voiture Toyota Avensis avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 01:59:02', '2022-04-17 01:59:02'),
	(94, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 16:02:50', '2022-04-17 16:02:50'),
	(96, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 16:27:17', '2022-04-17 16:27:17'),
	(99, 'SUCCESS', 'Mise à jour de la voiture Toyota Avensis avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 16:59:10', '2022-04-17 16:59:10'),
	(100, 'SUCCESS', 'Mise à jour de la voiture Toyota Avensis avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 16:59:42', '2022-04-17 16:59:42'),
	(101, 'SUCCESS', 'Suppression du parc Toto dans le système', '127.0.0.1', 1, '2022-04-17 17:05:31', '2022-04-17 17:05:31'),
	(102, 'SUCCESS', 'Enregistrement de la marque klusfuey avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 17:08:31', '2022-04-17 17:08:31'),
	(103, 'SUCCESS', 'Mise à jour de la marque klusfueyssss avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 17:08:47', '2022-04-17 17:08:47'),
	(104, 'SUCCESS', 'Suppression de la marque klusfueyssss dans le système', '127.0.0.1', 1, '2022-04-17 17:08:54', '2022-04-17 17:08:54'),
	(105, 'SUCCESS', 'Enregistrement du modele Carina 3001 avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 17:09:14', '2022-04-17 17:09:14'),
	(106, 'SUCCESS', 'Mise à jour du modele Carina 3001 avec succes dans le système.', '127.0.0.1', 1, '2022-04-17 17:09:24', '2022-04-17 17:09:24'),
	(107, 'SUCCESS', 'Suppression du modele Carina 3001 dans le système', '127.0.0.1', 1, '2022-04-17 17:09:33', '2022-04-17 17:09:33'),
	(108, 'SUCCESS', 'Enregistrement du client Sossou Gato avec succes dans le système.', '127.0.0.1', 4, '2022-04-17 18:31:43', '2022-04-17 18:31:43'),
	(110, 'SUCCESS', 'Enregistrement du client Tchalla Olivier avec succes dans le système.', '127.0.0.1', 6, '2022-04-18 12:58:44', '2022-04-18 12:58:44'),
	(111, 'SUCCESS', 'Enregistrement du client Bagou Gracia avec succes dans le système.', '127.0.0.1', 7, '2022-04-18 13:08:58', '2022-04-18 13:08:58'),
	(112, 'SUCCESS', 'Suppression de l\'image de la voiture dans le système', '127.0.0.1', 1, '2022-04-19 11:47:35', '2022-04-19 11:47:35'),
	(113, 'SUCCESS', 'Enregistrement du client Zontodji cornelus avec succes dans le système.', '127.0.0.1', 8, '2022-04-20 21:31:12', '2022-04-20 21:31:12'),
	(114, 'SUCCESS', 'Enregistrement du client Tchalladdd Olivier avec succes dans le système.', '127.0.0.1', 6, '2022-04-20 22:26:14', '2022-04-20 22:26:14'),
	(115, 'SUCCESS', 'Enregistrement du client Tchalla Olivier avec succes dans le système.', '127.0.0.1', 6, '2022-04-20 22:27:04', '2022-04-20 22:27:04'),
	(116, 'SUCCESS', 'Mise à jour du mot de passe du client Tchalla Olivier avec succes dans le système.', '127.0.0.1', 6, '2022-04-20 22:58:51', '2022-04-20 22:58:51'),
	(117, 'SUCCESS', 'Mise à jour du client Tchalla Olivier avec succes dans le système.', '127.0.0.1', 6, '2022-04-20 23:07:52', '2022-04-20 23:07:52'),
	(118, 'SUCCESS', 'Mise à jour du client Tchalla Olivier avec succes dans le système.', '127.0.0.1', 6, '2022-04-20 23:31:26', '2022-04-20 23:31:26'),
	(119, 'SUCCESS', 'Enregistrement du client Dacey Daniel avec succes dans le système.', '127.0.0.1', 9, '2022-04-21 10:57:44', '2022-04-21 10:57:44'),
	(120, 'SUCCESS', 'Suppression du client Kothor Evelyne dans le système', '127.0.0.1', 1, '2022-04-21 11:24:47', '2022-04-21 11:24:47'),
	(121, 'SUCCESS', 'Mise à jour du client Bagou Gracia avec succes dans le système.', '127.0.0.1', 1, '2022-04-21 11:41:48', '2022-04-21 11:41:48'),
	(122, 'SUCCESS', 'Suppression du gestionnaire Kothor Axel dans le système', '127.0.0.1', 1, '2022-04-21 13:21:19', '2022-04-21 13:21:19'),
	(123, 'SUCCESS', 'Mise à jour du gestionnaire Fondey Omar avec succes dans le système.', '127.0.0.1', 1, '2022-04-21 13:23:07', '2022-04-21 13:23:07'),
	(124, 'SUCCESS', 'Mise à jour du gestionnaire Fondey Omar avec succes dans le système.', '127.0.0.1', 1, '2022-04-21 13:23:53', '2022-04-21 13:23:53'),
	(125, 'SUCCESS', 'Mise à jour du gestionnaire Fondey Omar avec succes dans le système.', '127.0.0.1', 1, '2022-04-21 14:12:29', '2022-04-21 14:12:29'),
	(126, 'SUCCESS', 'Mise à jour du gestionnaire Fondey Omar avec succes dans le système.', '127.0.0.1', 1, '2022-04-21 14:12:40', '2022-04-21 14:12:40'),
	(127, 'SUCCESS', 'Mise à jour de l\'admin Kothor Claude avec succes dans le système.', '127.0.0.1', 1, '2022-04-21 15:12:32', '2022-04-21 15:12:32'),
	(128, 'SUCCESS', 'Mise à jour de l\'admin Kothor Claude avec succes dans le système.', '127.0.0.1', 1, '2022-04-21 15:12:43', '2022-04-21 15:12:43'),
	(129, 'SUCCESS', 'Enregistrement de l\'administrateur tata taat avec succes dans le système.', '127.0.0.1', 1, '2022-04-21 15:42:35', '2022-04-21 15:42:35'),
	(130, 'SUCCESS', 'Suppression de l\'administrateur tata taat dans le système', '127.0.0.1', 1, '2022-04-21 15:48:49', '2022-04-21 15:48:49'),
	(131, 'SUCCESS', 'Suppression de la voiture dans le système', '127.0.0.1', 1, '2022-04-22 10:37:17', '2022-04-22 10:37:17'),
	(132, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-22 10:38:03', '2022-04-22 10:38:03'),
	(133, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 13:17:45', '2022-04-22 13:17:45'),
	(134, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 13:19:33', '2022-04-22 13:19:33'),
	(135, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 13:25:59', '2022-04-22 13:25:59'),
	(136, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 14:09:59', '2022-04-22 14:09:59'),
	(137, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 14:11:16', '2022-04-22 14:11:16'),
	(138, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 14:11:52', '2022-04-22 14:11:52'),
	(139, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 14:19:52', '2022-04-22 14:19:52'),
	(140, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 14:36:24', '2022-04-22 14:36:24'),
	(141, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-22 14:38:53', '2022-04-22 14:38:53'),
	(142, 'SUCCESS', 'Enregistrement du client Koglo Jacques avec succes dans le système.', '127.0.0.1', 11, '2022-04-22 18:04:11', '2022-04-22 18:04:11'),
	(143, 'SUCCESS', 'Mise à jour du client Koglos Jacques avec succes dans le système.', '127.0.0.1', 11, '2022-04-22 18:31:08', '2022-04-22 18:31:08'),
	(144, 'SUCCESS', 'Mise à jour du client Koglos Jacques avec succes dans le système.', '127.0.0.1', 11, '2022-04-22 18:32:19', '2022-04-22 18:32:19'),
	(145, 'SUCCESS', 'Mise à jour du client Koglos Jacques avec succes dans le système.', '127.0.0.1', 11, '2022-04-22 18:33:32', '2022-04-22 18:33:32'),
	(146, 'SUCCESS', 'Mise à jour du client Bagou Gracia avec succes dans le système.', '127.0.0.1', 1, '2022-04-22 18:43:09', '2022-04-22 18:43:09'),
	(147, 'SUCCESS', 'Enregistrement de la facture avec succes dans le système.', '127.0.0.1', 1, '2022-04-22 20:22:24', '2022-04-22 20:22:24'),
	(148, 'SUCCESS', 'Annulation de la reservation avec succes dans le système.', '127.0.0.1', 1, '2022-04-23 18:35:27', '2022-04-23 18:35:27'),
	(149, 'SUCCESS', 'Enregistrement de la facture avec succes dans le système.', '127.0.0.1', 1, '2022-04-23 19:35:17', '2022-04-23 19:35:17'),
	(150, 'SUCCESS', 'Mise à jour de la facture avec succes dans le système.', '127.0.0.1', 1, '2022-04-23 19:59:29', '2022-04-23 19:59:29'),
	(151, 'SUCCESS', 'Suppression de l\'image de la voiture dans le système', '127.0.0.1', 1, '2022-04-24 18:29:06', '2022-04-24 18:29:06'),
	(152, 'SUCCESS', 'Suppression de l\'image de la voiture dans le système', '127.0.0.1', 1, '2022-04-24 18:29:16', '2022-04-24 18:29:16'),
	(153, 'SUCCESS', 'Mise à jour de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-24 18:44:48', '2022-04-24 18:44:48'),
	(154, 'SUCCESS', 'Mise à jour de l\'admin Kothorss Claude avec succes dans le système.', '127.0.0.1', 1, '2022-04-24 20:39:27', '2022-04-24 20:39:27'),
	(155, 'SUCCESS', 'Mise à jour de l\'admin Kothor Claude avec succes dans le système.', '127.0.0.1', 1, '2022-04-24 20:39:39', '2022-04-24 20:39:39'),
	(156, 'SUCCESS', 'Mise à jour de l\'admin Kothor Claude avec succes dans le système.', '127.0.0.1', 1, '2022-04-24 20:43:02', '2022-04-24 20:43:02'),
	(157, 'SUCCESS', 'Mise à jour de l\'admin Kothor Claude avec succes dans le système.', '127.0.0.1', 1, '2022-04-24 20:43:51', '2022-04-24 20:43:51'),
	(158, 'SUCCESS', 'Mise à jour du mot de passe du client Kothor Claude avec succes dans le système.', '127.0.0.1', NULL, '2022-04-24 20:53:35', '2022-04-24 20:53:35'),
	(159, 'SUCCESS', 'Mise à jour du mot de passe du client Kothor Claude avec succes dans le système.', '127.0.0.1', NULL, '2022-04-24 20:55:42', '2022-04-24 20:55:42'),
	(160, 'SUCCESS', 'Mise à jour du mot de passe du client Kothor Claude avec succes dans le système.', '127.0.0.1', NULL, '2022-04-24 20:59:20', '2022-04-24 20:59:20'),
	(161, 'SUCCESS', 'Mise à jour du gestionnaire Fondeys Omars avec succes dans le système.', '127.0.0.1', 3, '2022-04-24 21:46:30', '2022-04-24 21:46:30'),
	(162, 'SUCCESS', 'Mise à jour du gestionnaire Fondey Omar avec succes dans le système.', '127.0.0.1', 3, '2022-04-24 21:46:47', '2022-04-24 21:46:47'),
	(163, 'SUCCESS', 'Mise à jour du mot de passe du client Fondey Omar avec succes dans le système.', '127.0.0.1', NULL, '2022-04-24 21:48:50', '2022-04-24 21:48:50'),
	(164, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 3, '2022-04-24 22:00:20', '2022-04-24 22:00:20'),
	(165, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 1, '2022-04-24 22:05:36', '2022-04-24 22:05:36'),
	(166, 'SUCCESS', 'Enregistrement de l\'image de la voiture avec succes dans le système.', '127.0.0.1', 3, '2022-04-24 22:06:32', '2022-04-24 22:06:32'),
	(167, 'SUCCESS', 'Mise à jour de la voiture avec succes dans le système.', '127.0.0.1', 3, '2022-04-24 22:17:13', '2022-04-24 22:17:13'),
	(168, 'SUCCESS', 'Suppression de l\'image de la voiture dans le système', '127.0.0.1', 3, '2022-04-24 22:20:55', '2022-04-24 22:20:55'),
	(169, 'SUCCESS', 'Mise à jour de la voiture Toyota Avensis avec succes dans le système.', '127.0.0.1', 1, '2022-04-25 01:19:41', '2022-04-25 01:19:41'),
	(170, 'SUCCESS', 'Mise à jour de la voiture Toyota Carina 3 avec succes dans le système.', '127.0.0.1', 3, '2022-04-25 01:44:42', '2022-04-25 01:44:42'),
	(171, 'SUCCESS', 'Mise à jour de la voiture Bmw E46 avec succes dans le système.', '127.0.0.1', 1, '2022-04-25 01:48:51', '2022-04-25 01:48:51'),
	(172, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-25 11:24:02', '2022-04-25 11:24:02'),
	(173, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-25 11:30:29', '2022-04-25 11:30:29'),
	(174, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 16:20:51', '2022-04-26 16:20:51'),
	(175, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 16:31:42', '2022-04-26 16:31:42'),
	(176, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 17:40:51', '2022-04-26 17:40:51'),
	(177, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 17:42:33', '2022-04-26 17:42:33'),
	(178, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 18:05:16', '2022-04-26 18:05:16'),
	(179, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 18:12:27', '2022-04-26 18:12:27'),
	(180, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 18:14:36', '2022-04-26 18:14:36'),
	(181, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 18:15:47', '2022-04-26 18:15:47'),
	(182, 'SUCCESS', 'Enregistrement de la reservation avec succes dans le système.', '127.0.0.1', 6, '2022-04-26 18:16:22', '2022-04-26 18:16:22'),
	(183, 'SUCCESS', 'Enregistrement de la facture avec succes dans le système.', '127.0.0.1', 1, '2022-04-26 19:05:55', '2022-04-26 19:05:55'),
	(184, 'SUCCESS', 'Reinitialisation de mot de passe de \'utilisateur Kothor Claude avec succes dans le système.', '127.0.0.1', NULL, '2022-04-26 20:18:33', '2022-04-26 20:18:33');
/*!40000 ALTER TABLE `syslogs` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix_user` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles_user` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_user` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays_user` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville_user` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quartier_user` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_user` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'assets/img/user.jpg',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_code_user_unique` (`code_user`),
  UNIQUE KEY `users_email_user_unique` (`email_user`),
  UNIQUE KEY `users_telephone_user_unique` (`telephone_user`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.users : ~8 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `code_user`, `nom_user`, `prenom_user`, `email_user`, `telephone_user`, `prefix_user`, `adresse_user`, `roles_user`, `status_user`, `email_verified_at`, `password`, `pays_user`, `ville_user`, `quartier_user`, `avatar_user`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'ADM-745263', 'Kothor', 'Claude', 'ckothor7@gmail.com', '70662316', '228', 'Agoe', 'A03', 1, NULL, '$2y$10$CtPc2lYMBNifuzDln0lk0.dwMW2iCFlPjW087Vdlued6YMtPFDTmO', 'Togo', 'Lome', 'Agoe', '/storage/uploads/1650833031.png', NULL, '2022-04-14 15:00:58', '2022-04-26 20:20:06'),
	(3, 'GES-669035', 'Fondey', 'Omar', 'omar@gmail.com', '99961005', '228', 'Agoe Kleves', 'G02', 1, NULL, '$2y$10$Ovv6Xe/0jd3KJEw05ov/huHewbl702hm22H/x8mUPIH5t5/rRwJTC', 'Togo', NULL, NULL, '/storage/uploads/1650836806.jpg', NULL, '2022-04-14 19:08:41', '2022-04-24 21:48:49'),
	(4, 'CLI-630842', 'Sossou', 'Gato', 'sossou@gmail.com', '98526341', '228', 'Agoe Telessou', 'C01', 1, NULL, '$2y$10$aiwaMIVV2RNcnD1PK9wJNuWRfHM5Cj55UgV0eEDZk9YCqgUUanAo2', 'Togo', NULL, NULL, 'assets/img/user.jpg', NULL, '2022-04-17 18:31:43', '2022-04-17 18:31:43'),
	(6, 'CLI-293994', 'Tchalla', 'Olivier', 'olivier@gmail.com', '96851234', '228', 'Agbalepedogan', 'C01', 1, NULL, '$2y$10$5e7GAgVUH8as8iiUBW7HneYBzzioptI6uxRjNeLMwK0RXkeUXiEtG', 'Togo', NULL, NULL, '/storage/uploads/1650497486.jpg', NULL, '2022-04-18 12:58:44', '2022-04-20 23:31:26'),
	(7, 'CLI-096790', 'Bagou', 'Gracia', 'gracia@gmail.com', '96523241', '228', 'Agbalepedogan', 'C01', 1, NULL, '$2y$10$NsylzhZYAHoKeMM/KNiCw.9pNAEHtzl0jMOzCHvut6vZrAdnKtrT2', 'Togo', NULL, NULL, 'assets/img/user.jpg', NULL, '2022-04-18 13:08:58', '2022-04-22 18:43:09'),
	(8, 'CLI-380619', 'Zontodji', 'cornelus', 'cornelus@gmail.com', '96521023', '228', 'Agoe Zongo', 'C01', 1, NULL, '$2y$10$S3aFdzRnhMN/7VR0j7O6T.L8rbSO61o5TgQmNzBNeN09zQECU6PWi', 'Togo', NULL, NULL, 'assets/img/user.jpg', NULL, '2022-04-20 21:31:11', '2022-04-20 21:31:11'),
	(9, 'CLI-859737', 'Dacey', 'Daniel', 'daniel@gmail.com', '98526312', '228', 'Novissi', 'C01', 1, NULL, '$2y$10$YvsKjr8If0bakWM5uYMEV.XXqwhRbC8y9sgYv1B1lrM353bBldST.', 'Togo', NULL, NULL, 'assets/img/user.jpg', NULL, '2022-04-21 10:57:44', '2022-04-21 10:57:44'),
	(11, 'CLI-372298', 'Koglos', 'Jacques', 'jacques@gmail.com', '96853241', '223', 'Bamako', 'C01', 1, NULL, '$2y$10$NSGIBLx7klV0tHcbRLmwKOBsxsS6IYdZ1fL07clnfOgywO3eIbABS', 'Mali', NULL, NULL, 'assets/img/user.jpg', NULL, '2022-04-22 18:04:09', '2022-04-22 18:33:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table cartraderdb. voitures
CREATE TABLE IF NOT EXISTS `voitures` (
  `id_voiture` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_voiture` int(11) NOT NULL DEFAULT '0',
  `kilometrage_voiture` int(11) NOT NULL DEFAULT '0',
  `interieur_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exterieur_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puissance_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbres_place_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_mise_circul_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carburant_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boite_vitesse_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee_voiture` int(11) NOT NULL DEFAULT '0',
  `image_voiture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_voiture` tinyint(1) NOT NULL DEFAULT '1',
  `status_reserver` tinyint(1) NOT NULL DEFAULT '0',
  `status_vente` tinyint(1) NOT NULL DEFAULT '0',
  `marque_id` bigint(20) unsigned NOT NULL,
  `modele_id` bigint(20) unsigned NOT NULL,
  `societe_id` bigint(20) unsigned NOT NULL,
  `parking_id` bigint(20) unsigned NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_voiture`),
  UNIQUE KEY `voitures_code_voiture_unique` (`code_voiture`),
  KEY `voitures_marque_id_foreign` (`marque_id`),
  KEY `voitures_modele_id_foreign` (`modele_id`),
  KEY `voitures_societe_id_foreign` (`societe_id`),
  KEY `voitures_parking_id_foreign` (`parking_id`),
  KEY `voitures_created_by_foreign` (`created_by`),
  CONSTRAINT `voitures_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `voitures_marque_id_foreign` FOREIGN KEY (`marque_id`) REFERENCES `marques` (`id_marque`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `voitures_modele_id_foreign` FOREIGN KEY (`modele_id`) REFERENCES `modeles` (`id_modele`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `voitures_parking_id_foreign` FOREIGN KEY (`parking_id`) REFERENCES `parkings` (`id_parking`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `voitures_societe_id_foreign` FOREIGN KEY (`societe_id`) REFERENCES `societes` (`id_societe`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cartraderdb.voitures : ~4 rows (environ)
/*!40000 ALTER TABLE `voitures` DISABLE KEYS */;
INSERT INTO `voitures` (`id_voiture`, `code_voiture`, `slug_voiture`, `prix_voiture`, `kilometrage_voiture`, `interieur_voiture`, `exterieur_voiture`, `puissance_voiture`, `nbres_place_voiture`, `date_mise_circul_voiture`, `carburant_voiture`, `boite_vitesse_voiture`, `annee_voiture`, `image_voiture`, `status_voiture`, `status_reserver`, `status_vente`, `marque_id`, `modele_id`, `societe_id`, `parking_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'VOITURE-648918', 'toyota-carina-3', 3000000, 14263, 'Tissu noir', 'Noire', '7 CV', '4', '2010-09-01', 'Essence', 'Manuelle', 2008, '/storage/uploads/1649950910.jpg', 1, 0, 0, 1, 1, 3, 3, 1, '2022-04-14 15:41:50', '2022-04-25 01:44:40'),
	(5, 'VOITURE-901089', 'toyota-rav4', 16500000, 11002, 'Tissu noir', 'Noire', '12 CV', '4', '2020-04-07', 'Essence', 'Manuelle', 2015, '/storage/uploads/1649951337.jpg', 1, 0, 0, 1, 5, 1, 2, 1, '2022-04-14 15:48:57', '2022-04-14 15:48:57'),
	(6, 'VOITURE-156868', 'bmw-e46', 28000000, 10256, 'Tissu noir', 'Blanche', '17 CV', '4', '2019-04-07', 'Essence', 'Automatique', 2018, '/storage/uploads/1650851331.jpg', 1, 0, 0, 3, 2, 1, 2, 1, '2022-04-14 15:50:26', '2022-04-25 01:48:51'),
	(7, 'VOITURE-440865', 'toyota-avensis', 7800000, 14236, 'Tissu noir', 'Rouge', '6 CV', '4', '2018-12-28', 'Essence', 'Manuelle', 2012, '/storage/uploads/1650210091.jpg', 1, 0, 0, 1, 3, 1, 2, 1, '2022-04-17 01:49:15', '2022-04-25 01:19:40');
/*!40000 ALTER TABLE `voitures` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
