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

class m_user_c_admin_checker extends Controller_Module
{
	public function index($page = '')
	{
		return [$this->pagination->get_data($this->model()->get_members(), $page)];
	}

	public function _edit($user_id, $username)
	{
		if ($this->model()->check_user($user_id, $username))
		{
			return $this->model()->get_user_profile($user_id);
		}
	}

	public function delete($user_id, $username)
	{
		$this->ajax();

		if ($user = $this->model()->check_user($user_id, $username))
		{
			return $user;
		}
	}

	public function _groups_edit()
	{
		if ($group = $this->groups->check_group(func_get_args()))
		{
			return [
				isset($group['id']) ? $group['id'] : 0,
				$group['unique_id'],
				$group['title'],
				$group['color'],
				$group['icon'],
				$group['hidden'],
				$group['auto']
			];
		}
	}

	public function _groups_delete()
	{
		$this->ajax();

		if ($group = $this->groups->check_group(func_get_args()))
		{
			if (!$group['auto'])
			{
				return [$group['id'], $group['title']];
			}
		}
	}
	
	public function _sessions($page = '')
	{
		return [$this->pagination->get_data($this->model()->get_sessions(), $page)];
	}

	public function _sessions_delete($session_id)
	{
		$this->ajax();

		if ($session = $this->model()->check_session($session_id))
		{
			return [$session['session_id'], $session['username']];
		}
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/modules/user/controllers/admin_checker.php
*/