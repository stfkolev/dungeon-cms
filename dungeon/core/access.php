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

class Access extends Core
{
	private $_access = [];
	
	public function __construct()
	{
		parent::__construct();
		$this->reload();
	}
	
	public function reload()
	{
		$this->_access = [];
		
		foreach ($this->db	->select('ad.entity', 'ad.type', 'ad.authorized', 'a.action', 'a.id', 'a.module')
							->from('dungeon_access a')
							->join('dungeon_access_details ad', 'a.access_id = ad.access_id')
							->order_by('type <> "user"', 'authorized DESC')
							->get() as $access)
		{
			if ($access['entity'])
			{
				$this->_access[$access['module']][$access['action']][$access['id']][] = [
					'entity'     => $access['entity'],
					'type'       => $access['type'],
					'authorized' => (bool)$access['authorized'],
				];
			}
			else
			{
				$this->_access[$access['module']][$access['action']][$access['id']] = TRUE;
			}
		}
	}
	
	public function __invoke($module, $action, $id = 0, $group_id = NULL, $user_id = NULL)
	{
		$access = isset($this->_access[$module][$action][$id]) ? $this->_access[$module][$action][$id] : FALSE;

		if (	$group_id == 'admins' || 
				($user_id !== NULL && in_array('admins', $this->groups($user_id))) || 
				($group_id === NULL && $user_id === NULL && $this->user('admin')) ||
				$access === TRUE
			)
		{
			return TRUE;
		}
		else if (!$access)
		{
			//TODO return FALSE;
			return $action == 'module_access';
		}

		$authorized = array_fill(0, 2, 0);
		
		foreach ($access as $permission)
		{
			if ($permission['type'] == 'group')
			{
				$authorized[$permission['authorized']]++;
			}
		}
		
		$user_groups = $user_id || $this->user() ? $this->groups($user_id ?: $this->user('user_id')) : ['visitors'];
		$default     = array_sum($authorized) ? $authorized[0] > $authorized[1] : TRUE;
		$groups      = [];
		
		foreach ($access as $permission)
		{
			if ($permission['type'] == 'group' && $group_id === NULL && in_array($permission['entity'], $user_groups))
			{
				$groups[$permission['entity']] = (bool)$permission['authorized'];
			}
			else if ($permission['type'] == 'group' && $group_id == $permission['entity'])
			{
				return (bool)$permission['authorized'];
			}
			else if ($permission['type'] == 'user'  && $group_id === NULL && $permission['entity'] == ($user_id ?: $this->user('user_id')))
			{
				return (int)(bool)$permission['authorized'];
			}
		}
		
		if ($group_id !== NULL)
		{
			return $default;
		}

		if ($user_id || $this->user())
		{
			foreach (array_keys($this->groups()) as $group)
			{
				if ($group != 'admins' && in_array($group, $user_groups))
				{
					return isset($groups[$group]) ? $groups[$group] : $default;
				}
			}
		}
		else
		{
			return isset($groups['visitors']) ? $groups['visitors'] : $default;
		}
	}
	
	public function count($module, $action, $id = 0)
	{
		$count = array_fill(0, 2, 0);
		
		foreach ($this->db->select('user_id')->from('dungeon_users')->where('deleted', FALSE)->get() as $user_id)
		{
			$access = $this($module, $action, $id, NULL, $user_id);
			$count[(int)$access]++;
		}
		
		$output = [];

		if (!empty($count[1]))
		{
			$output[] = '<span class="text-success" data-toggle="tooltip" title="'.$this->lang('authorized_members').'" data-original-title="">'.icon('fa-check').' '.$count[1].'</span>';
		}
		
		if (!empty($count[0]))
		{
			$output[] = '<span class="text-danger" data-toggle="tooltip" title="'.$this->lang('forbidden_members').'">'.icon('fa-ban').' '.$count[0].'</span>';
		}
		
		if (!$this($module, $action, $id, 'visitors'))
		{
			$output[] = '<span class="text-info" data-toggle="tooltip" title="'.$this->lang('forbidden_guests').'">'.icon('fa-eye-slash').'</span>';
		}
		
		return implode(str_repeat('&nbsp;', 3), $output);
	}

	public function init($module_name, $type = 'default', $id = 0)
	{
		$module = $this->module($module_name);
		$access = $module->get_permissions($type);
		
		if (!empty($access['init']))
		{
			foreach ($access['init'] as $action => $groups)
			{
				$access_id = $this->db->insert('dungeon_access', [
					'module' => $module_name,
					'action' => $action,
					'id'     => $id
				]);
				
				foreach ($groups as $group)
				{
					list($entity, $authorized) = $group;
					
					$this->db->insert('dungeon_access_details', [
						'access_id'  => $access_id,
						'entity'     => $entity,
						'type'       => 'group',
						'authorized' => $authorized
					]);
				}
			}
			
			$this->reload();
		}

		return $this;
	}
	
	public function delete($module, $id = 0)
	{
		$this->db	->where('module', $module)
					->where('id', $id)
					->delete('dungeon_access');

		return $this;
	}

	public function revoke($group_id)
	{
		$this->db	->where('entity', $group_id)
					->where('type', 'group')
					->delete('dungeon_access_details');

		return $this;
	}
	
	public function admin()
	{
		static $allowed;
		
		if ($allowed === NULL)
		{
			$allowed = FALSE;
			
			if ($this->user('admin'))
			{
				$allowed = TRUE;
			}
			else if (isset($this->groups($this->user('user_id'))[1]))
			{
				foreach ($this->addons->get_modules() as $module)
				{
					if ($module->is_authorized())
					{
						$allowed = TRUE;
						break;
					}
				}
			}
		}
		
		return $allowed;
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/core/access.php
*/