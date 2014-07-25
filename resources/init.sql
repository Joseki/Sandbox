SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  `surname` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `role` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_role` (`user`,`role`),
  KEY `role` (`role`),
  CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_role_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `section_closure`;
CREATE TABLE `section_closure` (
  `ancestor` int(11) NOT NULL,
  `descendant` int(11) NOT NULL,
  `depth` int(11) NOT NULL DEFAULT '0',
  KEY `descendant` (`descendant`),
  KEY `ancestor` (`ancestor`),
  CONSTRAINT `section_closure_ibfk_2` FOREIGN KEY (`descendant`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  CONSTRAINT `section_closure_ibfk_3` FOREIGN KEY (`ancestor`) REFERENCES `section` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `restriction`;
CREATE TABLE `restriction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `section_restriction`;
CREATE TABLE `section_restriction` (
  `section` int(11) NOT NULL,
  `restriction` int(11) NOT NULL,
  KEY `section` (`section`),
  KEY `restriction` (`restriction`),
  CONSTRAINT `section_restriction_ibfk_1` FOREIGN KEY (`section`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  CONSTRAINT `section_restriction_ibfk_2` FOREIGN KEY (`restriction`) REFERENCES `restriction` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;