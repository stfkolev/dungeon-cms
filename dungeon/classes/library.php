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

class Library extends Dungeon
{
	static public $ID;

	public $id;
	public $load;
	public $name = '';

	public function __sleep()
	{
		return array_filter(array_keys(get_object_vars($this)), function($a){
			return $a[0] == '_';
		});
	}

	public function __wakeup()
	{
		$this->load = Dungeon();
	}

	public function reset()
	{
		if (isset($this->load->libraries[$this->name]))
		{
			unset($this->load->libraries[$this->name]);
		}

		return $this->set_id();
	}

	public function save()
	{
		$clone = clone $this;

		$this->reset();

		return $clone;
	}

	public function set_id($id = NULL)
	{
		$this->id = $id ?: md5($this->name.++self::$ID);
		return $this;
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/classes/library.php
*/