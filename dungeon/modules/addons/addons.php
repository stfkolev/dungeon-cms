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

class m_addons extends Module
{
	public $title         = 'Components';
	public $description   = '';
	public $icon          = 'fa-puzzle-piece';
	public $link          = 'http://www.dungeon.com';
	public $author        = 'Evil <inkyzfx@gmail.com>';
	public $licence       = 'http://www.dungeon.com/license.html LGPLv3';
	public $version       = 'Alpha 0.1';
	public $dungeon_version    = 'Alpha 0.1';
	public $path          = __FILE__;
	public $admin         = FALSE;
	public $routes        = [
		//Modules
		'admin/module/{url_title}'        => '_module_settings',
		'admin/delete/module/{url_title}' => '_module_delete',
		
		//Thèmes
		'admin/theme/{url_title}'         => '_theme_settings',
		'admin/delete/theme/{url_title}'  => '_theme_delete',
		'admin/ajax/theme/active'         => '_theme_activation',
		'admin/ajax/theme/reset'          => '_theme_reset',
		'admin/ajax/theme/{url_title}'    => '_theme_settings',

		//Languages
		'admin/ajax/language/sort'        => '_language_sort',

		//Authenticators
		'admin/ajax/authenticator/sort'   => '_authenticator_sort',
		'admin/ajax/authenticator/admin'  => '_authenticator_admin',
		'admin/ajax/authenticator/update' => '_authenticator_update'
	];
}

/*
Dungeon Alpha 0.1.6
./dungeon/modules/addons/addons.php
*/