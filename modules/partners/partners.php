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

class m_partners extends Module
{
	public $title       = 'Partenaires';
	public $description = '';
	public $icon        = 'fa-star-o';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1';
	public $dungeon_version  = 'Alpha 0.1.4';
	public $path        = __FILE__;
	public $admin       = TRUE;
	public $routes      = [
		//Index
		'{id}/{url_title}'        => '_partner',

		//Admin
		'admin/{id}/{url_title*}' => '_edit'
	];

	public function settings()
	{
		$this	->form
				->add_rules([
					'partners_logo_display' => [
						'label'       => 'Logo',
						'value'       => $this->config->partners_logo_display,
						'values'      => [
							'logo_dark'  => 'Dark',
							'logo_light' => 'Light'
						],
						'type'        => 'radio',
						'description' => 'Use the light logo if it is displayed on a dark background',
						'size'        => 'col-md-4'
					]
				])
				->add_submit($this->lang('edit'))
				->add_back('admin/addons#modules');

		if ($this->form->is_valid($post))
		{
			$this->config('partners_logo_display', $post['partners_logo_display']);
			
			redirect_back('admin/addons#modules');
		}

		return $this->panel()->body($this->form->display());
	}
}

/*
Dungeon Alpha 0.1.6
./modules/partners/partners.php
*/