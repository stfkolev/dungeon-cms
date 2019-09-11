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
 
class m_forum_c_ajax_checker extends Controller
{
	public function _topic_move($topic_id, $title)
	{
		if ($topic = $this->model()->check_topic($topic_id, $title))
		{
			if ($this->access('forum', 'category_move', $topic['category_id']))
			{
				return [$topic_id, $topic['topic_title'], $topic['forum_id']];
			}
			else
			{
				throw new Exception(Dungeon::UNAUTHORIZED);
			}
		}
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/forum/controllers/ajax_checker.php
*/