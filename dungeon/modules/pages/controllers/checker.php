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

class m_pages_c_checker extends Controller_Module
{
	public function _index($name)
	{
		if ($content = $this->db->select('pl.title', 'pl.subtitle', 'pl.content')->from('dungeon_pages p')->join('dungeon_pages_lang pl', 'p.page_id = pl.page_id')->where('name', $name)->where('published', TRUE)->row())
		{
			return $content;
		}
	}
}

/*
Dungeon Alpha 0.1.7.5
./dungeon/modules/pages/controllers/checker.php
*/