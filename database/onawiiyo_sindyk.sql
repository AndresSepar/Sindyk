/*
Database: onawiiyo_sindyk
*/

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `onawiiyo_sindyk`.`info`;
DROP TABLE IF EXISTS `onawiiyo_sindyk`.`menu`;
DROP TABLE IF EXISTS `onawiiyo_sindyk`.`plans`;
CREATE TABLE `info` (
  `image` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `description` text,
  `logo_light` varchar(255) DEFAULT NULL,
  `logo_dark` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT '#',
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `period` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `best` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

