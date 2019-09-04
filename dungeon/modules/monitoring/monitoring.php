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

class m_monitoring extends Module
{
	public $title         = 'Monitoring';
	public $description   = '';
	public $icon          = 'fa-heartbeat';
	public $link          = 'http://www.dungeon.com';
	public $author        = 'Evil <inkyzfx@gmail.com>';
	public $licence       = 'http://www.dungeon.com/license.html LGPLv3';
	public $version       = 'Alpha 0.1';
	public $dungeon_version    = 'Alpha 0.1';
	public $routes        = [];
	public $path          = __FILE__;
	public $admin         = FALSE;

	public function need_checking()
	{
		return ($this->config->dungeon_monitoring_last_check < ($time = strtotime('01:00')) && time() > $time) || !file_exists('cache/monitoring/monitoring.json');
	}

	public function display()
	{
		if (file_exists('cache/monitoring/monitoring.json'))
		{
			foreach (array_merge(array_fill_keys(['danger', 'warning', 'info'], 0), array_count_values(array_map(function($a){
				return $a[1];
			}, json_decode(file_get_contents('cache/monitoring/monitoring.json'))->notifications))) as $class => $count)
			{
				if ($count)
				{
					return '<span class="pull-right label label-'.$class.'">'.$count.'</span>';
				}
			}
		}

		return '';
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/modules/monitoring/monitoring.php
*/