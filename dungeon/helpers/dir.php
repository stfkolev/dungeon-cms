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

function dir_create()
{
	foreach (func_get_args() as $dir)
	{
		if (!file_exists($dir))
		{
			mkdir($dir, 0777, TRUE);
		}
	}
}

function dir_scan($dirs = '.', $callback = NULL, $dir_callback = NULL)
{
	$result = [];

	foreach ((array)$dirs as $dir)
	{
		if (!file_exists($dir))
		{
			continue;
		}
		
		foreach (scandir($dir) as $file)
		{
			if (in_array($file, ['.', '..']))
			{
				continue;
			}
			
			if (is_dir($path = $dir.'/'.$file))
			{
				$result = array_merge($result, dir_scan($path, $callback, $dir_callback));
				
				if (is_callable($dir_callback))
				{
					$dir_callback($path);
				}
			}
			else
			{
				$result[$path] = is_callable($callback) ? $callback($path) : $file;
			}
		}
	}
	
	return $result;
}

function dir_remove($directory)
{
	dir_scan($directory, 'unlink', 'dir_remove');
	rmdir($directory);
}

function dir_copy($src, $dst)
{ 
	dir_create($dst);

	$dir = opendir($src); 

	while (($file = readdir($dir)) !== FALSE)
	{
		if (!in_array($file, ['.', '..']))
		{
			if (is_dir($src.'/'.$file))
			{
				dir_copy($src.'/'.$file, $dst.'/'.$file); 
			}
			else
			{
				copy($src.'/'.$file, $dst.'/'.$file); 
			}
		}
	}
	
	closedir($dir); 
}

/*
Dungeon Alpha 0.1.5.2
./dungeon/helpers/dir.php
*/