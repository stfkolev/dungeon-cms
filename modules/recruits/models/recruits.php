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

class m_recruits_m_recruits extends Model
{
	public function get_recruits()
	{
		$this->db	->select('r.*', 'u.user_id', 'u.username', 'up.avatar', 'up.sex', 'COUNT(DISTINCT rc.candidacy_id) as candidacies', 'COUNT(DISTINCT CASE WHEN rc.status = \'1\' THEN rc.candidacy_id END) as candidacies_pending', 'COUNT(DISTINCT CASE WHEN rc.status = \'2\' THEN rc.candidacy_id END) as candidacies_accepted', 'COUNT(DISTINCT CASE WHEN rc.status = \'3\' THEN rc.candidacy_id END) as candidacies_declined', 'tl.title as team_name')
					->from('dungeon_recruits r')
					->join('dungeon_users u',                 'r.user_id     = u.user_id')
					->join('dungeon_users_profiles up',       'up.user_id    = u.user_id')
					->join('dungeon_recruits_candidacies rc', 'rc.recruit_id = r.recruit_id')
					->join('dungeon_teams_lang tl',           'r.team_id     = tl.team_id')
					->group_by('r.recruit_id')
					->order_by('r.date DESC');

		if (!$this->url->admin)
		{
			$this->db->where('r.closed', FALSE);
		}

		return $this->db->get();
	}

	public function check_recruit($recruit_id, $title)
	{
		$this->db	->select('r.*', 'u.user_id', 'u.username', 'up.avatar', 'up.sex', 'COUNT(DISTINCT rc.candidacy_id) as candidacies', 'COUNT(DISTINCT CASE WHEN rc.status = \'1\' THEN rc.candidacy_id END) as candidacies_pending', 'COUNT(DISTINCT CASE WHEN rc.status = \'2\' THEN rc.candidacy_id END) as candidacies_accepted', 'COUNT(DISTINCT CASE WHEN rc.status = \'3\' THEN rc.candidacy_id END) as candidacies_declined', 'tl.title as team_name')
					->from('dungeon_recruits r')
					->join('dungeon_users u',                 'r.user_id     = u.user_id')
					->join('dungeon_users_profiles up',       'up.user_id    = u.user_id')
					->join('dungeon_recruits_candidacies rc', 'rc.recruit_id = r.recruit_id')
					->join('dungeon_teams_lang tl',           'r.team_id     = tl.team_id')
					->group_by('r.recruit_id')
					->where('r.recruit_id', $recruit_id);

		if (!$this->url->admin)
		{
			$this->db->where('r.closed', FALSE);
		}

		$recruit = $this->db->row();

		if ($recruit && url_title($recruit['title']) == $title)
		{
			return $recruit;
		}
		else
		{
			return FALSE;
		}
	}

	public function add_recruits($title, $introduction, $description, $requierments, $size, $role, $icon, $date_end, $closed, $team_id, $image_id)
	{
		$recruit_id = $this->db->insert('dungeon_recruits', [
			'title'        => $title,
			'introduction' => $introduction,
			'description'  => $description,
			'requierments' => $requierments,
			'user_id'      => $this->user('user_id'),
			'size'         => $size,
			'role'         => $role,
			'icon'         => $icon,
			'date_end'     => $date_end ?: NULL,
			'closed'       => $closed,
			'team_id'      => $team_id ?: NULL,
			'image_id'     => $image_id ?: NULL
		]);

		$this->access->init('recruits', 'recruit', $recruit_id);
	}

	public function get_teams_list()
	{
		$list = [];

		foreach ($this->db	->select('t.team_id', 't.name', 'tl.title')
							->from('dungeon_teams t')
							->join('dungeon_teams_lang tl', 't.team_id = tl.team_id')
							->where('tl.lang', $this->config->lang)
							->order_by('tl.title')
							->get() as $team)
		{
			$list[$team['team_id']] = $team['title'];
		}

		natsort($list);

		return $list;
	}

	public function edit_recruits($recruit_id, $title, $introduction, $description, $requierments, $size, $role, $icon, $date_end, $closed, $team_id, $image_id)
	{
		$this->db	->where('recruit_id', $recruit_id)
					->update('dungeon_recruits', [
						'title' => $title,
						'introduction' => $introduction,
						'description'  => $description,
						'requierments' => $requierments,
						'size'         => $size,
						'role'         => $role,
						'icon'         => $icon,
						'date_end'     => $date_end ?: NULL,
						'closed'       => $closed,
						'team_id'      => $team_id ?: NULL,
						'image_id'     => $image_id ?: NULL
					]);
	}

	public function delete_recruit($recruit_id)
	{
		$this->file->delete($this->db->select('image_id')->from('dungeon_recruit')->where('recruit_id', $recruit_id)->row());

		$this->db	->where('recruit_id', $recruit_id)
					->delete('dungeon_recruits');
	}

