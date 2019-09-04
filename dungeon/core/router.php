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

class Router extends Core
{
	public $segments = [];

	public function __invoke()
	{
		$segments = ['error'];

		if ((in_array($this->url->extension, ['', 'json', 'xml', 'txt']) || is_asset()) && !in_string('//', $this->url->request))
		{
			$segments = $this->url->segments;
			
			if ($segments[0] == 'index')
			{
				$segments = array_merge(explode('/', $this->config->dungeon_default_page), array_offset_left($segments));
			}
			
			if ($this->url->admin && $this->url->request != 'admin')
			{
				$segments = array_offset_left($segments);
			}
			
			if ($this->url->ajax)
			{
				$segments = array_offset_left($segments);
			}
			
			if ($this->url->admin && !$this->access->admin())
			{
				$this->url->admin = FALSE;
				
				if ($this->user())
				{
					$segments = ['error', 'unauthorized'];
				}
				else
				{
					$segments = ['user', 'login', Dungeon::UNCONNECTED];
				}
			}
		}

		$this->load->theme = $this->theme($this->url->admin ? 'admin' : ($this->config->dungeon_default_theme ?: 'default'))->load();

		$this->_load($segments);
		
		return $this;
	}

	private function _load($segments)
	{
		if (!$module = $this->load->module = $this->module(!in_string('_', $segments[0]) ? str_replace('-', '_', $segments[0]) : 'error'))
		{
			return $this->_load($segments[0] != 'pages' ? array_merge([$this->url->admin ? 'admin' : 'pages'], $segments) : ['error']);
		}

		array_shift($segments);
		
		if (method_exists($module, 'load'))
		{
			$module->load();
		}

		//Méthode par défault
		if (empty($segments))
		{
			$method = 'index';
		}
		else if (strpos($segments[0], '_') === 0)
		{
			return $this->_load(['error']);
		}
		//Méthode définie par routage
		else if (!empty($module->routes))
		{
			$method = $module->get_method($segments);
		}

		//Routage automatique
		if (!isset($method))
		{
			$method = str_replace('-', '_', array_shift($segments));
		}
		
		$this->segments = array_merge([$module->name, $method], $segments);
		
		//Checker Controller
		if (($checker = $module->controller(($this->url->admin ? 'admin_' : '').($this->url->ajax ? 'ajax_' : '').'checker')) && $checker->has_method($method))
		{
			try
			{
				if (($segments = call_user_func_array([$checker, $method], $segments)) === NULL)
				{
					throw new Exception(Dungeon::UNFOUND);
				}
				else if (!is_array($segments))
				{
					$module->append_output($segments);
					return;
				}
			}
			catch (Exception $error)
			{
				$this->_check($error->getMessage());
				return;
			}
		}

		$controller_name = [];
		
		if ($module->name != 'error')
		{
			if (($ajax_error = $this->url->ajax_header && !$this->url->ajax && !$this->url->ajax_allowed) && !post('table_id'))
			{
				return $this->_load(['error']);
			}
			
			if ($this->url->admin)
			{
				$controller_name[] = 'admin';
			}
			
			if ($this->url->ajax)
			{
				$controller_name[] = 'ajax';
			}
			
			if (!$controller_name)
			{
				$controller_name[] = 'index';
			}
		}
		else
		{
			$controller_name[] = $this->url->ajax_header ? 'ajax' : 'index';
		}
	
		//Controller
		if (($controller = $module->controller(implode('_', $controller_name))) && $controller->has_method($method))
		{
			if ($module->name != 'error' && $module->name != 'admin' && $this->url->admin && !$module->is_authorized())
			{
				return $this->_load(['error', 'unauthorized']);
			}

			try
			{
				$module->add_data('module_title', $module->get_title());
				$module->add_data('module_icon', $module->icon);
				$module->add_data('module_method', $method);

				$output = $controller->method($method, $segments);

				if ($module->name == 'error' || ((empty($ajax_error) || $this->url->ajax_allowed) && $this->url->extension_allowed))
				{
					$module->append_output($output);
					return;
				}
			}
			catch (Exception $error)
			{
				$this->_check($error->getMessage());
				return;
			}
		}
		
		$this->_load(['error']);
	}

	private function _check($error)
	{
		if ($error == Dungeon::UNAUTHORIZED)
		{
			if ($this->user())
			{
				$this->_load(['error', 'unauthorized']);
			}
			else
			{
				$this->_load(['user', 'login', Dungeon::UNAUTHORIZED]);
			}
		}
		else if ($error == Dungeon::UNCONNECTED)
		{
			$this->_load(['user', 'login', Dungeon::UNCONNECTED]);
		}
		else
		{
			$this->_load(['error']);
		}
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/core/router.php
*/