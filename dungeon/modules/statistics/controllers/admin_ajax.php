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

class m_statistics_c_admin_ajax extends Controller_Module
{
	public function index($statistics, $start, $end, $period)
	{
		$date = clone $start;
		
		if (isset($period[3]))
		{
			$period[3]($date);
		}
		
		$dates = [];
		while ($date <= $end)
		{
			$dates[$date->format($period[1])] = 0; 
			$date->add($period[2]);
		}
		
		$series = [];

		$this->session->set('statistics', 'modules', []);

		foreach ($statistics as $name => $statistic)
		{
			$this->session->add('statistics', 'modules', $name);

			$var = $statistic['data']();
			$data = $dates;

			foreach ($this->db	->select($period[0]($var).' as x', (!empty($statistic['group_by']) ? $statistic['group_by'] : 'COUNT(*)').' as y')
								->where($var.' >=', $start->format('Y-m-d H:i:s'))
								->where($var.' <=', $end->format('Y-m-d H:i:s'))
								->group_by('x')
								->get() as $value)
			{
				$data[$value['x']] = $value['y'];
			}

			array_walk($data, function(&$a, $b) use ($period){
				$date = $period[1] == 'o-W' ? date_create()->setISODate(substr($b, 0, 4), substr($b, 5)) : date_create_from_format($period[1], $b);
				$a = [$date->getTimestamp() * 1000, $a];
			});

			$series[] = [
				'type'  => 'line',
				'name'  => $statistic['title'],
				'data'  => array_values($data),
				'color' => $statistic['color']
			];
		}

		return $series;
	}
}

/*
Dungeon Alpha 0.1.5
./dungeon/modules/statistics/controllers/admin_ajax.php
*/