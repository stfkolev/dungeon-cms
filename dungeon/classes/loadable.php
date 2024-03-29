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

abstract class Loadable extends Dungeon
{
	abstract public function paths();

	public $name;
	public $type;
	public $title;
	public $description;
	public $link;
	public $author;
	public $licence;
	public $version;
	public $dungeon_version;

	public function __construct($name, $type)
	{
		$this->name = $name;
		$this->type = $type;
	}

	public function __get($name)
	{
		return $name != 'load' ? parent::__get($name) : $this->load = load('loader', $this, $this->paths());
	}

	public function is_deactivatable()
	{
		return !empty(static::$core[$this->name]) || $this->is_removable();
	}

	public function is_removable()
	{
		return !isset(static::$core[$this->name]);
	}

	public function get_title($new_title = NULL)
	{
		static $title;

		if ($new_title !== NULL)
		{
			$title = $new_title;
		}
		else if ($title === NULL)
		{
			$title = $this->lang($this->title, NULL);
		}
		
		return $title;
	}

	public function install()
	{
		$this->db->insert('dungeon_settings_addons', [
			'name'       => $this->name,
			'type'       => $this->type,
			'is_enabled' => TRUE
		]);

		return $this;
	}
	
	public function uninstall($remove = TRUE)
	{
		$this->db	->where('name', $this->name)
					->where('type', $this->type)
					->delete('dungeon_settings_addons');

		if ($remove)
		{
			dir_remove($this->type.'s/'.$this->name);
		}

		return $this;
	}
	
	public function reset()
	{
		$this->uninstall(FALSE);
		$this->config->reset();
		$this->install();
		
		return $this;
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/classes/loadable.php
*/