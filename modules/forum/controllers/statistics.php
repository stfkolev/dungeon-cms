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

class m_forum_c_statistics extends Controller_Module
{
	public function statistics()
	{
		return [
			'topics' => [
				'title' => 'New topics',
				'data'  => function(){
					$this->db	->from('dungeon_forum_topics t')
								->join('dungeon_forum_messages m', 'm.message_id = t.message_id', 'INNER');
					
					return 'm.date';
				}
			],
			'replies' => [
				'title' => 'New replies',
				'data'  => function(){
					$this->db	->from('dungeon_forum_messages m')
								->join('dungeon_forum_topics t', 'm.topic_id = t.topic_id', 'INNER')
								->where('m.message_id <> t.message_id');
					
					return 'm.date';
				}
			]
		];
	}
}

/*
Dungeon Alpha 0.1.5
./modules/forum/controllers/statistics.php
*/