	public function get_candidacies($recruit_id = '', $status = '')
	{
		$this->db	->select('rc.*', 'u.user_id', 'u.username', 'up.avatar', 'up.sex', 'r.title')
					->from('dungeon_recruits_candidacies rc')
					->join('dungeon_recruits r',        'rc.recruit_id = r.recruit_id')
					->join('dungeon_users u',           'rc.user_id    = u.user_id')
					->join('dungeon_users_profiles up', 'up.user_id    = u.user_id')
					->order_by('rc.date DESC');

		if ($recruit_id)
		{
			$this->db->where('rc.recruit_id', $recruit_id);
		}

		if ($status)
		{
			$this->db->where('rc.status', $status);
		}

		return $this->db->get();
	}

	public function send_candidacy($recruit_id, $user_id, $pseudo, $email, $date_of_birth, $presentation, $motivations, $experiences)
	{
		$candidacy_id = $this->db->insert('dungeon_recruits_candidacies', [
			'recruit_id' => $recruit_id,
			'user_id' => $user_id,
			'pseudo' => $pseudo,
			'email' => $email,
			'date_of_birth' => $date_of_birth,
			'presentation' => $presentation,
			'motivations' => $motivations,
			'experiences' => $experiences
		]);

		return $candidacy_id;
	}

	public function check_candidacy($candidacy_id, $title)
	{
		$candidacy = $this->db	->select('rc.*', 'r.recruit_id', 'r.title', 'r.icon', 'r.role', 'r.team_id', 'tl.title as team_name', 'u.username', 'up.avatar', 'up.sex')
								->from('dungeon_recruits_candidacies rc')
								->join('dungeon_recruits r',        'rc.recruit_id = r.recruit_id')
								->join('dungeon_teams_lang tl',     'r.team_id    = tl.team_id')
								->join('dungeon_users u',           'rc.user_id    = u.user_id')
								->join('dungeon_users_profiles up', 'up.user_id    = u.user_id')
								->where('rc.candidacy_id', $candidacy_id)
								->row();

		if ($candidacy && url_title($candidacy['title']) == $title)
		{
			return $candidacy;
		}

		return FALSE;
	}
	
	public function update_candidacy($candidacy_id, $reply, $status)
	{
		$this->db	->where('candidacy_id', $candidacy_id)
					->update('dungeon_recruits_candidacies', [
						'reply'  => $reply,
						'status' => $status
					]);
	}

	public function delete_candidacy($candidacy_id)
	{
		$this->db	->where('candidacy_id', $candidacy_id)
					->delete('dungeon_recruits_candidacies');
	}

	public function postulated($user_id, $recruit_id, $title)
	{
		$candidacy = $this->db	->select('rc.candidacy_id', 'rc.recruit_id', 'rc.date', 'rc.user_id', 'rc.status', 'r.title')
								->from('dungeon_recruits_candidacies rc')
								->join('dungeon_recruits r', 'rc.recruit_id = r.recruit_id')
								->where('rc.user_id', $user_id)
								->where('rc.recruit_id', $recruit_id)
								->where('r.title', $title);
		
		$candidacy = $this->db->row();

		if ($candidacy && $candidacy['title'] == $title)
		{
			return $candidacy;
		}

		return FALSE;
	}

	public function get_votes($candidacy_id)
	{
		return $this->db->select('rcv.*', 'u.username', 'up.avatar', 'up.sex')
						->from('dungeon_recruits_candidacies_votes rcv')
						->join('dungeon_users u',           'u.user_id   = rcv.user_id')
						->join('dungeon_users_profiles up', 'up.user_id  = u.user_id')
						->where('rcv.candidacy_id', $candidacy_id)
						->get();
	}

	public function send_vote($candidacy_id, $vote, $comment)
	{
		$this->db->insert('dungeon_recruits_candidacies_votes', [
			'candidacy_id' => $candidacy_id,
			'user_id'      => $this->user('user_id'),
			'vote'         => $vote,
			'comment'      => $comment
		]);
	}

	public function update_vote($user_id, $candidacy_id, $vote, $comment)
	{
		$this->db	->where('candidacy_id', $candidacy_id)
					->where('user_id', $user_id)
					->update('dungeon_recruits_candidacies_votes', [
						'vote'    => $vote,
						'comment' => $comment
					]);
	}

	public function check_team($team_id, $name)
	{
		return $this->db->select('t.team_id', 't.name', 'tl.title', 't.image_id', 't.icon_id', 'tl.description', 't.game_id', 'gl.title as game', 'g.icon_id as game_icon')
						->from('dungeon_teams t')
						->join('dungeon_teams_lang tl', 't.team_id = tl.team_id')
						->join('dungeon_games g',       'g.game_id = t.game_id')
						->join('dungeon_games_lang gl', 'g.game_id = gl.game_id')
						->where('t.team_id', $team_id)
						->where('t.name', $name)
						->where('tl.lang', $this->config->lang)
						->row();
	}

	public function check_role($title)
	{
		$role = $this->db	->select('role_id', 'title')
							->from('dungeon_teams_roles')
							->where('title', $title)
							->row();

		if ($role && $title == $role['title'])
		{
			return $role;
		}

		return FALSE;
	}
}

/*
Dungeon Alpha 0.1.7
./modules/recruits/models/recruits.php
*/