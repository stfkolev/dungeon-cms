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

abstract class Widget extends Loadable
{
	static public $core = [
		'breadcrumb' => TRUE,
		'error'      => FALSE,
		'html'       => TRUE,
		'members'    => TRUE,
		'module'     => FALSE,
		'navigation' => TRUE,
		'user'       => TRUE
	];

	public function paths()
	{
		if (!empty(Dungeon()->theme))
		{
			if (in_array($theme_name = Dungeon()->theme->name, ['default', 'admin']))
			{
				unset($theme_name);
			}
		}

		return [
			'assets' => [
				'assets',
				'overrides/widgets/'.$this->name,
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/widgets/'.$this->name : '',
				'dungeon/widgets/'.$this->name,
				'widgets/'.$this->name,
				'overrides/modules/'.$this->name,
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/modules/'.$this->name : '',
				'dungeon/modules/'.$this->name,
				'modules/'.$this->name
			],
			'controllers' => [
				'overrides/widgets/'.$this->name.'/controllers',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/widgets/'.$this->name.'/controllers' : '',
				'dungeon/widgets/'.$this->name.'/controllers',
				'widgets/'.$this->name.'/controllers'
			],
			'helpers' => [
				'overrides/widgets/'.$this->name.'/helpers',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/widgets/'.$this->name.'/helpers' : '',
				'dungeon/widgets/'.$this->name.'/helpers',
				'widgets/'.$this->name.'/helpers',
				'overrides/modules/'.$this->name.'/helpers',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/modules/'.$this->name.'/helpers' : '',
				'dungeon/modules/'.$this->name.'/helpers',
				'modules/'.$this->name.'/helpers'
			],
			'lang' => [
				'overrides/widgets/'.$this->name.'/lang',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/widgets/'.$this->name.'/lang' : '',
				'dungeon/widgets/'.$this->name.'/lang',
				'widgets/'.$this->name.'/lang',
				'overrides/modules/'.$this->name.'/lang',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/modules/'.$this->name.'/lang' : '',
				'dungeon/modules/'.$this->name.'/lang',
				'modules/'.$this->name.'/lang'
			],
			'libraries' => [
				'overrides/widgets/'.$this->name.'/libraries',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/widgets/'.$this->name.'/libraries' : '',
				'dungeon/widgets/'.$this->name.'/libraries',
				'widgets/'.$this->name.'/libraries',
				'overrides/modules/'.$this->name.'/libraries',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/modules/'.$this->name.'/libraries' : '',
				'dungeon/modules/'.$this->name.'/libraries',
				'modules/'.$this->name.'/libraries'
			],
			'models' => [
				'overrides/widgets/'.$this->name.'/models',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/widgets/'.$this->name.'/models' : '',
				'dungeon/widgets/'.$this->name.'/models',
				'widgets/'.$this->name.'/models',
				'overrides/modules/'.$this->name.'/models',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/modules/'.$this->name.'/models' : '',
				'dungeon/modules/'.$this->name.'/models',
				'modules/'.$this->name.'/models'
			],
			'views' => [
				'overrides/widgets/'.$this->name.'/views',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/widgets/'.$this->name.'/views' : '',
				'dungeon/widgets/'.$this->name.'/views',
				'widgets/'.$this->name.'/views',
				'overrides/modules/'.$this->name.'/views',
				!empty($theme_name) ? 'themes/'.$theme_name.'/overrides/modules/'.$this->name.'/views' : '',
				'dungeon/modules/'.$this->name.'/views',
				'modules/'.$this->name.'/views'
			]
		];
	}

	public function is_removable()
	{
		return !in_array($this->name, ['access', 'addons', 'admin', 'comments', 'error', 'live_editor', 'members', 'pages', 'search', 'settings', 'user']);
	}

	public function get_output($type, $settings = [])
	{
		if (($controller = $this->controller('index')) && $controller->has_method($type))
		{
			if (!is_array($output = $controller->method($type, [$settings])))
			{
				$output = [$output];
			}
			
			return $output;
		}

		return $this->widget('error')->get_output('index');
	}

	public function get_admin($type, $settings = [])
	{
		if (($controller = $this->controller('admin')) && $controller->has_method($type))
		{
			if (!is_array($output = $controller->method($type, [$settings])))
			{
				$output = [$output];
			}
			
			return $output;
		}

		return '';
	}

	public function get_settings($type, $settings = [])
	{
		if (($controller = $this->controller('checker')) && $controller->has_method($type))
		{
			return serialize($controller->method($type, [$settings]));
		}
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/classes/widget.php
*/