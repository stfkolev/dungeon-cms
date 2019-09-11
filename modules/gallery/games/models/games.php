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

class m_games_m_games extends Model
{
	public function check_game($game_id, $name, $lang = 'default')
	{
		if ($lang == 'default')
		{
			$lang = $this->config->lang;
		}
		
		return $this->db->select('g.game_id', 'g.parent_id', 'g.image_id', 'g.icon_id', 'gl.title', 'g.name')
						->from('dungeon_games g')
						->join('dungeon_games_lang gl', 'g.game_id = gl.game_id')
						->where('g.game_id', $game_id)
						->where('g.name', $name)
						->where('gl.lang', $lang)
						->row();
	}
	
	public function get_games()
	{
		return $this->db->select('g.*', 'gl.title')
						->from('dungeon_games g')
						->join('dungeon_games_lang gl',  'g.game_id = gl.game_id')
						->join('dungeon_games g2',       'g2.game_id = g.parent_id')
						->join('dungeon_games_lang gl2', 'g2.game_id = gl2.game_id')
						->where('gl.lang', $this->config->lang)
						->order_by('If(g.parent_id IS NULL, gl.title, CONCAT(gl2.title, gl.title))')
						->get();
	}
	
	public function get_games_list($all = FALSE, $game_id = NULL)
	{
		$list = [];

		foreach ($this->get_games() as $game)
		{
			if ($game_id == $game['game_id'] || ($game_id && $game_id == $game['parent_id']))
			{
				continue;
			}
			
			if (empty($game['parent_id']))
			{
				$list[$game['game_id']] = $game['title'];
			}
			else if ($all)
			{
				$list['g'.$game['game_id']] = str_repeat('&nbsp;', 10).$game['title'];
			}
		}

		return $list;
	}

	public function add_game($title, $parent_id, $image_id, $icon_id)
	{
		$game_id = $this->db->insert('dungeon_games', [
			'name'      => url_title($title),
			'parent_id' => $parent_id ?: NULL,
			'image_id'  => $image_id,
			'icon_id'   => $icon_id
		]);

		$this->db->insert('dungeon_games_lang', [
			'game_id'   => $game_id,
			'lang'      => $this->config->lang,
			'title'     => $title
		]);
		
		return $game_id;
	}

	public function edit_game($game_id, $title, $parent_id, $image_id, $icon_id)
	{
		$this->db	->where('game_id', $game_id)
					->update('dungeon_games', [
						'parent_id' => $parent_id ?: NULL,
						'image_id'  => $image_id,
						'icon_id'   => $icon_id,
						'name'      => url_title($title)
					]);

		$this->db	->where('game_id', $game_id)
					->where('lang', $this->config->lang)
					->update('dungeon_games_lang', [
						'title'     => $title
					]);
	}

	public function delete_game($game_id)
	{
		$files = [];
		
		foreach ($this->db->select('image_id', 'icon_id')->from('dungeon_games')->where('parent_id', $game_id)->get() as $game)
		{
			$files[] = $game['image_id'];
			$files[] = $game['icon_id'];
		}
		
		$this->file->delete(array_merge(
			array_values($this->db->select('image_id', 'icon_id')->from('dungeon_games')->where('game_id', $game_id)->row()),
			array_filter($files)
		));
		
		foreach ($this->db->select('team_id')->from('dungeon_teams')->where('game_id', $game_id)->get() as $team_id)
		{
			$this->groups->delete('teams', $team_id);
		}
		
		$this->db	->where('game_id', $game_id)
					->delete('dungeon_games');
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/games/models/games.php
*/