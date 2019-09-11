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

class w_members_c_index extends Controller_Widget
{
	public function index($config = [])
	{
		$members = $this->db->select('user_id', 'username', 'registration_date')
							->from('dungeon_users')
							->where('deleted', FALSE)
							->order_by('registration_date DESC')
							->limit(5)
							->get();
		
		if (!empty($members))
		{
			return $this->panel()
						->heading($this->lang('last_members'))
						->body($this->view('index', [
							'members'  => $members
						]), FALSE)
						->footer('<a href="'.url('members').'">'.icon('fa-arrow-circle-o-right').' '.$this->lang('members_list').'</a>', 'right');
		}
		else
		{
			return $this->panel()
						->heading($this->lang('last_members'))
						->body($this->lang('no_members'));
		}
	}
	
	public function online($config = [])
	{
		$admins = $members = [];
		$nb_admins = $nb_members = 0;
		
		foreach ($this->db	->select('u.user_id', 'u.username', 'u.admin', 'up.avatar', 'up.sex', 'MAX(s.last_activity) AS last_activity')
							->from('dungeon_sessions s')
							->join('dungeon_users u', 'u.user_id = s.user_id AND u.deleted = "0"', 'INNER')
							->join('dungeon_users_profiles up', 'u.user_id = up.user_id')
							->where('s.last_activity > DATE_SUB(NOW(), INTERVAL 5 MINUTE)')
							->where('s.is_crawler', FALSE)
							->group_by('u.user_id')
							->order_by('u.username')
							->get() as $user)
		{
			if ($user['admin'])
			{
				$admins[] = $user;
				$nb_admins++;
			}
			else
			{
				$members[] = $user;
				$nb_members++;
			}
		}

		$output = [
			$this	->panel()
					->heading($this->lang('whos_online'))
					->body($this->view('online', [
						'administrators' => $admins,
						'members'        => $members,
						'nb_admins'      => $nb_admins,
						'nb_members'     => $nb_members,
						'nb_visitors'    => $this->session->current_sessions() - $nb_admins - $nb_members
					]))
		];

		if ($nb_admins)
		{
			$output[] = $this->view('online_modal', [
				'name'  => 'administrators',
				'title' => $this->lang('admins_online'),
				'users' => $admins
			]);
		}
		
		if ($nb_members)
		{
			$output[] = $this->view('online_modal', [
				'name'  => 'members',
				'title' => $this->lang('members_online'),
				'users' => $members
			]);
		}
		
		return $output;
	}
	
	public function online_mini($config = [])
	{
		return $this->view('online_mini', [
			'members' => $this->session->current_sessions(),
			'align'   => !empty($config['align']) ? $config['align'] : 'pull-right'
		]);
	}
}

/*
Dungeon Alpha 0.1.7
./widgets/members/controllers/index.php
*/