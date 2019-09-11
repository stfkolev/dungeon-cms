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

class m_recruits_c_index extends Controller_Module
{
	public function index($recruits)
	{
		$panels = [];

		foreach ($recruits as $recruit)
		{
			if (($recruit['closed'] || ($recruit['candidacies_accepted'] >= $recruit['size']) || ($recruit['date_end'] && strtotime($recruit['date_end']) < time())) && !$this->config->recruits_hide_unavailable)
			{
				$panels[] = $this	->panel()
									->heading($recruit['title'], $recruit['icon'] ?: 'fa-bullhorn')
									->body('This offer is no longer available.')
									->color('info');
			}
			else
			{
				if ($candidacy = $this->model()->postulated($this->user('user_id'), $recruit['recruit_id'], $recruit['title']))
				{
					$footer = '<a href="'.url('recruits/candidacy/'.$candidacy['candidacy_id'].'/'.url_title($recruit['title'])).'" class="btn btn-primary">'.icon('fa-briefcase').' View my application</a>';
				}
				else
				{
					$footer = '<a href="'.url('recruits/'.$recruit['recruit_id'].'/'.url_title($recruit['title'])).'" class="btn btn-default">'.icon('fa-eye').' Learn more</a> <a href="'.url('recruits/postulate/'.$recruit['recruit_id'].'/'.url_title($recruit['title'])).'" class="btn btn-primary">'.icon('fa-briefcase').' Apply</a>';
				}

				$panels[] = $this	->panel()
									->heading($candidacy ? $recruit['title'].'<div class="pull-right"><span class="label label-default">I applied !</span></div>' : $recruit['title'], $recruit['icon'] ?: 'fa-bullhorn', 'recruits/'.$recruit['recruit_id'].'/'.url_title($recruit['title']))
									->body($this->view('index', [
										'recruit_id'   => $recruit['recruit_id'],
										'title'        => $recruit['title'],
										'image_id'     => $recruit['image_id'],
										'date'         => $recruit['date'],
										'team_id'      => $recruit['team_id'],
										'team_name'    => $recruit['team_name'],
										'role'         => $recruit['role'],
										'size'         => $recruit['size'] - $recruit['candidacies_accepted'],
										'date_end'     => $recruit['date_end'],
										'introduction' => bbcode($recruit['introduction'])
									]))
									->footer_if($footer, $footer, 'right');
			}
		}

		if (empty($panels))
		{
			$panels[] = $this	->panel()
								->heading('Recruitment', 'fa-bullhorn')
								->body('<div class="text-center">No offers have been published yet</div>')
								->color('info');
		}
		else if ($pagination = $this->pagination->get_pagination())
		{
			$panels[] = '<div class="text-right">'.$pagination.'</div>';
		}

		return $panels;
	}

