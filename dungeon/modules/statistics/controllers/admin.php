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

class m_statistics_c_admin extends Controller_Module
{
	public function index()
	{
		$this	->js('statistics')
				->js('highstock');

		return [
			$this->row(
				$this	->col(
							$this	->panel()
									->heading('Statistics', 'fa-bar-chart')
									->body($this	->form
													->set_id('sq6fswkfb81n0lu4cb7eyb3tuixcovla')
													->add_rules('statistics')
													->fast_mode()
													->display())
						)
						->size('col-md-4 col-lg-3'),
				$this	->col($this->panel()->body('<div id="highcharts"></div>', FALSE))
						->size('col-md-8 col-lg-9')
			)
		];
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/modules/statistics/controllers/admin.php
*/