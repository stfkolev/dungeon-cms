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

function post($var = NULL)
{
	if ($var === NULL)
	{
		return $_POST;
	}
	
	if (isset($_POST[$var]))
	{
		return $_POST[$var];
	}

	return NULL;
}

function post_check($args, $post = NULL)
{
	if (is_array($args))
	{
		if ($post === NULL)
		{
			$post = post();
		}
		else if (!is_array($post))
		{
			$post = post($post);
		}
	}
	else
	{
		$args = func_get_args();
		$post = post();
	}

	$data = [];

	foreach ($args as $var)
	{
		if (isset($post[$var]))
		{
			$data[$var] = $post[$var];
		}
		else
		{
			return FALSE;
		}
	}

	return $data;
}

/*
Dungeon Alpha 0.1.5
./dungeon/helpers/input.php
*/