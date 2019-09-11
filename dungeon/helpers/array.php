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

function array_last_key($array)
{
	$keys = array_keys($array);

	return end($keys);
}

function array_last($array)
{
	return end($array);
}

function array_offset_left($array, $offset = 1)
{
	return array_slice($array, $offset);
}

function array_offset_right($array, $length = 1)
{
	return array_slice($array, 0, -$length);
}

function array_natsort(&$array, $data = NULL)
{
	uasort($array, function($a, $b) use ($data){
		return str_nat($a, $b, $data);
	});
}

/*
Dungeon Alpha 0.1.7.7.1
./dungeon/helpers/array.php
*/