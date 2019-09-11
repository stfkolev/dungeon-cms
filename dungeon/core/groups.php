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

class Groups extends Core
{
	private $_groups = [];
	
	public function __construct()
	{
		parent::__construct();
		
		$users = $this->db->select('user_id', 'admin')->from('dungeon_users')->where('deleted', FALSE)->get();
		
		$this->_groups = [
			'admins' => [
				'name'   => 'admins',
				'title'  => Dungeon()->lang('group_admins'),
				'color'  => 'danger',
				'icon'   => 'fa-rocket',
				'hidden' => FALSE,
				'users'  => array_map('intval', array_map(function($a){return intval($a['user_id']);}, array_filter($users, function($a){return $a['admin'];}))),
				'auto'   => 'dungeon'
			],
			'members' => [
				'name'   => 'members',
				'title'  => Dungeon()->lang('group_members'),
				'color'  => 'success',
				'icon'   => 'fa-user',
				'hidden' => FALSE,
				'users'  => array_map('intval', array_map(function($a){return intval($a['user_id']);}, array_filter($users, function($a){return !$a['admin'];}))),
				'auto'   => 'dungeon'
			],
			'visitors' => [
				'name'   => 'visitors',
				'title'  => Dungeon()->lang('group_visitors'),
				'color'  => 'info',
				'icon'   => '',
				'hidden' => FALSE,
				'users'  => NULL,
				'auto'   => 'dungeon'
			]
		];
		
		$groups = $this->db	->select('g.group_id', 'g.name', 'g.color', 'g.icon', 'g.hidden', 'IFNULL(gl.title, g.name) AS title', 'GROUP_CONCAT(u.user_id) AS users', 'g.auto')
							->from('dungeon_groups g')
							->join('dungeon_groups_lang gl',  'gl.group_id = g.group_id')
							->join('dungeon_users_groups ug', 'ug.group_id = g.group_id')
							->join('dungeon_users u',         'ug.user_id  = u.user_id AND u.deleted = "0"')
							->where('gl.lang', $this->config->lang, 'OR')
							->where('gl.lang', NULL)
							->group_by('g.group_id')
							->order_by('g.order')
							->get();

		$order = 1;

		foreach ($groups as $group)
		{
			if ($group['auto'])
			{
				if (!isset($this->_groups[$group['name']]))
				{
					$this->_groups[$group['name']]['order'] = $order++;
				}

				$this->_groups[$group['name']]['id']     = $group['group_id'];
				$this->_groups[$group['name']]['color']  = $group['color'];
				$this->_groups[$group['name']]['icon']   = $group['icon'];
				$this->_groups[$group['name']]['hidden'] = (bool)$group['hidden'];
				$this->_groups[$group['name']]['auto']   = TRUE;
			}
			else
			{
				$this->_groups[url_title($group['group_id'])] = [
					'id'     => $group['group_id'],
					'name'   => $group['name'],
					'title'  => $group['title'],
					'color'  => $group['color'],
					'icon'   => $group['icon'],
					'hidden' => (bool)$group['hidden'],
					'users'  => !empty($group['users']) ? array_map('intval', explode(',', $group['users'])) : [],
					'auto'   => FALSE,
					'order'  => $order++
				];
			}
		}
		
		foreach ($this->addons->get_modules() as $module)
		{
			if (method_exists($module, 'groups'))
			{
				foreach ($module->groups() as $id => $group)
				{
					$group_id = url_title($module->name.'_'.$id);
					
					$this->_groups[$group_id]         = !empty($this->_groups[$group_id]) ? array_merge($group, $this->_groups[$group_id]) : $group;
					$this->_groups[$group_id]['auto'] = 'module_'.$module->name;
					
					if (empty($this->_groups[$group_id]['icon']))
					{
						$this->_groups[$group_id]['icon'] = $module->icon;
					}

					if (empty($this->_groups[$group_id]['color']))
					{
						$this->_groups[$group_id]['color'] = 'default';
					}

					if (empty($this->_groups[$group_id]['hidden']))
					{
						$this->_groups[$group_id]['hidden'] = FALSE;
					}

					if (empty($this->_groups[$group_id]['order']))
					{
						$this->_groups[$group_id]['order'] = $order++;
					}
				}
			}
		}
		
		foreach ($this->_groups as $group_id => &$group)
		{
			if (array_key_exists('users', $group))
			{
				$group['url'] = url_title($group_id).($group['auto'] != 'dungeon' ? '/'.$group['name'] : '');
			}
			else
			{
				unset($this->_groups[$group_id]);
			}
			
			unset($group);
		}

		$this->_groups['admins']['order']   = 0;
		$this->_groups['members']['order']  = $order++;
		$this->_groups['visitors']['order'] = $order;

		uasort($this->_groups, function($a, $b){
			return $a['order'] > $b['order'];
		});
	}
	
	public function __invoke($user_id = NULL)
	{
		if (func_num_args() == 1)
		{
			$groups = [];
			
			foreach ($this->_groups as $group_id => $group)
			{
				if (!empty($group['users']) && in_array($user_id, $group['users']))
				{
					$groups[] = $group_id;
				}
			}
			
			$groups = array_unique($groups);
			
			return $groups ?: ['visitors'];
		}
		else
		{
			return $this->_groups;
		}
	}

	public function user_groups($user_id, $label = TRUE)
	{
		$groups = [];
		
		foreach ($this->_groups as $group_id => $group)
		{
			if (!empty($group['users']) && in_array($user_id, $group['users']) && (!$group['hidden'] || ($this->user('admin') && $this->url->admin)))
			{
				$groups[] = $this->display($group_id, $label);
			}
		}
		
		return implode(' ', $groups);
	}
	
	public function display($group_id, $label = TRUE, $link = TRUE)
	{
		if ($label)
		{
			if ($group_id == 'visitors')
			{
				$link = FALSE;
			}
			
			return $this->label()
						->title($this->_groups[$group_id]['title'])
						->icon($this->_groups[$group_id]['icon'])
						->url_if($link, 'members/group/'.$this->_groups[$group_id]['url'])
						->color($this->_groups[$group_id]['color']);
		}
		else
		{
			return $this->_groups[$group_id]['title'];
		}
	}
	
	public function check_group($args)
	{
		$n = count($args);
		
		if ($n == 1)
		{
			return $this->_groups[$args[0]] + ['unique_id' => $args[0]];
		}
		
		if ($n == 3)
		{
			list($module, $group_id, $name) = $args;
			$group_id = $module.'-'.$group_id;
		}
		else if ($n == 2)
		{
			list($group_id, $name) = $args;
		}
		
		if (isset($this->_groups[$group_id]) && $name == $this->_groups[$group_id]['name'])
		{
			return $this->_groups[$group_id] + ['unique_id' => $group_id];
		}
		
		return FALSE;
	}
	
	public function delete($module, $id)
	{
		$group_id = url_title($module.'_'.$id);
		
		if (isset($this->_groups[$group_id]))
		{
			if (!empty($this->_groups[$group_id]['id']))
			{
				$this->db	->where('group_id', $this->_groups[$group_id]['id'])
							->delete('dungeon_groups');
			}
			
			$this->access->revoke($group_id);
			
			unset($this->_groups[$group_id]);
		}
		
		return $this;
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/core/groups.php
*/