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

class w_events_c_admin extends Controller
{
	public function events($settings = [])
	{
		return $this->view('admin_events', [
			'type_id' => isset($settings['type_id']) ? $settings['type_id'] : 0,
			'types'   => $this->model('types')->get_types()
		]);
	}

	public function event($settings = [])
	{
		return $this->view('admin_event', [
			'event_id' => isset($settings['event_id']) ? $settings['event_id'] : 0,
			'events'   => $this->model()->get_events()
		]);
	}
}

/*
Dungeon Alpha 0.1.7.7
./widgets/events/controllers/admin.php
*/