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

class m_teams_c_admin_checker extends Controller_Module
{
	public function _edit($team_id, $name)
	{
		if ($team = $this->model()->check_team($team_id, $name))
		{
			return $team;
		}
	}

	public function delete($team_id, $name)
	{
		$this->ajax();

		if ($team = $this->model()->check_team($team_id, $name))
		{
			return [$team['team_id'], $team['title']];
		}
	}
	
	public function _roles_edit($role_id, $name)
	{
		if ($role = $this->model('roles')->check_role($role_id, $name))
		{
			return $role;
		}
	}
	
	public function _roles_delete($role_id, $name)
	{
		$this->ajax();

		if ($role = $this->model('roles')->check_role($role_id, $name))
		{
			return $role;
		}
	}
	
	public function _players_delete($team_id, $name, $user_id)
	{
		$this->ajax();

		if (($team = $this->model()->check_team($team_id, $name)) && $user = $this->db->select('u.user_id', 'u.username')->from('dungeon_teams_users tu')->join('dungeon_users u', 'tu.user_id = u.user_id AND u.deleted = "0"', 'INNER')->where('tu.team_id', $team['team_id'])->where('tu.user_id', $user_id)->row())
		{
			return array_merge([$team['team_id']], $user);
		}
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/teams/controllers/admin_checker.php
*/