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

class w_recruits_m_recruits extends Model
{
	public function get_last_recruits()
	{
		return $this->db->select('r.*', 'u.user_id', 'u.username', 'up.avatar', 'up.sex', 'COUNT(DISTINCT rc.candidacy_id) as candidacies', 'COUNT(DISTINCT CASE WHEN rc.status = \'1\' THEN rc.candidacy_id END) as candidacies_pending', 'COUNT(DISTINCT CASE WHEN rc.status = \'2\' THEN rc.candidacy_id END) as candidacies_accepted', 'COUNT(DISTINCT CASE WHEN rc.status = \'3\' THEN rc.candidacy_id END) as candidacies_declined', 'tl.title as team_name')
						->from('dungeon_recruits r')
						->join('dungeon_users u',                 'r.user_id     = u.user_id')
						->join('dungeon_users_profiles up',       'up.user_id    = u.user_id')
						->join('dungeon_recruits_candidacies rc', 'rc.recruit_id = r.recruit_id')
						->join('dungeon_teams_lang tl',           'r.team_id     = tl.team_id')
						->group_by('r.recruit_id')
						->order_by('r.date DESC')
						->limit(5)
						->get();
	}
	
	public function get_recruits()
	{
		return $this->db->select('r.*', 'u.user_id', 'u.username', 'up.avatar', 'up.sex', 'COUNT(DISTINCT rc.candidacy_id) as candidacies', 'COUNT(DISTINCT CASE WHEN rc.status = \'1\' THEN rc.candidacy_id END) as candidacies_pending', 'COUNT(DISTINCT CASE WHEN rc.status = \'2\' THEN rc.candidacy_id END) as candidacies_accepted', 'COUNT(DISTINCT CASE WHEN rc.status = \'3\' THEN rc.candidacy_id END) as candidacies_declined', 'tl.title as team_name')
						->from('dungeon_recruits r')
						->join('dungeon_users u',                 'r.user_id     = u.user_id')
						->join('dungeon_users_profiles up',       'up.user_id    = u.user_id')
						->join('dungeon_recruits_candidacies rc', 'rc.recruit_id = r.recruit_id')
						->join('dungeon_teams_lang tl',           'r.team_id     = tl.team_id')
						->group_by('r.recruit_id')
						->order_by('r.date DESC')
						->get();
	}
	
	public function get_recruit($recruit_id)
	{
		return $this->db->select('r.*', 'COUNT(DISTINCT rc.candidacy_id) as candidacies', 'COUNT(DISTINCT CASE WHEN rc.status = \'1\' THEN rc.candidacy_id END) as candidacies_pending', 'COUNT(DISTINCT CASE WHEN rc.status = \'2\' THEN rc.candidacy_id END) as candidacies_accepted', 'COUNT(DISTINCT CASE WHEN rc.status = \'3\' THEN rc.candidacy_id END) as candidacies_declined', 'tl.title as team_name')
						->from('dungeon_recruits r')
						->join('dungeon_recruits_candidacies rc', 'rc.recruit_id = r.recruit_id')
						->join('dungeon_teams_lang tl',           'r.team_id     = tl.team_id')
						->group_by('r.recruit_id')
						->where('r.recruit_id', $recruit_id)
						->row();
	}
}

/*
Dungeon Alpha 0.1.7
./widgets/recruits/models/recruits.php
*/