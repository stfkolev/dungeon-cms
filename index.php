<?php
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

function Dungeon()
{
	global $Dungeon;
	return $Dungeon;
}

function check_file($dir, $force = FALSE)
{
	if ($dir === '')
	{
		return FALSE;
	}

	static $cache;

	if (!isset($cache[$dir]) || $force)
	{
		$dirs = explode('/', $dir);

		$exists = TRUE;

		foreach (array_keys($dirs) as $i)
		{
			if (!isset($cache[$path = implode('/', array_slice($dirs, 0, $i + 1))]) || $force)
			{
				$cache[$path] = $exists ? file_exists($path) : FALSE;
			}
			
			$exists = $cache[$path];
		}
	}

	return $cache[$dir];
}

ob_start();

define('DUNGEON_CMS',     dirname(__FILE__));
define('DUNGEON_MEMORY',  memory_get_peak_usage());
define('DUNGEON_TIME',    microtime(TRUE));
define('DUNGEON_VERSION', 'Alpha 0.1.6.1');

ini_set('default_charset', 'UTF8');
ini_set('mbstring.func_overload', 7);
mb_regex_encoding('UTF-8');
mb_internal_encoding('UTF-8');

spl_autoload_register(function($name){
	if ($override = substr($name = strtolower($name), 0, 2) == 'o_')
	{
		$name = substr($name, 2);
	}

	$dir = $override ? 'overrides' : 'dungeon';

	if (file_exists($file = $dir.'/classes/'.$name.'.php'))
	{
		require_once $file;
	}
	else if (preg_match('/^(.+?)_(.+)/', $name, $match) && file_exists($dir.'/libraries/'.$match[1].'.php') && file_exists($file = $dir.'/libraries/'.$match[1].'s/'.$match[2].'.php'))
	{
		require_once $file;
	}
	else if (file_exists($file = $dir.'/libraries/'.$name.'.php'))
	{
		require_once $file;
	}
});

function load($name)
{
	$args = array_slice(func_get_args(), 1);

	$override = FALSE;

	if (substr($name, 0, 2) == 'o_')
	{
		$override = TRUE;
	}
	else if (class_exists('o_'.$name))
	{
		$name = 'o_'.$name;
		
		$override = TRUE;
	}

	$r = new ReflectionClass($name);

	if ($debug = Dungeon() === NULL || !isset(Dungeon()->user) || !isset(Dungeon()->debug) || Dungeon()->debug->is_enabled())
	{
		$memory = memory_get_usage();
		$time   = microtime(TRUE);
	}

	$object = $r->newInstanceArgs($args);
	
	if ($debug)
	{
		$object->memory = [$memory, memory_get_usage()];
		$object->time   = [$time, microtime(TRUE)];

		if ($override)
		{
			$object->override = TRUE;
		}
	}

	return $object;
}

$Dungeon = load('loader', [
	'assets' => [
		'assets',
		'overrides/themes/default',
		'dungeon/themes/default'
	],
	'authenticators' => [
		'authenticators'
	],
	'config' => [
		'overrides/config',
		'dungeon/config',
		'config'
	],
	'core' => [
		'overrides/core',
		'dungeon/core'
	],
	'helpers' => [
		'overrides/helpers',
		'dungeon/helpers'
	],
	'lang' => [
		'overrides/lang',
		'dungeon/lang'
	],
	'libraries' => [
		'overrides/libraries',
		'dungeon/libraries',
	],
	'modules' => [
		'overrides/modules',
		'dungeon/modules',
		'modules'
	],
	'themes' => [
		'overrides/themes',
		'dungeon/themes',
		'themes'
	],
	'views' => [
		'overrides/themes/default/views',
		'dungeon/themes/default/views',
		'overrides/views',
		'dungeon/views'
	],
	'widgets' => [
		'overrides/widgets',
		'dungeon/widgets',
		'widgets'
	]
]);

$Dungeon->modules = $Dungeon->themes = $Dungeon->widgets = $Dungeon->authenticators = $Dungeon->css = $Dungeon->js = $Dungeon->js_load = $Dungeon->modals = [];

$Dungeon->module = $Dungeon->theme = NULL;

foreach ([
			'array',
			'assets',
			'color',
			'countries',
			'file',
			'geolocalisation',
			'dir',
			'input',
			'location',
			'notify',
			'output',
			'statistics',
			'string',
			'time',
			'user_agent'
		] as $helper
	)
{
	$Dungeon->helper($helper);
}

foreach([
			'debug',
			'output',
			'db',
			'url',
			'config',
			'access',
			'addons',
			'session',
			'user',
			'groups',
			'router'
		] as $library
	)
{
	$Dungeon->{'core_'.$library};

	if ($library == 'config' && is_asset() && !preg_match('#^backups/#', $Dungeon->url->request))
	{
		asset($Dungeon->url->request);
	}
}

if (isset($Dungeon->config->dungeon_dispositions_upgrade) && !$Dungeon->config->dungeon_dispositions_upgrade)
{
	foreach ($Dungeon->db->from('dungeon_dispositions')->get() as $disposition)
	{
		$rows = unserialize(preg_replace('/O:\d+:"(Row|Col|Widget_View)"/', 'O:8:"stdClass"', preg_replace_callback('/s:\d+:"(.(?:Row|Col|Widget_View).+?)";/', function($a){
			return 's:'.strlen($a = preg_replace('/.*_(.+?)$/', '\1', $a[1])).':"'.$a.'";';
		}, $disposition['disposition'])));

		$new_disposition = [];

		foreach ($rows as $row)
		{
			$cols = [];

			if (!empty($row->cols))
			{
				foreach ($row->cols as $col)
				{
					$widgets = [];

					if (!empty($col->widgets))
					{
						foreach ($col->widgets as $widget)
						{
							$new_widget = $Dungeon->panel_widget($widget->widget_id);

							if (!empty($widget->style))
							{
								$new_widget->color(str_replace('panel-', '', $widget->style));
							}

							$widgets[] = $new_widget;
						}
					}

					$new_col = call_user_func_array([$Dungeon, 'col'], $widgets);

					if (!empty($col->size))
					{
						$new_col->size($col->size);
					}

					$cols[] = $new_col;
				}
			}

			$new_row = call_user_func_array([$Dungeon, 'row'], $cols);

			if (!empty($row->style))
			{
				$new_row->style($row->style);
			}

			$new_disposition[] = $new_row;
		}

		$Dungeon->db	->where('disposition_id', $disposition['disposition_id'])
						->update('dungeon_dispositions', [
							'disposition' => serialize($new_disposition)
						]);

		$Dungeon->config('dungeon_dispositions_upgrade', TRUE, 'bool');
	}

	dir_create('authenticators');

	foreach (['facebook', 'twitter', 'google', 'battle_net', 'steam', 'twitch', 'github', 'linkedin'] as $name)
	{
		$Dungeon->network('https://raw.githubusercontent.com/DungeonCMS/dungeon-cms/master/authenticators/'.$name.'.php')->stream('authenticators/'.$name.'.php');
	}
}

echo $Dungeon->router()->output;

/*
Dungeon Alpha 0.1.6
./index.php
*/