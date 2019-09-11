<?php if (!defined('DUNGEON_CMS')) exit;
/**************************************************************************
Copyright © 2019 Evil

This file is part of Dungeon.

Dungeon is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Dungeon is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Dungeon. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

class i_0_1_4 extends Install
{
	public function up()
	{
		$this->db	->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'addons\', \'module\', \'1\')')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'error\', \'widget\', \'1\')')
					->execute('ALTER TABLE `dungeon_settings_addons` CHANGE `enable` `is_enabled` ENUM(\'0\',\'1\') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'0\'')
					->execute('ALTER TABLE `dungeon_users` DROP `theme`')
					->execute('ALTER TABLE `dungeon_settings_languages` DROP COLUMN `language_id`, DROP COLUMN `domain_extension`, DROP INDEX `code`, DROP PRIMARY KEY, ADD PRIMARY KEY (`code`)')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'search\', \'widget\', \'1\')')
					->execute('ALTER TABLE `dungeon_users_messages` DROP FOREIGN KEY `dungeon_users_messages_ibfk_1`')
					->execute('ALTER TABLE `dungeon_users_messages` CHANGE `user_id` `reply_id` INT(11) UNSIGNED NOT NULL')
					->execute('ALTER TABLE `dungeon_users_messages` ADD `last_reply_id` INT UNSIGNED DEFAULT NULL AFTER `title`, ADD INDEX (`last_reply_id`)')
					->execute('ALTER TABLE `dungeon_users_messages` ADD FOREIGN KEY (`reply_id`) REFERENCES `dungeon_users_messages_replies`(`reply_id`) ON DELETE CASCADE ON UPDATE CASCADE')
					->execute('ALTER TABLE `dungeon_users_messages` ADD FOREIGN KEY (`last_reply_id`) REFERENCES `dungeon_users_messages_replies`(`reply_id`) ON DELETE SET NULL ON UPDATE SET NULL')
					->execute('ALTER TABLE `dungeon_users_messages` DROP `content`, DROP `date`')
					->execute('ALTER TABLE `dungeon_users_messages_recipients` DROP `read`')
					->execute('ALTER TABLE `dungeon_users_messages_recipients` ADD `date` TIMESTAMP NULL DEFAULT NULL AFTER `message_id`')
					->execute('ALTER TABLE `dungeon_users_messages_recipients` ADD `deleted` ENUM(\'0\',\'1\') NOT NULL DEFAULT \'0\' AFTER `date`')
					->execute('ALTER TABLE `dungeon_users_messages_replies` CHANGE `content` `message` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL')
					->execute('ALTER TABLE `dungeon_users_messages_replies` DROP `read`')
					->execute('DROP TABLE IF EXISTS `dungeon_awards`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_awards` (
						`award_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
						`team_id` int(11) UNSIGNED DEFAULT NULL,
						`game_id` int(11) UNSIGNED NOT NULL,
						`image_id` int(11) UNSIGNED DEFAULT NULL,
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
					) ENGINE=InnoDB DEFAULT CHARSET=utf8')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'awards\', \'module\', \'1\')')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'awards\', \'widget\', \'1\')')
					->execute('ALTER TABLE `dungeon_awards`
						ADD CONSTRAINT `dungeon_awards_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_awards_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_awards_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE')
					->execute('DROP TABLE IF EXISTS `dungeon_partners`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_partners` (
						`partner_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
						`name` varchar(100) NOT NULL,
						`logo_light` int(11) UNSIGNED DEFAULT NULL,
						`logo_dark` int(11) UNSIGNED DEFAULT NULL,
						`website` varchar(100) NOT NULL,
						`facebook` varchar(100) NOT NULL,
						`twitter` varchar(100) NOT NULL,
						`code` varchar(50) NOT NULL,
						`count` int(11) UNSIGNED NOT NULL,
						`order` tinyint(6) UNSIGNED NOT NULL,
						PRIMARY KEY (`partner_id`),
						KEY `image_id` (`logo_light`),
						KEY `logo_dark` (`logo_dark`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8')
					->execute('DROP TABLE IF EXISTS `dungeon_partners_lang`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_partners_lang` (
						`partner_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
						`lang` varchar(5) NOT NULL,
						`title` varchar(100) NOT NULL,
						`description` text NOT NULL,
						PRIMARY KEY (`partner_id`),
						KEY `lang` (`lang`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'partners\', \'module\', \'1\')')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'partners\', \'widget\', \'1\')')
					->execute('INSERT INTO `dungeon_settings` VALUES(\'partners_logo_display\', \'\', \'\', \'logo_dark\', \'string\')')
					->execute('ALTER TABLE `dungeon_partners`
						ADD CONSTRAINT `dungeon_partners_ibfk_1` FOREIGN KEY (`logo_light`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL,
						ADD CONSTRAINT `dungeon_partners_ibfk_2` FOREIGN KEY (`logo_dark`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL')
					->execute('ALTER TABLE `dungeon_partners_lang`
						ADD CONSTRAINT `dungeon_partners_lang_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `dungeon_partners` (`partner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_partners_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE')
					->execute('DROP TABLE IF EXISTS `dungeon_games_maps`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_games_maps` (
						`map_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
						`game_id` int(11) UNSIGNED NOT NULL,
						`image_id` int(11) UNSIGNED DEFAULT NULL,
						`title` varchar(100) NOT NULL,
						PRIMARY KEY (`map_id`),
						KEY `game_id` (`game_id`),
						KEY `image_id` (`image_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8')
					->execute('DROP TABLE IF EXISTS `dungeon_games_modes`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_games_modes` (
						`mode_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
						`game_id` int(11) UNSIGNED NOT NULL,
						`title` varchar(100) NOT NULL,
						PRIMARY KEY (`mode_id`),
						KEY `game_id` (`game_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8')
					->execute('ALTER TABLE `dungeon_games_maps`
						ADD CONSTRAINT `dungeon_games_maps_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_games_maps_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL')
					->execute('ALTER TABLE `dungeon_games_modes` ADD CONSTRAINT `dungeon_games_modes_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `dungeon_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE');
	}
}

/*
Dungeon Alpha 0.1.7.5
./dungeon/install/alpha.0.1.4.php
*/