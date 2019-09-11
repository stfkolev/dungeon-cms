-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2019 at 02:28 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dungeon`
--

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_access`
--

CREATE TABLE `dungeon_access` (
  `access_id` int(11) UNSIGNED NOT NULL,
  `id` int(11) UNSIGNED NOT NULL,
  `module` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_access`
--

INSERT INTO `dungeon_access` (`access_id`, `id`, `module`, `action`) VALUES
(11, 1, 'events', 'access_events_type'),
(8, 1, 'forum', 'category_announce'),
(7, 1, 'forum', 'category_delete'),
(9, 1, 'forum', 'category_lock'),
(6, 1, 'forum', 'category_modify'),
(10, 1, 'forum', 'category_move'),
(4, 1, 'forum', 'category_read'),
(5, 1, 'forum', 'category_write'),
(12, 2, 'events', 'access_events_type'),
(3, 2, 'talks', 'delete'),
(1, 2, 'talks', 'read'),
(2, 2, 'talks', 'write'),
(13, 3, 'events', 'access_events_type'),
(14, 4, 'events', 'access_events_type'),
(15, 5, 'events', 'access_events_type');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_access_details`
--

CREATE TABLE `dungeon_access_details` (
  `access_id` int(11) UNSIGNED NOT NULL,
  `entity` varchar(100) NOT NULL,
  `type` enum('group','user') NOT NULL DEFAULT 'group',
  `authorized` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_access_details`
--

INSERT INTO `dungeon_access_details` (`access_id`, `entity`, `type`, `authorized`) VALUES
(2, 'visitors', 'group', '0'),
(3, 'admins', 'group', '1'),
(5, 'visitors', 'group', '0'),
(6, 'admins', 'group', '1'),
(7, 'admins', 'group', '1'),
(8, 'admins', 'group', '1'),
(9, 'admins', 'group', '1'),
(10, 'admins', 'group', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_awards`
--

CREATE TABLE `dungeon_awards` (
  `award_id` int(11) UNSIGNED NOT NULL,
  `team_id` int(11) UNSIGNED DEFAULT NULL,
  `game_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `platform` varchar(100) NOT NULL,
  `ranking` int(11) UNSIGNED NOT NULL,
  `participants` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_comments`
--

CREATE TABLE `dungeon_comments` (
  `comment_id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `module_id` int(11) UNSIGNED NOT NULL,
  `module` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_crawlers`
--

CREATE TABLE `dungeon_crawlers` (
  `name` varchar(100) NOT NULL,
  `path` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_dispositions`
--

CREATE TABLE `dungeon_dispositions` (
  `disposition_id` int(11) UNSIGNED NOT NULL,
  `theme` varchar(100) NOT NULL,
  `page` varchar(100) NOT NULL,
  `zone` int(11) UNSIGNED NOT NULL,
  `disposition` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_dispositions`
--

INSERT INTO `dungeon_dispositions` (`disposition_id`, `theme`, `page`, `zone`, `disposition`) VALUES
(1, 'default', '*', 0, 'a:2:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-white\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:2;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-8\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:3;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}}}i:1;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-light\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:4;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-8\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";s:8:\"col-md-4\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:6:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:5;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}i:1;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:6;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";s:10:\"panel-dark\";s:8:\"\0*\0_size\";N;}i:2;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:7;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";s:10:\"panel-dark\";s:8:\"\0*\0_size\";N;}i:3;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:8;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}i:4;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:9;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}i:5;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:10;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";s:9:\"panel-red\";s:8:\"\0*\0_size\";N;}}}}}}'),
(2, 'default', '*', 1, 'a:1:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:11:\"row-default\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:3:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:11;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:12;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";s:10:\"panel-dark\";s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}i:2;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:13;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";s:9:\"panel-red\";s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}}}}'),
(3, 'default', '*', 2, 'a:0:{}'),
(4, 'default', '*', 3, 'a:2:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:11:\"row-default\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:14;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}}}}}i:1;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-black\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:15;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-7\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:16;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-5\";}}}}}}'),
(5, 'default', '*', 4, 'a:1:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:11:\"row-default\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:17;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-8\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:18;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}}}}'),
(6, 'default', '*', 5, 'a:1:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:11:\"row-default\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:19;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";s:10:\"panel-dark\";s:8:\"\0*\0_size\";N;}}}}}}'),
(7, 'default', '/', 3, 'a:3:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:11:\"row-default\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:20;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}}}}}i:1;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-black\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:21;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-7\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:22;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-5\";}}}}}i:2;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:11:\"row-default\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:23;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}}}}}}'),
(8, 'default', 'forum/*', 0, 'a:2:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-white\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:24;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-8\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:25;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}}}i:1;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-light\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:26;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}}}}}}'),
(9, 'default', 'forum/*', 2, 'a:1:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-light\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:35;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";s:9:\"panel-red\";s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:36;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";s:10:\"panel-dark\";s:8:\"\0*\0_size\";s:8:\"col-md-8\";}}}}}}'),
(10, 'default', 'news/_news/*', 0, 'a:2:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-white\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:27;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-8\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:28;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}}}i:1;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-light\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:29;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}}}}}}'),
(11, 'default', 'user/*', 0, 'a:2:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-white\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:30;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-8\";}}}i:1;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:31;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-4\";}}}}}i:1;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-light\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:32;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}}}}}}'),
(12, 'default', 'search/*', 0, 'a:2:{i:0;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-white\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:2:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:33;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";s:8:\"col-md-8\";}}}i:1;N;}}i:1;O:3:\"Row\":3:{s:9:\"\0*\0_style\";s:9:\"row-light\";s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:3:\"Col\":3:{s:8:\"\0*\0_size\";N;s:6:\"\0*\0_id\";N;s:12:\"\0*\0_children\";a:1:{i:0;O:12:\"Panel_widget\":8:{s:6:\"\0*\0_id\";N;s:10:\"\0*\0_widget\";i:34;s:11:\"\0*\0_heading\";a:0:{}s:10:\"\0*\0_footer\";a:0:{}s:8:\"\0*\0_body\";N;s:13:\"\0*\0_body_tags\";N;s:9:\"\0*\0_style\";N;s:8:\"\0*\0_size\";N;}}}}}}');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_events`
--

CREATE TABLE `dungeon_events` (
  `event_id` int(11) UNSIGNED NOT NULL,
  `type_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `private_description` text NOT NULL,
  `location` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_end` timestamp NULL DEFAULT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_events_matches`
--

CREATE TABLE `dungeon_events_matches` (
  `event_id` int(11) UNSIGNED NOT NULL,
  `team_id` int(11) UNSIGNED NOT NULL,
  `opponent_id` int(11) UNSIGNED NOT NULL,
  `mode_id` int(11) UNSIGNED DEFAULT NULL,
  `webtv` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_events_matches_opponents`
--

CREATE TABLE `dungeon_events_matches_opponents` (
  `opponent_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `country` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_events_matches_rounds`
--

CREATE TABLE `dungeon_events_matches_rounds` (
  `round_id` int(11) UNSIGNED NOT NULL,
  `event_id` int(11) UNSIGNED NOT NULL,
  `map_id` int(11) UNSIGNED DEFAULT NULL,
  `score1` int(11) NOT NULL,
  `score2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_events_participants`
--

CREATE TABLE `dungeon_events_participants` (
  `event_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` smallint(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_events_types`
--

CREATE TABLE `dungeon_events_types` (
  `type_id` int(11) UNSIGNED NOT NULL,
  `type` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `icon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_events_types`
--

INSERT INTO `dungeon_events_types` (`type_id`, `type`, `title`, `color`, `icon`) VALUES
(1, 1, 'Entertainment', 'success', 'fa-gamepad'),
(2, 1, 'Friendly game', 'info', 'fa-angellist'),
(3, 1, 'Official Match', 'warning', 'fa-trophy'),
(4, 0, 'IRL', 'primary', 'fa-glass'),
(5, 0, 'Various', 'default', 'fa-comments'),
(6, 1, 'Meeting', 'danger', 'fa-briefcase');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_files`
--

CREATE TABLE `dungeon_files` (
  `file_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `path` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_files`
--

INSERT INTO `dungeon_files` (`file_id`, `user_id`, `name`, `path`, `date`) VALUES
(1, 1, 'Sans-titre-2.jpg', './upload/news/categories/ubfuejdfooirqya0pyltfeklja4ew4sn.jpg', '2015-05-29 22:34:16'),
(2, 1, 'logo.png', 'upload/partners/zwvmsjijfljaka4rdblgvlype1lnbwaw.png', '2016-05-07 16:51:53'),
(3, 1, 'logo_black.png', 'upload/partners/y4ofwq2ekppwnfpmnrmnafeivszlg5bd.png', '2016-05-07 16:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum`
--

CREATE TABLE `dungeon_forum` (
  `forum_id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL,
  `is_subforum` enum('0','1') NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `count_topics` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `count_messages` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_message_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_forum`
--

INSERT INTO `dungeon_forum` (`forum_id`, `parent_id`, `is_subforum`, `title`, `description`, `order`, `count_topics`, `count_messages`, `last_message_id`) VALUES
(1, 1, '0', 'First Forum', 'This is an example forum !', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum_categories`
--

CREATE TABLE `dungeon_forum_categories` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_forum_categories`
--

INSERT INTO `dungeon_forum_categories` (`category_id`, `title`, `order`) VALUES
(1, 'General', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum_messages`
--

CREATE TABLE `dungeon_forum_messages` (
  `message_id` int(11) UNSIGNED NOT NULL,
  `topic_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum_polls`
--

CREATE TABLE `dungeon_forum_polls` (
  `topic_id` int(11) UNSIGNED NOT NULL,
  `question` varchar(100) NOT NULL,
  `answers` text NOT NULL,
  `is_multiple_choice` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum_read`
--

CREATE TABLE `dungeon_forum_read` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `forum_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum_topics`
--

CREATE TABLE `dungeon_forum_topics` (
  `topic_id` int(11) UNSIGNED NOT NULL,
  `forum_id` int(11) UNSIGNED NOT NULL,
  `message_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `status` enum('-2','-1','0','1') NOT NULL DEFAULT '0',
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `count_messages` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_message_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum_topics_read`
--

CREATE TABLE `dungeon_forum_topics_read` (
  `topic_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum_track`
--

CREATE TABLE `dungeon_forum_track` (
  `topic_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_forum_url`
--

CREATE TABLE `dungeon_forum_url` (
  `forum_id` int(11) UNSIGNED NOT NULL,
  `url` varchar(100) NOT NULL,
  `redirects` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_gallery`
--

CREATE TABLE `dungeon_gallery` (
  `gallery_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_gallery_categories`
--

CREATE TABLE `dungeon_gallery_categories` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `icon_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_gallery_categories_lang`
--

CREATE TABLE `dungeon_gallery_categories_lang` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_gallery_images`
--

CREATE TABLE `dungeon_gallery_images` (
  `image_id` int(11) UNSIGNED NOT NULL,
  `thumbnail_file_id` int(11) UNSIGNED NOT NULL,
  `original_file_id` int(11) UNSIGNED NOT NULL,
  `file_id` int(11) UNSIGNED NOT NULL,
  `gallery_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_gallery_lang`
--

CREATE TABLE `dungeon_gallery_lang` (
  `gallery_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_games`
--

CREATE TABLE `dungeon_games` (
  `game_id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `icon_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_games_lang`
--

CREATE TABLE `dungeon_games_lang` (
  `game_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_games_maps`
--

CREATE TABLE `dungeon_games_maps` (
  `map_id` int(11) UNSIGNED NOT NULL,
  `game_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_games_modes`
--

CREATE TABLE `dungeon_games_modes` (
  `mode_id` int(11) UNSIGNED NOT NULL,
  `game_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_groups`
--

CREATE TABLE `dungeon_groups` (
  `group_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `hidden` enum('0','1') NOT NULL DEFAULT '0',
  `auto` enum('0','1') NOT NULL DEFAULT '0',
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_groups_lang`
--

CREATE TABLE `dungeon_groups_lang` (
  `group_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_news`
--

CREATE TABLE `dungeon_news` (
  `news_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` enum('0','1') NOT NULL DEFAULT '0',
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `vote` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_news`
--

INSERT INTO `dungeon_news` (`news_id`, `category_id`, `user_id`, `image_id`, `date`, `published`, `views`, `vote`) VALUES
(1, 1, 1, NULL, '2019-09-04 12:21:35', '1', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_news_categories`
--

CREATE TABLE `dungeon_news_categories` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `icon_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_news_categories`
--

INSERT INTO `dungeon_news_categories` (`category_id`, `image_id`, `icon_id`, `name`) VALUES
(1, 1, NULL, 'general');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_news_categories_lang`
--

CREATE TABLE `dungeon_news_categories_lang` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_news_categories_lang`
--

INSERT INTO `dungeon_news_categories_lang` (`category_id`, `lang`, `title`) VALUES
(1, 'en', 'General');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_news_lang`
--

CREATE TABLE `dungeon_news_lang` (
  `news_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `introduction` text NOT NULL,
  `content` text NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_news_lang`
--

INSERT INTO `dungeon_news_lang` (`news_id`, `lang`, `title`, `introduction`, `content`, `tags`) VALUES
(1, 'en', 'Dungeon Alpha has installed successfully !', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam facilisis libero vel felis vestibulum pellentesque. Donec suscipit porta elit et pellentesque. Donec porta lobortis enim nec consequat. Praesent euismod erat ut justo hendrerit, eget dignissim leo fermentum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam facilisis libero vel felis vestibulum pellentesque. Donec suscipit porta elit et pellentesque. Donec porta lobortis enim nec consequat. Praesent euismod erat ut justo hendrerit, eget dignissim leo fermentum. Integer finibus tortor sed dui sagittis, cursus commodo purus faucibus. Donec iaculis mi sed semper convallis. Fusce a blandit sem.Morbi nec dolor nec nibh vulputate porttitor id a mi. Nam pellentesque, dui ut tempor lacinia, orci eros aliquam libero, et tempor neque nisi porttitor orci. Vestibulum dui neque, auctor efficitur tincidunt eu, volutpat quis nunc. Cras quis massa pharetra, efficitur purus vel, ultrices purus. Sed turpis erat, gravida amet..', 'Dungeon,Cms,Alpha');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_pages`
--

CREATE TABLE `dungeon_pages` (
  `page_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_pages_lang`
--

CREATE TABLE `dungeon_pages_lang` (
  `page_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(100) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_partners`
--

CREATE TABLE `dungeon_partners` (
  `partner_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo_light` int(11) UNSIGNED DEFAULT NULL,
  `logo_dark` int(11) UNSIGNED DEFAULT NULL,
  `website` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `order` tinyint(6) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_partners`
--

INSERT INTO `dungeon_partners` (`partner_id`, `name`, `logo_light`, `logo_dark`, `website`, `facebook`, `twitter`, `code`, `count`, `order`) VALUES
(1, 'dungeon', 2, 3, 'https://dungeon.com', '#', '#', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_partners_lang`
--

CREATE TABLE `dungeon_partners_lang` (
  `partner_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_partners_lang`
--

INSERT INTO `dungeon_partners_lang` (`partner_id`, `lang`, `title`, `description`) VALUES
(1, 'en', 'Dungeon', 'Dungeon is a performance-based lightweight universal gaming content-management system.');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_recruits`
--

CREATE TABLE `dungeon_recruits` (
  `recruit_id` int(11) UNSIGNED NOT NULL,
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
  `image_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_recruits_candidacies`
--

CREATE TABLE `dungeon_recruits_candidacies` (
  `candidacy_id` int(11) UNSIGNED NOT NULL,
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
  `reply` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_recruits_candidacies_votes`
--

CREATE TABLE `dungeon_recruits_candidacies_votes` (
  `vote_id` int(11) UNSIGNED NOT NULL,
  `candidacy_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `vote` enum('0','1') NOT NULL DEFAULT '0',
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_search_keywords`
--

CREATE TABLE `dungeon_search_keywords` (
  `keyword` varchar(100) NOT NULL,
  `count` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_sessions`
--

CREATE TABLE `dungeon_sessions` (
  `session_id` varchar(32) NOT NULL,
  `ip_address` varchar(39) NOT NULL,
  `host_name` varchar(100) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `is_crawler` enum('0','1') NOT NULL DEFAULT '0',
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_data` text NOT NULL,
  `remember_me` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_sessions`
--

INSERT INTO `dungeon_sessions` (`session_id`, `ip_address`, `host_name`, `user_id`, `is_crawler`, `last_activity`, `user_data`, `remember_me`) VALUES
('ruqbqhkyyifttjnsinm93ma9y2wu5ago', '::1', 'DT-VN00453.intercard.bg', NULL, '0', '2019-09-04 12:28:15', 'a:2:{s:7:\"session\";a:6:{s:4:\"date\";i:1567599737;s:10:\"javascript\";b:0;s:13:\"authenticator\";s:0:\"\";s:7:\"referer\";s:25:\"http://localhost/dungeon/\";s:10:\"user_agent\";s:115:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36\";s:7:\"history\";a:7:{i:0;s:5:\"index\";i:1;s:7:\"members\";i:2;s:8:\"recruits\";i:3;s:7:\"gallery\";i:4;s:6:\"search\";i:5;s:6:\"search\";i:6;s:6:\"search\";}}s:4:\"form\";a:1:{s:32:\"6e0fbe194d97aa8c83e9f9e6b5d07c66\";s:32:\"cc3vgvx9jxh4zhroqgsbnckjtxze8zvf\";}}', '0');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_sessions_history`
--

CREATE TABLE `dungeon_sessions_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` varchar(32) DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(39) NOT NULL,
  `host_name` varchar(100) NOT NULL,
  `authenticator` varchar(100) NOT NULL,
  `referer` varchar(100) NOT NULL,
  `user_agent` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_settings`
--

CREATE TABLE `dungeon_settings` (
  `name` varchar(100) NOT NULL,
  `site` varchar(100) NOT NULL DEFAULT '',
  `lang` varchar(5) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `type` enum('string','bool','int','list','array','float') NOT NULL DEFAULT 'string'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_settings`
--

INSERT INTO `dungeon_settings` (`name`, `site`, `lang`, `value`, `type`) VALUES
('default_background', '', '', '0', 'int'),
('default_background_attachment', '', '', 'scroll', 'string'),
('default_background_color', '', '', '#141d26', 'string'),
('default_background_position', '', '', 'center top', 'string'),
('default_background_repeat', '', '', 'no-repeat', 'string'),
('dungeon_analytics', '', '', '', 'string'),
('dungeon_captcha_private_key', '', '', '', 'string'),
('dungeon_captcha_public_key', '', '', '', 'string'),
('dungeon_contact', '', '', 'noreply@dungeon.com', 'string'),
('dungeon_cookie_expire', '', '', '1 hour', 'string'),
('dungeon_cookie_name', '', '', 'session', 'string'),
('dungeon_debug', '', '', '0', 'int'),
('dungeon_default_page', 'default', '', 'news', 'string'),
('dungeon_default_theme', 'default', '', 'default', 'string'),
('dungeon_description', 'default', '', 'Alpha 0.1.7.7', 'string'),
('dungeon_email_password', '', '', '', 'string'),
('dungeon_email_port', '', '', '25', 'int'),
('dungeon_email_secure', '', '', '', 'string'),
('dungeon_email_smtp', '', '', '', 'string'),
('dungeon_email_username', '', '', '', 'string'),
('dungeon_http_authentication', '', '', '0', 'bool'),
('dungeon_http_authentication_name', '', '', '', 'string'),
('dungeon_humans_txt', '', '', '/* TEAM */\n	Dungeon CMS for gamers\n	Contact: contact [at] dungeon.com\n	Twitter: @DungeonCMS\n	From: Bulgaria\n\n	Developer: Stf Kolev\n	Contact: Evil#8815 [at] Discord', 'string'),
('dungeon_maintenance', '', '', '0', 'bool'),
('dungeon_maintenance_background', '', '', '0', 'int'),
('dungeon_maintenance_background_color', '', '', '', 'string'),
('dungeon_maintenance_background_position', '', '', '', 'string'),
('dungeon_maintenance_background_repeat', '', '', '', 'string'),
('dungeon_maintenance_content', '', '', '', 'string'),
('dungeon_maintenance_facebook', '', '', '', 'string'),
('dungeon_maintenance_google-plus', '', '', '', 'string'),
('dungeon_maintenance_logo', '', '', '0', 'int'),
('dungeon_maintenance_opening', '', '', '', 'string'),
('dungeon_maintenance_steam', '', '', '', 'string'),
('dungeon_maintenance_text_color', '', '', '', 'string'),
('dungeon_maintenance_title', '', '', '', 'string'),
('dungeon_maintenance_twitch', '', '', '', 'string'),
('dungeon_maintenance_twitter', '', '', '', 'string'),
('dungeon_monitoring_last_check', '', '', '0', 'int'),
('dungeon_name', 'default', '', 'Dungeon CMS', 'string'),
('dungeon_registration_terms', '', '', '', 'string'),
('dungeon_registration_status', '', '', '0', 'string'),
('dungeon_robots_txt', '', '', 'User-agent: *\r\nDisallow:', 'string'),
('dungeon_social_behance', '', '', '', 'string'),
('dungeon_social_deviantart', '', '', '', 'string'),
('dungeon_social_dribble', '', '', '', 'string'),
('dungeon_social_facebook', '', '', '', 'string'),
('dungeon_social_flickr', '', '', '', 'string'),
('dungeon_social_github', '', '', '', 'string'),
('dungeon_social_google', '', '', '', 'string'),
('dungeon_social_instagram', '', '', '', 'string'),
('dungeon_social_steam', '', '', '', 'string'),
('dungeon_social_twitch', '', '', '', 'string'),
('dungeon_social_twitter', '', '', '', 'string'),
('dungeon_social_youtube', '', '', '', 'string'),
('dungeon_team_biographie', '', '', '', 'string'),
('dungeon_team_creation', '', '', '', 'string'),
('dungeon_team_logo', '', '', '0', 'int'),
('dungeon_team_name', '', '', '', 'string'),
('dungeon_team_type', '', '', '', 'string'),
('dungeon_version_css', '', '', '0', 'int'),
('dungeon_welcome', '', '', '0', 'bool'),
('dungeon_welcome_content', '', '', '', 'string'),
('dungeon_welcome_title', '', '', '', 'string'),
('dungeon_welcome_user_id', '', '', '0', 'int'),
('events_alert_mp', '', '', '1', 'string'),
('events_per_page', '', '', '10', 'string'),
('forum_messages_per_page', '', '', '15', 'int'),
('forum_topics_per_page', '', '', '20', 'int'),
('news_per_page', '', '', '5', 'int'),
('partners_logo_display', '', '', 'logo_dark', 'string'),
('recruits_alert', '', '', '1', 'bool'),
('recruits_hide_unavailable', '', '', '1', 'bool'),
('recruits_per_page', '', '', '5', 'int'),
('recruits_send_mail', '', '', '1', 'bool'),
('recruits_send_mp', '', '', '1', 'bool');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_settings_addons`
--

CREATE TABLE `dungeon_settings_addons` (
  `name` varchar(100) NOT NULL,
  `type` enum('module','theme','widget') NOT NULL,
  `is_enabled` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_settings_addons`
--

INSERT INTO `dungeon_settings_addons` (`name`, `type`, `is_enabled`) VALUES
('access', 'module', '1'),
('addons', 'module', '1'),
('admin', 'module', '1'),
('awards', 'module', '1'),
('awards', 'widget', '1'),
('breadcrumb', 'widget', '1'),
('comments', 'module', '1'),
('contact', 'module', '1'),
('default', 'theme', '1'),
('error', 'module', '1'),
('error', 'widget', '1'),
('events', 'module', '1'),
('events', 'widget', '1'),
('forum', 'module', '1'),
('forum', 'widget', '1'),
('gallery', 'module', '1'),
('gallery', 'widget', '1'),
('games', 'module', '1'),
('header', 'widget', '1'),
('html', 'widget', '1'),
('live_editor', 'module', '1'),
('members', 'module', '1'),
('members', 'widget', '1'),
('module', 'widget', '1'),
('monitoring', 'module', '1'),
('navigation', 'widget', '1'),
('news', 'module', '1'),
('news', 'widget', '1'),
('pages', 'module', '1'),
('partners', 'module', '1'),
('partners', 'widget', '1'),
('recruits', 'module', '1'),
('recruits', 'widget', '1'),
('search', 'module', '1'),
('search', 'widget', '1'),
('settings', 'module', '1'),
('slider', 'widget', '1'),
('statistics', 'module', '1'),
('talks', 'module', '1'),
('talks', 'widget', '1'),
('teams', 'module', '1'),
('teams', 'widget', '1'),
('user', 'module', '1'),
('user', 'widget', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_settings_authenticators`
--

CREATE TABLE `dungeon_settings_authenticators` (
  `name` varchar(100) NOT NULL,
  `settings` text NOT NULL,
  `is_enabled` enum('0','1') NOT NULL DEFAULT '0',
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_settings_authenticators`
--

INSERT INTO `dungeon_settings_authenticators` (`name`, `settings`, `is_enabled`, `order`) VALUES
('battle_net', 'a:0:{}', '0', 3),
('facebook', 'a:0:{}', '0', 0),
('github', 'a:0:{}', '0', 6),
('google', 'a:0:{}', '0', 2),
('linkedin', 'a:0:{}', '0', 7),
('steam', 'a:0:{}', '0', 4),
('twitch', 'a:0:{}', '0', 5),
('twitter', 'a:0:{}', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_settings_languages`
--

CREATE TABLE `dungeon_settings_languages` (
  `code` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_settings_languages`
--

INSERT INTO `dungeon_settings_languages` (`code`, `name`, `flag`, `order`) VALUES 
('en', 'English', 'gb.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_settings_smileys`
--

CREATE TABLE `dungeon_settings_smileys` (
  `smiley_id` int(11) UNSIGNED NOT NULL,
  `file_id` int(11) UNSIGNED NOT NULL,
  `code` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_statistics`
--

CREATE TABLE `dungeon_statistics` (
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_statistics`
--

INSERT INTO `dungeon_statistics` (`name`, `value`) VALUES
('dungeon_sessions_max_simultaneous', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_talks`
--

CREATE TABLE `dungeon_talks` (
  `talk_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dungeon_talks`
--

INSERT INTO `dungeon_talks` (`talk_id`, `name`) VALUES
(1, 'admin'),
(2, 'public');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_talks_messages`
--

CREATE TABLE `dungeon_talks_messages` (
  `message_id` int(10) UNSIGNED NOT NULL,
  `talk_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dungeon_talks_messages`
--

INSERT INTO `dungeon_talks_messages` (`message_id`, `talk_id`, `user_id`, `message`, `date`) VALUES
(1, 2, 1, 'Welcome to your new website !', '2019-09-04 12:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_teams`
--

CREATE TABLE `dungeon_teams` (
  `team_id` int(11) UNSIGNED NOT NULL,
  `game_id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) UNSIGNED DEFAULT NULL,
  `icon_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_teams_lang`
--

CREATE TABLE `dungeon_teams_lang` (
  `team_id` int(11) UNSIGNED NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_teams_roles`
--

CREATE TABLE `dungeon_teams_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `order` smallint(6) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_teams_users`
--

CREATE TABLE `dungeon_teams_users` (
  `team_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_users`
--

CREATE TABLE `dungeon_users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(34) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_activity_date` timestamp NULL DEFAULT NULL,
  `admin` enum('0','1') NOT NULL DEFAULT '0',
  `language` varchar(5) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_users`
--

INSERT INTO `dungeon_users` (`user_id`, `username`, `password`, `salt`, `email`, `registration_date`, `last_activity_date`, `admin`, `language`, `deleted`) VALUES
(1, 'admin', '$H$92EwygSmbdXunbIvoo/V91MWcnHqzX/', '', 'noreply@dungeon.com', '2019-09-04 12:21:48', '2019-09-04 12:21:48', '1', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_users_auth`
--

CREATE TABLE `dungeon_users_auth` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `authenticator` varchar(100) NOT NULL,
  `id` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_users_groups`
--

CREATE TABLE `dungeon_users_groups` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_users_keys`
--

CREATE TABLE `dungeon_users_keys` (
  `key_id` varchar(32) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_users_messages`
--

CREATE TABLE `dungeon_users_messages` (
  `message_id` int(11) UNSIGNED NOT NULL,
  `reply_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `last_reply_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_users_messages_recipients`
--

CREATE TABLE `dungeon_users_messages_recipients` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `message_id` int(11) UNSIGNED NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_users_messages_replies`
--

CREATE TABLE `dungeon_users_messages_replies` (
  `reply_id` int(11) UNSIGNED NOT NULL,
  `message_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_users_profiles`
--

CREATE TABLE `dungeon_users_profiles` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `avatar` int(11) UNSIGNED DEFAULT NULL,
  `signature` text NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `sex` enum('male','female') DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  `quote` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_votes`
--

CREATE TABLE `dungeon_votes` (
  `module_id` int(11) UNSIGNED NOT NULL,
  `module` varchar(100) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `note` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dungeon_widgets`
--

CREATE TABLE `dungeon_widgets` (
  `widget_id` int(11) UNSIGNED NOT NULL,
  `widget` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `settings` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dungeon_widgets`
--

INSERT INTO `dungeon_widgets` (`widget_id`, `widget`, `type`, `title`, `settings`) VALUES
(1, 'talks', 'index', NULL, 'a:1:{s:7:\"talk_id\";s:1:\"1\";}'),
(2, 'breadcrumb', 'index', NULL, NULL),
(3, 'search', 'index', NULL, NULL),
(4, 'module', 'index', NULL, NULL),
(5, 'navigation', 'index', NULL, 'a:2:{s:7:\"display\";b:0;s:5:\"links\";a:6:{i:0;a:2:{s:5:\"title\";s:4:\"News\";s:3:\"url\";s:4:\"news\";}i:1;a:2:{s:5:\"title\";s:7:\"Members\";s:3:\"url\";s:7:\"members\";}i:2;a:2:{s:5:\"title\";s:11:\"Recruitment\";s:3:\"url\";s:8:\"recruits\";}i:3;a:2:{s:5:\"title\";s:7:\"Gallery\";s:3:\"url\";s:7:\"gallery\";}i:4;a:2:{s:5:\"title\";s:6:\"Search\";s:3:\"url\";s:6:\"search\";}i:5;a:2:{s:5:\"title\";s:8:\"Contacts\";s:3:\"url\";s:7:\"contact\";}}}'),
(6, 'partners', 'column', NULL, 'a:1:{s:13:\"display_style\";s:5:\"light\";}'),
(7, 'user', 'index', NULL, NULL),
(8, 'news', 'categories', NULL, NULL),
(9, 'talks', 'index', NULL, 'a:1:{s:7:\"talk_id\";i:2;}'),
(10, 'members', 'online', NULL, NULL),
(11, 'forum', 'topics', NULL, NULL),
(12, 'news', 'index', NULL, NULL),
(13, 'members', 'index', NULL, NULL),
(14, 'header', 'index', NULL, 'a:5:{s:5:\"align\";s:11:\"text-center\";s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:11:\"color-title\";s:0:\"\";s:17:\"color-description\";s:7:\"#DC351E\";}'),
(15, 'navigation', 'index', NULL, 'a:2:{s:7:\"display\";b:1;s:5:\"links\";a:6:{i:0;a:2:{s:5:\"title\";s:4:\"Home\";s:3:\"url\";s:0:\"\";}i:1;a:2:{s:5:\"title\";s:5:\"Forum\";s:3:\"url\";s:5:\"forum\";}i:2;a:2:{s:5:\"title\";s:5:\"Teams\";s:3:\"url\";s:5:\"teams\";}i:3;a:2:{s:5:\"title\";s:6:\"Events\";s:3:\"url\";s:14:\"events/matches\";}i:4;a:2:{s:5:\"title\";s:8:\"Partners\";s:3:\"url\";s:8:\"partners\";}i:5;a:2:{s:5:\"title\";s:6:\"Awards\";s:3:\"url\";s:6:\"awards\";}}}'),
(16, 'user', 'index_mini', NULL, NULL),
(17, 'navigation', 'index', NULL, 'a:2:{s:7:\"display\";b:1;s:5:\"links\";a:4:{i:0;a:2:{s:5:\"title\";s:8:\"Facebook\";s:3:\"url\";s:1:\"#\";}i:1;a:2:{s:5:\"title\";s:7:\"Twitter\";s:3:\"url\";s:1:\"#\";}i:2;a:2:{s:5:\"title\";s:6:\"Origin\";s:3:\"url\";s:1:\"#\";}i:3;a:2:{s:5:\"title\";s:5:\"Steam\";s:3:\"url\";s:1:\"#\";}}}'),
(18, 'members', 'online_mini', NULL, NULL),
(19, 'html', 'index', NULL, 'a:1:{s:7:\"content\";s:92:\"[center]Powered by [url=https://dungeon.com]Dungeon CMS[/url] version Alpha 0.1.7.7[/center]\";}'),
(20, 'header', 'index', NULL, 'a:5:{s:5:\"align\";s:11:\"text-center\";s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:11:\"color-title\";s:0:\"\";s:17:\"color-description\";s:7:\"#DC351E\";}'),
(21, 'navigation', 'index', NULL, 'a:2:{s:7:\"display\";b:1;s:5:\"links\";a:6:{i:0;a:2:{s:5:\"title\";s:4:\"Home\";s:3:\"url\";s:0:\"\";}i:1;a:2:{s:5:\"title\";s:5:\"Forum\";s:3:\"url\";s:5:\"forum\";}i:2;a:2:{s:5:\"title\";s:5:\"Teams\";s:3:\"url\";s:5:\"teams\";}i:3;a:2:{s:5:\"title\";s:6:\"Events\";s:3:\"url\";s:14:\"events/matches\";}i:4;a:2:{s:5:\"title\";s:8:\"Partners\";s:3:\"url\";s:8:\"partners\";}i:5;a:2:{s:5:\"title\";s:6:\"Awards\";s:3:\"url\";s:6:\"awards\";}}}'),
(22, 'user', 'index_mini', NULL, NULL),
(23, 'slider', 'index', NULL, NULL),
(24, 'breadcrumb', 'index', NULL, NULL),
(25, 'search', 'index', NULL, NULL),
(26, 'module', 'index', NULL, NULL),
(27, 'breadcrumb', 'index', NULL, NULL),
(28, 'search', 'index', NULL, NULL),
(29, 'module', 'index', NULL, NULL),
(30, 'breadcrumb', 'index', NULL, NULL),
(31, 'search', 'index', NULL, NULL),
(32, 'module', 'index', NULL, NULL),
(33, 'breadcrumb', 'index', NULL, NULL),
(34, 'module', 'index', NULL, NULL),
(35, 'forum', 'statistics', NULL, NULL),
(36, 'forum', 'activity', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dungeon_access`
--
ALTER TABLE `dungeon_access`
  ADD PRIMARY KEY (`access_id`),
  ADD UNIQUE KEY `module_id` (`id`,`module`,`action`),
  ADD KEY `module` (`module`);

--
-- Indexes for table `dungeon_access_details`
--
ALTER TABLE `dungeon_access_details`
  ADD PRIMARY KEY (`access_id`,`entity`,`type`);

--
-- Indexes for table `dungeon_awards`
--
ALTER TABLE `dungeon_awards`
  ADD PRIMARY KEY (`award_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `dungeon_comments`
--
ALTER TABLE `dungeon_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `module` (`module`);

--
-- Indexes for table `dungeon_dispositions`
--
ALTER TABLE `dungeon_dispositions`
  ADD PRIMARY KEY (`disposition_id`),
  ADD UNIQUE KEY `theme` (`theme`,`page`,`zone`);

--
-- Indexes for table `dungeon_events`
--
ALTER TABLE `dungeon_events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`) USING BTREE,
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `dungeon_events_matches`
--
ALTER TABLE `dungeon_events_matches`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `opponent_id` (`opponent_id`),
  ADD KEY `mode_id` (`mode_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `dungeon_events_matches_opponents`
--
ALTER TABLE `dungeon_events_matches_opponents`
  ADD PRIMARY KEY (`opponent_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `dungeon_events_matches_rounds`
--
ALTER TABLE `dungeon_events_matches_rounds`
  ADD PRIMARY KEY (`round_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `map_id` (`map_id`);

--
-- Indexes for table `dungeon_events_participants`
--
ALTER TABLE `dungeon_events_participants`
  ADD PRIMARY KEY (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_events_types`
--
ALTER TABLE `dungeon_events_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `dungeon_files`
--
ALTER TABLE `dungeon_files`
  ADD PRIMARY KEY (`file_id`),
  ADD UNIQUE KEY `path` (`path`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_forum`
--
ALTER TABLE `dungeon_forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `last_message_id` (`last_message_id`);

--
-- Indexes for table `dungeon_forum_categories`
--
ALTER TABLE `dungeon_forum_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `dungeon_forum_messages`
--
ALTER TABLE `dungeon_forum_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_forum_read`
--
ALTER TABLE `dungeon_forum_read`
  ADD PRIMARY KEY (`user_id`,`forum_id`);

--
-- Indexes for table `dungeon_forum_topics`
--
ALTER TABLE `dungeon_forum_topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD UNIQUE KEY `last_message_id` (`last_message_id`),
  ADD KEY `forum_id` (`forum_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `dungeon_forum_topics_read`
--
ALTER TABLE `dungeon_forum_topics_read`
  ADD PRIMARY KEY (`topic_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_forum_track`
--
ALTER TABLE `dungeon_forum_track`
  ADD PRIMARY KEY (`topic_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_forum_url`
--
ALTER TABLE `dungeon_forum_url`
  ADD PRIMARY KEY (`forum_id`);

--
-- Indexes for table `dungeon_gallery`
--
ALTER TABLE `dungeon_gallery`
  ADD PRIMARY KEY (`gallery_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `dungeon_gallery_categories`
--
ALTER TABLE `dungeon_gallery_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `icon_id` (`icon_id`);

--
-- Indexes for table `dungeon_gallery_categories_lang`
--
ALTER TABLE `dungeon_gallery_categories_lang`
  ADD PRIMARY KEY (`category_id`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_gallery_images`
--
ALTER TABLE `dungeon_gallery_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `gallery_id` (`gallery_id`),
  ADD KEY `original_file_id` (`original_file_id`),
  ADD KEY `thumbnail_file_id` (`thumbnail_file_id`);

--
-- Indexes for table `dungeon_gallery_lang`
--
ALTER TABLE `dungeon_gallery_lang`
  ADD PRIMARY KEY (`gallery_id`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_games`
--
ALTER TABLE `dungeon_games`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `icon_id` (`icon_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `dungeon_games_lang`
--
ALTER TABLE `dungeon_games_lang`
  ADD PRIMARY KEY (`game_id`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_games_maps`
--
ALTER TABLE `dungeon_games_maps`
  ADD PRIMARY KEY (`map_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `dungeon_games_modes`
--
ALTER TABLE `dungeon_games_modes`
  ADD PRIMARY KEY (`mode_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `dungeon_groups`
--
ALTER TABLE `dungeon_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `dungeon_groups_lang`
--
ALTER TABLE `dungeon_groups_lang`
  ADD PRIMARY KEY (`group_id`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_news`
--
ALTER TABLE `dungeon_news`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `dungeon_news_categories`
--
ALTER TABLE `dungeon_news_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `icon_id` (`icon_id`);

--
-- Indexes for table `dungeon_news_categories_lang`
--
ALTER TABLE `dungeon_news_categories_lang`
  ADD PRIMARY KEY (`category_id`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_news_lang`
--
ALTER TABLE `dungeon_news_lang`
  ADD PRIMARY KEY (`news_id`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_pages`
--
ALTER TABLE `dungeon_pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `page` (`name`);

--
-- Indexes for table `dungeon_pages_lang`
--
ALTER TABLE `dungeon_pages_lang`
  ADD PRIMARY KEY (`page_id`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_partners`
--
ALTER TABLE `dungeon_partners`
  ADD PRIMARY KEY (`partner_id`),
  ADD KEY `image_id` (`logo_light`),
  ADD KEY `logo_dark` (`logo_dark`);

--
-- Indexes for table `dungeon_partners_lang`
--
ALTER TABLE `dungeon_partners_lang`
  ADD PRIMARY KEY (`partner_id`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_recruits`
--
ALTER TABLE `dungeon_recruits`
  ADD PRIMARY KEY (`recruit_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `dungeon_recruits_candidacies`
--
ALTER TABLE `dungeon_recruits_candidacies`
  ADD PRIMARY KEY (`candidacy_id`),
  ADD KEY `recruit_id` (`recruit_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_recruits_candidacies_votes`
--
ALTER TABLE `dungeon_recruits_candidacies_votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `candidacy_id` (`candidacy_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_search_keywords`
--
ALTER TABLE `dungeon_search_keywords`
  ADD PRIMARY KEY (`keyword`);

--
-- Indexes for table `dungeon_sessions`
--
ALTER TABLE `dungeon_sessions`
  ADD UNIQUE KEY `session_id` (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_sessions_history`
--
ALTER TABLE `dungeon_sessions_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `dungeon_sessions_history_ibfk_2` (`session_id`);

--
-- Indexes for table `dungeon_settings`
--
ALTER TABLE `dungeon_settings`
  ADD PRIMARY KEY (`name`,`site`,`lang`);

--
-- Indexes for table `dungeon_settings_addons`
--
ALTER TABLE `dungeon_settings_addons`
  ADD PRIMARY KEY (`name`,`type`);

--
-- Indexes for table `dungeon_settings_authenticators`
--
ALTER TABLE `dungeon_settings_authenticators`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `dungeon_settings_languages`
--
ALTER TABLE `dungeon_settings_languages`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `dungeon_settings_smileys`
--
ALTER TABLE `dungeon_settings_smileys`
  ADD PRIMARY KEY (`smiley_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `dungeon_statistics`
--
ALTER TABLE `dungeon_statistics`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `dungeon_talks`
--
ALTER TABLE `dungeon_talks`
  ADD PRIMARY KEY (`talk_id`);

--
-- Indexes for table `dungeon_talks_messages`
--
ALTER TABLE `dungeon_talks_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `dungeon_teams`
--
ALTER TABLE `dungeon_teams`
  ADD PRIMARY KEY (`team_id`),
  ADD KEY `activity_id` (`game_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `icon_id` (`icon_id`);

--
-- Indexes for table `dungeon_teams_lang`
--
ALTER TABLE `dungeon_teams_lang`
  ADD PRIMARY KEY (`team_id`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- Indexes for table `dungeon_teams_roles`
--
ALTER TABLE `dungeon_teams_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `dungeon_teams_users`
--
ALTER TABLE `dungeon_teams_users`
  ADD PRIMARY KEY (`team_id`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `dungeon_users`
--
ALTER TABLE `dungeon_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `language` (`language`),
  ADD KEY `deleted` (`deleted`);

--
-- Indexes for table `dungeon_users_auth`
--
ALTER TABLE `dungeon_users_auth`
  ADD PRIMARY KEY (`authenticator`,`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_users_groups`
--
ALTER TABLE `dungeon_users_groups`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `dungeon_users_keys`
--
ALTER TABLE `dungeon_users_keys`
  ADD PRIMARY KEY (`key_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `dungeon_users_messages`
--
ALTER TABLE `dungeon_users_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `reply_id` (`reply_id`),
  ADD KEY `last_reply_id` (`last_reply_id`);

--
-- Indexes for table `dungeon_users_messages_recipients`
--
ALTER TABLE `dungeon_users_messages_recipients`
  ADD PRIMARY KEY (`user_id`,`message_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `dungeon_users_messages_replies`
--
ALTER TABLE `dungeon_users_messages_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `message_id` (`message_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_users_profiles`
--
ALTER TABLE `dungeon_users_profiles`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `avatar` (`avatar`);

--
-- Indexes for table `dungeon_votes`
--
ALTER TABLE `dungeon_votes`
  ADD PRIMARY KEY (`module_id`,`module`,`user_id`),
  ADD KEY `module` (`module`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dungeon_widgets`
--
ALTER TABLE `dungeon_widgets`
  ADD PRIMARY KEY (`widget_id`),
  ADD KEY `widget_name` (`widget`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dungeon_access`
--
ALTER TABLE `dungeon_access`
  MODIFY `access_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `dungeon_awards`
--
ALTER TABLE `dungeon_awards`
  MODIFY `award_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_comments`
--
ALTER TABLE `dungeon_comments`
  MODIFY `comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_dispositions`
--
ALTER TABLE `dungeon_dispositions`
  MODIFY `disposition_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dungeon_events`
--
ALTER TABLE `dungeon_events`
  MODIFY `event_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_events_matches_opponents`
--
ALTER TABLE `dungeon_events_matches_opponents`
  MODIFY `opponent_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_events_matches_rounds`
--
ALTER TABLE `dungeon_events_matches_rounds`
  MODIFY `round_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_events_types`
--
ALTER TABLE `dungeon_events_types`
  MODIFY `type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dungeon_files`
--
ALTER TABLE `dungeon_files`
  MODIFY `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dungeon_forum`
--
ALTER TABLE `dungeon_forum`
  MODIFY `forum_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dungeon_forum_categories`
--
ALTER TABLE `dungeon_forum_categories`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dungeon_forum_messages`
--
ALTER TABLE `dungeon_forum_messages`
  MODIFY `message_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_forum_topics`
--
ALTER TABLE `dungeon_forum_topics`
  MODIFY `topic_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_gallery`
--
ALTER TABLE `dungeon_gallery`
  MODIFY `gallery_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_gallery_categories`
--
ALTER TABLE `dungeon_gallery_categories`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_gallery_images`
--
ALTER TABLE `dungeon_gallery_images`
  MODIFY `image_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_games`
--
ALTER TABLE `dungeon_games`
  MODIFY `game_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_games_maps`
--
ALTER TABLE `dungeon_games_maps`
  MODIFY `map_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_games_modes`
--
ALTER TABLE `dungeon_games_modes`
  MODIFY `mode_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_groups`
--
ALTER TABLE `dungeon_groups`
  MODIFY `group_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_news`
--
ALTER TABLE `dungeon_news`
  MODIFY `news_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dungeon_news_categories`
--
ALTER TABLE `dungeon_news_categories`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dungeon_pages`
--
ALTER TABLE `dungeon_pages`
  MODIFY `page_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_partners`
--
ALTER TABLE `dungeon_partners`
  MODIFY `partner_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dungeon_partners_lang`
--
ALTER TABLE `dungeon_partners_lang`
  MODIFY `partner_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dungeon_recruits`
--
ALTER TABLE `dungeon_recruits`
  MODIFY `recruit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_recruits_candidacies`
--
ALTER TABLE `dungeon_recruits_candidacies`
  MODIFY `candidacy_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_recruits_candidacies_votes`
--
ALTER TABLE `dungeon_recruits_candidacies_votes`
  MODIFY `vote_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_sessions_history`
--
ALTER TABLE `dungeon_sessions_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_settings_smileys`
--
ALTER TABLE `dungeon_settings_smileys`
  MODIFY `smiley_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_talks`
--
ALTER TABLE `dungeon_talks`
  MODIFY `talk_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dungeon_talks_messages`
--
ALTER TABLE `dungeon_talks_messages`
  MODIFY `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dungeon_teams`
--
ALTER TABLE `dungeon_teams`
  MODIFY `team_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_teams_roles`
--
ALTER TABLE `dungeon_teams_roles`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_users`
--
ALTER TABLE `dungeon_users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dungeon_users_messages`
--
ALTER TABLE `dungeon_users_messages`
  MODIFY `message_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_users_messages_replies`
--
ALTER TABLE `dungeon_users_messages_replies`
  MODIFY `reply_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dungeon_widgets`
--
ALTER TABLE `dungeon_widgets`
  MODIFY `widget_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dungeon_access`
--
ALTER TABLE `dungeon_access`
  ADD CONSTRAINT `dungeon_access_ibfk_1` FOREIGN KEY (`module`) REFERENCES `dungeon_settings_addons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_access_details`
--
ALTER TABLE `dungeon_access_details`
  ADD CONSTRAINT `dungeon_access_details_ibfk_1` FOREIGN KEY (`access_id`) REFERENCES `dungeon_access` (`access_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_awards`
--
ALTER TABLE `dungeon_awards`
  ADD CONSTRAINT `dungeon_awards_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_awards_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_awards_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_comments`
--
ALTER TABLE `dungeon_comments`
  ADD CONSTRAINT `dungeon_comments_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `dungeon_comments` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_comments_ibfk_3` FOREIGN KEY (`module`) REFERENCES `dungeon_settings_addons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_events`
--
ALTER TABLE `dungeon_events`
  ADD CONSTRAINT `dungeon_events_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `dungeon_events_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_events_matches`
--
ALTER TABLE `dungeon_events_matches`
  ADD CONSTRAINT `dungeon_events_matches_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_matches_ibfk_2` FOREIGN KEY (`opponent_id`) REFERENCES `dungeon_events_matches_opponents` (`opponent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_matches_ibfk_3` FOREIGN KEY (`mode_id`) REFERENCES `dungeon_games_modes` (`mode_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_events_matches_opponents`
--
ALTER TABLE `dungeon_events_matches_opponents`
  ADD CONSTRAINT `dungeon_events_matches_opponents_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_events_matches_rounds`
--
ALTER TABLE `dungeon_events_matches_rounds`
  ADD CONSTRAINT `dungeon_events_matches_rounds_ibfk_1` FOREIGN KEY (`map_id`) REFERENCES `dungeon_games_maps` (`map_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_matches_rounds_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_events_participants`
--
ALTER TABLE `dungeon_events_participants`
  ADD CONSTRAINT `dungeon_events_participants_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_events_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_files`
--
ALTER TABLE `dungeon_files`
  ADD CONSTRAINT `dungeon_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_forum`
--
ALTER TABLE `dungeon_forum`
  ADD CONSTRAINT `dungeon_forum_ibfk_1` FOREIGN KEY (`last_message_id`) REFERENCES `dungeon_forum_messages` (`message_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_forum_messages`
--
ALTER TABLE `dungeon_forum_messages`
  ADD CONSTRAINT `dungeon_forum_messages_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `dungeon_forum_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_forum_read`
--
ALTER TABLE `dungeon_forum_read`
  ADD CONSTRAINT `dungeon_forum_read_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_forum_topics`
--
ALTER TABLE `dungeon_forum_topics`
  ADD CONSTRAINT `dungeon_forum_topics_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `dungeon_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_topics_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `dungeon_forum_messages` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_topics_ibfk_3` FOREIGN KEY (`last_message_id`) REFERENCES `dungeon_forum_messages` (`message_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_forum_topics_read`
--
ALTER TABLE `dungeon_forum_topics_read`
  ADD CONSTRAINT `dungeon_forum_topics_read_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `dungeon_forum_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_topics_read_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_forum_track`
--
ALTER TABLE `dungeon_forum_track`
  ADD CONSTRAINT `dungeon_forum_track_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `dungeon_forum_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_forum_track_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_forum_url`
--
ALTER TABLE `dungeon_forum_url`
  ADD CONSTRAINT `dungeon_forum_url_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `dungeon_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_gallery`
--
ALTER TABLE `dungeon_gallery`
  ADD CONSTRAINT `dungeon_gallery_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dungeon_gallery_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_gallery_categories`
--
ALTER TABLE `dungeon_gallery_categories`
  ADD CONSTRAINT `dungeon_gallery_categories_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_categories_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_gallery_categories_lang`
--
ALTER TABLE `dungeon_gallery_categories_lang`
  ADD CONSTRAINT `dungeon_gallery_categories_lang_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dungeon_gallery_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_categories_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_gallery_images`
--
ALTER TABLE `dungeon_gallery_images`
  ADD CONSTRAINT `dungeon_gallery_images_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_images_ibfk_2` FOREIGN KEY (`gallery_id`) REFERENCES `dungeon_gallery` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_images_ibfk_3` FOREIGN KEY (`thumbnail_file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_images_ibfk_4` FOREIGN KEY (`original_file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_gallery_lang`
--
ALTER TABLE `dungeon_gallery_lang`
  ADD CONSTRAINT `dungeon_gallery_lang_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `dungeon_gallery` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_gallery_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_games`
--
ALTER TABLE `dungeon_games`
  ADD CONSTRAINT `dungeon_games_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_games_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_games_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_games_lang`
--
ALTER TABLE `dungeon_games_lang`
  ADD CONSTRAINT `dungeon_games_lang_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_games_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_games_maps`
--
ALTER TABLE `dungeon_games_maps`
  ADD CONSTRAINT `dungeon_games_maps_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_games_maps_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_games_modes`
--
ALTER TABLE `dungeon_games_modes`
  ADD CONSTRAINT `dungeon_games_modes_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_groups_lang`
--
ALTER TABLE `dungeon_groups_lang`
  ADD CONSTRAINT `dungeon_groups_lang_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `dungeon_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_groups_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_news`
--
ALTER TABLE `dungeon_news`
  ADD CONSTRAINT `dungeon_news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_ibfk_4` FOREIGN KEY (`category_id`) REFERENCES `dungeon_news_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_news_categories`
--
ALTER TABLE `dungeon_news_categories`
  ADD CONSTRAINT `dungeon_news_categories_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_categories_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_news_categories_lang`
--
ALTER TABLE `dungeon_news_categories_lang`
  ADD CONSTRAINT `dungeon_news_categories_lang_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dungeon_news_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_categories_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_news_lang`
--
ALTER TABLE `dungeon_news_lang`
  ADD CONSTRAINT `dungeon_news_lang_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `dungeon_news` (`news_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_news_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_pages_lang`
--
ALTER TABLE `dungeon_pages_lang`
  ADD CONSTRAINT `dungeon_pages_lang_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `dungeon_pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_pages_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_partners`
--
ALTER TABLE `dungeon_partners`
  ADD CONSTRAINT `dungeon_partners_ibfk_1` FOREIGN KEY (`logo_light`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `dungeon_partners_ibfk_2` FOREIGN KEY (`logo_dark`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_partners_lang`
--
ALTER TABLE `dungeon_partners_lang`
  ADD CONSTRAINT `dungeon_partners_lang_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `dungeon_partners` (`partner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_partners_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_recruits`
--
ALTER TABLE `dungeon_recruits`
  ADD CONSTRAINT `dungeon_recruits_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `dungeon_recruits_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `dungeon_recruits_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_recruits_candidacies`
--
ALTER TABLE `dungeon_recruits_candidacies`
  ADD CONSTRAINT `dungeon_recruits_candidacies_ibfk_1` FOREIGN KEY (`recruit_id`) REFERENCES `dungeon_recruits` (`recruit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_recruits_candidacies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_recruits_candidacies_votes`
--
ALTER TABLE `dungeon_recruits_candidacies_votes`
  ADD CONSTRAINT `dungeon_recruits_candidacies_votes_ibfk_1` FOREIGN KEY (`candidacy_id`) REFERENCES `dungeon_recruits_candidacies` (`candidacy_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_recruits_candidacies_votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_sessions`
--
ALTER TABLE `dungeon_sessions`
  ADD CONSTRAINT `dungeon_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_sessions_history`
--
ALTER TABLE `dungeon_sessions_history`
  ADD CONSTRAINT `dungeon_sessions_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_sessions_history_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `dungeon_sessions` (`session_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_teams`
--
ALTER TABLE `dungeon_teams`
  ADD CONSTRAINT `dungeon_teams_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_ibfk_3` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_teams_lang`
--
ALTER TABLE `dungeon_teams_lang`
  ADD CONSTRAINT `dungeon_teams_lang_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_lang_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_teams_users`
--
ALTER TABLE `dungeon_teams_users`
  ADD CONSTRAINT `dungeon_teams_users_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_teams_users_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `dungeon_teams_roles` (`role_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_users`
--
ALTER TABLE `dungeon_users`
  ADD CONSTRAINT `dungeon_users_ibfk_1` FOREIGN KEY (`language`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_users_auth`
--
ALTER TABLE `dungeon_users_auth`
  ADD CONSTRAINT `dungeon_users_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_auth_ibfk_2` FOREIGN KEY (`authenticator`) REFERENCES `dungeon_settings_authenticators` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_users_groups`
--
ALTER TABLE `dungeon_users_groups`
  ADD CONSTRAINT `dungeon_users_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `dungeon_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_users_keys`
--
ALTER TABLE `dungeon_users_keys`
  ADD CONSTRAINT `dungeon_users_keys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_keys_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `dungeon_sessions` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_users_messages`
--
ALTER TABLE `dungeon_users_messages`
  ADD CONSTRAINT `dungeon_users_messages_ibfk_1` FOREIGN KEY (`reply_id`) REFERENCES `dungeon_users_messages_replies` (`reply_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_messages_ibfk_2` FOREIGN KEY (`last_reply_id`) REFERENCES `dungeon_users_messages_replies` (`reply_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `dungeon_users_messages_recipients`
--
ALTER TABLE `dungeon_users_messages_recipients`
  ADD CONSTRAINT `dungeon_users_messages_recipients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_messages_recipients_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `dungeon_users_messages` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_users_messages_replies`
--
ALTER TABLE `dungeon_users_messages_replies`
  ADD CONSTRAINT `dungeon_users_messages_replies_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `dungeon_users_messages` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_messages_replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_users_profiles`
--
ALTER TABLE `dungeon_users_profiles`
  ADD CONSTRAINT `dungeon_users_profiles_ibfk_2` FOREIGN KEY (`avatar`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_users_profiles_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_votes`
--
ALTER TABLE `dungeon_votes`
  ADD CONSTRAINT `dungeon_votes_ibfk_1` FOREIGN KEY (`module`) REFERENCES `dungeon_settings_addons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dungeon_votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dungeon_widgets`
--
ALTER TABLE `dungeon_widgets`
  ADD CONSTRAINT `dungeon_widgets_ibfk_1` FOREIGN KEY (`widget`) REFERENCES `dungeon_settings_addons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
