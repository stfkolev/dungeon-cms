-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 30 Mai 2015 à 01:40
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `dungeon`
--

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_access`
--

DROP TABLE IF EXISTS `dungeon_access`;
CREATE TABLE IF NOT EXISTS `dungeon_access` (
  `access_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id` int(11) UNSIGNED NOT NULL,
  `module` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  PRIMARY KEY (`access_id`),
  UNIQUE KEY `module_id` (`id`,`module`,`action`),
  KEY `module` (`module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_access`
--

INSERT INTO `dungeon_access` VALUES(1, 2, 'talks', 'read');
INSERT INTO `dungeon_access` VALUES(2, 2, 'talks', 'write');
INSERT INTO `dungeon_access` VALUES(3, 2, 'talks', 'delete');
INSERT INTO `dungeon_access` VALUES(4, 1, 'forum', 'category_read');
INSERT INTO `dungeon_access` VALUES(5, 1, 'forum', 'category_write');
INSERT INTO `dungeon_access` VALUES(6, 1, 'forum', 'category_modify');
INSERT INTO `dungeon_access` VALUES(7, 1, 'forum', 'category_delete');
INSERT INTO `dungeon_access` VALUES(8, 1, 'forum', 'category_announce');
INSERT INTO `dungeon_access` VALUES(9, 1, 'forum', 'category_lock');
INSERT INTO `dungeon_access` VALUES(10, 1, 'forum', 'category_move');
INSERT INTO `dungeon_access` VALUES(11, 1, 'events', 'access_events_type');
INSERT INTO `dungeon_access` VALUES(12, 2, 'events', 'access_events_type');
INSERT INTO `dungeon_access` VALUES(13, 3, 'events', 'access_events_type');
INSERT INTO `dungeon_access` VALUES(14, 4, 'events', 'access_events_type');
INSERT INTO `dungeon_access` VALUES(15, 5, 'events', 'access_events_type');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_access_details`
--

