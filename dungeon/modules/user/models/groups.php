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

class m_user_m_groups extends Model
{
	public function add_group($title, $color, $icon, $hidden, $lang)
	{
		$group_id = $this->db->insert('dungeon_groups', [
			'name'   => url_title($title),
			'color'  => $color,
			'icon'   => $icon,
			'hidden' => $hidden,
			'auto'   => FALSE
		]);
		
		$this->db->insert('dungeon_groups_lang', [
			'group_id' => $group_id,
			'lang'     => $lang,
			'title'    => $title
		]);
	}
	
	public function edit_group($group_id, $title, $color, $icon, $hidden, $lang, $auto)
	{
		$group = [
			'color'  => $color,
			'icon'   => $icon,
			'hidden' => $hidden
		];
		
		if (!$auto)
		{
			$group['name'] = url_title($title);
			
			$this->db	->where('group_id', $group_id)
						->update('dungeon_groups_lang', [
							'lang'  => $lang,
							'title' => $title
						]);
		}
		
		$this->db	->where('group_id', $group_id)
					->update('dungeon_groups', $group);
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/modules/user/models/groups.php
*/