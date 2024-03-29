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

class Output extends Core
{
	public $data = [];

	public function __toString()
	{
		$this->data = $this->load->data;

		$this->data['page_title'] = $this->config->dungeon_name.' :: '.$this->config->dungeon_description;
		$this->data['lang']       = $this->config->lang;
		$this->data['output']     = preg_replace('/\xEF\xBB\xBF/', '', ob_get_clean());

		if ($this->url->ajax())
		{
			$output = $this->load->module;
		}
		else
		{
			$this->data['module_actions'] = $this->load->module->get_actions();

			$this->data = array_merge($this->data, $this->load->module->load->data);

			$this->parse_data($this->data);

			if (!empty($this->data['module_title']) && $this->url->segments[0] != 'index')
			{
				$this->data['page_title'] = $this->data['module_title'].' :: '.$this->config->dungeon_name;
			}

			if (!empty($this->load->module->icon) || !empty($this->data['module_icon']))
			{
				$this->data['module_title'] = icon(!empty($this->data['module_icon']) ? $this->data['module_icon'] : $this->load->module->icon).' '.$this->data['module_title'];
			}

			notifications();
			
			if ($this->load->module->name == 'live_editor')
			{
				$this->data['body'] = $this->load->module;
			}
			else
			{
				$this->data['body'] = '';

				if (Dungeon::live_editor())
				{
					$this->data['body'] = '<div id="live_editor" data-module-title="'.utf8_htmlentities($this->url->segments[0] == 'index' ? $this->label($this->lang('home'), 'fa-map-marker') : $this->data['module_title']).'"></div>';

					$this->load	->css('font.open-sans.300.400.600.700.800')
								->css('dungeon.live-editor');
				}

				$this->data['body'] .= $this->load->theme->view('body', $this->data);

				if ($this->load->modals)
				{
					$this->data['body'] .= implode($this->load->modals);
				}

				if (!Dungeon::live_editor())
				{
					$this->data['body'] .= $this->debug->display();
				}
			}

			if (!$this->url->ajax() && $this->user('admin') && $this->url->request != 'admin/monitoring' && $this->module('monitoring')->need_checking())
			{
				$this->js_load('$.post(\''.url('admin/ajax/monitoring.json').'\', {refresh: false});');
			}

			$this->data['css']     = output('css');
			$this->data['js']      = output('js');
			$this->data['js_load'] = output('js_load');

			$output = $this->load->theme->view('default', $this->data);
		}

		if ($this->url->extension == 'json')
		{
			header('Content-Type: application/json; charset=UTF-8');
		}
		else if ($this->url->extension == 'xml')
		{
			header('Content-Type: application/xml; charset=UTF-8');
			$output = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n".$output;
		}
		else if ($this->url->extension == 'txt')
		{
			header('Content-Type: text/plain; charset=UTF-8');
			$output = utf8_html_entity_decode($output);
		}
		else
		{
			header('Content-Type: text/html; charset=UTF-8');
		}

		return (string)$output;
	}

	public function zone($zone_id)
	{
		static $dispositions;
		
		if ($dispositions === NULL)
		{
			$this->db	->select('zone', 'disposition_id', 'disposition', 'page')
						->from('dungeon_dispositions')
						->where('theme', $this->load->theme->name)
						->order_by('page DESC');

			$pages = ['page', '*', 'OR'];

			if ($this->url->segments[0] == 'index')
			{
				$pages[] = 'page';
				$pages[] = '/';
				$pages[] = 'OR';
			}
			else
			{
				for ($i = count($segments = $this->router->segments); $i > 0; $i--)
				{
					$pages[] = 'page';
					$pages[] = implode('/', array_slice($segments, 0, $i)).'/*';
					$pages[] = 'OR';
				}
			}

			call_user_func_array([$this->db, 'where'], $pages);
			
			foreach ($this->db->get() as $disposition)
			{
				if (!isset($dispositions[$zone = $disposition['zone']]))
				{
					unset($disposition['zone']);
					$dispositions[$zone] = $disposition;
				}
			}
		}

		if (!empty($dispositions[$zone_id]))
		{
			$disposition = $dispositions[$zone_id];
			return parent::zone($disposition['disposition_id'], unserialize($disposition['disposition']), $disposition['page'], $zone_id);
		}

		return '';
	}

	public function parse($content, $data = [])
	{
		if (is_a($content, 'closure'))
		{
			$content = call_user_func($content, $data);
		}

		return $content;
	}

	public function parse_data(&$data)
	{
		array_walk_recursive($data, function(&$a) use (&$data){
			$a = $this->parse($a, $data);
		});
	}
}

/*
Dungeon Alpha 0.1.7.7
./dungeon/core/output.php
*/