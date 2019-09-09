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

class m_awards_c_admin extends Controller_Module
{
	public function index($awards)
	{
		$this->css('awards');

		$awards = $this	->table
						->add_columns([
							[
								'title'   => 'Title',
								'content' => function($data){
									return $data['name'];
								},
								'sort'    => function($data){
									return $data['name'];
								},
								'search'  => function($data){
									return $data['name'];
								}
							],
							[
								'title'   => 'Location',
								'content' => function($data){
									return $data['location'] ? icon('fa-map-marker').$data['location'] : '';
								},
								'sort'    => function($data){
									return $data['location'];
								},
								'search'  => function($data){
									return $data['location'];
								}
							],
							[
								'title'   => 'Date',
								'content' => function($data){
									return timetostr(Dungeon()->lang('date_short'), $data['date']);
								},
								'sort'    => function($data){
									return $data['date'];
								},
								'search'  => function($data){
									return $data['date'];
								}
							],
							[
								'title'   => 'Team',
								'content' => function($data){
									return $data['team_title'];
								},
								'sort'    => function($data){
									return $data['team_title'];
								},
								'search'  => function($data){
									return $data['team_title'];
								}
							],
							[
								'title'   => 'Game',
								'content' => function($data){
									return $data['game_title'];
								},
								'sort'    => function($data){
									return $data['game_title'];
								},
								'search'  => function($data){
									return $data['game_title'];
								}
							],
							[
								'title'   => '<span data-toggle="tooltip" title="Ranking">'.icon('fa-trophy').'</span>',
								'size'    => TRUE,
								'content' => function($data){
									if ($data['ranking'] == 1)
									{
										return '<span data-toggle="tooltip" title="'.$data['ranking'].'st / '.$data['participants'].' teams">'.icon('fa-trophy trophy-gold').'</span>';
									}
									else if ($data['ranking'] == 2)
									{
										return '<span data-toggle="tooltip" title="'.$data['ranking'].'nd / '.$data['participants'].' teams">'.icon('fa-trophy trophy-silver').'</span>';
									}
									else if ($data['ranking'] == 3)
									{
										return '<span data-toggle="tooltip" title="'.$data['ranking'].'rd / '.$data['participants'].' teams">'.icon('fa-trophy trophy-bronze').'</span>';
									}
									else
									{
										return $data['ranking'].'<small>th</small>';
									}
								}
							],
							[
								'title'   => '<span data-toggle="tooltip" title="Platform">'.icon('fa-tv').'</span>',
								'size'    => TRUE,
								'content' => function($data){
									return $data['platform'];
								},
								'search'  => function($data){
									return $data['platform'];
								}
							],
							[
								'content' => [
									function($data){
										return $this->button_update('admin/awards/'.$data['award_id'].'/'.url_title($data['name']));
									},
									function($data){
										return $this->button_delete('admin/awards/delete/'.$data['award_id'].'/'.url_title($data['name']));
									}
								],
								'size'    => TRUE
							]
						])
						->data($awards)
						->no_data('No awards')
						->display();

		return $this->panel()
					->heading('List of awards', 'fa-trophy')
					->body($awards)
					->footer($this->button_create('admin/awards/add', 'Add award'));
	}

	public function add()
	{
		$this	->subtitle('Add award')
				->form
				->add_rules('awards', [
					'teams' => $this->model()->get_teams_list(),
					'games' => $this->model()->get_games_list(),
				])
				->add_submit($this->lang('add'))
				->add_back('admin/awards');

		if ($this->form->is_valid($post))
		{
			$this->model()->add_awards(	$post['date'],
										$post['team'],
										$post['game'],
										$post['platform'],
										$post['location'],
										$post['name'],
										$post['ranking'],
										$post['participants'],
										$post['description'],
										$post['image']);

			notify('Award added successfully');

			redirect_back('admin/awards');
		}

		return $this->panel()
					->heading('New award', 'fa-trophy')
					->body($this->form->display());
	}

	public function _edit($award_id, $team_id, $date, $location, $name, $platform, $game_id, $ranking, $participants, $description, $image_id, $team_name, $team_title, $game_name, $game_title)
	{
		$this	->subtitle('Team '.$team_title)
				->form
				->add_rules('awards', [
					'award_id'     => $award_id,
					'date'         => $date,
					'team_id'      => $team_id,
					'teams'        => $this->model()->get_teams_list(),
					'game_id'      => $game_id,
					'games'        => $this->model()->get_games_list(),
					'platform'     => $platform,
					'location'     => $location,
					'name'         => $name,
					'ranking'      => $ranking,
					'participants' => $participants,
					'description'  => $description,
					'image'        => $image_id
				])
				->add_submit($this->lang('edit'))
				->add_back('admin/awards');

		if ($this->form->is_valid($post))
		{
			$this->model()->edit_awards($award_id,
										$post['date'],
										$post['team'],
										$post['game'],
										$post['platform'],
										$post['location'],
										$post['name'],
										$post['ranking'],
										$post['participants'],
										$post['description'],
										$post['image']);

			notify('Award modified successfully');

			redirect_back('admin/awards');
		}

		return $this->panel()
					->heading('Modify award', 'fa-trophy')
					->body($this->form->display());
	}

	public function delete($award_id, $name)
	{
		$this	->title('Awards')
				->subtitle($name)
				->form
				->confirm_deletion($this->lang('delete_confirmation'), 'Are you sure you want to delete the award <b>'.$name.'</b> ?');

		if ($this->form->is_valid())
		{
			$this->model()->delete_awards($award_id);

			return 'OK';
		}

		echo $this->form->display();
	}
}

/*
Dungeon Alpha 0.1.6
./modules/awards/controllers/admin.php
*/