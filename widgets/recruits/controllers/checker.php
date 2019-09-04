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

class w_recruits_c_checker extends Controller
{
	public function recruit($settings = [])
	{
		if (in_array($settings['recruit_id'], array_map(function($a){
			return $a['recruit_id'];
		}, $this->model()->get_recruits())))
		{
			return [
				'recruit_id' => $settings['recruit_id']
			];
		}
	}
}

/*
Dungeon Alpha 0.1.6
./widgets/recruits/controllers/checker.php
*/