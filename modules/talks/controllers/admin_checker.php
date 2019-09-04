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

class m_talks_c_admin_checker extends Controller_Module
{
	public function index($page = '')
	{
		return [$this->pagination->get_data($this->model()->get_talks(), $page)];
	}
	
	public function _edit($talk_id, $title)
	{
		if ($talk_id > 1 && $talk = $this->model()->check_talk($talk_id, $title))
		{
			return $talk;
		}
	}
	
	public function delete($talk_id, $title)
	{
		$this->ajax();

		if ($talk_id > 1 && $talk = $this->model()->check_talk($talk_id, $title))
		{
			return $talk;
		}
	}
}

/*
Dungeon Alpha 0.1.5
./modules/talks/controllers/admin_checker.php
*/