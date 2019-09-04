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

class Addons extends Core
{
	private $_addons = [];
	
	public function __construct()
	{
		parent::__construct();

		foreach ($this->db->from('dungeon_settings_addons')->get() as $addon)
		{
			$this->_addons[$addon['type']][$addon['name']] = (bool)$addon['is_enabled'];
		}
		
		foreach (['module', 'widget'] as $type)
		{
			foreach ($type::$core as $name => $deactivatable)
			{
				if (!isset($this->_addons[$type][$name]) || !$deactivatable)
				{
					$this->_addons[$type][$name] = TRUE;
				}
			}
		}

		foreach ($this->db->select('code', 'name', 'flag')->from('dungeon_settings_languages')->order_by('order')->get() as $language)
		{
			$this->_addons['language'][array_shift($language)] = $language;
		}
	}
	
	public function is_enabled($name, $type)
	{
		return !empty($this->_addons[$type][$name]);
	}
	
	private function _get_addons($get_all, $type)
	{
		static $list = [];
		
		if (!isset($list[$type][(int)$get_all]))
		{
			foreach ($this->_addons[$type] as $name => $is_enabled)
			{
				if (($object = Dungeon()->$type($name, $get_all)) && ($is_enabled || $get_all))
				{
					$list[$type][(int)$get_all][$name] = $object;
				}
			}
		}

		return $list[$type][(int)$get_all];
	}

	public function get_modules($get_all = FALSE)
	{
		return $this->_get_addons($get_all, 'module');
	}
	
	public function get_widgets($get_all = FALSE)
	{
		return $this->_get_addons($get_all, 'widget');
	}

	public function get_themes()
	{
		static $list;
		
		if ($list === NULL)
		{
			$list = [];

			foreach (array_keys($this->_addons['theme']) as $name)
			{
				if ($theme = Dungeon()->theme($name))
				{
					$list[$name] = $theme;
				}
			}
			
			array_natsort($list, function($a){
				return $a->get_title();
			});
		}

		return $list;
	}

	public function get_languages()
	{
		return $this->_addons['language'];
	}

	public function get_authenticators($get_all = FALSE)
	{
		$authenticators = [];

		foreach ($this->db->from('dungeon_settings_authenticators')->order_by('order')->get() as $auth)
		{
			if (($auth['is_enabled'] || $get_all) && ($authenticator = $this->authenticator($auth['name'], $auth['is_enabled'], unserialize($auth['settings']))))
			{
				$authenticators[] = $authenticator;
			}
		}

		return $authenticators;
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/core/addons.php
*/