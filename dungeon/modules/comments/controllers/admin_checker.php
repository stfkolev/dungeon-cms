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

class m_comments_c_admin_checker extends Controller
{
	public function index($tab = '', $page = '')
	{
		$comments = $this->model()->get_comments();
		$modules  = [];

		foreach ($comments as $i => $comment)
		{
			$modules[$comment['module']] = [$comment['module_title'], $comment['icon']];

			if (!in_array($tab, ['', $comment['module']]))
			{
				unset($comments[$i]);
			}
		}

		array_natsort($modules, function($a){
			return $a[0];
		});

		return [$this->pagination->get_data($comments, $page), $modules, $tab];
	}
}

/*
Dungeon Alpha 0.1.5.3
./dungeon/modules/comments/controllers/admin_checker.php
*/