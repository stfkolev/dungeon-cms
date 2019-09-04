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

class Button_sort extends Library
{
	public function __invoke($id, $url, $parent = 'table', $items = 'tr')
	{
		return $this->js('dungeon.sortable')
					->button()
					->tooltip($this->lang('sort'))
					->icon('fa-arrows-v')
					->color('link')
					->style('btn-sortable')
					->data([
						'id'     => $id,
						'update' => url($url),
						'parent' => $parent,
						'items'  => $items
					])
					->compact()
					->outline();
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/libraries/buttons/sort.php
*/