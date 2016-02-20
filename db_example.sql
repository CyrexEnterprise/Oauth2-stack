# ************************************************************
# Sequel Pro SQL dump
# Version 4500
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.01 (MySQL 5.6.21)
# Database: softtouch example
# Generation Time: 2016-01-30 19:39:10 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table account_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `account_user`;

CREATE TABLE `account_user` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invitation_token` varchar(32) DEFAULT NULL,
  KEY `account_id` (`account_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `account_user` WRITE;
/*!40000 ALTER TABLE `account_user` DISABLE KEYS */;

INSERT INTO `account_user` (`account_id`, `user_id`, `invitation_token`)
VALUES
	(1,1,'4eb54d7430a9c97c7df31c518720fd9d');

/*!40000 ALTER TABLE `account_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;

INSERT INTO `accounts` (`id`, `name`, `active`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1,'Cloudoki',1,NULL,'2015-03-24 16:00:00','2015-05-21 14:36:34');

/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_access_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_access_tokens`;

CREATE TABLE `oauth_access_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `scope` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;

INSERT INTO `oauth_access_tokens` (`id`, `access_token`, `client_id`, `user_id`, `expires`, `scope`)
VALUES
	(1,'6941b436e1b4967e46afec479913ee5893743f64','oauth25511896525d2a4.36355655',1,'2017-01-01 00:00:01',NULL);

/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_authorizations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_authorizations`;

CREATE TABLE `oauth_authorizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `authorization_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `oauth_authorizations` WRITE;
/*!40000 ALTER TABLE `oauth_authorizations` DISABLE KEYS */;

INSERT INTO `oauth_authorizations` (`id`, `client_id`, `user_id`, `authorization_date`)
VALUES
	(1,'oauth25511896525d2a4.36355655',1,'2016-01-01 00:00:01');

/*!40000 ALTER TABLE `oauth_authorizations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_clients`;

CREATE TABLE `oauth_clients` (
  `id` int(11) NOT NULL DEFAULT '0',
  `client_id` varchar(80) NOT NULL,
  `client_secret` varchar(80) NOT NULL,
  `client_name` varchar(80) NOT NULL,
  `redirect_uri` varchar(256) NOT NULL,
  `grant_types` varchar(80) DEFAULT NULL,
  `scope` varchar(80) DEFAULT NULL,
  `user_id` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;

INSERT INTO `oauth_clients` (`id`, `client_id`, `client_secret`, `client_name`, `redirect_uri`, `grant_types`, `scope`, `user_id`)
VALUES
	(1,'oauth25511896525d2a4.36355655','31654ad1f17d15edd4cc4fa329372618','Cloudoki Superadmin','http://superadmin.cloudoki.ninja/auth.html',NULL,NULL,'1');

/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_scopes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_scopes`;

CREATE TABLE `oauth_scopes` (
  `scope` text,
  `is_default` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL DEFAULT '',
  `lastname` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) DEFAULT '',
  `reset_token` varchar(40) DEFAULT NULL,
  `avatar` varchar(80) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `firstname`, `lastname`, `password`, `reset_token`, `avatar`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1,'koen@cloudoki.com','Koen','Betsens','$2y$10$80x5xsWURigtOSeducoWXeDLNJB4ruCqU21cva6lTPvYV1P3oeKcO',NULL,'https://pbs.twimg.com/profile_images/460710408500695041/eZGWaSPZ.png',NULL,'2016-01-01 16:00:00','2016-01-01 16:00:00');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
