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

class m_events_c_checker extends Controller_Module
{
	public function index($page = '')
	{
		return [$this->pagination->fix_items_per_page($this->config->events_per_page)->get_data($this->model()->get_events(), $page)];
	}

	public function standards($page = '')
	{
		return [$this->pagination->fix_items_per_page($this->config->events_per_page)->get_data($this->model()->get_events('filter', 'standards'), $page)];
	}

	public function matches($page = '')
	{
		return [$this->pagination->fix_items_per_page($this->config->events_per_page)->get_data($this->model()->get_events('filter', 'matches'), $page)];
	}

	public function upcoming($page = '')
	{
		return [$this->pagination->fix_items_per_page($this->config->events_per_page)->get_data($this->model()->get_events('filter', 'upcoming'), $page)];
	}

	public function _type($type_id, $title, $page = '')
	{
		return [$this->pagination->fix_items_per_page($this->config->events_per_page)->get_data($this->model()->get_events('type', $type_id), $page)];
	}

	public function _team($team_id, $title, $page = '')
	{
		return [$this->pagination->fix_items_per_page($this->config->events_per_page)->get_data($this->model()->get_events('team', $team_id), $page)];
	}

	public function _event($event_id, $title)
	{
		if ($event = $this->model()->check_event($event_id, $title))
		{
			return $event;
		}
	}

	public function _participant_add($event_id, $title, $current_status)
	{
		$status = $this->model('participants')->status();

		if (isset($status[$current_status]) && $this->model()->check_event($event_id, $title) && $this->db->select('1')->from('dungeon_events_participants')->where('user_id', $this->user('user_id'))->where('event_id', $event_id)->row())
		{
			return [$event_id, $title, $current_status];
		}
	}

	public function _participant_delete($event_id, $title, $user_id)
	{
		if (!$this->user('admin'))
		{
			throw new Exception(Dungeon::UNAUTHORIZED);
		}

		$this->ajax();

		if ($this->model()->check_event($event_id, $title) && $this->db->select('1')->from('dungeon_events_participants')->where('user_id', $user_id)->where('event_id', $event_id)->row())
		{
			return [$event_id, $user_id];
		}
	}
}

/*
Dungeon Alpha 0.1.6
./modules/events/controllers/checker.php
*/