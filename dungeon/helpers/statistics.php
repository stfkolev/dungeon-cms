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

function statistics($name, $value = NULL, $callback = NULL)
{
	static $statistics;
	
	if ($statistics === NULL)
	{
		foreach (Dungeon()->db->from('dungeon_statistics')->get() as $stat)
		{
			$statistics[$stat['name']] = $stat['value'];
		}
	}
	
	if (func_num_args() > 1)
	{
		if (isset($statistics[$name]))
		{
			if ($callback === NULL || call_user_func($callback, $value, $statistics[$name]))
			{
				Dungeon()->db	->where('name', $name)
										->update('dungeon_statistics', [
											'value' => $value
										]);
			}
		}
		else
		{
			Dungeon()->db->insert('dungeon_statistics', [
				'name'  => $name,
				'value' => $value
			]);
		}
	}
	else
	{
		return $statistics[$name];
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/helpers/statistics.php
*/