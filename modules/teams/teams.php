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

class m_teams extends Module
{
	public $title       = '{lang teams_title}';
	public $description = '';
	public $icon        = 'fa-gamepad';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1';
	public $dungeon_version  = 'Alpha 0.1';
	public $path        = __FILE__;
	public $admin       = 'gaming';
	public $routes      = [
		//Index
		'{id}/{url_title}'                           => '_team',

		//Admin
		'admin/{id}/{url_title*}'                    => '_edit',
		'admin/roles/add'                            => '_roles_add',
		'admin/roles/{id}/{url_title*}'              => '_roles_edit',
		'admin/roles/delete/{id}/{url_title}'        => '_roles_delete',
		'admin/players/delete/{id}/{url_title}/{id}' => '_players_delete',
		'admin/ajax/roles/sort'                      => '_roles_sort'
	];
	
	public function groups()
	{
		$teams = Dungeon()->db	->select('t.team_id', 't.name', 'tl.title', 'GROUP_CONCAT(tu.user_id) AS users')
										->from('dungeon_teams t')
										->join('dungeon_teams_lang tl',  'tl.team_id = t.team_id')
										->join('dungeon_teams_users tu', 'tu.team_id = t.team_id')
										->where('tl.lang', Dungeon()->config->lang)
										->group_by('t.team_id')
										->get();
		
		$groups = [];
		
		foreach ($teams as $team)
		{
			$groups[$team['team_id']] = [
				'name'  => $team['name'],
				'title' => $team['title'],
				'users' => array_filter(array_map('intval', explode(',', $team['users'])))
			];
		}
		
		return $groups;
	}
}

/*
Dungeon Alpha 0.1.6
./modules/teams/teams.php
*/