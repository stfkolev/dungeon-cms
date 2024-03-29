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

class m_settings_c_admin extends Controller_Module
{
	public function index()
	{
		$this	->title($this->lang('configuration'))
				->subtitle($this->lang('general_settings'))
				->icon('fa-cog');
		
		$modules = $pages = [];
		
		foreach ($this->addons->get_modules() as $module)
		{
			if ($module->is_administrable())
			{
				$modules[] = $module;
			}
		}
		
		array_natsort($modules, function($a){
			return $a->get_title();
		});
		
		foreach ($modules as $module)
		{
			$pages[$module->name] = $module->get_title();
			
			if ($module->name == 'pages')
			{
				foreach ($module->model()->get_pages() as $page)
				{
					if ($page['published'])
					{
						$pages['pages/'.$page['name']] = str_repeat('&nbsp;', 10).$page['title'];
					}
				}
			}
		}

		$this	->form
				->add_rules([
					'name' => [
						'label'  => $this->lang('site_title'),
						'value'  => $this->config->dungeon_name,
						'rules'  => 'required'
					],
					'description' => [
						'label'  => $this->lang('site_description'),
						'value'  => $this->config->dungeon_description,
						'rules'  => 'required'
					],
					'contact' => [
						'label'  => $this->lang('contact_email'),
						'value'  => $this->config->dungeon_contact,
						'type'   => 'email',
						'rules'  => 'required'
					],
					'default_page' => [
						'label'  => $this->lang('default_page'),
						'values' => $pages,
						'value'  => $this->config->dungeon_default_page,
						'type'   => 'select',
						'rules'  => 'required'
					],
					'humans_txt' => [
						'label'  => '<a href="http://humanstxt.org/">humans.txt</a>',
						'type'   => 'textarea',
						'value'  => $this->config->dungeon_humans_txt
					],
					'robots_txt' => [
						'label'  => '<a href="http://www.robotstxt.org//">robots.txt</a>',
						'type'   => 'textarea',
						'value'  => $this->config->dungeon_robots_txt
					],
					'analytics' => [
						'label'  => $this->lang('code_analytics'),
						'type'   => 'textarea',
						'value'  => $this->config->dungeon_analytics
					],
					'debug' => [
						'label'  => $this->lang('debug_mode'),
						'type'   => 'radio',
						'value'  => $this->config->dungeon_debug,
						'values' => [$this->lang('debug_disabled'), $this->lang('debug_admins_only'), $this->lang('debug_always')]
					]
				])
				->add_submit($this->lang('save'))
				->display_required(FALSE);

		if ($this->form->is_valid($post))
		{
			foreach ($post as $var => $value)
			{
				if ($var == 'analytics')
				{
					$value = implode("\r\n", array_map('trim', explode("\r\n", trim(preg_replace('#&lt;script.*?&gt;(.*?)&lt;/script&gt;#is', '\1', $value)))));
				}

				$this->config('dungeon_'.$var, $value);
			}

			notify('General preferences saved successfully');

			refresh();
		}

		return $this->row(
			$this	->col($this->panel()->body($this->view('menu'), FALSE))
					->size('col-md-3'),
			$this	->col(
						$this	->panel()
								->heading($this->lang('general_settings'), 'fa-cog')
								->body($this->form->display())
					)
					->size('col-md-9')
		);
	}