DROP TABLE IF EXISTS `dungeon_access_details`;
CREATE TABLE IF NOT EXISTS `dungeon_access_details` (
  `access_id` int(11) UNSIGNED NOT NULL,
  `entity` varchar(100) NOT NULL,
  `type` enum('group','user') NOT NULL DEFAULT 'group',
  `authorized` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`access_id`,`entity`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_access_details`
--

INSERT INTO `dungeon_access_details` VALUES(2, 'visitors', 'group', '0');
INSERT INTO `dungeon_access_details` VALUES(3, 'admins', 'group', '1');
INSERT INTO `dungeon_access_details` VALUES(5, 'visitors', 'group', '0');
INSERT INTO `dungeon_access_details` VALUES(6, 'admins', 'group', '1');
INSERT INTO `dungeon_access_details` VALUES(7, 'admins', 'group', '1');
INSERT INTO `dungeon_access_details` VALUES(8, 'admins', 'group', '1');
INSERT INTO `dungeon_access_details` VALUES(9, 'admins', 'group', '1');
INSERT INTO `dungeon_access_details` VALUES(10, 'admins', 'group', '1');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_awards`
--

DROP TABLE IF EXISTS `dungeon_awards`;
CREATE TABLE IF NOT EXISTS `dungeon_awards` (
  `award_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `game_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `platform` varchar(100) NOT NULL,
  `ranking` int(11) UNSIGNED NOT NULL,
  `participants` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`award_id`),
  KEY `image_id` (`image_id`),
  KEY `game_id` (`game_id`),
  KEY `team_id` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_comments`
--

DROP TABLE IF EXISTS `dungeon_comments`;
CREATE TABLE IF NOT EXISTS `dungeon_comments` (
  `comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `module_id` int(11) UNSIGNED NOT NULL,
  `module` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `parent_id` (`parent_id`),
  KEY `user_id` (`user_id`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_crawlers`
--

DROP TABLE IF EXISTS `dungeon_crawlers`;
CREATE TABLE IF NOT EXISTS `dungeon_crawlers` (
  `name` varchar(100) NOT NULL,
  `path` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_dispositions`
--

DROP TABLE IF EXISTS `dungeon_dispositions`;
CREATE TABLE IF NOT EXISTS `dungeon_dispositions` (
  `disposition_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theme` varchar(100) NOT NULL,
  `page` varchar(100) NOT NULL,
  `zone` int(11) UNSIGNED NOT NULL,
  `disposition` text NOT NULL,
  PRIMARY KEY (`disposition_id`),
  UNIQUE KEY `theme` (`theme`,`page`,`zone`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_dispositions`
--

INSERT INTO `dungeon_dispositions` VALUES(1, 'default', '*', 0, 'a:2:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-white";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:2;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-8";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:3;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-4";}}}}}i:1;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-light";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:4;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-8";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";s:8:"col-md-4";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:6:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:5;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}i:1;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:6;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";s:10:"panel-dark";s:8:"\0*\0_size";N;}i:2;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:7;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";s:10:"panel-dark";s:8:"\0*\0_size";N;}i:3;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:8;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}i:4;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:9;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}i:5;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:10;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";s:9:"panel-red";s:8:"\0*\0_size";N;}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(2, 'default', '*', 1, 'a:1:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:11:"row-default";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:3:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:11;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-4";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:12;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";s:10:"panel-dark";s:8:"\0*\0_size";s:8:"col-md-4";}}}i:2;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:13;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";s:9:"panel-red";s:8:"\0*\0_size";s:8:"col-md-4";}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(3, 'default', '*', 2, 'a:0:{}');
INSERT INTO `dungeon_dispositions` VALUES(4, 'default', '*', 3, 'a:2:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:11:"row-default";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:14;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}}}}}i:1;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-black";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:15;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-7";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:16;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-5";}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(5, 'default', '*', 4, 'a:1:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:11:"row-default";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:17;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-8";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:18;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-4";}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(6, 'default', '*', 5, 'a:1:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:11:"row-default";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:19;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";s:10:"panel-dark";s:8:"\0*\0_size";N;}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(7, 'default', '/', 3, 'a:3:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:11:"row-default";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:20;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}}}}}i:1;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-black";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:21;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-7";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:22;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-5";}}}}}i:2;O:3:"Row":3:{s:9:"\0*\0_style";s:11:"row-default";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:23;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(8, 'default', 'forum/*', 0, 'a:2:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-white";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:24;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-8";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:25;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-4";}}}}}i:1;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-light";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:26;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(9, 'default', 'forum/*', 2, 'a:1:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-light";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:35;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";s:9:"panel-red";s:8:"\0*\0_size";s:8:"col-md-4";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:36;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";s:10:"panel-dark";s:8:"\0*\0_size";s:8:"col-md-8";}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(10, 'default', 'news/_news/*', 0, 'a:2:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-white";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:27;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-8";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:28;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-4";}}}}}i:1;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-light";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:29;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(11, 'default', 'user/*', 0, 'a:2:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-white";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:30;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-8";}}}i:1;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:31;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-4";}}}}}i:1;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-light";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:32;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}}}}}}');
INSERT INTO `dungeon_dispositions` VALUES(12, 'default', 'search/*', 0, 'a:2:{i:0;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-white";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:2:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:33;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";s:8:"col-md-8";}}}i:1;N;}}i:1;O:3:"Row":3:{s:9:"\0*\0_style";s:9:"row-light";s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:3:"Col":3:{s:8:"\0*\0_size";N;s:6:"\0*\0_id";N;s:12:"\0*\0_children";a:1:{i:0;O:12:"Panel_widget":8:{s:6:"\0*\0_id";N;s:10:"\0*\0_widget";i:34;s:11:"\0*\0_heading";a:0:{}s:10:"\0*\0_footer";a:0:{}s:8:"\0*\0_body";N;s:13:"\0*\0_body_tags";N;s:9:"\0*\0_style";N;s:8:"\0*\0_size";N;}}}}}}');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_events`
--

DROP TABLE IF EXISTS `dungeon_events`;
CREATE TABLE IF NOT EXISTS `dungeon_events` (
  `event_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `private_description` text NOT NULL,
  `location` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_end` timestamp NULL DEFAULT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`),
  KEY `user_id` (`user_id`),
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_events_matches`
--

DROP TABLE IF EXISTS `dungeon_events_matches`;
CREATE TABLE IF NOT EXISTS `dungeon_events_matches` (
  `event_id` int(11) UNSIGNED NOT NULL,
  `team_id` int(11) UNSIGNED NOT NULL,
  `opponent_id` int(11) UNSIGNED NOT NULL,
  `mode_id` int(11) UNSIGNED DEFAULT NULL,
  `webtv` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `opponent_id` (`opponent_id`),
  KEY `mode_id` (`mode_id`),
  KEY `team_id` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_events_matches_opponents`
--

DROP TABLE IF EXISTS `dungeon_events_matches_opponents`;
CREATE TABLE IF NOT EXISTS `dungeon_events_matches_opponents` (
  `opponent_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `country` varchar(5) NOT NULL,
  PRIMARY KEY (`opponent_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_events_matches_rounds`
--

DROP TABLE IF EXISTS `dungeon_events_matches_rounds`;
CREATE TABLE IF NOT EXISTS `dungeon_events_matches_rounds` (
  `round_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` int(11) UNSIGNED NOT NULL,
  `map_id` int(11) UNSIGNED DEFAULT NULL,
  `score1` int(11) NOT NULL,
  `score2` int(11) NOT NULL,
  PRIMARY KEY (`round_id`),
  KEY `event_id` (`event_id`),
  KEY `map_id` (`map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_events_participants`
--

DROP TABLE IF EXISTS `dungeon_events_participants`;
CREATE TABLE IF NOT EXISTS `dungeon_events_participants` (
  `event_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` smallint(6) UNSIGNED NOT NULL,
  PRIMARY KEY (`event_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_events_types`
--

DROP TABLE IF EXISTS `dungeon_events_types`;
CREATE TABLE IF NOT EXISTS `dungeon_events_types` (
  `type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `icon` varchar(20) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_events_types`
--

INSERT INTO `dungeon_events_types` VALUES(1, 1, 'Entrainement', 'success', 'fa-gamepad');
INSERT INTO `dungeon_events_types` VALUES(2, 1, 'Match amical', 'info', 'fa-angellist');
INSERT INTO `dungeon_events_types` VALUES(3, 1, 'Match officiel', 'warning', 'fa-trophy');
INSERT INTO `dungeon_events_types` VALUES(4, 0, 'IRL', 'primary', 'fa-glass');
INSERT INTO `dungeon_events_types` VALUES(5, 0, 'Divers', 'default', 'fa-comments');
INSERT INTO `dungeon_events_types` VALUES(6, 1, 'Réunion', 'danger', 'fa-briefcase');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_files`
--

DROP TABLE IF EXISTS `dungeon_files`;
CREATE TABLE IF NOT EXISTS `dungeon_files` (
  `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `path` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`file_id`),
  UNIQUE KEY `path` (`path`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_files`
--

INSERT INTO `dungeon_files` VALUES(1, 1, 'Sans-titre-2.jpg', './upload/news/categories/ubfuejdfooirqya0pyltfeklja4ew4sn.jpg', '2015-05-29 22:34:16');
INSERT INTO `dungeon_files` VALUES(2, 1, 'logo.png', 'upload/partners/zwvmsjijfljaka4rdblgvlype1lnbwaw.png', '2016-05-07 16:51:53');
INSERT INTO `dungeon_files` VALUES(3, 1, 'logo_black.png', 'upload/partners/y4ofwq2ekppwnfpmnrmnafeivszlg5bd.png', '2016-05-07 16:51:53');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum`
--

DROP TABLE IF EXISTS `dungeon_forum`;
CREATE TABLE IF NOT EXISTS `dungeon_forum` (
  `forum_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NOT NULL,
  `is_subforum` enum('0','1') NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `count_topics` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `count_messages` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_message_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`forum_id`),
  KEY `last_message_id` (`last_message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_forum`
--

INSERT INTO `dungeon_forum` VALUES(1, 1, '0', 'First Forum', 'This is an example forum !', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum_categories`
--

DROP TABLE IF EXISTS `dungeon_forum_categories`;
CREATE TABLE IF NOT EXISTS `dungeon_forum_categories` (
  `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_forum_categories`
--

INSERT INTO `dungeon_forum_categories` VALUES(1, 'General', 0);

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum_messages`
--

DROP TABLE IF EXISTS `dungeon_forum_messages`;
CREATE TABLE IF NOT EXISTS `dungeon_forum_messages` (
  `message_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum_polls`
--

DROP TABLE IF EXISTS `dungeon_forum_polls`;
CREATE TABLE IF NOT EXISTS `dungeon_forum_polls` (
  `topic_id` int(11) UNSIGNED NOT NULL,
  `question` varchar(100) NOT NULL,
  `answers` text NOT NULL,
  `is_multiple_choice` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum_read`
--

DROP TABLE IF EXISTS `dungeon_forum_read`;
CREATE TABLE IF NOT EXISTS `dungeon_forum_read` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `forum_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum_topics`
--

DROP TABLE IF EXISTS `dungeon_forum_topics`;
CREATE TABLE IF NOT EXISTS `dungeon_forum_topics` (
  `topic_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) UNSIGNED NOT NULL,
  `message_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `status` enum('-2','-1','0','1') NOT NULL DEFAULT '0',
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `count_messages` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_message_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`topic_id`),
  UNIQUE KEY `last_message_id` (`last_message_id`),
  KEY `forum_id` (`forum_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum_topics_read`
--

DROP TABLE IF EXISTS `dungeon_forum_topics_read`;
CREATE TABLE IF NOT EXISTS `dungeon_forum_topics_read` (
  `topic_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`topic_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum_track`
--

DROP TABLE IF EXISTS `dungeon_forum_track`;
CREATE TABLE IF NOT EXISTS `dungeon_forum_track` (
  `topic_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`topic_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_forum_url`
--

DROP TABLE IF EXISTS `dungeon_forum_url`;
CREATE TABLE IF NOT EXISTS `dungeon_forum_url` (
  `forum_id` int(11) UNSIGNED NOT NULL,
  `url` varchar(100) NOT NULL,
  `redirects` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_gallery`
--

DROP TABLE IF EXISTS `dungeon_gallery`;
CREATE TABLE IF NOT EXISTS `dungeon_gallery` (
  `gallery_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`gallery_id`),
  KEY `category_id` (`category_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_gallery_categories`
--

DROP TABLE IF EXISTS `dungeon_gallery_categories`;
CREATE TABLE IF NOT EXISTS `dungeon_gallery_categories` (
  `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `image_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `icon_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `image_id` (`image_id`),
  KEY `icon_id` (`icon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_gallery_categories_lang`
--

DROP TABLE IF EXISTS `dungeon_gallery_categories_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_gallery_categories_lang` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`,`lang`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_gallery_images`
--

DROP TABLE IF EXISTS `dungeon_gallery_images`;
CREATE TABLE IF NOT EXISTS `dungeon_gallery_images` (
  `image_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `thumbnail_file_id` int(11) UNSIGNED NOT NULL,
  `original_file_id` int(11) UNSIGNED NOT NULL,
  `file_id` int(11) UNSIGNED NOT NULL,
  `gallery_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`),
  KEY `file_id` (`file_id`),
  KEY `gallery_id` (`gallery_id`),
  KEY `original_file_id` (`original_file_id`),
  KEY `thumbnail_file_id` (`thumbnail_file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_gallery_lang`
--

DROP TABLE IF EXISTS `dungeon_gallery_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_gallery_lang` (
  `gallery_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`gallery_id`,`lang`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_games`
--

DROP TABLE IF EXISTS `dungeon_games`;
CREATE TABLE IF NOT EXISTS `dungeon_games` (
  `game_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `image_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `icon_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`game_id`),
  KEY `image_id` (`image_id`),
  KEY `icon_id` (`icon_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_games_lang`
--

DROP TABLE IF EXISTS `dungeon_games_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_games_lang` (
  `game_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`game_id`,`lang`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_games_maps`
--

DROP TABLE IF EXISTS `dungeon_games_maps`;
CREATE TABLE IF NOT EXISTS `dungeon_games_maps` (
  `map_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `game_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`map_id`),
  KEY `game_id` (`game_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_games_modes`
--

DROP TABLE IF EXISTS `dungeon_games_modes`;
CREATE TABLE IF NOT EXISTS `dungeon_games_modes` (
  `mode_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `game_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`mode_id`),
  KEY `game_id` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_groups`
--

DROP TABLE IF EXISTS `dungeon_groups`;
CREATE TABLE IF NOT EXISTS `dungeon_groups` (
  `group_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `hidden` enum('0','1') NOT NULL DEFAULT '0',
  `auto` enum('0','1') NOT NULL DEFAULT '0',
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `dungeon_groups_lang`
--

DROP TABLE IF EXISTS `dungeon_groups_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_groups_lang` (
  `group_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`group_id`,`lang`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_news`
--

DROP TABLE IF EXISTS `dungeon_news`;
CREATE TABLE IF NOT EXISTS `dungeon_news` (
  `news_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` enum('0','1') NOT NULL DEFAULT '0',
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `vote` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_news`
--

INSERT INTO `dungeon_news` VALUES(1, 1, 1, NULL, CURRENT_TIMESTAMP, '1', 0, '0');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_news_categories`
--

DROP TABLE IF EXISTS `dungeon_news_categories`;
CREATE TABLE IF NOT EXISTS `dungeon_news_categories` (
  `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `image_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `icon_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `image_id` (`image_id`),
  KEY `icon_id` (`icon_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_news_categories`
--

INSERT INTO `dungeon_news_categories` VALUES(1, 1, NULL, 'general');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_news_categories_lang`
--

DROP TABLE IF EXISTS `dungeon_news_categories_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_news_categories_lang` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`,`lang`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_news_categories_lang`
--

INSERT INTO `dungeon_news_categories_lang` VALUES(1, 'en', 'General');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_news_lang`
--

DROP TABLE IF EXISTS `dungeon_news_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_news_lang` (
  `news_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `introduction` text NOT NULL,
  `content` text NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY (`news_id`,`lang`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_news_lang`
--

INSERT INTO `dungeon_news_lang` VALUES(1, 'en', 'Dungeon Alpha has installed successfully !', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam facilisis libero vel felis vestibulum pellentesque. Donec suscipit porta elit et pellentesque. Donec porta lobortis enim nec consequat. Praesent euismod erat ut justo hendrerit, eget dignissim leo fermentum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam facilisis libero vel felis vestibulum pellentesque. Donec suscipit porta elit et pellentesque. Donec porta lobortis enim nec consequat. Praesent euismod erat ut justo hendrerit, eget dignissim leo fermentum. Integer finibus tortor sed dui sagittis, cursus commodo purus faucibus. Donec iaculis mi sed semper convallis. Fusce a blandit sem.Morbi nec dolor nec nibh vulputate porttitor id a mi. Nam pellentesque, dui ut tempor lacinia, orci eros aliquam libero, et tempor neque nisi porttitor orci. Vestibulum dui neque, auctor efficitur tincidunt eu, volutpat quis nunc. Cras quis massa pharetra, efficitur purus vel, ultrices purus. Sed turpis erat, gravida amet..', 'Dungeon,Cms,Alpha');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_pages`
--

DROP TABLE IF EXISTS `dungeon_pages`;
CREATE TABLE IF NOT EXISTS `dungeon_pages` (
  `page_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_pages_lang`
--

DROP TABLE IF EXISTS `dungeon_pages_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_pages_lang` (
  `page_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`page_id`,`lang`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_partners`
--

DROP TABLE IF EXISTS `dungeon_partners`;
CREATE TABLE IF NOT EXISTS `dungeon_partners` (
  `partner_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `logo_light` int(11) UNSIGNED NULL DEFAULT NULL,
  `logo_dark` int(11) UNSIGNED NULL DEFAULT NULL,
  `website` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `order` tinyint(6) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`partner_id`),
  KEY `image_id` (`logo_light`),
  KEY `logo_dark` (`logo_dark`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_partners`
--

INSERT INTO `dungeon_partners` VALUES(1, 'dungeon', 2, 3, 'https://dungeon.com', '#', '#', '', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_partners_lang`
--

DROP TABLE IF EXISTS `dungeon_partners_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_partners_lang` (
  `partner_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`partner_id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_partners_lang`
--

INSERT INTO `dungeon_partners_lang` VALUES(1, 'en', 'Dungeon', 'Dungeon is a performance-based lightweight universal gaming content-management system.');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_recruits`
--

DROP TABLE IF EXISTS `dungeon_recruits`;
CREATE TABLE IF NOT EXISTS `dungeon_recruits` (
  `recruit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `introduction` text NOT NULL,
  `description` text NOT NULL,
  `requierments` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) UNSIGNED NOT NULL,
  `size` int(11) NOT NULL,
  `role` varchar(60) NOT NULL,
  `icon` varchar(60) NOT NULL,
  `date_end` date DEFAULT NULL,
  `closed` enum('0','1') NOT NULL DEFAULT '0',
  `team_id` int(11) UNSIGNED DEFAULT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`recruit_id`),
  KEY `image_id` (`image_id`),
  KEY `user_id` (`user_id`),
  KEY `team_id` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_recruits_candidacies`
--

DROP TABLE IF EXISTS `dungeon_recruits_candidacies`;
CREATE TABLE IF NOT EXISTS `dungeon_recruits_candidacies` (
  `candidacy_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `recruit_id` int(11) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `pseudo` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `presentation` text NOT NULL,
  `motivations` text NOT NULL,
  `experiences` text NOT NULL,
  `status` enum('1','2','3') NOT NULL DEFAULT '1',
  `reply` text,
  PRIMARY KEY (`candidacy_id`),
  KEY `recruit_id` (`recruit_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_recruits_candidacies_votes`
--

DROP TABLE IF EXISTS `dungeon_recruits_candidacies_votes`;
CREATE TABLE IF NOT EXISTS `dungeon_recruits_candidacies_votes` (
  `vote_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `candidacy_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `vote` enum('0','1') NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  PRIMARY KEY (`vote_id`),
  KEY `candidacy_id` (`candidacy_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_search_keywords`
--

DROP TABLE IF EXISTS `dungeon_search_keywords`;
CREATE TABLE IF NOT EXISTS `dungeon_search_keywords` (
  `keyword` varchar(100) NOT NULL,
  `count` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_sessions`
--

DROP TABLE IF EXISTS `dungeon_sessions`;
CREATE TABLE IF NOT EXISTS `dungeon_sessions` (
  `session_id` varchar(32) NOT NULL,
  `ip_address` varchar(39) NOT NULL,
  `host_name` varchar(100) NOT NULL,
  `user_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `is_crawler` enum('0','1') NOT NULL DEFAULT '0',
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_data` text NOT NULL,
  `remember_me` enum('0','1') NOT NULL DEFAULT '0',
  UNIQUE KEY `session_id` (`session_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_sessions_history`
--

DROP TABLE IF EXISTS `dungeon_sessions_history`;
CREATE TABLE IF NOT EXISTS `dungeon_sessions_history` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` varchar(32) NULL DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(39) NOT NULL,
  `host_name` varchar(100) NOT NULL,
  `authenticator` varchar(100) NOT NULL,
  `referer` varchar(100) NOT NULL,
  `user_agent` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_settings`
--

DROP TABLE IF EXISTS `dungeon_settings`;
CREATE TABLE IF NOT EXISTS `dungeon_settings` (
  `name` varchar(100) NOT NULL,
  `site` varchar(100) NOT NULL DEFAULT '',
  `lang` varchar(5) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `type` enum('string','bool','int','list','array','float') NOT NULL DEFAULT 'string',
  PRIMARY KEY (`name`,`site`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_settings`
--

INSERT INTO `dungeon_settings` VALUES('forum_messages_per_page', '', '', '15', 'int');
INSERT INTO `dungeon_settings` VALUES('forum_topics_per_page', '', '', '20', 'int');
INSERT INTO `dungeon_settings` VALUES('news_per_page', '', '', '5', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_analytics', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_contact', '', '', 'noreply@dungeon.com', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_cookie_expire', '', '', '1 hour', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_cookie_name', '', '', 'session', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_debug', '', '', '0', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_default_page', 'default', '', 'news', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_default_theme', 'default', '', 'default', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_description', 'default', '', 'ALPHA 0.1.6.1', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_humans_txt', '', '', '/* TEAM */\n	Dungeon CMS for gamers\n	Contact: contact [at] dungeon.com\n	Twitter: @DungeonCMS\n	From: Bulgaria\n\n	Developer: Stf Kolev\n	Contact: Evil#8815 [at] Discord', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_name', 'default', '', 'Dungeon CMS', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_robots_txt', '', '', 'User-agent: *\r\nDisallow:', 'string');
INSERT INTO `dungeon_settings` VALUES('default_background', '', '', '0', 'int');
INSERT INTO `dungeon_settings` VALUES('default_background_attachment', '', '', 'scroll', 'string');
INSERT INTO `dungeon_settings` VALUES('default_background_color', '', '', '#141d26', 'string');
INSERT INTO `dungeon_settings` VALUES('default_background_position', '', '', 'center top', 'string');
INSERT INTO `dungeon_settings` VALUES('default_background_repeat', '', '', 'no-repeat', 'string');
INSERT INTO `dungeon_settings` VALUES('partners_logo_display', '', '', 'logo_dark', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_captcha_private_key', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_captcha_public_key', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_email_password', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_email_port', '', '', '25', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_email_secure', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_email_smtp', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_email_username', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_registration_charte', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_registration_status', '', '', '0', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_behance', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_deviantart', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_dribble', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_facebook', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_flickr', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_github', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_google', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_instagram', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_steam', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_twitch', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_twitter', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_social_youtube', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_team_logo', '', '', '0', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_team_biographie', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_team_creation', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_team_name', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_team_type', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_welcome', '', '', '0', 'bool');
INSERT INTO `dungeon_settings` VALUES('dungeon_welcome_content', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_welcome_title', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_welcome_user_id', '', '', '0', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_version_css', '', '', '0', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_monitoring_last_check', '', '', '0', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_http_authentication', '', '', '0', 'bool');
INSERT INTO `dungeon_settings` VALUES('dungeon_http_authentication_name', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance', '', '', '0', 'bool');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_opening', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_title', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_content', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_logo', '', '', '0', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_background', '', '', '0', 'int');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_background_repeat', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_background_position', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_background_color', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_text_color', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_facebook', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_twitter', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_google-plus', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_steam', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('dungeon_maintenance_twitch', '', '', '', 'string');
INSERT INTO `dungeon_settings` VALUES('recruits_alert', '', '', '1', 'bool');
INSERT INTO `dungeon_settings` VALUES('recruits_hide_unavailable', '', '', '1', 'bool');
INSERT INTO `dungeon_settings` VALUES('recruits_per_page', '', '', '5', 'int');
INSERT INTO `dungeon_settings` VALUES('recruits_send_mail', '', '', '1', 'bool');
INSERT INTO `dungeon_settings` VALUES('recruits_send_mp', '', '', '1', 'bool');
INSERT INTO `dungeon_settings` VALUES('events_alert_mp', '', '', '1', 'string');
INSERT INTO `dungeon_settings` VALUES('events_per_page', '', '', '10', 'string');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_settings_addons`
--

DROP TABLE IF EXISTS `dungeon_settings_addons`;
CREATE TABLE IF NOT EXISTS `dungeon_settings_addons` (
  `name` varchar(100) NOT NULL,
  `type` enum('module','theme','widget') NOT NULL,
  `is_enabled` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_settings_addons`
--

INSERT INTO `dungeon_settings_addons` VALUES('access', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('addons', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('admin', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('awards', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('awards', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('breadcrumb', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('comments', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('contact', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('default', 'theme', '1');
INSERT INTO `dungeon_settings_addons` VALUES('error', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('error', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('events', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('events', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('forum', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('forum', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('gallery', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('gallery', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('games', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('header', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('html', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('live_editor', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('members', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('members', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('module', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('monitoring', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('navigation', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('news', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('news', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('pages', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('partners', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('partners', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('recruits', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('recruits', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('search', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('search', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('settings', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('slider', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('statistics', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('talks', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('talks', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('teams', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('teams', 'widget', '1');
INSERT INTO `dungeon_settings_addons` VALUES('user', 'module', '1');
INSERT INTO `dungeon_settings_addons` VALUES('user', 'widget', '1');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_settings_authenticators`
--

DROP TABLE IF EXISTS `dungeon_settings_authenticators`;
CREATE TABLE IF NOT EXISTS `dungeon_settings_authenticators` (
  `name` varchar(100) NOT NULL,
  `settings` text NOT NULL,
  `is_enabled` enum('0','1') NOT NULL DEFAULT '0',
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_settings_authenticators`
--

INSERT INTO `dungeon_settings_authenticators` VALUES('facebook', 'a:0:{}', '0', 0);
INSERT INTO `dungeon_settings_authenticators` VALUES('twitter', 'a:0:{}', '0', 1);
INSERT INTO `dungeon_settings_authenticators` VALUES('google', 'a:0:{}', '0', 2);
INSERT INTO `dungeon_settings_authenticators` VALUES('battle_net', 'a:0:{}', '0', 3);
INSERT INTO `dungeon_settings_authenticators` VALUES('steam', 'a:0:{}', '0', 4);
INSERT INTO `dungeon_settings_authenticators` VALUES('twitch', 'a:0:{}', '0', 5);
INSERT INTO `dungeon_settings_authenticators` VALUES('github', 'a:0:{}', '0', 6);
INSERT INTO `dungeon_settings_authenticators` VALUES('linkedin', 'a:0:{}', '0', 7);

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_settings_languages`
--

DROP TABLE IF EXISTS `dungeon_settings_languages`;
CREATE TABLE IF NOT EXISTS `dungeon_settings_languages` (
  `code` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_settings_languages`
--

INSERT INTO `dungeon_settings_languages` VALUES('en', 'English', 'gb.png', 1);
INSERT INTO `dungeon_settings_languages` VALUES('fr', 'Français', 'fr.png', 2);
INSERT INTO `dungeon_settings_languages` VALUES('de', 'Deutsch', 'de.png', 3);
INSERT INTO `dungeon_settings_languages` VALUES('es', 'Español', 'es.png', 4);
INSERT INTO `dungeon_settings_languages` VALUES('it', 'Italiano', 'it.png', 5);
INSERT INTO `dungeon_settings_languages` VALUES('pt', 'Português', 'pt.png', 6);

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_settings_smileys`
--

DROP TABLE IF EXISTS `dungeon_settings_smileys`;
CREATE TABLE IF NOT EXISTS `dungeon_settings_smileys` (
  `smiley_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_id` int(11) UNSIGNED NOT NULL,
  `code` varchar(15) NOT NULL,
  PRIMARY KEY (`smiley_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_statistics`
--

DROP TABLE IF EXISTS `dungeon_statistics`;
CREATE TABLE IF NOT EXISTS `dungeon_statistics` (
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_statistics`
--

INSERT INTO `dungeon_statistics` VALUES('dungeon_sessions_max_simultaneous', '0');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_talks`
--

DROP TABLE IF EXISTS `dungeon_talks`;
CREATE TABLE IF NOT EXISTS `dungeon_talks` (
  `talk_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`talk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dungeon_talks`
--

INSERT INTO `dungeon_talks` VALUES(1, 'admin');
INSERT INTO `dungeon_talks` VALUES(2, 'public');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_talks_messages`
--

DROP TABLE IF EXISTS `dungeon_talks_messages`;
CREATE TABLE IF NOT EXISTS `dungeon_talks_messages` (
  `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `talk_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dungeon_talks_messages`
--

INSERT INTO `dungeon_talks_messages` VALUES(1, 2, 1, 'Welcome to your new website !', CURRENT_TIMESTAMP);

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_teams`
--

DROP TABLE IF EXISTS `dungeon_teams`;
CREATE TABLE IF NOT EXISTS `dungeon_teams` (
  `team_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `game_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `icon_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`team_id`),
  KEY `activity_id` (`game_id`),
  KEY `image_id` (`image_id`),
  KEY `icon_id` (`icon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_teams_lang`
--

DROP TABLE IF EXISTS `dungeon_teams_lang`;
CREATE TABLE IF NOT EXISTS `dungeon_teams_lang` (
  `team_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`team_id`,`lang`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_teams_roles`
--

DROP TABLE IF EXISTS `dungeon_teams_roles`;
CREATE TABLE IF NOT EXISTS `dungeon_teams_roles` (
  `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_teams_users`
--

DROP TABLE IF EXISTS `dungeon_teams_users`;
CREATE TABLE IF NOT EXISTS `dungeon_teams_users` (
  `team_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`team_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_users`
--

DROP TABLE IF EXISTS `dungeon_users`;
CREATE TABLE IF NOT EXISTS `dungeon_users` (
  `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(34) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_activity_date` timestamp NULL DEFAULT NULL,
  `admin` enum('0','1') NOT NULL DEFAULT '0',
  `language` varchar(5) NULL DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `language` (`language`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_users`
--

INSERT INTO `dungeon_users` VALUES(1, 'admin', '$H$92EwygSmbdXunbIvoo/V91MWcnHqzX/', '', 'noreply@dungeon.com', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1', NULL, '0');

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_users_auth`
--

DROP TABLE IF EXISTS `dungeon_users_auth`;
CREATE TABLE IF NOT EXISTS `dungeon_users_auth` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `authenticator` varchar(100) NOT NULL,
  `id` varchar(250) NOT NULL,
  PRIMARY KEY (`authenticator`,`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_users_groups`
--

DROP TABLE IF EXISTS `dungeon_users_groups`;
CREATE TABLE IF NOT EXISTS `dungeon_users_groups` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_users_keys`
--

DROP TABLE IF EXISTS `dungeon_users_keys`;
CREATE TABLE IF NOT EXISTS `dungeon_users_keys` (
  `key_id` varchar(32) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`),
  KEY `user_id` (`user_id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_users_messages`
--

DROP TABLE IF EXISTS `dungeon_users_messages`;
CREATE TABLE IF NOT EXISTS `dungeon_users_messages` (
  `message_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reply_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `last_reply_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `reply_id` (`reply_id`),
  KEY `last_reply_id` (`last_reply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_users_messages_recipients`
--

DROP TABLE IF EXISTS `dungeon_users_messages_recipients`;
CREATE TABLE IF NOT EXISTS `dungeon_users_messages_recipients` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `message_id` int(11) UNSIGNED NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`message_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_users_messages_replies`
--

DROP TABLE IF EXISTS `dungeon_users_messages_replies`;
CREATE TABLE IF NOT EXISTS `dungeon_users_messages_replies` (
  `reply_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `message_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reply_id`),
  KEY `message_id` (`message_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_users_profiles`
--

DROP TABLE IF EXISTS `dungeon_users_profiles`;
CREATE TABLE IF NOT EXISTS `dungeon_users_profiles` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `avatar` int(11) UNSIGNED NULL DEFAULT NULL,
  `signature` text NOT NULL,
  `date_of_birth` date NULL DEFAULT NULL,
  `sex` enum('male','female') NULL DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  `quote` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `avatar` (`avatar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_votes`
--

DROP TABLE IF EXISTS `dungeon_votes`;
CREATE TABLE IF NOT EXISTS `dungeon_votes` (
  `module_id` int(11) UNSIGNED NOT NULL,
  `module` varchar(100) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `note` tinyint(4) NOT NULL,
  PRIMARY KEY (`module_id`,`module`,`user_id`),
  KEY `module` (`module`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dungeon_widgets`
--

DROP TABLE IF EXISTS `dungeon_widgets`;
CREATE TABLE IF NOT EXISTS `dungeon_widgets` (
  `widget_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `widget` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `title` varchar(100) NULL DEFAULT NULL,
  `settings` text,
  PRIMARY KEY (`widget_id`),
  KEY `widget_name` (`widget`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dungeon_widgets`
--

INSERT INTO `dungeon_widgets` VALUES(1, 'talks', 'index', NULL, 'a:1:{s:7:"talk_id";s:1:"1";}');
INSERT INTO `dungeon_widgets` VALUES(2, 'breadcrumb', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(3, 'search', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(4, 'module', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(5, 'navigation', 'index', NULL, 'a:2:{s:7:"display";b:0;s:5:"links";a:6:{i:0;a:2:{s:5:"title";s:17:"News";s:3:"url";s:4:"news";}i:1;a:2:{s:5:"title";s:7:"Members";s:3:"url";s:7:"members";}i:2;a:2:{s:5:"title";s:12:"Recruitement";s:3:"url";s:8:"recruits";}i:3;a:2:{s:5:"title";s:6:"Gallery";s:3:"url";s:7:"gallery";}i:4;a:2:{s:5:"title";s:10:"Search";s:3:"url";s:6:"search";}i:5;a:2:{s:5:"title";s:7:"Contacts";s:3:"url";s:7:"contact";}}}');
INSERT INTO `dungeon_widgets` VALUES(6, 'partners', 'column', NULL, 'a:1:{s:13:"display_style";s:5:"light";}');
INSERT INTO `dungeon_widgets` VALUES(7, 'user', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(8, 'news', 'categories', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(9, 'talks', 'index', NULL, 'a:1:{s:7:"talk_id";i:2;}');
INSERT INTO `dungeon_widgets` VALUES(10, 'members', 'online', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(11, 'forum', 'topics', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(12, 'news', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(13, 'members', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(14, 'header', 'index', NULL, 'a:5:{s:5:"align";s:11:"text-center";s:5:"title";s:0:"";s:11:"description";s:0:"";s:11:"color-title";s:0:"";s:17:"color-description";s:7:"#DC351E";}');
INSERT INTO `dungeon_widgets` VALUES(15, 'navigation', 'index', NULL, 'a:2:{s:7:"display";b:1;s:5:"links";a:6:{i:0;a:2:{s:5:"title";s:4:"Home";s:3:"url";s:0:"";}i:1;a:2:{s:5:"title";s:5:"Forum";s:3:"url";s:5:"forum";}i:2;a:2:{s:5:"title";s:5:"Teams";s:3:"url";s:5:"teams";}i:3;a:2:{s:5:"title";s:7:"Matches";s:3:"url";s:14:"events/matches";}i:4;a:2:{s:5:"title";s:8:"Partners";s:3:"url";s:8:"partners";}i:5;a:2:{s:5:"title";s:6:"Awards";s:3:"url";s:6:"awards";}}}');
INSERT INTO `dungeon_widgets` VALUES(16, 'user', 'index_mini', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(17, 'navigation', 'index', NULL, 'a:2:{s:7:"display";b:1;s:5:"links";a:4:{i:0;a:2:{s:5:"title";s:8:"Facebook";s:3:"url";s:1:"#";}i:1;a:2:{s:5:"title";s:7:"Twitter";s:3:"url";s:1:"#";}i:2;a:2:{s:5:"title";s:6:"Origin";s:3:"url";s:1:"#";}i:3;a:2:{s:5:"title";s:5:"Steam";s:3:"url";s:1:"#";}}}');
INSERT INTO `dungeon_widgets` VALUES(18, 'members', 'online_mini', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(19, 'html', 'index', NULL, 'a:1:{s:7:"content";s:92:"[center]Powered by [url=https://dungeon.com]Dungeon CMS[/url] version Alpha 0.1.6.1[/center]";}');
INSERT INTO `dungeon_widgets` VALUES(20, 'header', 'index', NULL, 'a:5:{s:5:"align";s:11:"text-center";s:5:"title";s:0:"";s:11:"description";s:0:"";s:11:"color-title";s:0:"";s:17:"color-description";s:7:"#DC351E";}');
INSERT INTO `dungeon_widgets` VALUES(21, 'navigation', 'index', NULL, 'a:2:{s:7:"display";b:1;s:5:"links";a:6:{i:0;a:2:{s:5:"title";s:4:"Home";s:3:"url";s:0:"";}i:1;a:2:{s:5:"title";s:5:"Forum";s:3:"url";s:5:"forum";}i:2;a:2:{s:5:"title";s:5:"Teams";s:3:"url";s:5:"teams";}i:3;a:2:{s:7:"title";s:6:"Matches";s:3:"url";s:14:"events/matches";}i:4;a:2:{s:5:"title";s:8:"Partners";s:3:"url";s:8:"partners";}i:5;a:2:{s:5:"title";s:6:"Awards";s:3:"url";s:6:"awards";}}}');
INSERT INTO `dungeon_widgets` VALUES(22, 'user', 'index_mini', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(23, 'slider', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(24, 'breadcrumb', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(25, 'search', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(26, 'module', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(27, 'breadcrumb', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(28, 'search', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(29, 'module', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(30, 'breadcrumb', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(31, 'search', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(32, 'module', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(33, 'breadcrumb', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(34, 'module', 'index', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(35, 'forum', 'statistics', NULL, NULL);
INSERT INTO `dungeon_widgets` VALUES(36, 'forum', 'activity', NULL, NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `dungeon_access`
--
ALTER TABLE `dungeon_access`
  ADD CONSTRAINT `dungeon_access_ibfk_1` FOREIGN KEY (`module`) REFERENCES `dungeon_settings_addons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_access_details`
--
ALTER TABLE `dungeon_access_details`
  ADD CONSTRAINT `dungeon_access_details_ibfk_1` FOREIGN KEY (`access_id`) REFERENCES `dungeon_access` (`access_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_awards`
--
ALTER TABLE `dungeon_awards`
  ADD CONSTRAINT `dungeon_awards_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_awards_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_awards_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_comments`
--
ALTER TABLE `dungeon_comments`
  ADD CONSTRAINT `dungeon_comments_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `dungeon_comments` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_comments_ibfk_3` FOREIGN KEY (`module`) REFERENCES `dungeon_settings_addons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_events`
--
ALTER TABLE `dungeon_events`
  ADD CONSTRAINT `dungeon_events_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `dungeon_events_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_events_matches`
--
ALTER TABLE `dungeon_events_matches`
  ADD CONSTRAINT `dungeon_events_matches_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_matches_ibfk_2` FOREIGN KEY (`opponent_id`) REFERENCES `dungeon_events_matches_opponents` (`opponent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_matches_ibfk_3` FOREIGN KEY (`mode_id`) REFERENCES `dungeon_games_modes` (`mode_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_events_matches_opponents`
--
ALTER TABLE `dungeon_events_matches_opponents`
  ADD CONSTRAINT `dungeon_events_matches_opponents_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_events_matches_rounds`
--
ALTER TABLE `dungeon_events_matches_rounds`
  ADD CONSTRAINT `dungeon_events_matches_rounds_ibfk_1` FOREIGN KEY (`map_id`) REFERENCES `dungeon_games_maps` (`map_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_matches_rounds_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_events_participants`
--
ALTER TABLE `dungeon_events_participants`
  ADD CONSTRAINT `dungeon_events_participants_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_files`
--
ALTER TABLE `dungeon_files`
  ADD CONSTRAINT `dungeon_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_forum`
--
ALTER TABLE `dungeon_forum`
  ADD CONSTRAINT `dungeon_forum_ibfk_1` FOREIGN KEY (`last_message_id`) REFERENCES `dungeon_forum_messages` (`message_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_forum_messages`
--
ALTER TABLE `dungeon_forum_messages`
  ADD CONSTRAINT `dungeon_forum_messages_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `dungeon_forum_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_forum_read`
--
ALTER TABLE `dungeon_forum_read`
  ADD CONSTRAINT `dungeon_forum_read_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_forum_topics`
--
ALTER TABLE `dungeon_forum_topics`
  ADD CONSTRAINT `dungeon_forum_topics_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `dungeon_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_topics_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `dungeon_forum_messages` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_topics_ibfk_3` FOREIGN KEY (`last_message_id`) REFERENCES `dungeon_forum_messages` (`message_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_forum_topics_read`
--
ALTER TABLE `dungeon_forum_topics_read`
  ADD CONSTRAINT `dungeon_forum_topics_read_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `dungeon_forum_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_topics_read_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_forum_track`
--
ALTER TABLE `dungeon_forum_track`
  ADD CONSTRAINT `dungeon_forum_track_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `dungeon_forum_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_track_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_forum_url`
--
ALTER TABLE `dungeon_forum_url`
  ADD CONSTRAINT `dungeon_forum_url_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `dungeon_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_gallery`
--
ALTER TABLE `dungeon_gallery`
  ADD CONSTRAINT `dungeon_gallery_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dungeon_gallery_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_gallery_categories`
--
ALTER TABLE `dungeon_gallery_categories`
  ADD CONSTRAINT `dungeon_gallery_categories_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_categories_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_gallery_categories_lang`
--
ALTER TABLE `dungeon_gallery_categories_lang`
  ADD CONSTRAINT `dungeon_gallery_categories_lang_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dungeon_gallery_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_categories_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_gallery_images`
--
ALTER TABLE `dungeon_gallery_images`
  ADD CONSTRAINT `dungeon_gallery_images_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_images_ibfk_2` FOREIGN KEY (`gallery_id`) REFERENCES `dungeon_gallery` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_images_ibfk_3` FOREIGN KEY (`thumbnail_file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_images_ibfk_4` FOREIGN KEY (`original_file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_gallery_lang`
--
ALTER TABLE `dungeon_gallery_lang`
  ADD CONSTRAINT `dungeon_gallery_lang_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `dungeon_gallery` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_games`
--
ALTER TABLE `dungeon_games`
  ADD CONSTRAINT `dungeon_games_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_games_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_games_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_games_lang`
--
ALTER TABLE `dungeon_games_lang`
  ADD CONSTRAINT `dungeon_games_lang_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_games_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_groups_lang`
--
ALTER TABLE `dungeon_groups_lang`
  ADD CONSTRAINT `dungeon_groups_lang_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `dungeon_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_groups_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_games_maps`
--
ALTER TABLE `dungeon_games_maps`
  ADD CONSTRAINT `dungeon_games_maps_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_games_maps_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_games_modes`
--
ALTER TABLE `dungeon_games_modes`
  ADD CONSTRAINT `dungeon_games_modes_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_news`
--
ALTER TABLE `dungeon_news`
  ADD CONSTRAINT `dungeon_news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_ibfk_4` FOREIGN KEY (`category_id`) REFERENCES `dungeon_news_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_news_categories`
--
ALTER TABLE `dungeon_news_categories`
  ADD CONSTRAINT `dungeon_news_categories_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_categories_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_news_categories_lang`
--
ALTER TABLE `dungeon_news_categories_lang`
  ADD CONSTRAINT `dungeon_news_categories_lang_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dungeon_news_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_categories_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_news_lang`
--
ALTER TABLE `dungeon_news_lang`
  ADD CONSTRAINT `dungeon_news_lang_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `dungeon_news` (`news_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_pages_lang`
--
ALTER TABLE `dungeon_pages_lang`
  ADD CONSTRAINT `dungeon_pages_lang_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `dungeon_pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_pages_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_partners`
--
ALTER TABLE `dungeon_partners`
  ADD CONSTRAINT `dungeon_partners_ibfk_1` FOREIGN KEY (`logo_light`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `dungeon_partners_ibfk_2` FOREIGN KEY (`logo_dark`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_partners_lang`
--
ALTER TABLE `dungeon_partners_lang`
  ADD CONSTRAINT `dungeon_partners_lang_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `dungeon_partners` (`partner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_partners_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_recruits`
--
ALTER TABLE `dungeon_recruits`
  ADD CONSTRAINT `dungeon_recruits_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `dungeon_recruits_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `dungeon_recruits_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_recruits_candidacies`
--
ALTER TABLE `dungeon_recruits_candidacies`
  ADD CONSTRAINT `dungeon_recruits_candidacies_ibfk_1` FOREIGN KEY (`recruit_id`) REFERENCES `dungeon_recruits` (`recruit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_recruits_candidacies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_recruits_candidacies_votes`
--
ALTER TABLE `dungeon_recruits_candidacies_votes`
  ADD CONSTRAINT `dungeon_recruits_candidacies_votes_ibfk_1` FOREIGN KEY (`candidacy_id`) REFERENCES `dungeon_recruits_candidacies` (`candidacy_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_recruits_candidacies_votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_sessions`
--
ALTER TABLE `dungeon_sessions`
  ADD CONSTRAINT `dungeon_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_sessions_history`
--
ALTER TABLE `dungeon_sessions_history`
  ADD CONSTRAINT `dungeon_sessions_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_sessions_history_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `dungeon_sessions` (`session_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_teams`
--
ALTER TABLE `dungeon_teams`
  ADD CONSTRAINT `dungeon_teams_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_ibfk_3` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_teams_lang`
--
ALTER TABLE `dungeon_teams_lang`
  ADD CONSTRAINT `dungeon_teams_lang_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_lang_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_teams_users`
--
ALTER TABLE `dungeon_teams_users`
  ADD CONSTRAINT `dungeon_teams_users_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_users_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `dungeon_teams_roles` (`role_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_users`
--
ALTER TABLE `dungeon_users`
  ADD CONSTRAINT `dungeon_users_ibfk_1` FOREIGN KEY (`language`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_users_auth`
--
ALTER TABLE `dungeon_users_auth`
  ADD CONSTRAINT `dungeon_users_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_auth_ibfk_2` FOREIGN KEY (`authenticator`) REFERENCES `dungeon_settings_authenticators` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_users_groups`
--
ALTER TABLE `dungeon_users_groups`
  ADD CONSTRAINT `dungeon_users_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `dungeon_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_users_keys`
--
ALTER TABLE `dungeon_users_keys`
  ADD CONSTRAINT `dungeon_users_keys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_keys_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `dungeon_sessions` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_users_messages`
--
ALTER TABLE `dungeon_users_messages`
  ADD CONSTRAINT `dungeon_users_messages_ibfk_1` FOREIGN KEY (`reply_id`) REFERENCES `dungeon_users_messages_replies` (`reply_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_messages_ibfk_2` FOREIGN KEY (`last_reply_id`) REFERENCES `dungeon_users_messages_replies` (`reply_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `dungeon_users_messages_recipients`
--
ALTER TABLE `dungeon_users_messages_recipients`
  ADD CONSTRAINT `dungeon_users_messages_recipients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_messages_recipients_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `dungeon_users_messages` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_users_messages_replies`
--
ALTER TABLE `dungeon_users_messages_replies`
  ADD CONSTRAINT `dungeon_users_messages_replies_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `dungeon_users_messages` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_messages_replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_users_profiles`
--
ALTER TABLE `dungeon_users_profiles`
  ADD CONSTRAINT `dungeon_users_profiles_ibfk_2` FOREIGN KEY (`avatar`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_profiles_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_votes`
--
ALTER TABLE `dungeon_votes`
  ADD CONSTRAINT `dungeon_votes_ibfk_1` FOREIGN KEY (`module`) REFERENCES `dungeon_settings_addons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dungeon_widgets`
--
ALTER TABLE `dungeon_widgets`
  ADD CONSTRAINT `dungeon_widgets_ibfk_1` FOREIGN KEY (`widget`) REFERENCES `dungeon_settings_addons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
