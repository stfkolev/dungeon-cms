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

class m_statistics_c_admin_ajax_checker extends Controller_Module
{
	public function index()
	{
		if ($check = post_check(['modules', 'start', 'end', 'period'], $this->form->token('sq6fswkfb81n0lu4cb7eyb3tuixcovla')))
		{
			$this->extension('json');

			$periods = [
				'hour'  => [function($a){ return 'DATE_FORMAT('.$a.', "%Y-%m-%d %H")'; },                                     'Y-m-d H', new DateInterval('PT1H'), function(&$a) { $a = $a->setTime(0, 0); }],
				'day'   => [function($a){ return 'DATE_FORMAT('.$a.', "%Y-%m-%d")'; },                                        'Y-m-d',   new DateInterval('P1D')],
				'week'  => [function($a){ return 'CONCAT_WS("-", DATE_FORMAT('.$a.', "%x"), LPAD(WEEK('.$a.', 3), 2, 0))'; }, 'o-W',     new DateInterval('P1W'),  function(&$a) { $a = $a->modify('previous week'); }],
				'month' => [function($a){ return 'DATE_FORMAT('.$a.', "%Y-%m")'; },                                           'Y-m',     new DateInterval('P1M'),  function(&$a) { $a = $a->modify('first day of'); }],
				'year'  => [function($a){ return 'DATE_FORMAT('.$a.', "%Y")'; },                                              'Y',       new DateInterval('P1Y'),  function(&$a) { $a = $a->modify('01 january'); }]
			];

			$start = date_create_from_format('d/m/Y', $check['start']);
			$end = date_create_from_format('d/m/Y', $check['end']);

			$this->session	->set('statistics', 'period', $check['period'])
							->set('statistics', 'start', $start->getTimestamp())
							->set('statistics', 'end', $end->getTimestamp())
							->set('statistics', 'date', time());

			return [$this->model()->get_statistics(array_filter($check['modules'])), $start, $end->setTime(23, 59, 59), $periods[$check['period']]];
		}
	}
}

/*
Dungeon Alpha 0.1.5.2
./dungeon/modules/statistics/controllers/admin_ajax_checker.php
*/