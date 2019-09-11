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

function get_colors()
{
	return [
		'default' => '#777777',
		'primary' => '#337ab7', 
		'success' => '#5cb85c',
		'info'    => '#5bc0de',
		'warning' => '#f0ad4e',
		'danger'  => '#d9534f'
	];
}

function color2hex($color)
{
	$colors = get_colors();
	return isset($colors[$color]) ? $colors[$color] : $color;
}

/*
Dungeon Alpha 0.1.7.5
./dungeon/helpers/color.php
*/