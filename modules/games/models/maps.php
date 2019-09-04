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

class m_games_m_maps extends Model
{
	public function get_maps($game_id = NULL)
	{
		if ($game_id)
		{
			$this->db->where('m.game_id', $game_id);
		}
		
		return $this->db->select('m.*', 'g.name', 'g.icon_id', 'gl.title as game_title')
						->from('dungeon_games_maps m')
						->join('dungeon_games g', 'g.game_id = m.game_id')
						->join('dungeon_games_lang gl', 'gl.game_id = m.game_id')
						->where('gl.lang', $this->config->lang)
						->order_by('gl.title', 'm.title')
						->get();
	}

	public function check_map($map_id, $title)
	{
		$map = $this->db->select('m.*', 'g.name')
						->from('dungeon_games_maps m')
						->join('dungeon_games g', 'g.game_id = m.game_id')
						->where('m.map_id', $map_id)
						->row();

		if ($map && url_title($map['title']) == $title)
		{
			return $map;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function add_map($game_id, $title, $image)
	{
		return $this->db->insert('dungeon_games_maps', [
			'game_id'  => $game_id,
			'title'    => $title,
			'image_id' => $image
		]);
	}
	
	public function edit_map($map_id, $game_id, $title, $image)
	{
		$this->db	->where('map_id', $map_id)
					->update('dungeon_games_maps', [
						'game_id'  => $game_id,
						'title'    => $title,
						'image_id' => $image
					]);
	}

	public function delete_map($map_id)
	{
		$this->file->delete($this->db->select('image_id')->from('dungeon_games_maps')->where('map_id', $map_id)->row());

		$this->db	->where('map_id', $map_id)
					->delete('dungeon_games_maps');
	}
}

/*
Dungeon Alpha 0.1.5
./modules/games/models/maps.php
*/