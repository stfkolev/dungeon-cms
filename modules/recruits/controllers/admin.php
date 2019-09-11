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
 
class m_recruits_c_admin extends Controller_Module
{
	public function index($recruits)
	{
		$total_candidacies = 0;
		$total_pending     = 0;
		$total_accepted    = 0;
		$total_declined    = 0;

		foreach ($recruits as $recruit)
		{
			$total_candidacies += $recruit['candidacies'];
			$total_pending     += $recruit['candidacies_pending'];
			$total_accepted    += $recruit['candidacies_accepted'];
			$total_declined    += $recruit['candidacies_declined'];
		}

		$recruits = $this	->table
							->add_columns([
								[
									'content' => function($data){
										if ($data['closed'] || ($data['candidacies_accepted'] >= $data['size']) || ($data['date_end'] && strtotime($data['date_end']) < time()))
										{
											return '<i class="fa fa-circle-o" data-toggle="tooltip" title="Closed offers" style="color: #535353;"></i>';
										}
										else
										{
											return '<i class="fa fa-circle" data-toggle="tooltip" title="Opened offers" style="color: #7bbb17;"></i>';
										}
									},
									'size'    => TRUE
								],
								[
									'title'   => '<span data-toggle="tooltip" title="Number of posts">'.icon('fa-briefcase').'</span>',
									'content' => function($data){
										return $data['size'];
									},
									'size'    => TRUE
								],
								[
									'title'   => 'Title',
									'content' => function($data){
										return '<a href="'.url('recruits/'.$data['recruit_id'].'/'.url_title($data['title'])).'">'.$data['title'].'</a>';
									},
									'sort'    => function($data){
										return $data['title'];
									},
									'search'  => function($data){
										return $data['title'];
									}
								],
								[
									'title'   => icon('fa-black-tie').' Applications',
									'content' => function($data){
										return '<ul class="list-inline">
													<li class="text-muted" data-toggle="tooltip" title="Pending">'.icon('fa-clock-o').' '.$data['candidacies_pending'].'</li>
													<li class="text-success" data-toggle="tooltip" title="Accepted">'.icon('fa-check').' '.$data['candidacies_accepted'].'</li>
													<li class="text-danger" data-toggle="tooltip" title="Refused">'.icon('fa-ban').' '.$data['candidacies_declined'].'</li>
													'.($data['candidacies_accepted'] == $data['size'] ? '<li><span class="label label-success">Overdue</span></li>' : '<li><span class="label label-default">In progress</span></li>').'
												</ul>';
									}
								],
								[
									'content' => [
										function($data){
											return $this->user('admin') ? $this->button_access($data['recruit_id'], 'recruit') : NULL;
										},
										function($data){
											return $this->is_authorized('modify_recruit') ? $this->button_update('admin/recruits/'.$data['recruit_id'].'/'.url_title($data['title'])) : NULL;
										},
										function($data){
											return $this->is_authorized('delete_recruit') ? $this->button_delete('admin/recruits/delete/'.$data['recruit_id'].'/'.url_title($data['title'])) : NULL;
										}
									],
									'size'    => TRUE
								]
							])
							->data($recruits)
							->no_data('There are no position offers yet')
							->display();

		return $this->row(
			$this->col(
				$this	->panel()
						->heading('Applications', 'fa-black-tie')
						->body($this->view('admin-candidacies', [
							'total_candidacies' => $total_candidacies,
							'total_pending'     => $total_pending,
							'total_accepted'    => $total_accepted,
							'total_declined'    => $total_declined
						]), FALSE)
						->size('col-md-4 col-lg-3')
			),
			$this->col(
				$this	->panel()
						->heading('Offers List', 'fa-bullhorn')
						->body($recruits)
						->footer($this->is_authorized('add_recruit') ? $this->button_create('admin/recruits/add', 'Create an offer') : NULL)
						->size('col-md-8 col-lg-9')
			)
		);
	}