	public function registration()
	{
		$this	->title($this->lang('configuration'))
				->subtitle('Registrations')
				->icon('fa-sign-in fa-rotate-90');

		$users = $this->db	->select('user_id', 'username')
							->from('dungeon_users')
							->where('deleted', FALSE)
							->order_by('username')
							->get();

		$list_users = [];

		foreach ($users as $user)
		{
			$list_users[$user['user_id']] = $user['username'];
		}

		array_natsort($list_users);

		$this	->form
				->add_rules([
					[
						'label'   => 'Registration',
						'type'    => 'legend'
					],
					'registration_status' => [
						'label'   => 'Status',
						'type'    => 'radio',
						'value'   => $this->config->dungeon_registration_status,
						'values'  => ['Open', 'Closed']
					],
					/*'registration_validation' => array(
						'label'   => 'Validation',
						'type'    => 'radio',
						'value'   => $this->config->dungeon_registration_validation,
						'values'  => array('Automatic', 'E-Mail Confirmation')
					),*/
					'registration_terms' => [
						'label'   => 'Terms of usage',
						'value'   => $this->config->dungeon_registration_terms,
						'type'    => 'editor'
					],
					[
						'label'   => 'Welcome message',
						'type'    => 'legend'
					],
					'welcome' => [
						'type'    => 'checkbox',
						'checked' => ['on' => $this->config->dungeon_welcome],
						'values'  => ['on' => 'Send a private message to new members']
					],
					'welcome_user_id' => [
						'label'   => 'Author of the message',
						'values'  => $list_users,
						'value'   => $this->config->dungeon_welcome_user_id,
						'type'    => 'select',
						'size'    => 'col-md-5'
					],
					'welcome_title' => [
						'label'   => 'Message title',
						'value'   => $this->config->dungeon_welcome_title,
						'type'    => 'text'
					],
					'welcome_content' => [
						'label'   => 'Message content',
						'value'   => $this->config->dungeon_welcome_content,
						'type'    => 'editor'
					]
				])
				->add_submit($this->lang('save'))
				->display_required(FALSE);

		if ($this->form->is_valid($post))
		{
			foreach ($post as $var => $value)
			{
				if ($var == 'welcome')
				{
					$value = in_array('on', $value);
				}

				$this->config('dungeon_'.$var, $value);
			}

			notify('Registrations management successfully saved');

			refresh();
		}

		return $this->row(
			$this	->col($this->panel()->body($this->view('menu'), FALSE))
					->size('col-md-3'),
			$this	->col(
						$this	->panel()
								->heading('Registration management', 'fa-sign-in fa-rotate-90')
								->body($this->form->display()))
					->size('col-md-9')
		);
	}

	public function team()
	{
		$this	->title($this->lang('configuration'))
				->subtitle('Our structure')
				->icon('fa-users');

		$this	->form
				->add_rules([
					'team_name' => [
						'label'       => 'Team Name',
						'value'       => $this->config->dungeon_team_name,
						'type'        => 'text'
					],
					'team_logo' => [
						'label'       => 'Logo',
						'value'       => $this->config->dungeon_team_logo,
						'type'        => 'file',
						'upload'      => 'logos',
						'info'        => ' Image (max. '.(file_upload_max_size() / 1024 / 1024).' MB)',
						'check'       => function($filename, $ext){
							if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
							{
								return 'Please choose an image file';
							}
						},
						'description' => 'The logo can be displayed in the type widget <b>header</b> <i>(replacing the title and slogan)</i>.'
					],
					'team_type' => [
						'label'       => 'Type of structure',
						'value'       => $this->config->dungeon_team_type,
						'type'        => 'text',
						'size'        => 'col-md-4',
						'description' => '<b>Example:</b> Association, company, brand, etc...'
					],
					'team_creation' => [
						'label'       => 'Creation Date',
						'value'       => $this->config->dungeon_team_creation,
						'type'        => 'date',
						'size'        => 'col-md-4'
					],
					'team_biographie' => [
						'label'       => 'Biography',
						'value'       => $this->config->dungeon_team_biographie,
						'type'        => 'textarea'
					]
				])
				->add_submit($this->lang('save'))
				->display_required(FALSE);

		if ($this->form->is_valid($post))
		{
			foreach ($post as $var => $value)
			{
				$this->config('dungeon_'.$var, $value);
			}

			notify('Information saved successfully');

			refresh();
		}

		return $this->row(
			$this	->col($this->panel()->body($this->view('menu'), FALSE))
					->size('col-md-3'),
			$this	->col(
						$this	->panel()
								->heading('Our structure', 'fa-users')
								->body($this->form->display())
					)
					->size('col-md-9')
		);
	}

