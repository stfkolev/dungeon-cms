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

class i_0_1_6 extends Install
{
	public function up()
	{
		$default_settings = [
			'default_background'                 => [0, 'int'],
			'dungeon_team_logo '                      => [0, 'int'],
			'dungeon_http_authentication'             => [FALSE, 'bool'],
			'dungeon_http_authentication_name'        => ['', 'string'],
			'dungeon_maintenance'                     => [FALSE, 'bool'],
			'dungeon_maintenance_opening'             => ['', 'string'],
			'dungeon_maintenance_title'               => ['', 'string'],
			'dungeon_maintenance_content'             => ['', 'string'],
			'dungeon_maintenance_logo'                => [0, 'int'],
			'dungeon_maintenance_background'          => [0, 'int'],
			'dungeon_maintenance_background_repeat'   => ['', 'string'],
			'dungeon_maintenance_background_position' => ['', 'string'],
			'dungeon_maintenance_background_color'    => ['', 'string'],
			'dungeon_maintenance_text_color'          => ['', 'string'],
			'dungeon_maintenance_facebook'            => ['', 'string'],
			'dungeon_maintenance_twitter'             => ['', 'string'],
			'dungeon_maintenance_google-plus'         => ['', 'string'],
			'dungeon_maintenance_steam'               => ['', 'string'],
			'dungeon_maintenance_twitch'              => ['', 'string'],
			'recruits_alert'                     => [TRUE, 'bool'],
			'recruits_hide_unavailable'          => [TRUE, 'bool'],
			'recruits_per_page'                  => [5, 'int'],
			'recruits_send_mail'                 => [TRUE, 'bool'],
			'recruits_send_mp'                   => [TRUE, 'bool'],
			'events_alert_mp'                    => [TRUE, 'bool'],
			'events_per_page'                    => [10, 'int']
		];

		foreach ($default_settings as $name => $setting)
		{
			list($value, $type) = $setting;

			if (!isset($this->config->$name))
			{
				$this->config($name, $value, $type);
			}
		}

		$this->db	->execute('ALTER TABLE `dungeon_users_profiles` CHANGE `date_of_birth` `date_of_birth` DATE NULL DEFAULT NULL')
					->execute('ALTER TABLE `dungeon_groups` ADD `order` SMALLINT UNSIGNED NOT NULL DEFAULT \'0\' AFTER `auto`')
					->execute('ALTER TABLE `dungeon_groups` ADD `hidden` ENUM(\'0\',\'1\') NOT NULL DEFAULT \'0\' AFTER `icon`')
					->execute('ALTER TABLE `dungeon_users` CHANGE `email` `email` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL')
					->execute('ALTER TABLE `dungeon_sessions_history` ADD `authenticator` VARCHAR(100) NOT NULL AFTER `host_name`')
					->execute('CREATE TABLE `dungeon_settings_authenticators` (
						`name` varchar(100) NOT NULL,
						`settings` text NOT NULL,
						`is_enabled` enum(\'0\',\'1\') NOT NULL DEFAULT \'0\',
						`order` smallint(5) unsigned NOT NULL DEFAULT \'0\',
						PRIMARY KEY (`name`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('CREATE TABLE `dungeon_users_auth` (
						`user_id` int(11) unsigned NOT NULL,
						`authenticator` varchar(100) NOT NULL,
						`id` varchar(250) NOT NULL,
						PRIMARY KEY (`authenticator`,`id`),
						KEY `user_id` (`user_id`),
						CONSTRAINT `dungeon_users_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						CONSTRAINT `dungeon_users_auth_ibfk_2` FOREIGN KEY (`authenticator`) REFERENCES `dungeon_settings_authenticators` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('CREATE TABLE `dungeon_recruits` (
					  `recruit_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `title` varchar(100) NOT NULL,
					  `introduction` text NOT NULL,
					  `description` text NOT NULL,
					  `requierments` text NOT NULL,
					  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `user_id` int(11) unsigned NOT NULL,
					  `size` int(11) NOT NULL,
					  `role` varchar(60) NOT NULL,
					  `icon` varchar(60) NOT NULL,
					  `date_end` date DEFAULT NULL,
					  `closed` enum(\'0\',\'1\') NOT NULL DEFAULT \'0\',
					  `team_id` int(11) unsigned DEFAULT NULL,
					  `image_id` int(11) unsigned DEFAULT NULL,
					  PRIMARY KEY (`recruit_id`),
					  KEY `image_id` (`image_id`),
					  KEY `user_id` (`user_id`),
					  KEY `team_id` (`team_id`),
					  CONSTRAINT `dungeon_recruits_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `dungeon_teams` (`team_id`) ON DELETE SET NULL ON UPDATE SET NULL,
					  CONSTRAINT `dungeon_recruits_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL,
					  CONSTRAINT `dungeon_recruits_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('CREATE TABLE `dungeon_recruits_candidacies` (
					  `candidacy_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `recruit_id` int(11) unsigned NOT NULL,
					  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `user_id` int(11) unsigned DEFAULT NULL,
					  `pseudo` varchar(60) NOT NULL,
					  `email` varchar(100) NOT NULL,
					  `date_of_birth` date DEFAULT NULL,
					  `presentation` text NOT NULL,
					  `motivations` text NOT NULL,
					  `experiences` text NOT NULL,
					  `status` enum(\'1\',\'2\',\'3\') NOT NULL DEFAULT \'1\',
					  `reply` text,
					  PRIMARY KEY (`candidacy_id`),
					  KEY `recruit_id` (`recruit_id`),
					  KEY `user_id` (`user_id`),
					  CONSTRAINT `dungeon_recruits_candidacies_ibfk_1` FOREIGN KEY (`recruit_id`) REFERENCES `dungeon_recruits` (`recruit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
					  CONSTRAINT `dungeon_recruits_candidacies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('CREATE TABLE `dungeon_recruits_candidacies_votes` (
					  `vote_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `candidacy_id` int(11) unsigned NOT NULL,
					  `user_id` int(11) unsigned NOT NULL,
					  `vote` enum(\'0\',\'1\') NOT NULL DEFAULT \'0\',
					  `comment` text NOT NULL,
					  PRIMARY KEY (`vote_id`),
					  KEY `candidacy_id` (`candidacy_id`),
					  KEY `user_id` (`user_id`),
					  CONSTRAINT `dungeon_recruits_candidacies_votes_ibfk_1` FOREIGN KEY (`candidacy_id`) REFERENCES `dungeon_recruits_candidacies` (`candidacy_id`) ON DELETE CASCADE ON UPDATE CASCADE,
					  CONSTRAINT `dungeon_recruits_candidacies_votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'recruits\', \'module\', \'1\')')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'recruits\', \'widget\', \'1\')')
					->execute('CREATE TABLE `dungeon_events_types` (
					  `type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `type` smallint(5) unsigned NOT NULL DEFAULT \'0\',
					  `title` varchar(100) NOT NULL,
					  `color` varchar(20) NOT NULL,
					  `icon` varchar(20) NOT NULL,
					  PRIMARY KEY (`type_id`)
					) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;')
					->execute('INSERT INTO `dungeon_events_types` (`type_id`, `type`, `title`, `color`, `icon`) VALUES
						(1, 1, \'Entrainement\', \'success\', \'fa-gamepad\'),
						(2, 1, \'Match amical\', \'info\', \'fa-angellist\'),
						(3, 1, \'Match officiel\', \'warning\', \'fa-trophy\'),
						(4, 0, \'IRL\', \'primary\', \'fa-glass\'),
						(5, 0, \'Divers\', \'default\', \'fa-comments\'),
						(6, 1, \'Réunion\', \'danger\', \'fa-briefcase\');')
					->execute('CREATE TABLE `dungeon_events` (
					  `event_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `type_id` int(11) unsigned NOT NULL,
					  `user_id` int(11) unsigned NOT NULL,
					  `image_id` int(11) unsigned DEFAULT NULL,
					  `title` varchar(100) NOT NULL,
					  `description` text NOT NULL,
					  `private_description` text NOT NULL,
					  `location` text NOT NULL,
					  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  `date_end` timestamp NULL DEFAULT NULL,
					  `published` enum(\'0\',\'1\') NOT NULL DEFAULT \'0\',
					  PRIMARY KEY (`event_id`),
					  KEY `user_id` (`user_id`),
					  KEY `type_id` (`type_id`) USING BTREE,
					  KEY `image_id` (`image_id`),
					  CONSTRAINT `dungeon_events_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `dungeon_events_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
					  CONSTRAINT `dungeon_events_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
					  CONSTRAINT `dungeon_events_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('CREATE TABLE `dungeon_events_matches_opponents` (
					  `opponent_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `image_id` int(11) unsigned DEFAULT NULL,
					  `title` varchar(100) NOT NULL,
					  `website` varchar(100) NOT NULL,
					  `country` varchar(5) NOT NULL,
					  PRIMARY KEY (`opponent_id`),
					  KEY `image_id` (`image_id`),
					  CONSTRAINT `dungeon_events_matches_opponents_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE SET NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('CREATE TABLE `dungeon_events_matches` (
					  `event_id` int(11) unsigned NOT NULL,
					  `team_id` int(11) unsigned NOT NULL,
					  `opponent_id` int(11) unsigned NOT NULL,
					  `mode_id` int(11) unsigned DEFAULT NULL,
					  `webtv` varchar(100) NOT NULL,
					  `website` varchar(100) NOT NULL,
					  PRIMARY KEY (`event_id`),
					  KEY `opponent_id` (`opponent_id`),
					  KEY `mode_id` (`mode_id`),
					  KEY `team_id` (`team_id`),
					  CONSTRAINT `dungeon_events_matches_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
					  CONSTRAINT `dungeon_events_matches_ibfk_2` FOREIGN KEY (`opponent_id`) REFERENCES `dungeon_events_matches_opponents` (`opponent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
					  CONSTRAINT `dungeon_events_matches_ibfk_3` FOREIGN KEY (`mode_id`) REFERENCES `dungeon_games_modes` (`mode_id`) ON DELETE CASCADE ON UPDATE CASCADE
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('CREATE TABLE `dungeon_events_matches_rounds` (
					  `round_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `event_id` int(11) unsigned NOT NULL,
					  `map_id` int(11) unsigned DEFAULT NULL,
					  `score1` int(11) NOT NULL,
					  `score2` int(11) NOT NULL,
					  PRIMARY KEY (`round_id`),
					  KEY `event_id` (`event_id`),
					  KEY `map_id` (`map_id`),
					  CONSTRAINT `dungeon_events_matches_rounds_ibfk_1` FOREIGN KEY (`map_id`) REFERENCES `dungeon_games_maps` (`map_id`) ON DELETE CASCADE ON UPDATE CASCADE,
					  CONSTRAINT `dungeon_events_matches_rounds_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('CREATE TABLE `dungeon_events_participants` (
					  `event_id` int(10) unsigned NOT NULL,
					  `user_id` int(10) unsigned NOT NULL,
					  `status` smallint(6) unsigned NOT NULL,
					  PRIMARY KEY (`event_id`,`user_id`),
					  KEY `user_id` (`user_id`),
					  CONSTRAINT `dungeon_events_participants_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `dungeon_events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
					  CONSTRAINT `dungeon_events_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dungeon_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;')
					->execute('INSERT INTO `dungeon_access` VALUES(NULL, 1, \'events\', \'access_events_type\')')
					->execute('INSERT INTO `dungeon_access` VALUES(NULL, 2, \'events\', \'access_events_type\')')
					->execute('INSERT INTO `dungeon_access` VALUES(NULL, 3, \'events\', \'access_events_type\')')
					->execute('INSERT INTO `dungeon_access` VALUES(NULL, 4, \'events\', \'access_events_type\')')
					->execute('INSERT INTO `dungeon_access` VALUES(NULL, 5, \'events\', \'access_events_type\')')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'events\', \'module\', \'1\')')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'events\', \'widget\', \'1\')');

		foreach (['facebook', 'twitter', 'google', 'battle_net', 'steam', 'twitch', 'github', 'linkedin'] as $i => $name)
		{
			$this->db->insert('dungeon_settings_authenticators', [
				'name'     => $name,
				'settings' => serialize([]),
				'order'    => $i
			]);
		}

		$this	->config('dungeon_version_css', time())
				->config('dungeon_dispositions_upgrade', FALSE, 'bool');
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/install/alpha.0.1.6.php
*/