	public function add()
	{
		$this	->subtitle('Create an offer')
				->form
				->add_rules('recruit', [
					'teams' => $this->model()->get_teams_list()
				])
				->add_submit('Add')
				->add_back('admin/recruits');

		if ($this->form->is_valid($post))
		{
			$this->model()->add_recruits(	$post['title'],
											$post['introduction'],
											$post['description'],
											$post['requierments'],
											($post['size'] <= 0 ? 1 : $post['size']),
											$post['role'],
											$post['icon'],
											$post['date_end'],
											in_array('on', $post['closed']),
											$post['team_id'],
											$post['image']);

			notify('Recruitment offer successfully added');

			redirect_back('admin/recruits');
		}

		return $this->panel()
					->heading('Create a recruitment offer', 'fa-bullhorn')
					->body($this->form->display());
	}

	public function _edit($recruit_id, $title, $introduction, $description, $requierments, $date, $user_id, $size, $role, $icon, $date_end, $closed, $team_id, $image_id, $username, $avatar, $sex, $total_candidacies, $candidacies_pending, $candidacies_accepted, $candidacies_declined, $team_name)
	{
		$this	->subtitle($title)
				->css('recruits')
				->js('jquery.knob')
				->js_load('$(\'.knob\').knob();')
				->form
				->add_rules('recruit', [
					'teams'        => $this->model()->get_teams_list(),
					'title'        => $title,
					'introduction' => $introduction,
					'description'  => $description,
					'requierments' => $requierments,
					'size'         => $size,
					'role'         => $role,
					'icon'         => $icon,
					'date_end'     => $date_end,
					'closed'       => $closed,
					'team_id'      => $team_id,
					'image_id'     => $image_id
				])
				->add_submit('Modify')
				->add_back('admin/recruits');

		if ($this->form->is_valid($post))
		{
			$this->model()->edit_recruits(	$recruit_id,
											$post['title'],
											$post['introduction'],
											$post['description'],
											$post['requierments'],
											($post['size'] <= 0 ? 1 : $post['size']),
											$post['role'],
											$post['icon'],
											$post['date_end'],
											in_array('on', $post['closed']),
											$post['team_id'],
											$post['image']);

			notify('Recruitment offer successfully modified');

			redirect_back('admin/recruits');
		}

		return $this->row(
			$this->col(
				$this	->panel()
						->heading('<div class="pull-right">'.$this->button_access($recruit_id, 'recruit').'</div>'.$title, 'fa-briefcase')
						->body($this->form->display())
						->size('col-md-8')
			),
			$this->col(
				$this	->panel()
						->heading('Submitted applications', 'fa-black-tie')
						->body($this->view('admin-recruit-status', [
												'size'                 => $size,
												'available'            => $size - $candidacies_accepted,
												'total_candidacies'    => $total_candidacies,
												'candidacies_pending'  => $candidacies_pending,
												'candidacies_accepted' => $candidacies_accepted,
												'candidacies_declined' => $candidacies_declined
											]))
						->footer(($this->is_authorized('candidacy_vote') || $this->is_authorized('candidacy_reply')) ? '<a href="'.url('admin/recruits/candidacies/'.$recruit_id.'/'.url_title($title)).'" class="btn btn-info btn-outline">See the applicants</a>' : '<span class="text-red">ou are not allowed to manage applications...</span>')
						->size('col-md-4'),
				$this	->panel()
						->heading('Formulaire', 'fa-tasks')
						->body($this->view('admin-custom-form'))
						->footer('<a href="#" class="btn btn-info btn-outline" data-toggle="tooltip" title="Available soon..." disabled>Customize the form</a>')
						->size('col-md-4')
			)
		);
	}

	public function delete($recruit_id, $title)
	{
		$this	->title('Delete Recruitment offer')
				->subtitle($title)
				->form
				->confirm_deletion('Delete Confirmation', 'Are you sure you want to delete the offer <b>'.$title.'</b> ?<br />All applications associated with this offer will also be deleted.');

		if ($this->form->is_valid())
		{
			$this->model()->delete_recruit($recruit_id);

			return 'OK';
		}

		echo $this->form->display();
	}

