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

class m_games extends Module
{
	public $title       = '{lang games_maps}';
	public $description = '';
	public $icon        = 'fa-gamepad';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1.7';
	public $dungeon_version  = 'Alpha 0.1.7';
	public $path        = __FILE__;
	public $admin       = 'gaming';
	public $routes      = [
		//Admin
		'admin{pages}'                  => 'index',
		'admin/{id}/{url_title}{pages}' => '_edit',
		
		//Maps
		'admin/maps/add(?:/{id}/{url_title})?' => '_maps_add',
		'admin/maps/edit/{id}/{url_title}'     => '_maps_edit',
		'admin/maps/delete/{id}/{url_title}'   => '_maps_delete',
		
		//Modes
		'admin/modes/add/{id}/{url_title}'    => '_modes_add',
		'admin/modes/edit/{id}/{url_title}'   => '_modes_edit',
		'admin/modes/delete/{id}/{url_title}' => '_modes_delete'
	];
}

/*
Dungeon Alpha 0.1.7
./modules/games/games.php
*/