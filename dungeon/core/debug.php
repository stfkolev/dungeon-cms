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

class Debug extends Core
{
	const INFO       = 0;
	const WARNING    = 1;
	const ERROR      = 2;
	const NOTICE     = 3;
	const DEPRECATED = 4;
	const STRICT     = 5;

	private $_log      = [];
	private $_timeline = [];

	public function __construct()
	{
		parent::__construct();

		set_error_handler(function($errno, $errstr, $errfile, $errline){
			if (in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR]))
			{
				$error = self::ERROR;
			}
			else if (in_array($errno, [E_USER_WARNING, E_WARNING]))
			{
				$error = self::WARNING;
			}
			else if (in_array($errno, [E_USER_NOTICE, E_NOTICE]))
			{
				$error = self::NOTICE;
			}
			else if (in_array($errno, [E_DEPRECATED]))
			{
				$error = self::DEPRECATED;
			}
			else if ($errno == E_STRICT)
			{
				$error = self::STRICT;
			}

			$this->_log[] = [$errstr, $error, relative_path($errfile), $errline];

			return !(error_reporting() & $errno);
		}, E_ALL);

		$this->log('URL http://'.$_SERVER['HTTP_HOST'].rawurldecode($_SERVER['REQUEST_URI']), self::INFO);
		$this->log('IP '.((isset($_SERVER['HTTP_X_REAL_IP'])) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR']), self::INFO);
	}

	public function __destruct()
	{
		$this->log('Temps écoulé depuis la requète HTTP : '.round((microtime(TRUE) - $_SERVER['REQUEST_TIME']) * 1000, 3).' ms', self::INFO);
		$this->log('Temps total d\'exécution : '.round((microtime(TRUE) - DUNGEON_TIME) * 1000, 3).' ms', self::INFO);
		$this->log('Espace mémoire alloué par Dungeon : '.round((memory_get_peak_usage() - DUNGEON_MEMORY) / 1024 / 1024, 3).' Mo', self::INFO);
		$this->log('Espace mémoire alloué par PHP : '.round(memory_get_peak_usage() / 1024 / 1024, 3).' Mo', self::INFO);

		if (!is_asset() && check_file(DUNGEON_CMS.'/logs/'))
		{
			$f = fopen(DUNGEON_CMS.'/logs/log.php', 'a');

			foreach ($this->_log as $log)
			{
				fwrite($f, timetostr('%Y-%m-%d %H:%M:%S').' : '.$log[0]."\n");
			}

			fwrite($f, str_repeat('=', 150)."\n");

			fclose($f);
		}
	}

	public function log($error, $type = self::INFO, $trace = 0)
	{
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $trace + 1);
		$this->_log[] = [$error, $type, relative_path($backtrace[$trace]['file']), $backtrace[$trace]['line']];
	}

	public function table($data)
	{
		if (is_array($data) || is_object($data))
		{
			$output = '<table class="table table-striped">
						<tbody>';

			$data = (array)$data;
			ksort($data);

			foreach ($data as $key => $value)
			{
				$output .= '	<tr>
									<td style="width: 200px;"><b>'.$key.'</b></td>
									<td>'.$this->table($value).'</td>
								</tr>';
			}

			$output .= '	</tbody>
						</table>';

			return $output;
		}
		else if (is_bool($data))
		{
			return $data ? '<i class="fa fa-check text-success" title="TRUE"></i>' : '<i class="fa fa-close text-danger" title="FALSE"></i>';
		}
		else if ($data === NULL)
		{
			return '<em>NULL</em>';
		}
		else
		{
			return utf8_htmlentities(str_replace(["\n", "\r"], '', $data));
		}
	}
	
	public function timeline()
	{
		if (!func_num_args())
		{
			$output = '<table class="table table-striped">
						<tbody>';

			usort($this->_timeline, function($a, $b){
				return $a[1] > $b[1];
			});
			
			foreach ($this->_timeline as $time)
			{
				if (!isset($min, $max))
				{
					$min = $time[1];
					$max = $time[2];
				}
				else
				{
					$min = min($min, $time[1]);
					$max = max($max, $time[2]);
				}
			}
			
			$total = $max - $min;
			
			foreach ($this->_timeline as $time)
			{
				$class = 'pull-left';
				
				if (preg_match('/class="(.*?)"/', $time[0], $match))
				{
					$class .= ' '.$match[1];
				}
				
				$output .= '	<tr>
									<td class="col-md-1">'.$time[0].'</td>
									<td>
										<div class="pull-left" style="height: 25px; width: '.str_replace(',', '.', floor(($time[1] - $this->_timeline[0][1]) * 100 / $total)).'%;"></div>
										<div class="'.$class.'" style="height: 25px; display: block; padding: 0; width: '.str_replace(',', '.', max(1, floor(($time[2] - $time[1]) * 100 / $total))).'%;"></div>
									</td>
								</tr>';
			}
			
			$output .= '	</tbody>
						</table>';

			return $output;
		}
		else
		{
			$this->_timeline[] = func_get_args();
			return $this;
		}
	}

	public function is_enabled()
	{
		return isset($this->config) && !empty($this->config->dungeon_debug) && ($this->config->dungeon_debug == 2 || ($this->user('admin') && $this->config->dungeon_debug == 1));
	}
	
	public function display()
	{
		if ($this->is_enabled())
		{
			$this->load	->css('font.open-sans.300.400.600.700.800')
						->css('dungeon.debugbar')
						->css('jquery.mCustomScrollbar.min')
						->js('dungeon.debugbar')
						->js('jquery.mCustomScrollbar.min');

			return $this->view('debug/debugbar', [
				'tabs' => $tabs = [
					'console'  => [$this->debug->debugbar($console),              'Console',  'fa-terminal',    $console],
					'database' => [$this->db->debugbar($database),                'Database', 'fa-database',    $database],
					'loader'   => [Dungeon()->debugbar('Dungeon Loader'), 'Loader',   'fa-puzzle-piece'],
					'timeline' => [$this->debug->timeline(),                      'Timeline', 'fa-clock-o'],
					'settings' => [$this->config->debugbar(),                     'Settings', 'fa-cogs'],
					'session'  => [$this->session->debugbar(),                    'Session',  'fa-flag'],
					'server'   => [$this->debug->table($_SERVER),                 'Server',   'fa-server']
				],
				'active' => ($tab = $this->session('debugbar', 'tab')) && isset($tabs[$tab]) ? $tab : NULL
			]);
		}
	}

	public function debugbar(&$output = '')
	{
		$result = '<table class="table table-striped">';

		$warning = $error = $notice = $deprecated = $strict = 0;

		foreach ($this->_log as $i => $log)
		{
			list($text, $type, $file, $line) = $log;

			if ($type == self::INFO)
			{
				$type = '<span class="label label-success">Info</span>';
			}
			else if ($type == self::WARNING)
			{
				$type = '<span class="label label-warning">Warning</span>';
				$warning++;
			}
			else if ($type == self::ERROR)
			{
				$type = '<span class="label label-danger">Error</span>';
				$error++;
			}
			else if ($type == self::NOTICE)
			{
				$type = '<span class="label label-info">Notice</span>';
				$notice++;
			}
			else if ($type == self::DEPRECATED)
			{
				$type = '<span class="label label-warning">Deprecated</span>';
				$deprecated++;
			}
			else if ($type == self::STRICT)
			{
				$type = '<span class="label label-default">Strict</span>';
				$strict++;
			}

			$result .= '	<tr>
								<td class="col-md-1"><b>'.($i + 1).'</b><div class="pull-right">'.$type.'</div></td>
								<td class="col-md-8">'.utf8_htmlentities($text).'</td>
								<td class="col-md-3 text-right">'.$file.' <code>'.$line.'</code></td>
							</tr>';
		}

		$result .= '</table>';

		if ($error)
		{
			$output = '<span class="label label-danger">'.$error.'</span>';
		}
		else if ($warning)
		{
			$output = '<span class="label label-warning">'.$warning.'</span>';
		}
		else if ($strict)
		{
			$output = '<span class="label label-default">'.$strict.'</span>';
		}
		else if ($notice)
		{
			$output = '<span class="label label-info">'.$notice.'</span>';
		}
		else if ($deprecated)
		{
			$output = '<span class="label label-warning">'.$deprecated.'</span>';
		}
		
		return $result;
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/core/debug.php
*/