	public function pending()
	{
		if(!$this->is_authorized('candidacy_vote') && !$this->is_authorized('candidacy_reply'))
		{
			throw new Exception(Dungeon::UNAUTHORIZED);
		}

		$this->subtitle('Applicants waiting');

		$candidacies_pending = $this->table
									->add_columns([
										[
											'content' => function($data){
												return '<a href="mailto:'.$data['email'].'" data-toggle="tooltip" title="'.$data['email'].'">'.icon('fa-envelope-o').'</a>';
											},
											'sort'    => function($data){
												return $data['email'];
											},
											'search'  => function($data){
												return $data['email'];
											},
											'size'    => TRUE
										],
										[
											'title'   => 'Applicant',
											'content' => function($data){
												if ($data['user_id'])
												{
													return $this->user->link($data['user_id'], $data['username']);
												}
												else
												{
													return $data['pseudo'];
												}
											},
											'sort'    => function($data){
												return $data['pseudo'];
											},
											'search'  => function($data){
												return $data['pseudo'];
											}
										],
										[
											'title'   => 'Date',
											'content' => function($data){
												return '<span data-toggle="tooltip" title="'.timetostr($this->lang('date_time_long'), $data['date']).'">'.time_span($data['date']).'</span>';
											},
											'sort'    => function($data){
												return $data['date'];
											}
										],
										[
											'title'   => 'Offer',
											'content' => function($data){
												return $data['title'];
											},
											'sort'    => function($data){
												return $data['title'];
											},
											'search'  => function($data){
												return $data['title'];
											}
										],
										[
											'content' => [
												function($data){
													return ($this->is_authorized('candidacy_vote') || $this->is_authorized('candidacy_reply')) ? $this->button_update('admin/recruits/candidacy/'.$data['candidacy_id'].'/'.url_title($data['title'])) : NULL;
												},
												function($data){
													return $this->is_authorized('candidacy_delete') ? $this->button_delete('admin/recruits/candidacy/delete/'.$data['candidacy_id'].'/'.url_title($data['title'])) : NULL;
												}
											],
											'size'    => TRUE
										]
									])
									->data($this->model()->get_candidacies($recruit_id = '', 1))
									->no_data('No pending applications')
									->display();

		return [
			$this	->panel()
					->heading('List of applicants waiting', 'fa-black-tie')
					->body($candidacies_pending)
					->size('col-md-8'),
			$this->panel_back()
		];
	}

