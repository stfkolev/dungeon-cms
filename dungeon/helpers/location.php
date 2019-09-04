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

function url($url = '')
{
	if (substr($url, 0, 1) == '#')
	{
		$url = Dungeon()->url->request.$url;
	}
	
	return Dungeon()->url->base.$url;
}

function redirect($location = '')
{
	header('Location: '.url($location));
	exit;
}

function redirect_back($default = '')
{
	header('Location: '.url(Dungeon()->session->get_back() ?: $default));
	exit;
}

function refresh()
{
	header('Location: '.$_SERVER['REQUEST_URI']);
	exit;
}

function urltolink($url)
{
	return '<a href="'.$url.'">'.parse_url($url, PHP_URL_HOST).'</a>';
}

/*
Dungeon Alpha 0.1.6
./dungeon/helpers/location.php
*/