	public function _recruit($recruit_id, $title, $introduction, $description, $requierments, $date, $user_id, $size, $role, $icon, $date_end, $closed, $team_id, $image_id, $username, $avatar, $sex, $candidacies, $candidacies_pending, $candidacies_accepted, $candidacies_declined, $team_name)
	{
		$this->title($title);

		if (($this->access('recruits', 'recruit_postulate', $recruit_id)) && (!$date_end || strtotime($date_end) > time()))
		{
			if ($candidacy = $this->model()->postulated($this->user('user_id'), $recruit_id, $title))
			{
				$href                  = '<a href="'.url('recruits/candidacy/'.$candidacy['candidacy_id'].'/'.url_title($candidacy['title'])).'" class="btn btn-success">'.icon('fa-eye').' View my application</a>';
				$recruit['postulated'] = TRUE;
			}
			else
			{
				if ($this->access('recruits', 'recruit_postulate', $recruit_id))
				{
					$href = '<a href="'.url('recruits/postulate/'.$recruit_id.'/'.url_title($title)).'" class="btn btn-primary btn-block">'.icon('fa-briefcase').' Apply</a>';
				}
				else
				{
					$href = NULL;
				}

				$recruit['postulated'] = FALSE;
			}

			$postulate_panel = $this->panel()
									->heading($recruit['postulated'] ? 'I applied' : 'Apply', $recruit['postulated'] ? 'fa-check' : 'fa-black-tie')
									->body($recruit['postulated'] ? $this->view('recruit-postulate', [
														'postulated' => $recruit['postulated'],
														'status'     => $candidacy['status']
													]) : 'You have not yet applied for this job offer.')
									->footer($href);
		}
		else
		{
			$postulate_panel = $this->panel()
									->heading('Apply', 'fa-black-tie')
									->body('You are not allowed to apply for this offer...')
									->color('info');
		}

		return [
			$this->row(
				$this->col(
					$this	->panel()
							->heading($title, ($icon ? $icon : 'fa-bullhorn'))
							->body($this->view('recruit', [
								'recruit_id'   => $recruit_id,
								'title'        => $title,
								'introduction' => bbcode($introduction),
								'description'  => bbcode($description),
								'requierments' => bbcode($requierments),
								'date'         => $date,
								'user_id'      => $user_id,
								'size'         => $size - $candidacies_accepted,
								'role'         => $role,
								'icon'         => $icon,
								'date_end'     => $date_end,
								'closed'       => $closed,
								'team_id'      => $team_id,
								'image_id'     => $image_id
							]))
				)
			),
			$this->row(
				$this	->col(
							$this	->panel()
									->heading('Information', 'fa-info')
									->body($this->view('recruit-infos', [
																'role'      => $role,
																'size'      => $size,
																'date_end'  => $date_end,
																'team_id'   => $team_id,
																'team_name' => $team_name
															]), FALSE)
						)
						->size('col-md-6'),
				$this	->col($postulate_panel)
						->size('col-md-6')
			)
		];
	}