	public function socials()
	{
		$this	->title($this->lang('configuration'))
				->subtitle('Social networks')
				->icon('fa-globe');

		$this	->form
				->add_rules([
					'social_facebook' => [
						'label' => 'Facebook',
						'icon'  => 'fa-facebook',
						'value' => $this->config->dungeon_social_facebook,
						'type'  => 'url'
					],
					'social_twitter' => [
						'label' => 'Twitter',
						'icon'  => 'fa-twitter',
						'value' => $this->config->dungeon_social_twitter,
						'type'  => 'url'
					],
					'social_google' => [
						'label' => 'Google+',
						'icon'  => 'fa-google-plus',
						'value' => $this->config->dungeon_social_google,
						'type'  => 'url'
					],
					'social_steam' => [
						'label' => 'Steam',
						'icon'  => 'fa-steam',
						'value' => $this->config->dungeon_social_steam,
						'type'  => 'url'
					],
					'social_twitch' => [
						'label' => 'Twitch',
						'icon'  => 'fa-twitch',
						'value' => $this->config->dungeon_social_twitch,
						'type'  => 'url'
					],
					'social_dribble' => [
						'label' => 'Dribbble',
						'icon'  => 'fa-dribbble',
						'value' => $this->config->dungeon_social_dribble,
						'type'  => 'url'
					],
					'social_behance' => [
						'label' => 'Behance',
						'icon'  => 'fa-behance',
						'value' => $this->config->dungeon_social_behance,
						'type'  => 'url'
					],
					'social_deviantart' => [
						'label' => 'DeviantArt',
						'icon'  => 'fa-deviantart',
						'value' => $this->config->dungeon_social_deviantart,
						'type'  => 'url'
					],
					'social_flickr' => [
						'label' => 'Flickr',
						'icon'  => 'fa-flickr',
						'value' => $this->config->dungeon_social_flickr,
						'type'  => 'url'
					],
					'social_github' => [
						'label' => 'Github',
						'icon'  => 'fa-github',
						'value' => $this->config->dungeon_social_github,
						'type'  => 'url'
					],
					'social_instagram' => [
						'label' => 'Instagram',
						'icon'  => 'fa-instagram',
						'value' => $this->config->dungeon_social_instagram,
						'type'  => 'url'
					],
					'social_youtube' => [
						'label' => 'Youtube',
						'icon'  => 'fa-youtube',
						'value' => $this->config->dungeon_social_youtube,
						'type'  => 'url'
					]
				])
				->add_submit($this->lang('save'))
				->display_required(FALSE);

		if ($this->form->is_valid($post))
		{
			foreach ($post as $var => $value)
			{
				$this->config('dungeon_'.$var, $value);
			}

			notify('Social networks saved successfully');

			refresh();
		}

		return $this->row(
			$this	->col($this->panel()->body($this->view('menu'), FALSE))
					->size('col-md-3'),
			$this	->col(
						$this	->panel()
								->heading('Social networks', 'fa-globe')
								->body($this->form->display())
					)
					->size('col-md-9')
		);
	}

	public function captcha()
	{
		$this	->title($this->lang('configuration'))
				->subtitle('Anti-bot security')
				->icon('fa-shield');

		$this	->form
				->add_rules([
					'captcha_public_key' => [
						'label' => 'Google public key',
						'value' => $this->config->dungeon_captcha_public_key,
						'type'  => 'text'
					],
					'captcha_private_key' => [
						'label' => 'Google private key',
						'value' => $this->config->dungeon_captcha_private_key,
						'type'  => 'text'
					]
				])
				->add_submit($this->lang('save'))
				->display_required(FALSE);

		if ($this->form->is_valid($post))
		{
			foreach ($post as $var => $value)
			{
				$this->config('dungeon_'.$var, $value);
			}

			notify('Configuration of Google reCAPTCHA successfully saved');

			refresh();
		}

		return $this->row(
			$this	->col($this->panel()->body($this->view('menu'), FALSE))
					->size('col-md-3'),
			$this	->col(
						$this	->panel()
								->heading('Google reCAPTCHA configuration', 'fa-shield')
								->body('<div class="alert alert-info"><a href="https://www.google.com/recaptcha/intro/index.html" target="_blank">https://www.google.com/recaptcha/intro/index.html</a></div>'.$this->form->display())
					)
					->size('col-md-9')
		);
	}

