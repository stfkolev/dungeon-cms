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
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Dungeon. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

class w_dserv_c_checker extends Controller_Widget
{
	public function index($settings = array())
	{
		return array(
			'addr'    => $settings['addr'],
			'port' 	  => $settings['port'],
			'display' => $settings['display']
		);
	}
}

/*
Dungeon Alpha 0.1.7.3
./widgets/dserv/controllers/checker.php
*/