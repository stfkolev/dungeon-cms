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

class m_events_c_index extends Controller_Module
{
	public function index($events)
	{
		$panels[] = $this->_filters();

		$types = $this->model('types')->get_types();

		foreach ($events as $event)
		{
			if ($types[$event['type_id']]['type'] == 1)//Matches
			{
				$icon = 'fa-crosshairs';
			}
			else
			{
				$icon = 'fa-calendar-o';
			}

			$data = [
				'type'         => $types[$event['type_id']],
				'participants' => $this->model('participants')->count_participants($event['event_id'])
			];

			if ($data['type']['type'] == 1 && ($match = $this->model('matches')->get_match_info($event['event_id'])))//Matches
			{
				$data['match'] = $match;
			}

			if ($this->access('events', 'access_events_type', $event['type_id']))
			{
				$panels[] = $this	->panel()
									->heading('<a href="'.url('events/'.$event['event_id'].'/'.url_title($event['title'])).'">'.$event['title'].'</a>'.(!empty($data['match']) ? '<div class="pull-right">'.($data['match']['game']['icon_id'] ? '<img src="'.path($data['match']['game']['icon_id']).'" alt="" />' : icon('fa-gamepad')).' '.$data['match']['game']['title'].'</div>' : ''), $icon)
									->body($this->view('event', array_merge($event, $data)), FALSE);
			}
		}

		if (!$events)
		{
			$panels[] = $this	->panel()
								->heading()
								->body('<div class="text-center">No events at the moment</div>')
								->color('info');
		}
		else if ($pagination = $this->pagination->get_pagination())
		{
			$panels[] = '<div class="text-right">'.$pagination.'</div>';
		}

		return $panels;
	}

	public function standards($events)
	{
		return $this->index($events);
	}

	public function matches($events)
	{
		return $this->index($events);
	}

	public function upcoming($events)
	{
		return $this->index($events);
	}

	public function _type($events)
	{
		return $this->index($events);
	}

	public function _team($events)
	{
		return $this->index($events);
	}

	public function _filters()
	{
		$type = '';

		if (isset($this->url->segments[1]) && $this->url->segments[1] == 'type')
		{
			$type = $this->model('types')->check_type($this->url->segments[2], $this->url->segments[3]);
		}

		return $this->panel()
					->body($this->view('filters', [
						'type' => $type
					]));
	}