	public function _candidacies($recruit_id, $recruit_title)
	{
		$this->subtitle($recruit_title);

		$candidacies_pending = $this->table
									->add_columns([
										[
											'title'   => 'Applicant',
											'content' => function($data){
												if ($data['user_id'])
												{
													return $this->user->link($data['user_id'], $data['pseudo']);
												}
												else
												{
													return $data['pseudo'];
												}
											},
											'sort'    => function($data){
												return $data['pseudo'];
											},
											'search'  => function($data){
												return $data['pseudo'];
											}
										],
										[
											'title'   => 'Date',
											'content' => function($data){
												return '<span data-toggle="tooltip" title="'.timetostr($this->lang('date_time_long'), $data['date']).'">'.time_span($data['date']).'</span>';
											},
											'sort'    => function($data){
												return $data['date'];
											}
										],
										[
											'title'   => 'E-mail Address',
											'content' => function($data){
												return '<a href="mailto:'.$data['email'].'">'.$data['email'].'</a>';
											},
											'sort'    => function($data){
												return $data['email'];
											},
											'search'  => function($data){
												return $data['email'];
											}
										],
										[
											'content' => [
												function($data){
													return ($this->is_authorized('candidacy_vote') || $this->is_authorized('candidacy_reply')) ? $this->button_update('admin/recruits/candidacy/'.$data['candidacy_id'].'/'.url_title($data['title'])) : NULL;
												},
												function($data){
													return $this->is_authorized('candidacy_delete') ? $this->button_delete('admin/recruits/candidacy/delete/'.$data['candidacy_id'].'/'.url_title($data['title'])) : NULL;
												}
											],
											'size'    => TRUE
										]
									])
									->data($this->model()->get_candidacies($recruit_id, 1))
									->no_data('No pending applications')
									->display();

		$candidacies_accepted = $this->table
									->add_columns([
										[
											'title'   => 'Applicant',
											'content' => function($data){
												if ($data['user_id'])
												{
													return $this->user->link($data['user_id'], $data['username']);
												}
												else
												{
													return $data['pseudo'];
												}
											},
											'sort'    => function($data){
												return $data['pseudo'];
											},
											'search'  => function($data){
												return $data['pseudo'];
											}
										],
										[
											'title'   => 'Date',
											'content' => function($data){
												return '<span data-toggle="tooltip" title="'.timetostr($this->lang('date_time_long'), $data['date']).'">'.time_span($data['date']).'</span>';
											},
											'sort'    => function($data){
												return $data['date'];
											}
										],
										[
											'title'   => 'E-mail Address',
											'content' => function($data){
												return '<a href="mailto:'.$data['email'].'">'.$data['email'].'</a>';
											},
											'sort'    => function($data){
												return $data['email'];
											},
											'search'  => function($data){
												return $data['email'];
											}
										],
										[
											'content' => [
												function($data){
													return ($this->is_authorized('candidacy_vote') || $this->is_authorized('candidacy_reply')) ? $this->button_update('admin/recruits/candidacy/'.$data['candidacy_id'].'/'.url_title($data['title'])) : NULL;
												},
												function($data){
													return $this->is_authorized('candidacy_delete') ? $this->button_delete('admin/recruits/candidacy/delete/'.$data['candidacy_id'].'/'.url_title($data['title'])) : NULL;
												}
											],
											'size'    => TRUE
										]
									])
									->data($this->model()->get_candidacies($recruit_id, 2))
									->no_data('No accepted applications')
									->display();

		$candidacies_declined = $this->table
									->add_columns([
										[
											'title'   => 'Candidat',
											'content' => function($data){
												if ($data['user_id'])
												{
													return $this->user->link($data['user_id'], $data['username']);
												}
												else
												{
													return $data['pseudo'];
												}
											},
											'sort'    => function($data){
												return $data['pseudo'];
											},
											'search'  => function($data){
												return $data['pseudo'];
											}
										],
										[
											'title'   => 'Date',
											'content' => function($data){
												return '<span data-toggle="tooltip" title="'.timetostr($this->lang('date_time_long'), $data['date']).'">'.time_span($data['date']).'</span>';
											},
											'sort'    => function($data){
												return $data['date'];
											}
										],
										[
											'title'   => 'E-mail Address',
											'content' => function($data){
												return '<a href="mailto:'.$data['email'].'">'.$data['email'].'</a>';
											},
											'sort'    => function($data){
												return $data['email'];
											},
											'search'  => function($data){
												return $data['email'];
											}
										],
										[
											'content' => [
												function($data){
													return ($this->is_authorized('candidacy_vote') || $this->is_authorized('candidacy_reply')) ? $this->button_update('admin/recruits/candidacy/'.$data['candidacy_id'].'/'.url_title($data['title'])) : NULL;
												},
												function($data){
													return $this->is_authorized('candidacy_delete') ? $this->button_delete('admin/recruits/candidacy/delete/'.$data['candidacy_id'].'/'.url_title($data['title'])) : NULL;
												}
											],
											'size'    => TRUE
										]
									])
									->data($this->model()->get_candidacies($recruit_id, 3))
									->no_data('No refused applications')
									->display();

		return [
			$this	->panel()
					->heading('Applications List', 'fa-briefcase')
					->body($this->view('admin-recruit-candidacies', [
										'table_pending'  => $candidacies_pending,
										'table_accepted' => $candidacies_accepted,
										'table_declined' => $candidacies_declined
									]))
					->size('col-md-12'),
			$this->panel_back()
		];
	}

