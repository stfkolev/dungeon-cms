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

class Button_create extends Library
{
	public function __invoke($url, $title, $icon = 'fa-plus')
	{
		return $this->button()
					->title($title)
					->url($url)
					->icon($icon)
					->color('primary')
					->outline();
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/libraries/buttons/create.php
*/