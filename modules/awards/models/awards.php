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

class m_awards_m_awards extends Model
{
	public function get_years()
	{
		return $this->db->select('DISTINCT YEAR(date)')
						->from('dungeon_awards')
						->order_by('date DESC')
						->get();
	}

	public function get_awards($filter = '', $filter_data = '')
	{
		$this->db	->select('a.*', 't.team_id', 't.name as team_name', 'tl.title as team_title', 'g.game_id', 'g.name as game_name', 'gl.title as game_title')
					->from('dungeon_awards a')
					->join('dungeon_teams t', 'a.team_id = t.team_id')
					->join('dungeon_teams_lang tl', 't.team_id = tl.team_id')
					->join('dungeon_games g', 'a.game_id = g.game_id')
					->join('dungeon_games_lang gl', 'a.game_id = gl.game_id')
					->where('tl.lang', $this->config->lang)
					->where('gl.lang', $this->config->lang)
					->order_by('a.date DESC');

		if (!empty($filter) && !empty($filter_data))
		{
			if ($filter == 'date')
			{
				$this->db->where('YEAR(date)', $filter_data);
			}
			else if ($filter == 'team')
			{
				$this->db->where('a.team_id', $filter_data);
			}
			else if ($filter == 'game')
			{
				$this->db->where('a.game_id', $filter_data);
			}
		}

		return $this->db->get();
	}

	public function count_awards($ranking = '', $filter = '', $filter_data = '')
	{
		$this->db	->select('COUNT(award_id) as nb_awards')
					->from('dungeon_awards');

		if (!empty($ranking))
		{
			$this->db->where('ranking', $ranking);
		}

		if (!empty($filter) && !empty($filter_data))
		{
			if ($filter == 'team')
			{
				$this->db->where('team_id', $filter_data);
			}
			else if ($filter == 'game')
			{
				$this->db->where('game_id', $filter_data);
			}
		}

		return $this->db->get();
	}

	public function check_awards($award_id, $name)
	{
		return $this->db->select('a.*', 't.team_id', 't.name as team_name', 'tl.title as team_title', 'g.game_id', 'g.name as game_name', 'gl.title as game_title')
						->from('dungeon_awards a')
						->join('dungeon_teams t', 'a.team_id = t.team_id')
						->join('dungeon_teams_lang tl', 't.team_id = tl.team_id')
						->join('dungeon_games g', 'a.game_id = g.game_id')
						->join('dungeon_games_lang gl', 'a.game_id = gl.game_id')
						->where('a.award_id', $award_id)
						->where('tl.lang', $this->config->lang)
						->where('gl.lang', $this->config->lang)
						->row();
	}

	public function check_team($team_id, $name)
	{
		return $this->db->select('t.team_id', 't.name', 'tl.title', 't.image_id', 't.icon_id', 'tl.description', 't.game_id')
						->from('dungeon_teams t')
						->join('dungeon_teams_lang tl', 't.team_id = tl.team_id')
						->where('t.team_id', $team_id)
						->where('t.name', $name)
						->where('tl.lang', $this->config->lang)
						->row();
	}

	public function check_game($game_id, $name)
	{
		return $this->db->select('g.game_id', 'g.name', 'g.image_id', 'gl.title')
						->from('dungeon_games g')
						->join('dungeon_games_lang gl', 'g.game_id = gl.game_id')
						->where('g.game_id', $game_id)
						->where('g.name', $name)
						->where('gl.lang', $this->config->lang)
						->row();
	}

	public function get_teams()
	{
		return $this->db->select('t.team_id', 't.name', 'tl.title')
						->from('dungeon_teams t')
						->join('dungeon_teams_lang tl', 't.team_id = tl.team_id')
						->where('tl.lang', $this->config->lang)
						->order_by('tl.title')
						->get();
	}

	public function get_teams_list()
	{
		$list = [];

		foreach ($this->get_teams() as $team)
		{
			$list[$team['team_id']] = $team['title'];
		}

		array_natsort($list);

		return $list;
	}

