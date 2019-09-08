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

if (($date = $this->session('statistics', 'date')) && time() - $date > strtoseconds('1 day'))
{
	$this->session	->destroy('statistics', 'start')
					->destroy('statistics', 'end');
}

$rules = [
	[
		'type'  => 'legend',
		'label' => 'Period'
	],
	'start' => [
		'type'  => 'date',
		'value' => $this->session('statistics', 'start') ?: strtotime('-1 year')
	],
	'end' => [
		'type'  => 'date',
		'value' => $this->session('statistics', 'end') ?: time()
	],
	'period' => [
		'type'   => 'select',
		'value'  => $this->session('statistics', 'period') ?: 'month',
		'values' => [
			'hour'  => 'Hour',
			'day'   => 'Day',
			'week'  => 'Week',
			'month' => 'Month',
			'year'  => 'Year'
		]
	],
	[
		'type'  => 'legend',
		'label' => 'Statistics'
	],
	'modules' => [
		'type'   => 'checkbox',
		'values' => []
	]
];

if ($modules = $this->session('statistics', 'modules'))
{
	$rules['modules']['checked'] = array_fill_keys($modules, TRUE);
}

foreach ($this->model()->get_statistics() as $name => $statistic)
{
	if ($modules === NULL)
	{
		$rules['modules']['checked'][$name] = TRUE;
	}

	$rules['modules']['values'][$name] = '<b style="color: '.$statistic['color'].'">'.$statistic['title'].'</b>';
}

/*
Dungeon Alpha 0.1.5
./dungeon/modules/statistics/forms/statistics.php
*/