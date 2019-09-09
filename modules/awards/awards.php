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

class m_awards extends Module
{
	public $title       = 'Awards';
	public $description = '';
	public $icon        = 'fa-trophy';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = '1.0';
	public $dungeon_version  = 'Alpha 0.1.4';
	public $path        = __FILE__;
	public $admin       = 'gaming';
	public $routes      = [
		//Index
		'{id}/{url_title}'             => '_award',
		'{url_title}/{id}/{url_title}' => '_filter',
		//Admin
		'admin{pages}'                 => 'index',
		'admin/{id}/{url_title*}'      => '_edit'
	];

	public function comments($award_id)
	{
		$award = $this->db	->select('name')
							->from('dungeon_awards')
							->where('award_id', $award_id)
							->row();

		if ($award)
		{
			return [
				'title' => $award,
				'url'   => 'awards/'.$award_id.'/'.url_title($award)
			];
		}
	}
}

/*
Dungeon Alpha 0.1.6
./modules/awards/awards.php
*/