	public function _event($event_id, $title, $type_id, $date, $date_end, $description, $private_description, $location, $image_id, $published, $type, $mode_id, $webtv, $website, $mode_title)
	{
		$this	->title($title)
				->breadcrumb($title)
				->table
				->add_columns([
					[
						'content' => function($data){
							return $this->user->avatar($data['avatar'], $data['sex'], $data['user_id'], $data['username']);
						},
						'size'    => TRUE
					],
					[
						'content' => function($data){
							return '<div>'.$this->user->link($data['user_id'], $data['username']).'</div><small>'.icon('fa-circle '.($data['online'] ? 'text-green' : 'text-gray')).' '.($data['admin'] ? 'Admin' : 'Member').' '.($data['online'] ? 'online' : 'offline').'</small>';
						},
					],
					[
						'align'   => 'right',
						'content' => function($data) use ($event_id, $title){
							return $data['user_id'] == $this->user('user_id') ? $this->model('participants')->buttons_status($event_id, $title, $data['status']) : $this->model('participants')->label_status($data['status']);
						}
					]
				])
				->add_columns_if($this->user('admin'), [[
						'content' => function($data) use ($event_id, $title){
							return $this->button_delete('events/participant/delete/'.$event_id.'/'.url_title($title).'/'.$data['user_id']);
						},
						'size'    => TRUE
					]
				])
				->data($this->model('participants')->get_participants($event_id))
				->no_data('No participants for this event');

		$match = $type == 1 ? $this->model('matches')->get_match_info($event_id) : NULL;

		$rounds = $this->db	->select('r.round_id', 'm.image_id', 'm.title', 'r.score1', 'r.score2')
							->from('dungeon_events_matches_rounds r')
							->join('dungeon_games_maps m', 'm.map_id = r.map_id')
							->where('r.event_id', $event_id)
							->order_by('r.round_id')
							->get();

		if ($this->user('admin'))
		{
			$this->js('participants');

			$participants = $this->db	->select('user_id')
										->from('dungeon_events_participants')
										->where('event_id', $event_id)
										->get();

			$users = [];

			foreach ($this->db->select('user_id', 'username')->from('dungeon_users')->where_if($participants, 'user_id NOT', $participants)->where('deleted', FALSE)->get() as $user)
			{
				if ($this->access('events', 'access_events_type', $type_id, NULL, $user['user_id']))
				{
					$users[$user['user_id']] = $user['username'];
				}
			}

			array_natsort($users);

			$this	->form
					->add_rules([
						'users' => [
							'type'   => 'checkbox',
							'values' => $users,
							'rules'  => 'required'
						]
					]);

			if ($this->form->is_valid($post))
			{
				$this->model('participants')->invite($event_id, $title, array_unique($post['users']));

				notify('Invitations envoyées');

				refresh();
			}

			$modal = $this	->modal('Invite members', 'fa-user-plus')
							->body($this->view('participants', [
								'users'   => $users,
								'form_id' => $this->form->token()
							]))
							->submit('Invite')
							->cancel()
							->set_id('c2dac90bb0731401a293d27ee036757a');
		}
		
		return [
			$this->_filters(),
			$this	->panel()
					->heading('<a href="'.url('events/'.$event_id.'/'.url_title($title)).'">'.$title.'</a>'.(!empty($match) ? '<div class="pull-right">'.($match['game']['icon_id'] ? '<img src="'.path($match['game']['icon_id']).'" alt="" />' : icon('fa-gamepad')).' '.$match['game']['title'].'</div>' : ''), $type == 1 ? 'fa-crosshairs' : 'fa-calendar-o')
					->body($this->view('event', [
						'event_id'             => $event_id,
						'title'                => $title,
						'date'                 => $date,
						'date_end'             => $date_end,
						'description'          => $description,
						'private_description'  => $private_description,
						'location'             => $location,
						'image_id'             => $image_id,
						'match'                => $match,
						'webtv'                => $webtv,
						'website'              => $website,
						'mode'                 => $mode_title,
						'rounds'               => $rounds,
						'type'                 => $this->model('types')->get_types()[$type_id],
						'participants'         => $this->model('participants')->count_participants($event_id),
						'list_participants'    => $this->model('participants')->get_participants($event_id),
						'show_details'         => TRUE
					]), FALSE),
			$this->user() ? $this	->panel()
									->heading('<a name="participants"></a>Participants'.(isset($modal) ? '<div class="pull-right">'.$this->button()->title('Invitations')->icon('fa-user-plus')->modal($modal).'</div>' : ''), 'fa-users')
									->body($this->table->display()) : NULL,
			$this->comments->display('events', $event_id),
			$this->button_back()
		];
	}

	public function _participant_add($event_id, $title, $status)
	{
		$this->db	->where('event_id', $event_id)
					->where('user_id', $this->user('user_id'))
					->update('dungeon_events_participants', [
						'status' => $status
					]);

		notify('Availability added');

		redirect('events/'.$event_id.'/'.$title.'#participants');
	}

	public function _participant_delete($event_id, $user_id)
	{
		$this	->title('Delete participant')
				->form
				->confirm_deletion('Delete confirmation', 'Are you sure you want to delete this guest?');

		if ($this->form->is_valid())
		{
			$this->db	->where('event_id', $event_id)
						->where('user_id', $user_id)
						->delete('dungeon_events_participants');

			return 'OK';
		}

		echo $this->form->display();
	}
}

/*
Dungeon Alpha 0.1.7.7
./modules/events/controllers/index.php
*/