	public function get_teams_ranking($limit = '')
	{
		$this->db	->select('t.team_id', 't.name', 'tl.title as team_title', 'COUNT(DISTINCT CASE WHEN a.ranking = \'1\' THEN a.award_id END) as total_gold', 'COUNT(DISTINCT CASE WHEN a.ranking = \'2\' THEN a.award_id END) as total_silver', 'COUNT(DISTINCT CASE WHEN a.ranking = \'3\' THEN a.award_id END) as total_bronze', 'COUNT(DISTINCT CASE WHEN a.ranking >= \'4\' THEN a.award_id END) as total_other')
					->from('dungeon_teams t')
					->join('dungeon_teams_lang tl', 't.team_id = tl.team_id')
					->join('dungeon_awards a', 't.team_id = a.team_id')
					->where('tl.lang', $this->config->lang)
					->group_by('t.team_id')
					->order_by('total_gold DESC', 'total_silver DESC', 'total_bronze DESC', 'total_other DESC');

		if (!empty($limit))
		{
			$this->db->limit($limit);
		}

		return $this->db->get();
	}

	public function get_best_team_awards()
	{
		return $this->db->select('COUNT(a.award_id) as nb_awards', 't.team_id', 't.name', 'tl.title as team_title')
						->from('dungeon_awards a')
						->join('dungeon_teams t', 'a.team_id = t.team_id')
						->join('dungeon_teams_lang tl', 't.team_id = tl.team_id')
						->group_by('t.team_id')
						->order_by('nb_awards DESC')
						->limit(1)
						->get();
	}

	public function get_best_game_awards()
	{
		return $this->db->select('COUNT(a.award_id) as nb_awards', 'g.game_id', 'g.name', 'gl.title as game_title')
						->from('dungeon_awards a')
						->join('dungeon_games g', 'a.game_id = g.game_id')
						->join('dungeon_games_lang gl', 'g.game_id = gl.game_id')
						->group_by('g.game_id')
						->order_by('nb_awards DESC')
						->limit(1)
						->get();
	}

	public function get_games_list()
	{
		$list = [];

		foreach ($this->db->select('g.game_id', 'gl.title')->from('dungeon_games g')->join('dungeon_games_lang gl', 'gl.game_id = g.game_id')->where('g.parent_id', NULL)->where('gl.lang', $this->config->lang)->get() as $game)
		{
			$list[$game['game_id']] = $game['title'];
		}

		return $list;
	}

	public function add_awards($date, $team_id, $game_id, $platform, $location, $name, $ranking, $participants, $description, $image_id)
	{
		$this->db->insert('dungeon_awards', [
			'team_id'      => $team_id,
			'date'         => $date,
			'location'     => $location,
			'name'         => $name,
			'platform'     => $platform,
			'game_id'      => $game_id,
			'ranking'      => $ranking,
			'participants' => $participants,
			'description'  => $description,
			'image_id'     => $image_id
		]);
	}

	public function edit_awards($award_id, $date, $team_id, $game_id, $platform, $location, $name, $ranking, $participants, $description, $image_id)
	{
		$this->db	->where('award_id', $award_id)
					->update('dungeon_awards', [
						'team_id'      => $team_id,
						'date'         => $date,
						'location'     => $location,
						'name'         => $name,
						'platform'     => $platform,
						'game_id'      => $game_id,
						'ranking'      => $ranking,
						'participants' => $participants,
						'description'  => $description,
						'image_id'     => $image_id
					]);
	}

	public function delete_awards($award_id)
	{
		$this->file->delete($this->db->select('image_id')->from('dungeon_awards')->where('award_id', $award_id)->row());

		$this->db	->where('award_id', $award_id)
					->delete('dungeon_awards');
	}
}

/*
Dungeon Alpha 0.1.5
./modules/awards/models/awards.php
*/