	public function _candidacies_edit($candidacy_id, $date, $user_id, $pseudo, $email, $date_of_birth, $presentation, $motivations, $experiences, $status, $reply, $recruit_id, $title, $icon, $role, $team_id, $team_name, $username, $avatar, $sex)
	{
		$this->subtitle($title);

		$reply_form = $this->load	->form
									->add_rules($rules = [
										'reply' => [
											'label'  => 'Your answer',
											'value'  => $reply,
											'type'   => 'editor',
											'rules'  => 'required'
										],
										'status' => [
											'label'  => 'Status',
											'value'  => $status,
											'values' => [
												'1' => 'Pending',
												'2' => 'Accept',
												'3' => 'Refuse',
											],
											'type'   => 'radio',
											'rules'  => 'required'
										]
									])
									->add_submit('Send the answer')
									->save();

		if ($reply_form->is_valid($post))
		{
			$this->model()->update_candidacy(	$candidacy_id,
												$post['reply'],
												$post['status']);

			$this->contact_applicant($candidacy_id, $title, $post['reply'], $post['status']);

			if ($post['status'] == 2)
			{
				if ($team_id && $user_id && $this->model()->check_team($team_id, url_title($team_name)) && $status != 2 && !$this->db->select('1')->from('dungeon_teams_users')->where('user_id', $user_id)->where('team_id', $team_id)->row())
				{
					if ($check_role = $this->model()->check_role($role))
					{
						$this->db->insert('dungeon_teams_users', [
							'team_id' => $team_id,
							'user_id' => $user_id,
							'role_id' => $check_role['role_id']
						]);
					}
					else
					{
						$role_id = $this->db->insert('dungeon_teams_roles', [
							'title' => $role
						]);

						$this->db->insert('dungeon_teams_users', [
							'team_id' => $team_id,
							'user_id' => $user_id,
							'role_id' => $role_id
						]);
					}
				}
			}

			notify('Answer sent successfully');

			redirect('admin/recruits/candidacy/'.$candidacy_id.'/'.url_title($title));
		}

		$total_votes = 0;
		$total_up = 0;
		$total_down = 0;

		foreach ($votes = $this->model()->get_votes($candidacy_id) as $vote)
		{
			if ($vote['vote'] == 1)
			{
				$total_up += 1;
			}
			else
			{
				$total_down += 1;
			}

			$total_votes += 1;
		}

		$user_vote = $this->db	->from('dungeon_recruits_candidacies_votes')
								->where('candidacy_id', $candidacy_id)
								->where('user_id', $this->user('user_id'))
								->row();

		$vote_form = $this	->form
							->add_rules($rules = [
								'vote' => [
									'label'  => 'I',
									'value'  => isset($user_vote['vote']) ? $user_vote['vote'] : NULL,
									'values' => [
										'1' => icon('fa-thumbs-o-up').' <span class="text-green">agree</span>',
										'0' => icon('fa-thumbs-o-down').' <span class="text-red">disagree</span>'
									],
									'type'   => 'radio',
									'rules'  => 'required'
								],
								'comment' => [
									'label'  => 'Arguments',
									'type'   => 'textarea',
									'value'  => isset($user_vote['comment']) ? $user_vote['comment'] : NULL,
									'rules'  => 'required'
								],
							])
							->add_submit('Send my opinion')
							->save();

		if ($vote_form->is_valid($post))
		{
			if ($user_vote)
			{
				$this->model()->update_vote($this->user('user_id'),	
											$candidacy_id,
											$post['vote'],
											$post['comment']);

				notify('Vote successfully changed');
			}
			else
			{
				$this->model()->send_vote(	$candidacy_id,
											$post['vote'],
											$post['comment']);

				notify('Vote sent successfully');
			}

			refresh();
		}

		if ($status == 1)
		{
			$statut_heading = icon('fa-hourglass-end').' Application is <b>under review</b>';
			$statut_color   = 'bg-teal';
		}
		else if ($status == 2)
		{
			$statut_heading = icon('fa-check').' Application <b>accepted</b>';
			$statut_color   = 'bg-green';
		}
		else
		{
			$statut_heading = icon('fa-close').' Application <b>refused</b>';
			$statut_color   = 'bg-red';
		}

		return $this->row(
			$this->col(
				$this	->panel_box()
						->heading($statut_heading, '', 'admin/recruits/candidacies/'.$recruit_id.'/'.url_title($title))
						->color($statut_color)
						->footer(icon('fa-arrow-circle-left').' Back to applications for this offer'),
				$this	->panel()
						->heading('<div class="pull-right"><a href="mailto:'.$email.'" class="btn btn-outline btn-info btn-xs" data-toggle="tooltip" title="Contacter par e-mail">'.icon('fa-envelope-o').'</a></div>Candidature de <b>'.$pseudo.'</b>', 'fa-black-tie')
						->body($this->view('candidacy', [
							'candidacy_id'  => $candidacy_id,
							'date'          => $date,
							'user_id'       => $user_id,
							'pseudo'        => $pseudo,
							'email'         => $email,
							'role'          => $role,
							'date_of_birth' => $date_of_birth,
							'presentation'  => bbcode($presentation),
							'motivations'   => bbcode($motivations),
							'experiences'   => bbcode($experiences),
							'status'        => $status,
							'reply'         => $reply,
							'title'         => $title,
							'icon'          => $icon,
							'username'      => $username,
							'avatar'        => $avatar,
							'sex'           => $sex,
							'team_id'       => $team_id,
							'team_name'     => $team_name
						])),
				$this	->panel()
						->heading('Respond to the applicant', 'fa-lock')
						->body($this->is_authorized('candidacy_reply') ? $reply_form->display() : '<span class="text-red">You are not authorized to manage the status of the application.</span>')
						->size('col-md-7'),
				$this->button_back()
			),
			$this->col(
				$this	->panel()
						->heading('<div class="pull-right text-right"><ul class="list-inline no-margin"><li>'.$total_up.' '.icon('fa-thumbs-o-up text-green').'</li><li>'.$total_down.' '.icon('fa-thumbs-o-down text-red').'</li></ul></div>Voting Trend', 'fa-commenting-o')
						->body($this->view('admin-candidacy-status', [
							'status' => $status,
							'votes'  => $votes
						])),
				$this	->panel()
						->heading('My opinion on the application', 'fa-star-o')
						->body($this->is_authorized('candidacy_vote') ? $vote_form->display() : '<span class="text-red">You are not allowed to leave your opinion.</span>')
						->size('col-md-5')
			)
		);
	}

