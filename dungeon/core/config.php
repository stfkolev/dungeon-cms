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

class Config extends Core
{
	private $_settings = [];
	private $_configs  = [];

	public function __construct()
	{
		parent::__construct();

		$this->reset();
	}

	public function reset()
	{
		$this->_configs = $this->_settings = [];

		if (($configs = $this->load->db->select('site', 'lang', 'name', 'value', 'type')->from('dungeon_settings')->get()) === NULL)
		{
			header('HTTP/1.0 503 Service Unavailable');
			exit('Database is empty');
		}

		foreach ($configs as $setting)
		{
			if ($setting['type'] == 'array')
			{
				$value = unserialize(utf8_html_entity_decode($setting['value']));
			}
			else if ($setting['type'] == 'list')
			{
				$value = explode('|', $setting['value']);
			}
			else if ($setting['type'] == 'bool')
			{
				$value = (bool)$setting['value'];
			}
			else if ($setting['type'] == 'int')
			{
				$value = (int)$setting['value'];
			}
			else
			{
				$value = $setting['value'];
			}

			$this->_settings[$setting['site']][$setting['lang']][$setting['name']] = $value;
		}

		$this->update('');

		$dungeon_languages = $this->db	->select('code')
									->from('dungeon_settings_languages')
									->order_by('order')
									->get();

		//TODO
		$this->_configs['langs'] = array_unique(array_merge(array_intersect(array_filter(array_merge(/*[$this->session('language')], */preg_replace('/^(.+?)[;-].*/', '\1', explode(',', !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '')))), $dungeon_languages), $dungeon_languages));

		$this->update('default');

		$this->update('default', 'en');
		//$this->update('default', array_shift($dungeon_languages));
	}

	public function __get($name)
	{
		if (isset($this->_configs[$name]))
		{
			return $this->_configs[$name];
		}

		return parent::__get($name);
	}

	public function __set($name, $value)
	{
		$this->_configs[$name] = $value;
	}

	public function __isset($name)
	{
		return isset($this->_configs[$name]);
	}

	public function __invoke($name, $value, $type = NULL)
	{
		if (isset($this->_configs[$name]))
		{
			Dungeon()->db	->where('name', $name)
									->update('dungeon_settings', [
										'value' => $value
									]);

			if ($type)
			{
				Dungeon()->db	->where('name', $name)
										->update('dungeon_settings', [
											'type' => $type
										]);
			}
		}
		else
		{
			Dungeon()->db->insert('dungeon_settings', [
				'name'  => $name,
				'value' => $value,
				'type'  => $type ?: 'string'
			]);
		}

		$this->_configs[$name] = $value;

		return $this;
	}

	public function update($site = '', $lang = '')
	{
		$this->_configs['lang'] = $lang;
		$this->_configs['site'] = $site;

		if (!empty($this->_settings[$site][$lang]))
		{
			foreach ($this->_settings[$site][$lang] as $name => $value)
			{
				$this->_configs[$name] = $value;
			}
		}
	}

	public function debugbar()
	{
		return $this->debug->table($this->_configs);
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/core/config.php
*/