# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.25)
# Database: face_detection
# Generation Time: 2020-11-03 09:37:26 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table book_reading_expressions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book_reading_expressions`;

CREATE TABLE `book_reading_expressions` (
  `expression_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `book_current_page` int(10) unsigned NOT NULL,
  `expression_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expression_image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`expression_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `book_reading_expressions` WRITE;
/*!40000 ALTER TABLE `book_reading_expressions` DISABLE KEYS */;

INSERT INTO `book_reading_expressions` (`expression_id`, `user_id`, `book_id`, `book_current_page`, `expression_type`, `expression_image_name`, `created_at`, `updated_at`)
VALUES
	(1,1,1,2,'neutral','1604383224_1_neutral_picture.jpeg','2020-11-03 06:00:24','2020-11-03 06:00:24'),
	(2,1,1,2,'neutral','1604383230_1_neutral_picture.jpeg','2020-11-03 06:00:30','2020-11-03 06:00:30'),
	(3,1,1,3,'neutral','1604383237_1_neutral_picture.jpeg','2020-11-03 06:00:37','2020-11-03 06:00:37'),
	(4,1,1,3,'neutral','1604383244_1_neutral_picture.jpeg','2020-11-03 06:00:44','2020-11-03 06:00:44'),
	(5,1,1,3,'neutral','1604383251_1_neutral_picture.jpeg','2020-11-03 06:00:51','2020-11-03 06:00:51'),
	(6,1,1,3,'neutral','1604383258_1_neutral_picture.jpeg','2020-11-03 06:00:58','2020-11-03 06:00:58'),
	(7,1,1,3,'neutral','1604383264_1_neutral_picture.jpeg','2020-11-03 06:01:04','2020-11-03 06:01:04'),
	(8,1,1,3,'neutral','1604383271_1_neutral_picture.jpeg','2020-11-03 06:01:11','2020-11-03 06:01:11'),
	(9,1,1,3,'neutral','1604383278_1_neutral_picture.jpeg','2020-11-03 06:01:18','2020-11-03 06:01:18'),
	(10,1,1,3,'neutral','1604383288_1_neutral_picture.jpeg','2020-11-03 06:01:28','2020-11-03 06:01:28'),
	(11,1,1,3,'neutral','1604383295_1_neutral_picture.jpeg','2020-11-03 06:01:35','2020-11-03 06:01:35'),
	(12,1,1,4,'neutral','1604387151_1_neutral_picture.jpeg','2020-11-03 07:05:51','2020-11-03 07:05:51'),
	(13,1,1,4,'sad','1604387156_1_sad_picture.jpeg','2020-11-03 07:05:56','2020-11-03 07:05:56'),
	(14,1,1,4,'neutral','1604387164_1_neutral_picture.jpeg','2020-11-03 07:06:04','2020-11-03 07:06:04'),
	(15,1,1,4,'neutral','1604387171_1_neutral_picture.jpeg','2020-11-03 07:06:11','2020-11-03 07:06:11'),
	(16,1,1,4,'neutral','1604387178_1_neutral_picture.jpeg','2020-11-03 07:06:18','2020-11-03 07:06:18'),
	(17,1,1,4,'neutral','1604387185_1_neutral_picture.jpeg','2020-11-03 07:06:25','2020-11-03 07:06:25'),
	(18,1,1,4,'neutral','1604387192_1_neutral_picture.jpeg','2020-11-03 07:06:32','2020-11-03 07:06:32'),
	(19,1,1,4,'neutral','1604387199_1_neutral_picture.jpeg','2020-11-03 07:06:39','2020-11-03 07:06:39'),
	(20,1,1,4,'neutral','1604387205_1_neutral_picture.jpeg','2020-11-03 07:06:45','2020-11-03 07:06:45'),
	(21,1,1,4,'neutral','1604387212_1_neutral_picture.jpeg','2020-11-03 07:06:52','2020-11-03 07:06:52'),
	(22,1,1,4,'neutral','1604387219_1_neutral_picture.jpeg','2020-11-03 07:06:59','2020-11-03 07:06:59'),
	(23,1,1,4,'neutral','1604387225_1_neutral_picture.jpeg','2020-11-03 07:07:05','2020-11-03 07:07:05'),
	(24,1,1,4,'neutral','1604387232_1_neutral_picture.jpeg','2020-11-03 07:07:12','2020-11-03 07:07:12'),
	(25,1,1,4,'neutral','1604387240_1_neutral_picture.jpeg','2020-11-03 07:07:20','2020-11-03 07:07:20'),
	(26,1,3,2,'sad','1604387254_1_sad_picture.jpeg','2020-11-03 07:07:34','2020-11-03 07:07:34'),
	(27,1,3,5,'neutral','1604387260_1_neutral_picture.jpeg','2020-11-03 07:07:40','2020-11-03 07:07:40'),
	(28,1,3,5,'neutral','1604387267_1_neutral_picture.jpeg','2020-11-03 07:07:47','2020-11-03 07:07:47'),
	(29,1,3,5,'neutral','1604387274_1_neutral_picture.jpeg','2020-11-03 07:07:54','2020-11-03 07:07:54'),
	(30,1,3,5,'neutral','1604387281_1_neutral_picture.jpeg','2020-11-03 07:08:01','2020-11-03 07:08:01'),
	(31,1,3,5,'sad','1604387287_1_sad_picture.jpeg','2020-11-03 07:08:07','2020-11-03 07:08:07'),
	(32,1,3,5,'neutral','1604387294_1_neutral_picture.jpeg','2020-11-03 07:08:14','2020-11-03 07:08:14'),
	(33,1,3,5,'neutral','1604387301_1_neutral_picture.jpeg','2020-11-03 07:08:21','2020-11-03 07:08:21'),
	(34,1,3,5,'happy','1604387312_1_happy_picture.jpeg','2020-11-03 07:08:32','2020-11-03 07:08:32'),
	(35,1,3,5,'neutral','1604387319_1_neutral_picture.jpeg','2020-11-03 07:08:39','2020-11-03 07:08:39'),
	(36,1,3,5,'surprised','1604387325_1_surprised_picture.jpeg','2020-11-03 07:08:45','2020-11-03 07:08:45'),
	(37,1,3,5,'neutral','1604387332_1_neutral_picture.jpeg','2020-11-03 07:08:52','2020-11-03 07:08:52'),
	(38,1,3,5,'neutral','1604387338_1_neutral_picture.jpeg','2020-11-03 07:08:58','2020-11-03 07:08:58'),
	(39,1,3,5,'neutral','1604387346_1_neutral_picture.jpeg','2020-11-03 07:09:06','2020-11-03 07:09:06'),
	(40,1,1,4,'neutral','1604389566_1_neutral_picture.jpeg','2020-11-03 07:46:07','2020-11-03 07:46:07'),
	(41,1,1,4,'happy','1604389572_1_happy_picture.jpeg','2020-11-03 07:46:12','2020-11-03 07:46:12'),
	(42,1,1,4,'sad','1604389581_1_sad_picture.jpeg','2020-11-03 07:46:21','2020-11-03 07:46:21'),
	(43,1,1,4,'happy','1604389588_1_happy_picture.jpeg','2020-11-03 07:46:28','2020-11-03 07:46:28'),
	(44,1,1,4,'sad','1604389598_1_sad_picture.jpeg','2020-11-03 07:46:38','2020-11-03 07:46:38'),
	(45,1,1,4,'happy','1604389605_1_happy_picture.jpeg','2020-11-03 07:46:45','2020-11-03 07:46:45'),
	(46,1,1,4,'neutral','1604389615_1_neutral_picture.jpeg','2020-11-03 07:46:55','2020-11-03 07:46:55'),
	(47,1,1,4,'happy','1604389624_1_happy_picture.jpeg','2020-11-03 07:47:04','2020-11-03 07:47:04'),
	(48,1,1,4,'neutral','1604389631_1_neutral_picture.jpeg','2020-11-03 07:47:11','2020-11-03 07:47:11'),
	(49,1,1,4,'neutral','1604389638_1_neutral_picture.jpeg','2020-11-03 07:47:18','2020-11-03 07:47:18'),
	(50,1,1,4,'neutral','1604389647_1_neutral_picture.jpeg','2020-11-03 07:47:27','2020-11-03 07:47:27');

/*!40000 ALTER TABLE `book_reading_expressions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table book_reading_stats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book_reading_stats`;

CREATE TABLE `book_reading_stats` (
  `stats_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reading_id` int(10) unsigned NOT NULL,
  `book_page_number` int(10) unsigned NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stats_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `book_reading_stats` WRITE;
/*!40000 ALTER TABLE `book_reading_stats` DISABLE KEYS */;

INSERT INTO `book_reading_stats` (`stats_id`, `reading_id`, `book_page_number`, `start_time`, `end_time`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'03:43:40','06:00:07','2020-11-03 03:36:15','2020-11-03 06:00:07'),
	(2,1,2,'06:00:07','06:01:41','2020-11-03 03:43:43','2020-11-03 06:01:41'),
	(3,2,1,'05:04:47',NULL,'2020-11-03 03:44:33','2020-11-03 05:04:47'),
	(4,1,3,'06:01:41','07:45:55','2020-11-03 06:00:37','2020-11-03 07:45:55'),
	(5,1,4,'07:45:55',NULL,'2020-11-03 06:01:47','2020-11-03 07:45:55'),
	(6,3,1,'07:07:23','07:07:26','2020-11-03 07:07:23','2020-11-03 07:07:26'),
	(7,3,2,'07:07:26',NULL,'2020-11-03 07:07:26','2020-11-03 07:07:26'),
	(8,3,5,'07:07:40',NULL,'2020-11-03 07:07:40','2020-11-03 07:07:40'),
	(9,3,5,'07:07:40',NULL,'2020-11-03 07:07:40','2020-11-03 07:07:40'),
	(10,3,5,'07:07:40',NULL,'2020-11-03 07:07:40','2020-11-03 07:07:40');

/*!40000 ALTER TABLE `book_reading_stats` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table book_readings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book_readings`;

CREATE TABLE `book_readings` (
  `reading_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `book_total_pages` int(10) unsigned NOT NULL,
  `book_current_page` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`reading_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `book_readings` WRITE;
/*!40000 ALTER TABLE `book_readings` DISABLE KEYS */;

INSERT INTO `book_readings` (`reading_id`, `user_id`, `book_id`, `book_total_pages`, `book_current_page`, `created_at`, `updated_at`)
VALUES
	(1,1,1,30,4,'2020-11-03 03:36:15','2020-11-03 06:01:47'),
	(2,1,2,258,1,'2020-11-03 03:44:33','2020-11-03 03:44:33'),
	(3,1,3,258,5,'2020-11-03 07:07:23','2020-11-03 07:07:40');

/*!40000 ALTER TABLE `book_readings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table books
# ------------------------------------------------------------

DROP TABLE IF EXISTS `books`;

CREATE TABLE `books` (
  `book_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_thumb` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;

INSERT INTO `books` (`book_id`, `book_title`, `book_slug`, `book_thumb`, `book_author_name`, `book_file`, `book_status`, `created_at`, `updated_at`)
VALUES
	(1,'Alanna Reynolds','alanna-reynolds','book9.png','Monica Osinski','book1.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(2,'Mia Tromp','mia-tromp','book19.png','Lavada Rice','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(3,'Dr. Felicita Johnston','dr-felicita-johnston','book1.png','Holly Watsica Sr.','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(4,'Dr. Stephan Spencer','dr-stephan-spencer','book14.png','Prof. Adonis Champlin I','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(5,'Betty Langworth','betty-langworth','book3.png','Presley Balistreri Jr.','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(6,'Mrs. Creola Considine I','mrs-creola-considine-i','book3.png','Dax Stanton','book1.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(7,'Tyree Block','tyree-block','book3.png','Jammie Walker','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(8,'Dr. Reba Barrows I','dr-reba-barrows-i','book18.png','Ms. Earline Ziemann','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(9,'Bernard Swaniawski MD','bernard-swaniawski-md','book15.png','Miss Duane Hill III','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(10,'Providenci Watsica','providenci-watsica','book16.png','Dylan Ruecker','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(11,'Lexus Zieme PhD','lexus-zieme-phd','book8.png','Ms. Susanna Murazik','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(12,'Roxanne Hartmann','roxanne-hartmann','book19.png','Adella Jakubowski','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(13,'Jedidiah Luettgen','jedidiah-luettgen','book7.png','Dino Cronin','book1.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(14,'Wade Kuphal','wade-kuphal','book2.png','Margarita Crist','book1.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(15,'Lenny Hauck','lenny-hauck','book2.png','Aimee Zemlak','book1.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(16,'Archibald Beier','archibald-beier','book15.png','Rosamond Prosacco','book1.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(17,'Mr. Emmett Crist','mr-emmett-crist','book11.png','Tracy Wiegand II','book1.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(18,'Jerrell Murray','jerrell-murray','book6.png','Nicholaus Welch','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(19,'Wilfredo Paucek','wilfredo-paucek','book12.png','Jaylan Roberts','book2.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07'),
	(20,'Mauricio Zulauf V','mauricio-zulauf-v','book14.png','Mr. Toni Lehner DDS','book1.pdf',1,'2020-11-03 03:36:07','2020-11-03 03:36:07');

/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2020_10_30_125045_create_books_table',1),
	(4,'2020_10_30_155312_create_book_readings_table',1),
	(5,'2020_10_30_171030_create_book_reading_stats_table',1),
	(6,'2020_11_03_035955_create_book_reading_expressions_table',2);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` tinyint(1) DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `api_token`, `password`, `user_status`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Naveed Shahzad','lhrciit@gmail.com','r076Tq6piCrVb4PANtE9boPJ38JwqU6rAy6TmbxNW3p9pvvBhP4fGgWKTZ9p','$2y$10$o4aPGx1oAS/w2fCGIyOFee54dldanQO2.c0VGthHCM37I.yURFhSq',1,NULL,NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
