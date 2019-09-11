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
 
class m_teams_c_admin_ajax_checker extends Controller
{
	public function sort()
	{
		if (($check = post_check('id', 'position')) && $this->db->select('1')->from('dungeon_teams')->where('team_id', $check['id'])->row())
		{
			return $check;
		}
	}

	public function _roles_sort()
	{
		if (($check = post_check('id', 'position')) && $this->db->select('1')->from('dungeon_teams_roles')->where('role_id', $check['id'])->row())
		{
			return $check;
		}
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/teams/controllers/admin_ajax_checker.php
*/