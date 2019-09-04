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
 
class m_teams_c_admin_ajax extends Controller
{
	public function sort($team_id, $position)
	{
		$teams = [];
		
		foreach ($this->db->select('team_id')->from('dungeon_teams')->where('team_id !=', $team_id)->order_by('order', 'team_id')->get() as $role)
		{
			$teams[] = $role;
		}
		
		foreach (array_merge(array_slice($teams, 0, $position, TRUE), [$team_id], array_slice($teams, $position, NULL, TRUE)) as $order => $team_id)
		{
			$this->db	->where('team_id', $team_id)
						->update('dungeon_teams', [
							'order' => $order
						]);
		}
	}
	
	public function _roles_sort($role_id, $position)
	{
		$roles = [];
		
		foreach ($this->db->select('role_id')->from('dungeon_teams_roles')->where('role_id !=', $role_id)->order_by('order', 'role_id')->get() as $role)
		{
			$roles[] = $role;
		}
		
		foreach (array_merge(array_slice($roles, 0, $position, TRUE), [$role_id], array_slice($roles, $position, NULL, TRUE)) as $order => $role_id)
		{
			$this->db	->where('role_id', $role_id)
						->update('dungeon_teams_roles', [
							'order' => $order
						]);
		}
	}
}

/*
Dungeon Alpha 0.1.5
./modules/teams/controllers/admin_ajax.php
*/