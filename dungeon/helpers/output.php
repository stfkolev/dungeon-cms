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

function display($objects, $id = NULL)
{
	$output = '';
	
	if (!Dungeon()->url->ajax)
	{
		if (is_object($objects) && is_a($objects, 'Panel'))
		{
			$objects = Dungeon()->col($objects);
		}
		
		if (is_object($objects) && is_a($objects, 'Col'))
		{
			$objects = Dungeon()->row($objects);
		}
	}
	
	if (!is_array($objects))
	{
		$objects = [$objects];
	}
	
	foreach ($objects as $i => $object)
	{
		if ($id !== NULL && method_exists($object, 'id'))
		{
			$object->id($i);
		}

		$output .= $object;
	}
	
	return $output;
}

function output($type)
{
	if (in_array($type, ['css', 'js', 'js_load']) && !empty(Dungeon()->{$type}))
	{
		if ($type == 'css')
		{
			if ($v = (int)Dungeon()->config->dungeon_version_css)
			{
				$v = '?v='.$v;
			}

			$output = array_map(function($a) use ($v){
				return '<link rel="stylesheet" href="'.path($a[0].'.css', 'css', $a[2]->paths('assets')).($v ?: '').'" type="text/css" media="'.$a[1].'" />';
			}, Dungeon()->css);
		}
		else if ($type == 'js')
		{
			$output = array_map(function($a){
				return '<script type="text/javascript" src="'.path($a[0].'.js', 'js', $a[1]->paths('assets')).'"></script>';
			}, Dungeon()->js);
		}
		else if ($type == 'js_load')
		{
			$output = Dungeon()->js_load;
		}

		return implode("\r\n", array_unique($output));
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/helpers/output.php
*/