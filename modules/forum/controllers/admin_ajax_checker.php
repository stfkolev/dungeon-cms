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
 
class m_forum_c_admin_ajax_checker extends Controller
{
	public function _categories_move()
	{
		if (($check = post_check('category_id', 'position')) && $this->db->select('1')->from('dungeon_forum_categories')->where('category_id', $check['category_id'])->row())
		{
			return $check;
		}
	}
	
	public function move()
	{
		if (	($check = post_check('parent_id', 'forum_id', 'position')) &&
				!is_array($is_subforum = $this->db->select('is_subforum')->from('dungeon_forum')->where('forum_id', $check['forum_id'])->row()) &&
				(
					($is_subforum  && $this->db->select('1')->from('dungeon_forum')->where('forum_id', $check['parent_id'])->where('is_subforum', FALSE)->row()) ||
					(!$is_subforum && $this->db->select('1')->from('dungeon_forum_categories')->where('category_id', $check['parent_id'])->row())
				)
			)
		{
			return array_merge($check, [$is_subforum]);
		}
	}
}

/*
Dungeon Alpha 0.1.5
./modules/forum/controllers/admin_ajax_checker.php
*/