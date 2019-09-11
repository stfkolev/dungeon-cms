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

class m_events_m_matches extends Model
{
	public function get_match_info($event_id)
	{
		static $result = [];

		if (!isset($result[$event_id]))
		{
			if ($match = $this->db->from('dungeon_events_matches')->where('event_id', $event_id)->row())
			{
				$result[$event_id] = array_merge($match, [
					'opponent' => $this->db->from('dungeon_events_matches_opponents')->where('opponent_id', $match['opponent_id'])->row(),
					'scores'   => $this->get_global_scores($event_id),
					'game'     => $this->db	->select('g.game_id', 'COALESCE(g.icon_id, g2.icon_id) as icon_id', 'gl.title', 'g.name')
											->from('dungeon_teams t')
											->join('dungeon_games g',       'g.game_id = t.game_id')
											->join('dungeon_games g2',      'g.parent_id = g2.game_id')
											->join('dungeon_games_lang gl', 'g.game_id = gl.game_id')
											->join('dungeon_games_lang gl2', 'g2.game_id = gl2.game_id')
											->where('t.team_id', $match['team_id'])
											->row(),
					'team'     => $this->db	->select('t.team_id', 't.name', 'COALESCE(t.icon_id, g.icon_id) as icon_id', 'tl.title')
											->from('dungeon_teams t')
											->join('dungeon_teams_lang tl', 'tl.team_id = t.team_id')
											->join('dungeon_games g',       'g.game_id  = t.game_id')
											->where('t.team_id', $match['team_id'])
											->row()
				]);
			}
			else
			{
				$result[$event_id] = FALSE;
			}
		}

		return $result[$event_id];
	}

	public function get_opponents_list()
	{
		$opponents = [];

		foreach ($this->db->select('opponent_id', 'title')->from('dungeon_events_matches_opponents')->get() as $opponent)
		{
			$opponents[$opponent['opponent_id']] = $opponent['title'];
		}

		array_natsort($opponents);

		return $opponents;
	}

	public function get_global_scores($event_id)
	{
		$scores = [];

		if ($rounds = $this->db->select('score1', 'score2')->from('dungeon_events_matches_rounds')->where('event_id', $event_id)->get())
		{
			if (count($rounds) == 1)
			{
				$scores = array_values($rounds[0]);
			}
			else
			{
				$scores = [0, 0];

				foreach ($rounds as $round)
				{
					if ($round['score1'] != $round['score2'])
					{
						$scores[(int)($round['score1'] < $round['score2'])]++;
					}
				}
			}
		}

		return $scores;
	}

	public function label_scores($score1, $score2)
	{
		$class = 'default';

		if ($score1 > $score2)
		{
			$class = 'success';
		}
		else if ($score1 < $score2)
		{
			$class = 'danger';
		}
		else
		{
			$class = 'primary';
		}

		return '<span class="label label-'.$class.'">'.$score1.' - '.$score2.'</span>';
	}

	public function label_global_scores($event_id)
	{
		return call_user_func_array([$this, 'label_scores'], $this->get_global_scores($event_id));
	}

	public function display_scores($scores, &$color, $opponents = FALSE)
	{
		if (!$scores)
		{
			return '';
		}

		if ($opponents)
		{
			$scores = array_reverse($scores);
		}

		if ($scores[0] > $scores[1])
		{
			$color = 'text-green';
			$icon  = 'fa-angle-up';
		}
		else if ($scores[0] < $scores[1])
		{
			$color = 'text-red';
			$icon  = 'fa-angle-down';
		}
		else
		{
			$color = 'text-blue';

			if ($opponents)
			{
				$icon  = 'fa-angle-left';
			}
			else
			{
				$icon  = 'fa-angle-right';
			}
		}

		return icon($icon.' '.$color);
	}
}

/*
Dungeon Alpha 0.1.7
./modules/events/models/matches.php
*/