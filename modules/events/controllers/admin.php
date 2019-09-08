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

class m_events_c_admin extends Controller_Module
{
	public function index($events)
	{
		$this	->css('fullcalendar.min')
				->css('admin')
				->js('moment.min')
				->js('fullcalendar.min')
				// ->js('lang-all')
				->js('events');

		$types = $this	->table
						->add_columns([
							[
								'content' => function($data){
									return $this->label($data['title'], $data['icon'], $data['color'], 'admin/events/types/'.$data['type_id'].'/'.url_title($data['title']));
								}
							],
							[
								'content' => [
									function($data){
										return $this->user('admin') ? $this->button_access($data['type_id'], 'type') : NULL;
									},
									function($data){
										return $this->is_authorized('modify_events_type') ? $this->button_update('admin/events/types/'.$data['type_id'].'/'.url_title($data['title'])) : NULL;
									},
									function($data){
										return $this->is_authorized('delete_events_type') ? $this->button_delete('admin/events/types/delete/'.$data['type_id'].'/'.url_title($data['title'])) : NULL;
									}
								],
								'size'    => TRUE
							]
						])
						->pagination(FALSE)
						->data($this->model('types')->get_types())
						->no_data('No type')
						->display();

		$events = $this	->table
						->add_columns([
							[
								'content' => function($data){
									return $data['published'] ? '<i class="fa fa-circle" data-toggle="tooltip" title="published" style="color: #7bbb17;"></i>' : '<i class="fa fa-circle-o" data-toggle="tooltip" title="Awaiting publication" style="color: #535353;"></i>';
								},
								'sort'    => function($data){
									return $data['published'];
								},
								'size'    => TRUE
							],
							[
								'title'   => 'Type',
								'content' => function($data){
									return $this->label($data['type_title'], $data['icon'], $data['color'], 'admin/events/types/'.$data['type_id'].'/'.url_title($data['type_title']));
								},
								'sort'    => function($data){
									return $data['type_title'];
								},
								'search'  => function($data){
									return $data['type_title'];
								}
							],
							[
								'title'   => 'Titre',
								'content' => function($data){
									return '<a href="'.url('events/'.$data['event_id'].'/'.url_title($data['title'])).'">'.$data['title'].'</a>';
								},
								'sort'    => function($data){
									return $data['title'];
								},
								'search'  => function($data){
									return $data['title'];
								}
							],
							[
								'content' => function($data){
									if ($data['type'] == 1 && ($match = $this->model('matches')->get_match_info($data['event_id'])))//Matches
									{
										return  ($match['scores'] ? $this->model('matches')->label_global_scores($data['event_id']).'<span style="margin: 0 10px;"> vs </span>' : '<span style="margin-right: 10px;">Match play vs </span>').
												($match['opponent']['country'] ? '<img src="'.url('dungeon/themes/default/images/flags/'.$match['opponent']['country'].'.png').'" data-toggle="tooltip" title="'.get_countries()[$match['opponent']['country']].'" style="margin-right: 10px;" alt="" />' : '').
												$match['opponent']['title'].' <i>('.$match['game']['title'].')</i>';
									}
								},
								'sort'    => function($data){
									if ($data['type'] == 1 && ($match = $this->model('matches')->get_match_info($data['event_id'])))//Matches
									{
										return $match['opponent']['title'].' '.$match['game']['title'].' '.implode(' - ', $match['scores']);
									}
								},
								'search'  => function($data){
									if ($data['type'] == 1 && ($match = $this->model('matches')->get_match_info($data['event_id'])))//Matches
									{
										return $match['opponent']['title'].' '.$match['game']['title'].' '.implode(' - ', $match['scores']);
									}
								}
							],
							[
								'title'   => 'Auteur',
								'content' => function($data){
									return $data['user_id'] ? Dungeon()->user->link($data['user_id'], $data['username']) : $this->lang('guest');
								},
								'sort'    => function($data){
									return $data['username'];
								},
								'search'  => function($data){
									return $data['username'];
								}
							],
							[
								'title'   => 'Date',
								'content' => function($data){
									return '<span data-toggle="tooltip" title="'.timetostr(Dungeon()->lang('date_time_long'), $data['date']).'">'.timetostr(Dungeon()->lang('date_time_short'), $data['date']).($data['date_end'] ? '&nbsp;&nbsp;<i>'.icon('fa-hourglass-end').(ceil((strtotime($data['date_end']) - strtotime($data['date'])) / ( 60 * 60 ))).'h</i>' : '').'</span>';
								},
								'sort'    => function($data){
									return $data['date'];
								}
							],
							[
								'title'   => '<i class="fa fa-users" data-toggle="tooltip" title="Participants"></i>',
								'content' => function($data){
									return '<a href="'.url('events/'.$data['event_id'].'/'.url_title($data['title']).'#participants').'">'.$this->model('participants')->count_participants($data['event_id']).'</a>';
								},
								'size'    => TRUE
							],
							[
								'title'   => '<i class="fa fa-comments-o" data-toggle="tooltip" title="Comments"></i>',
								'content' => function($data){
									return Dungeon()->comments->admin_comments('events', $data['event_id']);
								},
								'size'    => TRUE
							],
							[
								'content' => [
									function($data){
										return $this->is_authorized('modify_event') ? $this->button_update('admin/events/'.$data['event_id'].'/'.url_title($data['title'])) : NULL;
									},
									function($data){
										return $this->is_authorized('delete_event') ? $this->button_delete('admin/events/delete/'.$data['event_id'].'/'.url_title($data['title'])) : NULL;
									}
								],
								'size'    => TRUE
							]
						])
						->data($events)
						->no_data('There are no events yet')
						->display();

		return $this->row(
			$this	->col(
						$this	->panel()
								->heading('', 'fa-calendar')
								->body('<div id="calendar"></div>', FALSE),
						$this	->panel()
								->heading('Event type', 'fa-bookmark-o')
								->body($types)
								->footer($this->is_authorized('add_events_type') ? $this->button_create('admin/events/types/add', 'Create an event type') : NULL)
					)
					->size('col-md-4 col-lg-3'),
			$this	->col(
						$this	->panel()
								->heading('Events list', 'fa-calendar')
								->body('<div class="panel-footer">'.$this->_filters().'</div><div class="panel-body">'.$events.'</div>', FALSE)
								->footer($this->is_authorized('add_event') ? $this->button_create('admin/events/add', 'Create an event') : NULL)
					)
					->size('col-md-8 col-lg-9')
		);
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

	public function _filters()
	{
		return $this->view('filters', ['type' => '']);
	}

	public function add()
	{
		$this	->subtitle('Add an event')
				->form
				->add_rules('events')
				->add_submit('Add')
				->add_back('admin/events');

		if ($this->form->is_valid($post))
		{
			$event_id = $this->model()->add($post['title'],
											$post['type'],
											$post['date'],
											$post['date_end'],
											$post['description'],
											$post['private_description'],
											$post['location'],
											$post['image'],
											in_array('on', $post['published']));

			notify('Événement ajouté');

			if ($this->db->select('type')->from('dungeon_events_types')->where('type_id', $post['type'])->row())
			{
				redirect('admin/events/'.$event_id.'/'.url_title($post['title']));
			}
			else
			{
				redirect_back('admin/events');
			}
		}

		return $this->panel()
					->heading('Add an event', 'fa-calendar')
					->body($this->form->display());
	}

	public function _edit($event_id, $title, $type_id, $date, $date_end, $description, $private_description, $location, $image_id, $published, $type)
	{
		$form_default = $this	->title('Edit event')
								->subtitle($title)
								->form
								->add_rules('events', [
									'title'               => $title,
									'type_id'             => $type_id,
									'image_id'            => $image_id,
									'description'         => $description,
									'private_description' => $private_description,
									'location'            => $location,
									'date'                => $date,
									'date_end'            => $date_end,
									'published'           => $published
								])
								->add_submit($this->lang('edit'))
								->add_back('admin/events')
								->save();

		if ($type == 1)//Matches
		{
			$match = $this->db->from('dungeon_events_matches')->where('event_id', $event_id)->row();

			if (!empty($match['mode_id']))
			{
				$game_id = $this->db->select('game_id')->from('dungeon_games_modes')->where('mode_id', $match['mode_id'])->row();
				$this->db->where('game_id', $game_id);
			}

			$maps = [];

			foreach ($this->db->select('*')->from('dungeon_games_maps')->get() as $map)
			{
				$maps[$map['map_id']] = $map['title'];
			}

			$form_match = $this	->form
								->add_rules([
									'team' => [
										'label'       => 'Team',
										'value'       => isset($match['team_id']) ? $match['team_id'] : NULL,
										'values'      => $this->module('teams')->model()->get_teams_list(),
										'type'        => 'select',
										'rules'       => 'required'
									],
									'opponent' => [
										'label'       => 'Opponent',
										'value'       => isset($match['opponent_id']) ? $match['opponent_id'] : NULL,
										'values'      => $this->model('matches')->get_opponents_list(),
										'type'        => 'select',
										'rules'       => 'required'
									],
									'mode' => [
										'label'       => 'Mode',
										'value'       => isset($match['mode_id']) ? $match['mode_id'] : NULL,
										'values'      => $this->module('games')->model('modes')->get_modes_list(),
										'type'        => 'select'
									],
									'webtv' => [
										'label'       => 'WebTv',
										'value'       => isset($match['webtv']) ? $match['webtv'] : NULL,
										'description' => 'Fill in the url of your Twitch channel to indicate a live broadcast.',
										'type'        => 'url'
									],
									'website' => [
										'label'       => 'Website',
										'value'       => isset($match['website']) ? $match['website'] : NULL,
										'description' => 'Fill in a site that talks about the event',
										'type'        => 'url'
									]
								])
								->add_submit('Valider')
								->save();

			$form_opponent = $this	->form
									->add_rules([
										'title' => [
											'label'       => 'Name',
											'rules'       => 'required'
										],
										'image' => [
											'label'       => 'Image',
											'type'        => 'file',
											'upload'      => 'opponents',
											'info'        => $this->lang('file_picture', file_upload_max_size() / 1024 / 1024),
											'check'       => function($filename, $ext){
												if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
												{
													return $this->lang('select_image_file');
												}
											}
										],
										'country' => [
											'label'       => 'Country',
											'values'      => get_countries(),
											'type'        => 'select'
										],
										'website' => [
											'label'       => 'Website',
											'type'        => 'url'
										]
									])
									->add_submit('Valider')
									->save();

			$form_round = $this	->form
								->add_rules([
									'map' => [
										'label'  => 'Map',
										'type'   => 'select',
										'values' => $maps,
										'size'   => 'col-md-5'
									],
									'score1' => [
										'label'  => 'Our score',
										'type'   => 'number',
										'rules'  => 'required',
										'size'   => 'col-md-3'
									],
									'score2' => [
										'label'  => 'Opponent score',
										'type'   => 'number',
										'rules'  => 'required',
										'size'   => 'col-md-3'
									]
								])
								->add_submit('Validate')
								->save();

			if ($form_match->is_valid($post))
			{
				$this->db->replace('dungeon_events_matches', [
					'event_id'    => $event_id,
					'team_id'     => $post['team'],
					'opponent_id' => $post['opponent'],
					'mode_id'     => isset($post['mode']) ? $post['mode'] : NULL,
					'webtv'       => $post['webtv'],
					'website'     => $post['website'],
				]);

				notify('Edited meeting');

				redirect('admin/events/'.$event_id.'/'.url_title($title));
			}
			else if ($form_opponent->is_valid($post))
			{
				$this->db->insert('dungeon_events_matches_opponents', [
					'image_id' => $post['image'],
					'title'    => $post['title'],
					'country'  => $post['country'],
					'website'  => $post['website']
				]);

				notify('Opponent added');

				redirect('admin/events/'.$event_id.'/'.url_title($title));
			}
			else if ($form_round->is_valid($post))
			{
				$this->db->insert('dungeon_events_matches_rounds', [
					'event_id' => $event_id,
					'map_id'   => !empty($post['map']) ? $post['map'] : NULL,
					'score1'   => $post['score1'],
					'score2'   => $post['score2']
				]);

				notify('Channel added');

				redirect('admin/events/'.$event_id.'/'.url_title($title));
			}
		}

		if ($form_default->is_valid($post))
		{
			$this->model()->edit(	$event_id,
									$post['title'],
									$post['type'],
									$post['date'],
									$post['date_end'],
									$post['description'],
									$post['private_description'],
									$post['location'],
									$post['image'],
									in_array('on', $post['published']));

			notify('Event edited');

			$new_type = $this->db->select('type')->from('dungeon_events_types')->where('type_id', $post['type'])->row();

			if ($new_type && $type != $new_type)
			{
				redirect('admin/events/'.$event_id.'/'.url_title($post['title']));
			}
			else
			{
				redirect_back('admin/events');
			}
		}

		$alert = '';

		if ($published && !$this->model('participants')->get_participants($event_id))
		{
			$alert = $this	->panel()
							->body('<div class="pull-right"><a href="'.url('events/'.$event_id.'/'.url_title($title).'#participants').'" class="btn btn-info">Invite members</a></div><i class="fa fa-info-circle"></i> <b>Reminder !</b><br />Do not forget to send your participation requests to your members !</b>')
							->color('info');
		}

		$panel = $this		->panel()
							->heading('Edit event', 'fa-align-left')
							->body($form_default->display());

		if ($type == 1)//Matches
		{
			$this	->table
					->add_columns([
						[
							'content' => function($data){
								return $this->model('matches')->label_scores($data['score1'], $data['score2']).($data['title'] ? ' ('.$data['title'].')' : '');
							},
						],
						[
							'content' => [
								function($data) use ($event_id, $title){
									return $this->button_delete('admin/events/rounds/delete/'.$event_id.'/'.url_title($title).'/'.$data['round_id']);
								}
							],
							'size'    => TRUE
						]
					])
					->pagination(FALSE)
					->data($rounds = $this->db	->select('r.round_id', 'm.title', 'r.score1', 'r.score2')
												->from('dungeon_events_matches_rounds r')
												->join('dungeon_games_maps m', 'm.map_id = r.map_id')
												->where('r.event_id', $event_id)
												->order_by('r.round_id')
												->get())
					->no_data('No race completed');

			$modal_opponent = $this	->modal('Add an opponent', 'fa-plus')
									->body($form_opponent->display())
									->open_if($form_opponent->get_errors());

			$modal_round    = $this	->modal('Add a round', 'fa-plus')
									->body($form_round->display())
									->open_if($form_round->get_errors());

			return $this->row(
				$this	->col($alert, $panel)
						->size('col-md-8'),
				$this	->col(
							$this	->panel()
									->heading('Details of the meeting<div class="pull-right">'.$this->button()->title('Add an opponent')->icon('fa-plus')->modal($modal_opponent).'</div>', 'fa-info-circle')
									->body($form_match->display()),
							$this	->panel()
									->heading('Manches jouées'.(count($rounds) > 1 ? '<div class="pull-right">Overall result '.$this->model('matches')->label_global_scores($event_id).'</div>' : ''), 'fa-gamepad')
									->body($this->table->display())
									->footer($this->button_create('#', 'Add a round')->modal($modal_round))
						)
						->size('col-md-4')
			);
		}
		else
		{
			return $panel;
		}
	}

	public function delete($event_id, $title)
	{
		$this	->title('Event Deletion')
				->subtitle($title)
				->form
				->confirm_deletion('Delete confirmation', 'Are you sure you want to delete the event <b>'.$title.'</b> ?');

		if ($this->form->is_valid())
		{
			$this->model()->delete($event_id);

			return 'OK';
		}

		echo $this->form->display();
	}

	public function _types_add()
	{
		$this	->subtitle('Add an event type')
				->form
				->add_rules('types')
				->add_back('admin/events')
				->add_submit('Add');

		if ($this->form->is_valid($post))
		{
			$this->model('types')->add(	$post['type'],
										$post['title'],
										$post['color'],
										$post['icon']);

			notify('Type of event added');

			redirect_back('admin/events');
		}

		return $this->panel()
					->heading('Add an event type', 'fa-bookmark-o')
					->body($this->form->display());
	}

	public function _types_edit($type_id, $type, $title, $color, $icon)
	{
		$this	->subtitle('Type '.$title)
				->form
				->add_rules('types', [
					'type'  => $type,
					'title' => $title,
					'color' => $color,
					'icon'  => $icon
				])
				->add_submit($this->lang('edit'))
				->add_back('admin/events');

		if ($this->form->is_valid($post))
		{
			$this->model('types')->edit($type_id,
										$post['type'],
										$post['title'],
										$post['color'],
										$post['icon']);

			notify('Event type edited');

			redirect_back('admin/events');
		}

		return $this->panel()
					->heading('Edit event type', 'fa-bookmark-o')
					->body($this->form->display());
	}

	public function _types_delete($type_id, $title)
	{
		$this	->title('Event type deletion')
				->subtitle($title)
				->form
				->confirm_deletion('Deletion confirmation', 'Are you sure you want to delete the type of event <b>'.$title.'</b> ?<br />All events of this type will also be deleted.');

		if ($this->form->is_valid())
		{
			$this->model('types')->delete($type_id);

			return 'OK';
		}

		echo $this->form->display();
	}

	public function _round_delete($round_id)
	{
		$this	->title('Delete round')
				->form
				->confirm_deletion('Delete confirmation', 'Are you sure you want to delete this round? ?');

		if ($this->form->is_valid())
		{
			$this->db	->where('round_id', $round_id)
						->delete('dungeon_events_matches_rounds');

			return 'OK';
		}

		echo $this->form->display();
	}
}

/*
Dungeon Alpha 0.1.6
./modules/events/controllers/admin.php
*/