	public function _candidacies_delete($candidacy_id, $pseudo, $title)
	{
		$this	->title('Delete Application')
				->subtitle($title)
				->form
				->confirm_deletion('Delete confirmation', 'Are you sure you want to delete the application <b>'.$pseudo.'</b> ?<br />All notices associated with this application will also be removed.');

		if ($this->form->is_valid())
		{
			$this->model()->delete_candidacy($candidacy_id);

			return 'OK';
		}

		echo $this->form->display();
	}

	public function contact_applicant($candidacy_id, $title, $reply, $status)
	{
		if ($candidacy = $this->model()->check_candidacy($candidacy_id, url_title($title)))
		{
			if ($this->config->recruits_send_mp && $candidacy['user_id'])
			{
				if ($status == 2)
				{
					$message = '<div class="alert alert-success">Your application has been <b>accepted</b>. Congratulations !</div>'.$reply;
				}
				else if ($status == 3)
				{
					$message = '<div class="alert alert-danger">Your application has been <b>refused</b>. Sorry !</div>'.$reply;
				}
				else
				{
					$message = $reply;
				}

				$message_id = $this->db	->ignore_foreign_keys()
										->insert('dungeon_users_messages', [
											'title' => 'Application :: '.$candidacy['title']
										]);

				$reply_id = $this->db	->insert('dungeon_users_messages_replies', [
											'message_id' => $message_id,
											'user_id'    => $this->user('user_id'),
											'message'    => $message
										]);
			
				$this->db	->where('message_id', $message_id)
							->update('dungeon_users_messages', [
								'reply_id'      => $reply_id,
								'last_reply_id' => $reply_id
							]);

				foreach (array_unique([$this->user('user_id'), $candidacy['user_id']]) as $user_id)
				{
					$this->db->insert('dungeon_users_messages_recipients', [
						'user_id'    => $user_id,
						'message_id' => $message_id,
						'date'       => $user_id == $this->user('user_id') ? now() : NULL
					]);
				}
			}
			
			if ($this->config->recruits_send_mail && $candidacy['email'])
			{
				$this->load	->email
							->from($this->config->dungeon_contact ? $this->config->dungeon_contact : $this->user('email'))
							->to($candidacy['email'])
							->subject('Application :: '.$candidacy['title'])
							->message('default', [
								'content' => bbcode($reply).($this->user() ? '<br /><br /><br />'.$this->user->link() : '')
							])
							->send();
			}
		}
	}
}

/*
Dungeon Alpha 0.1.7.7
./modules/recruits/controllers/admin.php
*/