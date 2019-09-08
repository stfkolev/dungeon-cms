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

class w_events_c_index extends Controller_Widget
{
	public function index($settings = [])
	{
		$this	->css('fullcalendar.min')
				->css('events')
				->js('moment.min')
				->js('fullcalendar.min')
				// ->js('lang-all')
				->js('events');

		return $this->panel()
					->heading('Calendar', 'fa-calendar')
					->body('<div id="calendar"></div>')
					->footer('<a href="'.url('events').'">'.icon('fa-arrow-circle-o-right').' See all events</a>', 'right');
	}

	public function types($settings = [])
	{
		return $this->panel()
					->body($this->view('types', [
						'types' => $this->model()->get_types()
					]), FALSE)
					->footer($this->view('filters'), 'left');
	}

	public function events($settings = [])
	{
		if (isset($settings['type_id']) && $settings['type_id'] != 0)
		{
			$type = $this->db	->from('dungeon_events_types')
								->where('type_id', $settings['type_id'])
								->row();

			$label  = $this->label($type['title'], $type['icon'], $type['color']);
			$events = $this->model()->get_events('type', $settings['type_id']);
		}
		else
		{
			$label = $this->label('Tous', '', 'default');
			$events = $this->model()->get_events();
		}

		return $this->panel()
					->heading('<div class="pull-right">'.$label.'</div>Events', 'fa-calendar')
					->body($this->view('events', ['events' => array_slice($events, 0, 5)]), FALSE)
					->footer_if(count($events) > 5, '<a href="'.url('events').'">'.icon('fa-arrow-circle-o-right').' See all events</a>', 'right');
	}

	public function event($settings = [])
	{
		$this->css('events');

		$event = $this->model()->check_event($settings['event_id']);
		$types = $this->model()->get_types();

		if ($types[$event['type_id']]['type'] == 1)
		{
			$icon = 'fa-crosshairs';
		}
		else
		{
			$icon = 'fa-calendar-o';
		}

		$data = [
			'type'         => $types[$event['type_id']],
			'participants' => $this->model('participants')->count_participants($event['event_id'])
		];

		if ($data['type']['type'] == 1 && ($match = $this->model('matches')->get_match_info($event['event_id'])))//Matches
		{
			$data['match'] = $match;
		}

		if ($this->access('events', 'access_events_type', $data['type']['type_id']))
		{
			return $this->panel()
					->heading('<a href="'.url('events/'.$event['event_id'].'/'.url_title($event['title'])).'">'.$event['title'].'</a>', $icon)
					->body($this->view('event', array_merge($event, $data)), FALSE);
		}
	}

	public function matches($settings = [])
	{
		$this->css('events');

		if ($matches = $this->model()->get_events('filter', 'matches'))
		{
			foreach ($matches as $key => $match)
			{
				$matches[$key]['match'] = $this->model('matches')->get_match_info($match['event_id']);

				if (!$this->access('events', 'access_events_type', $matches[$key]['type_id']))
				{
					unset($matches[$key]);
				}
			}
		}

		return $this->panel()
					->heading('Latest results', 'fa-crosshairs')
					->body($this->view('matches', [
						'matches' => array_slice($matches, 0, 5)
					]), FALSE)
					->footer_if(!empty($matches), '<a href="'.url('events/matches').'">'.icon('fa-crosshairs').' All our results</a>', 'right');
	}

	public function upcoming($settings = [])
	{
		$this->css('events');

		if ($matches = $this->model()->get_events('filter', 'upcoming'))
		{
			foreach ($matches as $key => $match)
			{
				$matches[$key]['match'] = $this->model('matches')->get_match_info($match['event_id']);

				if (!$this->access('events', 'access_events_type', $matches[$key]['type_id']))
				{
					unset($matches[$key]);
				}
			}
		}

		return $this->panel()
					->heading('Upcoming matches', 'fa-crosshairs')
					->body($this->view('upcoming', [
						'matches' => array_slice($matches, 0, 5)
					]), FALSE)
					->footer_if(!empty($matches), '<a href="'.url('events/upcoming').'">'.icon('fa-crosshairs').' See upcoming matches</a>', 'right');
	}
}

/*
Dungeon Alpha 0.1.6.1
./widgets/events/controllers/index.php
*/