	public function email()
	{
		$this	->title($this->lang('configuration'))
				->subtitle('SMTP Server')
				->icon('fa-envelope-o');

		$this	->form
				->add_rules([
					'email_smtp' => [
						'label'  => 'SMTP Server',
						'value'  => $this->config->dungeon_email_smtp,
						'type'   => 'text'
					],
					'email_username' => [
						'label'  => 'Email username',
						'value'  => $this->config->dungeon_email_username,
						'type'   => 'text',
						'size'   => 'col-md-5'
					],
					'email_password' => [
						'label'  => 'Email password',
						'value'  => $this->config->dungeon_email_password,
						'type'   => 'password',
						'size'   => 'col-md-5'
					],
					'email_secure' => [
						'label'  => 'Email secure',
						'type'   => 'radio',
						'value'  => $this->config->dungeon_email_secure,
						'values' => ['SSL', 'TLS']
					],
					'email_port' => [
						'label'  => 'Port',
						'value'  => $this->config->dungeon_email_port,
						'type'   => 'number',
						'size'   => 'col-md-2'
					],
				])
				->add_submit($this->lang('save'))
				->display_required(FALSE);

		if ($this->form->is_valid($post))
		{
			foreach ($post as $var => $value)
			{
				$this->config('dungeon_'.$var, $value);
			}

			notify('Configuration of the SMTP server successfully saved');

			refresh();
		}

		return $this->row(
			$this	->col($this->panel()->body($this->view('menu'), FALSE))
					->size('col-md-3'),
			$this->col(
						$this	->panel()
								->heading('SMTP Server', 'fa-envelope-o')
								->body($this->form->display())
					)
					->size('col-md-9')
		);
	}

