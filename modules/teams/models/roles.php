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

class m_teams_m_roles extends Model
{
	public function get_roles()
	{
		return $this->db	->select('role_id', 'title')
							->from('dungeon_teams_roles')
							->order_by('order', 'role_id')
							->get();
	}
	
	public function check_role($role_id, $title)
	{
		$role = $this->db	->select('role_id', 'title')
							->from('dungeon_teams_roles')
							->where('role_id', $role_id)
							->row();
		
		if ($role && $title == url_title($role['title']))
		{
			return $role;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function add_role($title)
	{
		$this->db->insert('dungeon_teams_roles', [
			'title' => $title
		]);
	}

	public function edit_role($role_id, $title)
	{
		$this->db	->where('role_id', $role_id)
					->update('dungeon_teams_roles', [
						'title' => $title
					]);
	}
	
	public function delete_role($role_id)
	{
		$this->db	->where('role_id', $role_id)
					->delete('dungeon_teams_roles');
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/teams/models/roles.php
*/