	public function _postulate($recruit_id, $title, $introduction, $description, $requierments, $date, $recruit_user_id, $size, $role, $icon, $date_end, $closed, $team_id, $image_id, $username, $avatar, $sex, $candidacies, $candidacies_pending, $candidacies_accepted, $candidacies_declined, $team_name)
	{
		if ($candidacy = $this->model()->postulated($this->user('user_id'), $recruit_id, $title))
		{
			return $this->panel()
						->heading('Submit my application', 'fa-black-tie')
						->body('You have already applied for this offer on <b>'.timetostr('%e %b %Y', $candidacy['date']).'</b> !')
						->footer('<a href="'.url('recruits/candidacy/'.$candidacy['candidacy_id'].'/'.url_title($candidacy['title'])).'" class="btn btn-primary">'.icon('fa-eye').' See my application</a>')
						->color('info');
		}
		else
		{
			if ($candidacies_accepted < $size && $closed == FALSE && (!$date_end || strtotime($date_end) > time()))
			{
				$this	->form
						->add_rules($rules = [
							'pseudo' => [
								'label' => 'Nickname',
								'value' => $this->user('username'),
								'type'  => 'text',
								'rules' => 'required'
							],
							'email' => [
								'label' => 'E-mail Address',
								'value' => $this->user('email'),
								'type'  => 'email',
								'rules' => 'required'
							],
							'date_of_birth' => [
								'label' => 'Date of Birth',
								'value' => $this->user('date_of_birth'),
								'type'  => 'date',
								'check' => function($value){
									if ($value && strtotime($value) > strtotime(date('d-m-Y')))
									{
										return 'Really ?! 2.1 Gigwatt !';
									}
								},
								'rules' => 'required'
							],
							'presentation' => [
								'label' => 'Introduce yourself',
								'type'  => 'editor'
							],
							'motivations' => [
								'label' => 'Your motivations',
								'type'  => 'editor'
							],
							'experiences' => [
								'label' => 'Experiences',
								'type'  => 'editor'
							]
						])
						->add_captcha()
						->add_submit('Send my application');

				if ($this->form->is_valid($post))
				{
					$candidacy_id = $this->model()->send_candidacy(	$recruit_id,
																	$this->user('user_id'),
																	$this->user('username') ?: $post['pseudo'],
																	$this->user('email')    ?: $post['email'],
																	$post['date_of_birth'],
																	$post['presentation'],
																	$post['motivations'],
																	$post['experiences']);

					if ($this->config->recruits_alert && $this->user())
					{
						$users =  $this->db	->select('*')
											->from('dungeon_users')
											->where('deleted', FALSE)
											->get();

						$recipients = [];
						foreach ($users as $user)
						{
							if ($this->access('recruits', 'candidacy_vote', 0, NULL, $user['user_id']) || $this->access('recruits', 'candidacy_reply', 0, NULL, $user['user_id']))
							{
								$recipients[] = $user;
							}
						}

						if ($recipients)
						{
							$message_id = $this->db	->ignore_foreign_keys()
													->insert('dungeon_users_messages', [
														'title' => 'Nouvelle candidature :: '.$title
													]);

							$reply_id = $this->db	->insert('dungeon_users_messages_replies', [
														'message_id' => $message_id,
														'user_id'    => $this->user('user_id'),
														'message'    => '<div class="alert alert-info no-margin"><b>Automatic message.</b><br />A new application has just been submitted by '.($this->user() ? $user['username'] : $post['pseudo']).'.<br /><br />To view it, <a href="'.url('admin/recruits/candidacy/'.$candidacy_id.'/'.url_title($title)).'">click here</a>.</div>'
													]);
						
							$this->db	->where('message_id', $message_id)
										->update('dungeon_users_messages', [
											'reply_id'      => $reply_id,
											'last_reply_id' => $reply_id
										]);

							foreach ($recipients as $recipient)
							{
								$this->db->insert('dungeon_users_messages_recipients', [
									'user_id'    => $recipient['user_id'],
									'message_id' => $message_id,
									'date'       => NULL
								]);
							}
						}
					}

					notify('Application sent successfully');

					if ($this->user())
					{
						redirect('recruits/candidacy/'.$candidacy_id.'/'.url_title($title));
					}
					else
					{
						redirect('recruits');
					}
				}

				return $this->panel()
							->heading('Submit my application', 'fa-black-tie')
							->body($this->view('postulate', [
													'recruit_id'   => $recruit_id,
													'title'        => $title,
													'role'         => $role,
													'icon'         => $icon,
													'date_end'     => $date_end,
													'form'         => $this->form->display()
												]));
			}
			else
			{
				return $this->panel()
							->heading('Submit my application', 'fa-black-tie')
							->body('Oops... The offer <b>'.$title.'</b> is no longer available...')
							->color('danger');
			}
		}
	}

	public function _candidacy($candidacy_id, $recruit_id, $date, $user_id, $pseudo, $email, $date_of_birth, $presentation, $motivations, $experiences, $status, $reply_text, $title, $icon, $role, $team_id, $team_name, $username, $avatar, $sex)
	{
		return [
			$this	->panel()
					->heading('Status of my application', 'fa-reply')
					->body($this->view('candidacy-status', [
						'status'     => $status,
						'reply_text' => bbcode($reply_text)
					])),
			$this	->panel()
					->heading('My Application', 'fa-black-tie')
					->body($this->view('candidacy', [
						'candidacy_id'  => $candidacy_id,
						'recruit_id'    => $recruit_id,
						'date'          => $date,
						'user_id'       => $user_id,
						'pseudo'        => $pseudo,
						'email'         => $email,
						'role'          => $role,
						'date_of_birth' => $date_of_birth,
						'presentation'  => bbcode($presentation),
						'motivations'   => bbcode($motivations),
						'experiences'   => bbcode($experiences),
						'reply'         => bbcode($reply_text),
						'title'         => $title,
						'icon'          => $icon,
						'username'      => $username,
						'avatar'        => $avatar,
						'sex'           => $sex,
						'team_id'       => $team_id,
						'team_name'     => $team_name
					])),
			$this->panel_back()
		];
	}
}

/*
Dungeon Alpha 0.1.7.7
./modules/recruits/controllers/index.php
*/