	public function maintenance()
	{
		$this	->title($this->lang('maintenance'))
				->icon('fa-power-off')
				->css('maintenance')
				->js('maintenance');
				
		$form_opening = $this->form
			->add_rules([
				'opening' => [
					'type'  => 'datetime',
					'value' => $this->config->dungeon_maintenance_opening
				]
			])
			->fast_mode()
			->add_submit($this->lang('save'))
			->save();

		$form_maintenance = $this->form
			->add_rules([
				'title' => [
					'label' => $this->lang('title'),
					'type'  => 'text',
					'value' => $this->config->dungeon_maintenance_title
				],
				'content' => [
					'label' => $this->lang('content'),
					'type'  => 'editor',
					'value' => $this->config->dungeon_maintenance_content
				],
				'logo' => [
					'label'  => $this->lang('logo'),
					'value'  => $this->config->dungeon_maintenance_logo,
					'type'   => 'file',
					'upload' => 'maintenance',
					'info'   => $this->lang('file_picture', file_upload_max_size() / 1024 / 1024),
					'check'  => function($filename, $ext){
						if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
						{
							return $this->lang('select_image_file');
						}
					}
				],
				'background' => [
					'label'  => $this->lang('background'),
					'value'  => $this->config->dungeon_maintenance_background,
					'type'   => 'file',
					'upload' => 'maintenance',
					'info'   => $this->lang('file_picture', file_upload_max_size() / 1024 / 1024),
					'check'  => function($filename, $ext){
						if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
						{
							return $this->lang('select_image_file');
						}
					}
				],
				'repeat' => [
					'label'  => $this->lang('background_repeat'),
					'value'  => $this->config->dungeon_maintenance_background_repeat,
					'values' => [
						'no-repeat' => $this->lang('no'),
						'repeat-x'  => $this->lang('horizontally'),
						'repeat-y'  => $this->lang('vertically'),
						'repeat'    => $this->lang('both')
					],
					'type'   => 'radio'
				],
				'positionX' => [
					'label'  => $this->lang('position'),
					'value'  => $this->config->dungeon_maintenance_background_position ? explode(' ', $this->config->dungeon_maintenance_background_position)[0] : '',
					'values' => [
						'left'   => $this->lang('left'),
						'center' => $this->lang('center'),
						'right'  => $this->lang('right')
					],
					'type'   => 'radio'
				],
				'positionY' => [
					'value'  => $this->config->dungeon_maintenance_background_position ? explode(' ', $this->config->dungeon_maintenance_background_position)[1] : '',
					'values' => [
						'top'    => $this->lang('top'),
						'center' => $this->lang('middle'),
						'bottom' => $this->lang('bottom')
					],
					'type'   => 'radio'
				],
				'background_color' => [
					'label' => $this->lang('background_color'),
					'value' => $this->config->dungeon_maintenance_background_color,
					'type'  => 'colorpicker'
				],
				'text_color' => [
					'label' => $this->lang('text_color'),
					'value' => $this->config->dungeon_maintenance_text_color,
					'type'  => 'colorpicker'
				],
				'facebook' => [
					'label' => 'Facebook',
					'icon'  => 'fa-facebook',
					'value' => $this->config->dungeon_maintenance_facebook,
					'type'  => 'url'
				],
				'twitter' => [
					'label' => 'Twitter',
					'icon'  => 'fa-twitter',
					'value' => $this->config->dungeon_maintenance_twitter,
					'type'  => 'url'
				],
				'google' => [
					'label' => 'Google+',
					'icon'  => 'fa-google-plus',
					'value' => $this->config->{'dungeon_maintenance_google-plus'},
					'type'  => 'url'
				],
				'steam' => [
					'label' => 'Steam',
					'icon'  => 'fa-steam',
					'value' => $this->config->dungeon_maintenance_steam,
					'type'  => 'url'
				],
				'twitch' => [
					'label' => 'Twitch',
					'icon'  => 'fa-twitch',
					'value' => $this->config->dungeon_maintenance_twitch,
					'type'  => 'url'
				]
			])
			->add_submit($this->lang('save'))
			->save();
			
		if ($form_opening->is_valid($post))
		{
			$this->config('dungeon_maintenance_opening', $post['opening']);
			refresh();
		}
		else if ($form_maintenance->is_valid($post))
		{
			$this	->config('dungeon_maintenance_title',               $post['title'])
					->config('dungeon_maintenance_content',             $post['content'])
					->config('dungeon_maintenance_logo',                $post['logo'], 'int')
					->config('dungeon_maintenance_background',          $post['background'], 'int')
					->config('dungeon_maintenance_background_repeat',   $post['repeat'])
					->config('dungeon_maintenance_background_position', $post['positionX'].' '.$post['positionY'])
					->config('dungeon_maintenance_background_color',    $post['background_color'])
					->config('dungeon_maintenance_text_color',          $post['text_color'])
					->config('dungeon_maintenance_facebook',            $post['facebook'])
					->config('dungeon_maintenance_twitter',             $post['twitter'])
					->config('dungeon_maintenance_google-plus',         $post['google'])
					->config('dungeon_maintenance_steam',               $post['steam'])
					->config('dungeon_maintenance_twitch',              $post['twitch'])
					->config('dungeon_version_css',                     time());

			refresh();
		}

		return $this->row(
			$this	->col(
						$this	->panel()
								->heading($this->lang('website_status'), 'fa-power-off')
								->body($this->view('maintenance')),
						$this	->panel()
								->heading($this->lang('planned_opening'), 'fa-clock-o')
								->body($form_opening->display())
					)
					->size('col-md-3'),
			$this	->col(
						$this	->panel()
								->heading($this->lang('customizing_maintenance_page'), 'fa-paint-brush')
								->body($form_maintenance->display())
					)
					->size('col-md-9')
		);
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/modules/settings/controllers/admin.php
*/