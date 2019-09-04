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

class i_0_1_1 extends Install
{
	public function up()
	{
		$this->db	->execute('ALTER TABLE `dungeon_permissions_details` CHANGE `entity_id` `entity_id` VARCHAR(100) NOT NULL')
					->execute('UPDATE `dungeon_permissions_details` SET `entity_id` = \'admins\' WHERE `entity_id` = \'1\' AND `type` = \'group\'')
					->execute('UPDATE `dungeon_permissions_details` SET `entity_id` = \'members\' WHERE `entity_id` = \'2\' AND `type` = \'group\'')
					->execute('INSERT INTO `dungeon_settings` VALUES(\'default_background_attachment\', \'\', \'\', \'scroll\', \'string\')')
					->execute('INSERT INTO `dungeon_settings` VALUES(\'default_background_color\', \'\', \'\', \'#141d26\', \'string\')')
					->execute('INSERT INTO `dungeon_settings` VALUES(\'default_background_position\', \'\', \'\', \'center top\', \'string\')')
					->execute('INSERT INTO `dungeon_settings` VALUES(\'default_background_repeat\', \'\', \'\', \'no-repeat\', \'string\')')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'gallery\', \'module\', \'1\')')
					->execute('INSERT INTO `dungeon_settings_addons` VALUES(\'gallery\', \'widget\', \'1\')')
					->execute('DROP TABLE IF EXISTS `dungeon_gallery`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_gallery` (
						`gallery_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						`category_id` int(11) unsigned NOT NULL,
						`image_id` int(11) unsigned DEFAULT NULL,
						`name` varchar(100) NOT NULL,
						`published` enum(\'0\',\'1\') NOT NULL DEFAULT \'0\',
						PRIMARY KEY (`gallery_id`),
						KEY `category_id` (`category_id`),
						KEY `image_id` (`image_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8')
					->execute('DROP TABLE IF EXISTS `dungeon_gallery_categories`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_gallery_categories` (
						`category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						`image_id` int(11) unsigned DEFAULT NULL,
						`icon_id` int(11) unsigned DEFAULT NULL,
						`name` varchar(100) NOT NULL,
						PRIMARY KEY (`category_id`),
						KEY `image_id` (`image_id`),
						KEY `icon_id` (`icon_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8')
					->execute('DROP TABLE IF EXISTS `dungeon_gallery_categories_lang`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_gallery_categories_lang` (
						`category_id` int(11) unsigned NOT NULL,
						`lang` varchar(5) NOT NULL,
						`title` varchar(100) NOT NULL,
						PRIMARY KEY (`category_id`,`lang`),
						KEY `lang` (`lang`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8')
					->execute('DROP TABLE IF EXISTS `dungeon_gallery_images`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_gallery_images` (
						`image_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						`thumbnail_file_id` int(11) unsigned NOT NULL,
						`original_file_id` int(11) unsigned NOT NULL,
						`file_id` int(11) unsigned NOT NULL,
						`gallery_id` int(11) unsigned NOT NULL,
						`title` varchar(100) NOT NULL,
						`description` text,
						`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
						`views` int(11) unsigned NOT NULL,
						PRIMARY KEY (`image_id`),
						KEY `file_id` (`file_id`),
						KEY `gallery_id` (`gallery_id`),
						KEY `original_file_id` (`original_file_id`),
						KEY `thumbnail_file_id` (`thumbnail_file_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8')
					->execute('DROP TABLE IF EXISTS `dungeon_gallery_lang`')
					->execute('CREATE TABLE IF NOT EXISTS `dungeon_gallery_lang` (
						`gallery_id` int(11) unsigned NOT NULL,
						`lang` varchar(5) NOT NULL,
						`title` varchar(100) NOT NULL,
						`description` text NOT NULL,
						PRIMARY KEY (`gallery_id`,`lang`),
						KEY `lang` (`lang`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8')
					->execute('ALTER TABLE `dungeon_gallery`
						ADD CONSTRAINT `dungeon_gallery_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dungeon_gallery_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_gallery_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE')
					->execute('ALTER TABLE `dungeon_gallery_categories`
						ADD CONSTRAINT `dungeon_gallery_categories_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_gallery_categories_ibfk_2` FOREIGN KEY (`icon_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE')
					->execute('ALTER TABLE `dungeon_gallery_categories_lang`
						ADD CONSTRAINT `dungeon_gallery_categories_lang_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dungeon_gallery_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_gallery_categories_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE')
					->execute('ALTER TABLE `dungeon_gallery_images`
						ADD CONSTRAINT `dungeon_gallery_images_ibfk_4` FOREIGN KEY (`original_file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_gallery_images_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_gallery_images_ibfk_2` FOREIGN KEY (`gallery_id`) REFERENCES `dungeon_gallery` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_gallery_images_ibfk_3` FOREIGN KEY (`thumbnail_file_id`) REFERENCES `dungeon_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE')
					->execute('ALTER TABLE `dungeon_gallery_lang`
						ADD CONSTRAINT `dungeon_gallery_lang_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `dungeon_gallery` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
						ADD CONSTRAINT `dungeon_gallery_lang_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `dungeon_settings_languages` (`code`) ON DELETE CASCADE ON UPDATE CASCADE');
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/install/alpha.0.1.1.php
*/