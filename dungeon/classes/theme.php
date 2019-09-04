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

abstract class Theme extends Loadable
{
	static public $core = [
		'admin'   => FALSE,
		'default' => TRUE
	];

	abstract public function styles_row();
	abstract public function styles_widget();

	public $styles;
	
	public function paths()
	{
		return [
			'assets' => [
				'overrides/themes/'.$this->name,
				'dungeon/themes/'.$this->name,
				'themes/'.$this->name
			],
			'controllers' => [
				'overrides/themes/'.$this->name.'/controllers',
				'dungeon/themes/'.$this->name.'/controllers',
				'themes/'.$this->name.'/controllers'
			],
			'forms' => [
				'overrides/themes/'.$this->name.'/forms',
				'dungeon/themes/'.$this->name.'/forms',
				'themes/'.$this->name.'/forms'
			],
			'helpers' => [
				'overrides/themes/'.$this->name.'/helpers',
				'dungeon/themes/'.$this->name.'/helpers',
				'themes/'.$this->name.'/helpers'
			],
			'lang' => [
				'overrides/themes/'.$this->name.'/lang',
				'dungeon/themes/'.$this->name.'/lang',
				'themes/'.$this->name.'/lang'
			],
			'libraries' => [
				'overrides/themes/'.$this->name.'/libraries',
				'dungeon/themes/'.$this->name.'/libraries',
				'themes/'.$this->name.'/libraries'
			],
			'models' => [
				'overrides/themes/'.$this->name.'/models',
				'dungeon/themes/'.$this->name.'/models',
				'themes/'.$this->name.'/models'
			],
			'views' => [
				'overrides/themes/'.$this->name.'/views',
				'dungeon/themes/'.$this->name.'/views',
				'themes/'.$this->name.'/overrides/views',
				'themes/'.$this->name.'/views'
			]
		];
	}
	
	public function load()
	{
		return $this;
	}
	
	public function install($dispositions = [])
	{
		foreach ($dispositions as $page => $dispositions)
		{
			foreach ($dispositions as $zone => $disposition)
			{
				$this->db->insert('dungeon_dispositions', [
					'theme'       => $this->name,
					'page'        => $page,
					'zone'        => array_search($zone, $this->zones),
					'disposition' => serialize($disposition)
				]);
			}
		}

		return parent::install();
	}
	
	public function uninstall($remove = TRUE)
	{
		if ($dispositions = $this->db->select('disposition')->from('dungeon_dispositions')->where('theme', $this->name)->get())
		{
			$this->module('live_editor')->model()->delete_widgets(array_map('unserialize', $dispositions));

			$this->db	->where('theme', $this->name)
						->delete('dungeon_dispositions');
		}

		return parent::uninstall($remove);
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/classes/theme.php
*/