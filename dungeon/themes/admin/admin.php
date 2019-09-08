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

class t_admin extends Theme
{
	public $title       = '{lang administration}';
	public $description = '';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1';
	public $dungeon_version  = 'Alpha 0.1';
	public $path        = __FILE__;

	public function load()
	{
		$content_submenu = [
			'default' => [],
			'gaming'  => []
		];

		foreach ($this->addons->get_modules() as $module)
		{
			if ($module->is_administrable($category) && $category != 'none' && $module->is_authorized())
			{
				$content_submenu[isset($content_submenu[$category]) ? $category : 'default'][] = [
					'title'  => $module->get_title(),
					'icon'   => $module->icon,
					'url'    => 'admin/'.$module->name
				];
			}
		}

		array_walk($content_submenu, function(&$a){
			array_natsort($a, function($a){
				return $a['title'];
			});
		});

		if (file_exists($file = 'cache/monitoring/version.json'))
		{
			$version = json_decode(file_get_contents($file))->dungeon;
			
			if (version_compare(version_format($version->version), version_format(DUNGEON_VERSION), '>'))
			{
				$this->add_data('update', $version);
				$this->js('dungeon.update');
			}
		}

		$this	->css('font.open-sans.300.400.600.700.800')
				->css('font.roboto.100.300.400.500.700.900')
				->css('font.signika-negative.400.600')
				->css('sb-admin-2')
				->css('font-awesome.min')
				->css('style')
				->js('metisMenu.min')
				->js('dungeon.navigation')
				->js('slideout.min')
				->add_data('menu', [
					[
						'title' => $this->lang('dashboard'),
						'icon'  => 'fa-dashboard',
						'url'   => 'admin'
					],
					[
						'title' => $this->lang('settings'),
						'icon'  => 'fa-cogs',
						'url'   => [
							[
								'title'  => $this->lang('configuration'),
								'icon'   => 'fa-wrench',
								'url'    => 'admin/settings',
								'access' => $this->user('admin')
							],
							[
								'title'  => $this->lang('maintenance'),
								'icon'   => 'fa-power-off',
								'url'    => 'admin/settings/maintenance',
								'access' => $this->user('admin')
							],
							[
								'title'  => $this->lang('addons'),
								'icon'   => 'fa-puzzle-piece',
								'url'    => 'admin/addons',
								'access' => $this->user('admin')
							]
						]
					],
					[
						'title' => $this->lang('users'),
						'icon'  => 'fa-users',
						'url'   => [
							[
								'title'  => 'Members / Groups',
								'icon'   => 'fa-users',
								'url'    => 'admin/user',
								'access' => $this->user('admin')
							],
							[
								'title'  => $this->lang('sessions'),
								'icon'   => 'fa-globe',
								'url'    => 'admin/user/sessions',
								'access' => $this->user('admin')
							],
							/*array(
								'title' => 'Profile',
								'icon'  => 'fa-user',
								'url'   => 'admin/user'
							),*/
							[
								'title'  => $this->lang('permissions'),
								'icon'   => 'fa-unlock-alt',
								'url'    => 'admin/access',
								'access' => $this->user('admin')
							],
							[
								'title'  => $this->lang('ban'),
								'icon'   => 'fa-bomb',
								'url'    => 'admin/user/ban',
								'access' => $this->user('admin')
							]
						]
					],
					[
						'title' => $this->lang('content'),
						'icon'  => 'fa-edit',
						'url'   => $content_submenu['default']
					],
					[
						'title' => 'Gaming',
						'icon'  => 'fa-gamepad',
						'url'   => $content_submenu['gaming']
					],
					[
						'title' => $this->lang('design'),
						'icon'  => 'fa-paint-brush',
						'url'   => [
							[
								'title'  => $this->lang('themes'),
								'icon'   => 'fa-tint',
								'url'    => 'admin/addons#themes',
								'access' => $this->user('admin')
							],
							[
								'title' => $this->lang('liveditor'),
								'icon'  => 'fa-desktop',
								'url'   => 'live-editor',
								'access' => $this->user('admin')
							]
						]
					],
					[
						'title'  => 'Monitoring'.$this->module('monitoring')->display(),
						'icon'   => 'fa-heartbeat',
						'url'    => 'admin/monitoring',
						'access' => $this->user('admin')
					],
					[
						'title'  => 'Statistics',
						'icon'   => 'fa-bar-chart',
						'url'    => 'admin/statistics',
						'access' => $this->user('admin')
					],
					[
						'title'  => $this->lang('about'),
						'icon'   => 'fa-info',
						'url'    => 'admin/about',
						'access' => $this->user('admin')
					]
				]);

		return parent::load();
	}
	
	public function styles_row()
	{
		//Nothing to do
	}
	
	public function styles_widget()
	{
		//Nothing to do
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/themes/admin/admin.php
*/