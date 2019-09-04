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

class m_user_c_statistics extends Controller_Module
{
	public function statistics()
	{
		return [
			'registrations' => [
				'title' => 'Inscriptions',
				'data'  => function(){
					$this->db	->from('dungeon_users')
								->where('deleted', FALSE);
					
					return 'registration_date';
				}
			],
			'sessions' => [
				'title'    => 'Connections de membres',
				'group_by' => 'COUNT(DISTINCT user_id)',
				'data'     => function(){
					$this->db->from('dungeon_sessions_history');
					return 'date';
				}
			],
			'crawlers' => [
				'title' => 'Connections de bots',
				'data'  => function(){
					$this->db->from('dungeon_crawlers');
					return 'date';
				}
			]
		];
	}
}

/*
Dungeon Alpha 0.1.5
./dungeon/modules/user/controllers/statistics.php
*/