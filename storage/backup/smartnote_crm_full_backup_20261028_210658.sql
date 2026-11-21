-- Database Backup: smartnote_crm
-- Date: 2026-10-28 21:06:58

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sign` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cgst` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sgst` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `companies` (`id`, `name`, `gst_no`, `pan_no`, `email`, `contact`, `address`, `sign`, `bank_info`, `cgst`, `sgst`, `extra_info`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'DHYANI IMPEX', '24ABAFP6884C1Z9', 'AQOPT0852B', 'devharshadkumar@gmail.com', '9099333633', 'E-102, FIRST FLOOR, Happyness Residency , BEHIND SHRUSHTI
ROW HOUSE, Surat
Surat, GUJARAT, 394107', '17231287013.jpg', '{\"bank_name\":\"Kotak Mahindra Bank\",\"account_no\":\"222222222\",\"ifsc_code\":\"KKBK0002849\",\"branch\":\"Katargam Branch\"}', '0.75', '0.75', NULL, '0', '2024-08-08 20:21:41', '2024-08-08 20:28:40');

DROP TABLE IF EXISTS `dailies`;
CREATE TABLE `dailies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dimonds_id` bigint(20) unsigned NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dailies_dimonds_id_index` (`dimonds_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dailies` (`id`, `dimonds_id`, `barcode`, `stage`, `status`, `created_at`, `updated_at`) VALUES ('8', '6', '7745450641', 'Done', '1', '2024-01-12 17:09:47', '2024-02-06 16:02:18');
INSERT INTO `dailies` (`id`, `dimonds_id`, `barcode`, `stage`, `status`, `created_at`, `updated_at`) VALUES ('9', '7', '5926227741', 'No', '0', '2024-01-12 17:09:58', '2024-01-13 09:03:00');
INSERT INTO `dailies` (`id`, `dimonds_id`, `barcode`, `stage`, `status`, `created_at`, `updated_at`) VALUES ('10', '9', '4311277637', 'No', '0', '2024-01-12 18:50:20', '2024-01-21 16:01:37');
INSERT INTO `dailies` (`id`, `dimonds_id`, `barcode`, `stage`, `status`, `created_at`, `updated_at`) VALUES ('15', '20', '7332488301', 'No', '0', '2025-03-03 23:21:33', '2025-03-03 23:21:33');
INSERT INTO `dailies` (`id`, `dimonds_id`, `barcode`, `stage`, `status`, `created_at`, `updated_at`) VALUES ('16', '21', '7552532152', 'No', '0', '2025-03-03 23:58:16', '2025-03-03 23:58:16');

DROP TABLE IF EXISTS `designations`;
CREATE TABLE `designations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate_apply_on` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'issue_weight',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `designations` (`id`, `name`, `category`, `rate_apply_on`, `created_at`, `updated_at`) VALUES ('2', 'Maxy', 'Inner', 'issue_weight', '2023-12-16 11:00:56', '2024-08-08 17:19:15');
INSERT INTO `designations` (`id`, `name`, `category`, `rate_apply_on`, `created_at`, `updated_at`) VALUES ('3', 'Blocking', 'Inner', 'issue_weight', '2023-12-16 11:01:07', '2023-12-16 11:46:05');
INSERT INTO `designations` (`id`, `name`, `category`, `rate_apply_on`, `created_at`, `updated_at`) VALUES ('4', 'Dhar', 'Inner', 'diff_weight', '2023-12-16 11:01:15', '2024-08-08 17:25:43');
INSERT INTO `designations` (`id`, `name`, `category`, `rate_apply_on`, `created_at`, `updated_at`) VALUES ('5', 'Polish', 'Inner', 'issue_weight', '2023-12-16 11:01:46', '2023-12-16 11:01:46');
INSERT INTO `designations` (`id`, `name`, `category`, `rate_apply_on`, `created_at`, `updated_at`) VALUES ('6', 'Grading', 'Inner', 'issue_weight', '2023-12-16 11:01:56', '2023-12-16 11:01:56');
INSERT INTO `designations` (`id`, `name`, `category`, `rate_apply_on`, `created_at`, `updated_at`) VALUES ('10', 'HPHT', 'Outter', 'issue_weight', '2024-01-08 16:04:29', '2024-01-08 17:14:06');
INSERT INTO `designations` (`id`, `name`, `category`, `rate_apply_on`, `created_at`, `updated_at`) VALUES ('11', 'discus', 'Outter', 'issue_weight', '2024-01-08 17:14:35', '2024-01-08 17:14:35');
INSERT INTO `designations` (`id`, `name`, `category`, `rate_apply_on`, `created_at`, `updated_at`) VALUES ('12', 'GHISHI', 'Outter', 'issue_weight', '2024-01-08 17:16:00', '2024-01-08 17:16:00');

DROP TABLE IF EXISTS `dimonds`;
CREATE TABLE `dimonds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parties_id` bigint(20) unsigned NOT NULL,
  `dimond_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `janger_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shape` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clarity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `polish` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symmetry` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delevery_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dimonds_parties_id_index` (`parties_id`),
  CONSTRAINT `dimonds_parties_id_foreign` FOREIGN KEY (`parties_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dimonds` (`id`, `parties_id`, `dimond_name`, `janger_no`, `shape`, `weight`, `required_weight`, `clarity`, `color`, `cut`, `polish`, `symmetry`, `barcode`, `barcode_number`, `status`, `amount`, `delevery_date`, `created_at`, `updated_at`) VALUES ('20', '4', 'CS 2', 'janger-number-1', 'Modifiy', '20', '15', 'FL', 'D', 'EX', 'EX', 'EX', '<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"100\" height=\"100\" viewBox=\"0 0 100 100\"><rect x=\"0\" y=\"0\" width=\"100\" height=\"100\" fill=\"#ffffff\"/><g transform=\"scale(3.448)\"><g transform=\"translate(0,0)\"><path fill-rule=\"evenodd\" d=\"M12 0L12 1L14 1L14 0ZM16 0L16 1L15 1L15 2L17 2L17 0ZM18 0L18 2L19 2L19 4L18 4L18 3L13 3L13 2L12 2L12 3L13 3L13 4L11 4L11 3L8 3L8 4L9 4L9 5L8 5L8 7L9 7L9 8L6 8L6 9L7 9L7 10L5 10L5 8L0 8L0 9L3 9L3 10L2 10L2 11L1 11L1 10L0 10L0 13L1 13L1 12L2 12L2 14L1 14L1 15L0 15L0 16L1 16L1 17L0 17L0 21L1 21L1 18L2 18L2 21L3 21L3 17L4 17L4 18L5 18L5 19L4 19L4 21L8 21L8 23L9 23L9 22L12 22L12 23L14 23L14 24L13 24L13 25L11 25L11 23L10 23L10 24L8 24L8 29L10 29L10 28L9 28L9 26L10 26L10 27L11 27L11 28L13 28L13 29L14 29L14 28L16 28L16 27L17 27L17 25L18 25L18 26L19 26L19 25L18 25L18 24L17 24L17 23L18 23L18 22L19 22L19 23L20 23L20 27L18 27L18 28L17 28L17 29L18 29L18 28L22 28L22 27L23 27L23 26L24 26L24 27L26 27L26 26L24 26L24 25L28 25L28 26L27 26L27 28L24 28L24 29L27 29L27 28L28 28L28 26L29 26L29 25L28 25L28 24L29 24L29 23L27 23L27 22L29 22L29 20L28 20L28 19L27 19L27 16L28 16L28 15L27 15L27 12L28 12L28 11L27 11L27 12L25 12L25 9L26 9L26 8L25 8L25 9L24 9L24 8L23 8L23 9L22 9L22 8L20 8L20 9L18 9L18 8L19 8L19 6L18 6L18 8L17 8L17 4L18 4L18 5L20 5L20 3L21 3L21 0ZM8 1L8 2L9 2L9 1ZM10 1L10 2L11 2L11 1ZM19 1L19 2L20 2L20 1ZM10 4L10 6L9 6L9 7L10 7L10 6L11 6L11 8L10 8L10 9L9 9L9 10L7 10L7 11L6 11L6 12L8 12L8 11L9 11L9 12L11 12L11 13L10 13L10 14L9 14L9 13L5 13L5 10L3 10L3 16L4 16L4 17L5 17L5 18L7 18L7 19L5 19L5 20L8 20L8 21L9 21L9 20L12 20L12 21L13 21L13 22L14 22L14 23L15 23L15 22L16 22L16 21L17 21L17 20L18 20L18 19L19 19L19 20L21 20L21 19L22 19L22 18L21 18L21 17L20 17L20 16L21 16L21 14L22 14L22 17L23 17L23 18L24 18L24 19L25 19L25 21L26 21L26 20L27 20L27 19L25 19L25 18L24 18L24 17L26 17L26 16L27 16L27 15L26 15L26 13L25 13L25 12L24 12L24 9L23 9L23 12L22 12L22 13L20 13L20 12L21 12L21 11L22 11L22 10L21 10L21 9L20 9L20 10L17 10L17 8L16 8L16 6L15 6L15 10L16 10L16 11L17 11L17 12L16 12L16 13L15 13L15 12L14 12L14 11L13 11L13 10L14 10L14 9L13 9L13 8L14 8L14 6L13 6L13 8L12 8L12 5L11 5L11 4ZM14 4L14 5L16 5L16 4ZM20 6L20 7L21 7L21 6ZM27 8L27 9L28 9L28 10L29 10L29 9L28 9L28 8ZM10 9L10 11L11 11L11 12L13 12L13 13L11 13L11 14L10 14L10 15L11 15L11 14L12 14L12 16L11 16L11 18L12 18L12 20L13 20L13 21L14 21L14 22L15 22L15 21L14 21L14 20L15 20L15 19L16 19L16 20L17 20L17 19L18 19L18 18L20 18L20 17L18 17L18 16L17 16L17 15L16 15L16 14L18 14L18 15L19 15L19 14L20 14L20 13L18 13L18 12L17 12L17 13L16 13L16 14L14 14L14 12L13 12L13 11L11 11L11 10L13 10L13 9ZM23 12L23 13L22 13L22 14L23 14L23 13L24 13L24 14L25 14L25 13L24 13L24 12ZM4 13L4 15L5 15L5 17L8 17L8 16L6 16L6 15L7 15L7 14L6 14L6 15L5 15L5 13ZM28 13L28 14L29 14L29 13ZM8 14L8 15L9 15L9 14ZM13 15L13 16L12 16L12 17L13 17L13 18L14 18L14 17L15 17L15 18L16 18L16 17L17 17L17 16L16 16L16 15L15 15L15 16L14 16L14 15ZM23 15L23 16L24 16L24 15ZM9 16L9 17L10 17L10 16ZM13 16L13 17L14 17L14 16ZM28 17L28 18L29 18L29 17ZM8 18L8 19L9 19L9 18ZM13 19L13 20L14 20L14 19ZM21 21L21 24L24 24L24 21ZM22 22L22 23L23 23L23 22ZM25 23L25 24L27 24L27 23ZM14 24L14 25L13 25L13 26L14 26L14 27L13 27L13 28L14 28L14 27L15 27L15 26L16 26L16 25L17 25L17 24ZM10 25L10 26L11 26L11 27L12 27L12 26L11 26L11 25ZM14 25L14 26L15 26L15 25ZM22 25L22 26L21 26L21 27L22 27L22 26L23 26L23 25ZM0 0L0 7L7 7L7 0ZM1 1L1 6L6 6L6 1ZM2 2L2 5L5 5L5 2ZM22 0L22 7L29 7L29 0ZM23 1L23 6L28 6L28 1ZM24 2L24 5L27 5L27 2ZM0 22L0 29L7 29L7 22ZM1 23L1 28L6 28L6 23ZM2 24L2 27L5 27L5 24Z\" fill=\"#000000\"/></g></g></svg>
', '7332488301', 'Processing', NULL, NULL, '2025-03-03 23:21:33', '2025-03-03 23:21:46');
INSERT INTO `dimonds` (`id`, `parties_id`, `dimond_name`, `janger_no`, `shape`, `weight`, `required_weight`, `clarity`, `color`, `cut`, `polish`, `symmetry`, `barcode`, `barcode_number`, `status`, `amount`, `delevery_date`, `created_at`, `updated_at`) VALUES ('21', '4', '1254asd', 'pqrs-test', 'Modifiy', '15', '13', 'FL', 'D', 'EX', 'EX', 'EX', '<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"100\" height=\"100\" viewBox=\"0 0 100 100\"><rect x=\"0\" y=\"0\" width=\"100\" height=\"100\" fill=\"#ffffff\"/><g transform=\"scale(3.448)\"><g transform=\"translate(0,0)\"><path fill-rule=\"evenodd\" d=\"M12 0L12 2L11 2L11 1L10 1L10 2L11 2L11 3L8 3L8 4L9 4L9 5L8 5L8 7L9 7L9 8L6 8L6 9L5 9L5 8L0 8L0 10L1 10L1 11L2 11L2 9L4 9L4 10L3 10L3 13L2 13L2 14L1 14L1 13L0 13L0 14L1 14L1 15L2 15L2 14L3 14L3 13L4 13L4 15L3 15L3 16L4 16L4 15L5 15L5 14L6 14L6 15L7 15L7 16L5 16L5 17L4 17L4 18L2 18L2 17L1 17L1 16L0 16L0 21L1 21L1 18L2 18L2 19L5 19L5 20L3 20L3 21L8 21L8 23L9 23L9 21L10 21L10 22L13 22L13 21L14 21L14 24L13 24L13 25L11 25L11 24L10 24L10 26L12 26L12 27L10 27L10 28L9 28L9 24L8 24L8 29L10 29L10 28L13 28L13 29L14 29L14 28L16 28L16 27L17 27L17 25L18 25L18 26L19 26L19 25L18 25L18 24L17 24L17 23L18 23L18 22L19 22L19 23L20 23L20 27L18 27L18 28L17 28L17 29L18 29L18 28L22 28L22 27L23 27L23 26L24 26L24 27L26 27L26 26L24 26L24 25L28 25L28 26L27 26L27 28L24 28L24 29L27 29L27 28L28 28L28 26L29 26L29 25L28 25L28 24L29 24L29 23L27 23L27 22L29 22L29 20L28 20L28 19L27 19L27 16L28 16L28 15L27 15L27 12L28 12L28 11L27 11L27 12L25 12L25 9L26 9L26 8L25 8L25 9L24 9L24 8L23 8L23 9L22 9L22 8L20 8L20 9L18 9L18 8L19 8L19 6L18 6L18 8L17 8L17 4L18 4L18 5L20 5L20 3L21 3L21 0L18 0L18 2L19 2L19 4L18 4L18 3L13 3L13 1L14 1L14 0ZM16 0L16 1L15 1L15 2L17 2L17 0ZM8 1L8 2L9 2L9 1ZM19 1L19 2L20 2L20 1ZM11 3L11 4L10 4L10 6L9 6L9 7L10 7L10 6L11 6L11 8L10 8L10 9L8 9L8 10L9 10L9 12L7 12L7 11L4 11L4 12L7 12L7 13L6 13L6 14L7 14L7 15L9 15L9 14L11 14L11 15L10 15L10 16L11 16L11 17L9 17L9 16L7 16L7 17L6 17L6 18L8 18L8 17L9 17L9 18L11 18L11 19L13 19L13 20L11 20L11 21L13 21L13 20L14 20L14 21L15 21L15 22L16 22L16 21L17 21L17 20L18 20L18 19L19 19L19 20L21 20L21 19L22 19L22 18L21 18L21 17L20 17L20 16L21 16L21 14L22 14L22 17L23 17L23 18L24 18L24 19L25 19L25 21L26 21L26 20L27 20L27 19L25 19L25 18L24 18L24 17L26 17L26 16L27 16L27 15L26 15L26 13L25 13L25 12L24 12L24 9L23 9L23 12L22 12L22 13L20 13L20 12L21 12L21 11L22 11L22 10L21 10L21 9L20 9L20 10L17 10L17 8L16 8L16 6L15 6L15 10L16 10L16 11L17 11L17 12L16 12L16 13L15 13L15 12L14 12L14 11L13 11L13 10L14 10L14 9L13 9L13 8L14 8L14 6L13 6L13 5L11 5L11 4L13 4L13 3ZM14 4L14 5L16 5L16 4ZM12 6L12 7L13 7L13 6ZM20 6L20 7L21 7L21 6ZM27 8L27 9L28 9L28 10L29 10L29 9L28 9L28 8ZM6 9L6 10L7 10L7 9ZM10 9L10 11L11 11L11 10L13 10L13 9ZM12 11L12 12L13 12L13 13L11 13L11 12L9 12L9 13L7 13L7 14L9 14L9 13L11 13L11 14L12 14L12 15L11 15L11 16L13 16L13 17L11 17L11 18L13 18L13 19L14 19L14 20L15 20L15 19L16 19L16 20L17 20L17 19L18 19L18 18L20 18L20 17L18 17L18 16L17 16L17 15L16 15L16 14L18 14L18 15L19 15L19 14L20 14L20 13L18 13L18 12L17 12L17 13L16 13L16 14L14 14L14 12L13 12L13 11ZM23 12L23 13L22 13L22 14L23 14L23 13L24 13L24 14L25 14L25 13L24 13L24 12ZM28 13L28 14L29 14L29 13ZM13 15L13 16L14 16L14 17L13 17L13 18L14 18L14 17L15 17L15 18L16 18L16 17L17 17L17 16L16 16L16 15L15 15L15 16L14 16L14 15ZM23 15L23 16L24 16L24 15ZM28 17L28 18L29 18L29 17ZM6 19L6 20L8 20L8 19ZM9 19L9 20L10 20L10 19ZM21 21L21 24L24 24L24 21ZM22 22L22 23L23 23L23 22ZM25 23L25 24L27 24L27 23ZM14 24L14 25L13 25L13 28L14 28L14 25L15 25L15 26L16 26L16 25L17 25L17 24ZM22 25L22 26L21 26L21 27L22 27L22 26L23 26L23 25ZM0 0L0 7L7 7L7 0ZM1 1L1 6L6 6L6 1ZM2 2L2 5L5 5L5 2ZM22 0L22 7L29 7L29 0ZM23 1L23 6L28 6L28 1ZM24 2L24 5L27 5L27 2ZM0 22L0 29L7 29L7 22ZM1 23L1 28L6 28L6 23ZM2 24L2 27L5 27L5 24Z\" fill=\"#000000\"/></g></g></svg>
', '7552532152', 'Processing', NULL, NULL, '2025-03-03 23:58:16', '2025-03-03 23:58:24');

DROP TABLE IF EXISTS `expences`;
CREATE TABLE `expences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `expences` (`id`, `title`, `description`, `amount`, `date`, `status`, `created_at`, `updated_at`) VALUES ('1', 'Title', 'ths is description', '150', '2023-12-25', 'Processing', '2023-12-25 15:23:55', '2024-01-06 13:55:18');

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `invoicedatas`;
CREATE TABLE `invoicedatas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hsn_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quntity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoicedatas_invoice_id_index` (`invoice_id`),
  CONSTRAINT `invoicedatas_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parties_id` bigint(20) unsigned NOT NULL,
  `companies_id` bigint(20) unsigned NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_to_supply` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_parties_id_index` (`parties_id`),
  KEY `invoices_companies_id_index` (`companies_id`),
  CONSTRAINT `invoices_parties_id_foreign` FOREIGN KEY (`parties_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2023_04_29_141448_create_sliders_table', '8');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2014_10_12_100000_create_password_resets_table', '9');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2019_08_19_000000_create_failed_jobs_table', '9');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('14', '2019_12_14_000001_create_personal_access_tokens_table', '9');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('15', '2023_12_11_141729_create_parties_table', '9');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('16', '2023_12_11_154616_create_workers_table', '10');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('17', '2023_12_11_162332_create_worker_rates_table', '11');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('18', '2023_12_11_162354_create_party_rates_table', '11');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('22', '2023_12_12_164147_create_dimonds_table', '12');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('23', '2023_12_14_141717_create_processes_table', '12');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('24', '2023_12_16_044647_create_designations_table', '13');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('25', '2023_12_25_145822_create_expences_table', '14');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('26', '2024_01_02_161013_create_dailies_table', '15');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('27', '2024_01_11_161724_create_repairs_table', '16');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('28', '2024_07_18_165237_create_worker_barcodes_table', '17');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('29', '2024_07_20_111714_create_worker_attendances_table', '18');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('30', '2024_08_08_191840_create_companies_table', '19');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('31', '2024_08_08_203026_create_invoices_table', '20');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('32', '2024_08_08_203157_create_invoicedatas_table', '20');

DROP TABLE IF EXISTS `parties`;
CREATE TABLE `parties` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `round_1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `round_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `round_3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_4` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `fancy_5` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `fancy_6` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `fancy_7` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `fancy_8` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `parties` (`id`, `fname`, `lname`, `party_code`, `address`, `gst_no`, `mobile`, `is_active`, `created_at`, `updated_at`, `round_1`, `round_2`, `round_3`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `fancy_8`) VALUES ('4', 'John', 'asdasdasdasd', 'ABCDEF', '304,shimandhar residancy, Desai fadiu,opp.ramji mandir,katargam,surat', '09AAPCM2719Q1ZM', '9913866666', '1', '2025-01-18 21:46:06', '2026-08-22 10:38:14', '11', '12', '13', '21', '22', '23', '31', '32', '33', '41', '42');

DROP TABLE IF EXISTS `party_rates`;
CREATE TABLE `party_rates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `party_rates` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('1', 'key_1', '1235', '2023-12-11 22:08:02', '2024-01-06 12:57:22');
INSERT INTO `party_rates` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('2', 'key_2', '1300', '2023-12-11 22:08:34', '2023-12-11 16:52:55');
INSERT INTO `party_rates` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('3', 'key_3', '1500', '2023-12-11 22:09:40', '2023-12-11 16:53:03');

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `processes`;
CREATE TABLE `processes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dimonds_id` bigint(20) unsigned NOT NULL,
  `dimonds_barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `worker_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_shape` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_clarity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_cut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_polish` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_symmetry` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ratecut` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `processes_dimonds_id_index` (`dimonds_id`),
  CONSTRAINT `processes_dimonds_id_foreign` FOREIGN KEY (`dimonds_id`) REFERENCES `dimonds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `processes` (`id`, `dimonds_id`, `dimonds_barcode`, `designation`, `worker_name`, `issue_date`, `issue_weight`, `return_date`, `return_weight`, `price`, `r_shape`, `r_weight`, `r_clarity`, `r_color`, `r_cut`, `r_polish`, `r_symmetry`, `ratecut`, `created_at`, `updated_at`) VALUES ('76', '20', '7332488301', 'Maxy', 'John', '2025-03-03T23:21', '20', '2025-03-03T23:21', '19.5', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2025-03-03 23:21:46', '2025-03-03 23:23:02');
INSERT INTO `processes` (`id`, `dimonds_id`, `dimonds_barcode`, `designation`, `worker_name`, `issue_date`, `issue_weight`, `return_date`, `return_weight`, `price`, `r_shape`, `r_weight`, `r_clarity`, `r_color`, `r_cut`, `r_polish`, `r_symmetry`, `ratecut`, `created_at`, `updated_at`) VALUES ('78', '20', '7332488301', 'Maxy', 'John', '2025-03-03T23:30', '19.5', '2025-03-03T23:30', '18', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2025-03-03 23:30:28', '2025-03-03 23:30:36');
INSERT INTO `processes` (`id`, `dimonds_id`, `dimonds_barcode`, `designation`, `worker_name`, `issue_date`, `issue_weight`, `return_date`, `return_weight`, `price`, `r_shape`, `r_weight`, `r_clarity`, `r_color`, `r_cut`, `r_polish`, `r_symmetry`, `ratecut`, `created_at`, `updated_at`) VALUES ('79', '20', '7332488301', 'Maxy', 'John', '2025-03-03T23:30', '18', '2025-03-03T23:30', '17.5', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2025-03-03 23:30:45', '2025-03-03 23:30:58');
INSERT INTO `processes` (`id`, `dimonds_id`, `dimonds_barcode`, `designation`, `worker_name`, `issue_date`, `issue_weight`, `return_date`, `return_weight`, `price`, `r_shape`, `r_weight`, `r_clarity`, `r_color`, `r_cut`, `r_polish`, `r_symmetry`, `ratecut`, `created_at`, `updated_at`) VALUES ('80', '21', '7552532152', 'Maxy', 'John', '2025-03-03T23:58', '15', '2025-03-03T23:58', '14.5', '15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2025-03-03 23:58:24', '2025-03-03 23:58:32');
INSERT INTO `processes` (`id`, `dimonds_id`, `dimonds_barcode`, `designation`, `worker_name`, `issue_date`, `issue_weight`, `return_date`, `return_weight`, `price`, `r_shape`, `r_weight`, `r_clarity`, `r_color`, `r_cut`, `r_polish`, `r_symmetry`, `ratecut`, `created_at`, `updated_at`) VALUES ('81', '21', '7552532152', 'Maxy', 'John', '2025-03-03T23:58', '14.5', '2025-03-03T23:58', '14.2', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2025-03-03 23:58:38', '2025-03-03 23:58:52');

DROP TABLE IF EXISTS `repairs`;
CREATE TABLE `repairs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dimonds_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `repairs_dimonds_id_index` (`dimonds_id`),
  CONSTRAINT `repairs_dimonds_id_foreign` FOREIGN KEY (`dimonds_id`) REFERENCES `dimonds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_show` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('1', 'asasas', '17384148083.jpg', '1', '2025-02-01 18:30:08', '2025-02-01 18:30:08');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('2', 'sdsdsd', '1738414875admin-backgrond-111.jpg', '1', '2025-02-01 18:31:15', '2025-02-01 18:31:15');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('3', 'dfdsfdsf', '1738415039admin-backgrond.jpg', '1', '2025-02-01 18:33:59', '2025-02-01 18:33:59');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('4', 'Hello', '1738415139Untitled.png', '1', '2025-02-01 18:35:39', '2025-02-01 18:35:39');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('5', 'fgdgfdgdg', '1738415193Untitled.png', '1', '2025-02-01 18:36:33', '2025-02-01 18:36:33');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('6', 'sdsdsd', '1738417494Untitled.png', '1', '2025-02-01 19:14:54', '2025-02-01 19:14:54');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('7', 'sdsdsdsd', '1738417518admin-backgrond.jpg', '1', '2025-02-01 19:15:18', '2025-02-01 19:15:18');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('8', 'ccgfg', '1738417643admin-backgrond-111_1.jpg', '1', '2025-02-01 19:17:23', '2025-02-01 19:17:23');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('9', 'Hello', '1738417665admin-backgrond.png', '1', '2025-02-01 19:17:45', '2025-02-01 19:17:45');
INSERT INTO `sliders` (`id`, `text`, `file`, `is_show`, `created_at`, `updated_at`) VALUES ('10', 'sdsdsd', '1738417688Comp_1.gif', '1', '2025-02-01 19:18:08', '2025-02-01 19:18:08');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'admin', 'admin@gmail.com', 'admin', NULL, '$2y$10$VqORwWKfEB1cr7UbEeNcUeFwkmLip4Y4tdiM98bMaTg2y9Rl9b9gC', NULL, '2023-02-24 15:59:38', '2026-08-22 11:40:57');

DROP TABLE IF EXISTS `worker_attendances`;
CREATE TABLE `worker_attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `worker_id` bigint(20) unsigned NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `worker_attendances_worker_id_index` (`worker_id`),
  CONSTRAINT `worker_attendances_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `worker_barcodes`;
CREATE TABLE `worker_barcodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `worker_id` bigint(20) unsigned NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `worker_barcodes_worker_id_index` (`worker_id`),
  CONSTRAINT `worker_barcodes_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `worker_rates`;
CREATE TABLE `worker_rates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('1', 'Maxy', 'key_2', '10', '2023-12-11 22:10:12', '2024-04-06 12:27:09');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('2', 'Maxy', 'key_3', '4.5', '2023-12-11 22:10:39', '2023-12-16 16:29:58');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('3', 'Maxy', 'key_4', '4.6', '2023-12-11 22:10:39', '2023-12-16 16:30:05');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('4', 'Blocking', 'key_2', '5', '2023-12-11 22:10:12', '2023-12-16 14:57:21');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('5', 'Blocking', 'key_3', '5.6', '2023-12-11 22:10:39', '2023-12-16 16:29:10');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('6', 'Blocking', 'key_4', '5.7', '2023-12-11 22:10:39', '2023-12-16 16:29:18');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('7', 'Dhar', 'key_2', '6', '2023-12-11 22:10:12', '2023-12-16 14:57:34');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('8', 'Dhar', 'key_3', '6.5', '2023-12-11 22:10:39', '2023-12-16 16:30:39');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('9', 'Dhar', 'key_4', '6.7', '2023-12-11 22:10:39', '2023-12-16 16:30:48');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('10', 'Polish', 'key_2', '7', '2023-12-11 22:10:12', '2023-12-16 14:57:41');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('11', 'Polish', 'key_3', '7.5', '2023-12-11 22:10:39', '2023-12-16 16:31:04');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('12', 'Polish', 'key_4', '7.6', '2023-12-11 22:10:39', '2023-12-16 16:31:16');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('13', 'Grading', 'key_2', '8', '2023-12-11 22:10:12', '2023-12-16 14:57:49');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('14', 'Grading', 'key_3', '8.4', '2023-12-11 22:10:39', '2023-12-16 16:31:56');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('15', 'Grading', 'key_4', '8.5', '2023-12-11 22:10:39', '2023-12-16 16:32:04');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('16', 'HPHT', 'key_2', '0', NULL, '2024-01-08 17:14:06');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('17', 'HPHT', 'key_3', '0', NULL, '2024-01-08 17:14:06');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('18', 'HPHT', 'key_4', '0', NULL, '2024-01-08 17:14:06');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('19', 'discus', 'key_2', '0', '2024-01-08 17:14:35', '2024-01-08 17:14:35');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('20', 'discus', 'key_3', '0', '2024-01-08 17:14:35', '2024-01-08 17:14:35');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('21', 'discus', 'key_4', '0', '2024-01-08 17:14:36', '2024-01-08 17:14:36');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('22', 'GHISHI', 'key_2', '0', '2024-01-08 17:16:00', '2024-01-08 17:16:00');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('23', 'GHISHI', 'key_3', '0', '2024-01-08 17:16:00', '2024-01-08 17:16:00');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('24', 'GHISHI', 'key_4', '0', '2024-01-08 17:16:00', '2024-01-08 17:16:00');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('25', 'Maxy', 'key_1', '0', '2023-12-11 22:10:12', '2024-01-06 13:00:14');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('26', 'Blocking', 'key_1', '0', '2023-12-11 22:10:12', '2024-01-06 13:00:14');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('27', 'Dhar', 'key_1', '5', '2023-12-11 22:10:12', '2024-08-08 17:27:22');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('28', 'Polish', 'key_1', '0', '2023-12-11 22:10:12', '2024-01-06 13:00:14');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('29', 'Grading', 'key_1', '0', '2023-12-11 22:10:12', '2024-01-06 13:00:14');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('30', 'HPHT', 'key_1', '0', '2023-12-11 22:10:12', '2024-01-06 13:00:14');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('31', 'discus', 'key_1', '0', '2023-12-11 22:10:12', '2024-01-06 13:00:14');
INSERT INTO `worker_rates` (`id`, `designation`, `key`, `value`, `created_at`, `updated_at`) VALUES ('32', 'GHISHI', 'key_1', '0', '2023-12-11 22:10:12', '2024-01-06 13:00:14');

DROP TABLE IF EXISTS `workers`;
CREATE TABLE `workers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `round_1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `round_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `round_3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_0` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `fancy_1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_4` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_5` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_6` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fancy_7` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('1', 'John', 'does', 'tempary address', 'Maxy', '8128737012', '1111 1111 1111', '1', '1', '1', '1.00', '1', '1', '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, '2023-12-11 16:12:53', '2025-03-03 23:22:54');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('2', 'test', 'darbar', 'test address', 'Blocking', '8469492292', '1111 1111 1111', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2023-12-14 17:06:16', '2023-12-16 16:14:05');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('3', 'arvindam', 'luise', 'this is test data and address', 'Dhar', '8128737420', '1111 1111 1111', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2023-12-14 17:07:07', '2023-12-14 17:07:07');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('4', 'jay', 'test', 'graddel test address', 'Grading', '8469492213', '1234 5678 9789', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2023-12-15 15:25:15', '2023-12-16 16:14:21');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('5', 'test', 'data', 'test address', 'Dhar', '1235462154', '1111 1111 1111', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2023-12-28 16:51:20', '2023-12-28 16:51:20');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('6', 'farhan', 'joy', 'testdata', 'Maxy', '8128737123', '1111 1111 1123', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2023-12-28 16:52:48', '2023-12-28 16:52:48');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('7', 'jigar', 'patel', 'this is address for testing', 'Blocking', '45612123', '7894 1256 3211', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2023-12-28 16:54:15', '2024-01-02 15:17:00');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('8', 'asdasdupdate', 'asdasd', 'asdasd', 'Polish', '141111111', '7777 7777 7777', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', 'boi', 'asdasd', '777777777774', NULL, 'asdasd', '2024-01-02 15:15:03', '2024-05-11 03:58:47');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('11', 'eeee', 'vidhi', '304,shimandhar residancy, Desai fadiu,opp.ramji mandir,katargam,surat', 'Maxy', '234353554', '6787 6868 6779', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2024-01-06 11:49:13', '2024-01-06 11:49:13');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('12', 'dfdfdf', 'dfdfdf', 'dfdfdfdfdf', 'HPHT', '8128712222', '5154 5454 6454', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2024-01-09 14:20:25', '2024-01-09 14:20:25');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('13', 'dfgdg', 'gfhgfh', 'dsfgdfgfdhgfh', 'discus', '45454454645', '4545 5564 5454', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2024-01-09 14:20:46', '2024-01-09 14:20:46');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('14', 'dfggfh', 'hjku', 'ghjghj', 'GHISHI', '6767676767', '5456 4545 4654', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, NULL, NULL, '2024-01-09 14:21:03', '2024-01-09 14:21:03');
INSERT INTO `workers` (`id`, `fname`, `lname`, `address`, `designation`, `mobile`, `aadhar_no`, `round_1`, `round_2`, `round_3`, `fancy_0`, `fancy_1`, `fancy_2`, `fancy_3`, `fancy_4`, `fancy_5`, `fancy_6`, `fancy_7`, `is_active`, `bank_name`, `ifsc_code`, `account_no`, `remark`, `account_holder_name`, `created_at`, `updated_at`) VALUES ('15', 'ttttttttt', 'pppppppp', 'ttttest address', 'HPHT', '9913866666', '1111 1111 3333', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', NULL, NULL, NULL, 'gfhgfh', NULL, '2024-03-13 16:44:59', '2024-08-10 18:20:17');

SET FOREIGN_KEY_CHECKS=1;
