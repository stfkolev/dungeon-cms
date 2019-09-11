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

class Breadcrumb extends Library
{
	private $_links = [];
	
	public function get_links()
	{
		$links = $this->_links;
		
		if (empty($links) && $this->url->segments[0] == 'index')
		{
			array_unshift($links, [$this->lang('home'), '', 'fa-map-marker']);
		}
		else
		{
			array_unshift($links, [Dungeon()->module->get_title(), Dungeon()->module->name == 'pages' ? $this->url->request : Dungeon()->module->name, Dungeon()->module->icon ?: 'fa-map-marker']);
		}

		return $links;
	}

	public function __invoke($title = '', $link = '', $icon = '')
	{
		if ($title === '')
		{
			$title = !empty(Dungeon()->module->load->data['module_title']) ? Dungeon()->module->load->data['module_title'] : '';
		}

		if ($title !== '')
		{
			$this->_links[] = [$title, $link ?: $this->url->request, $icon ?: (!empty(Dungeon()->module->load->data['module_icon']) ? Dungeon()->module->load->data['module_icon'] : Dungeon()->module->icon)];
		}

		return $this;
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/libraries/breadcrumb.php
*/