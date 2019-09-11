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

class m_access_m_access extends Model
{
	public function add($module, $action, $id, $type, $entities, $authorized)
	{
		if (!($access_id = $this->db->select('access_id')->from('dungeon_access')->where('module', $module)->where('action', $action)->where('id', $id)->row()))
		{
			$access_id = $this->db->insert('dungeon_access', [
				'module' => $module,
				'action' => $action,
				'id'     => $id
			]);
		}
		
		foreach ((array)$entities as $entity)
		{
			$this->db->insert('dungeon_access_details', [
				'access_id'  => $access_id,
				'entity'     => $entity,
				'type'       => $type,
				'authorized' => $authorized
			]);
		}
		
		return $this;
	}
	
	public function delete($module, $action, $id, $type = NULL, $entity = NULL)
	{
		if ($type)
		{
			$this->db->where('ad.type', $type);
			
			if ($entity)
			{
				$this->db->where('ad.entity', $entity);
			}
		}
		
		$this->db	->where('a.module', $module)
					->where('a.action', $action)
					->where('a.id', $id)
					->delete('ad', 'dungeon_access_details ad INNER JOIN dungeon_access a ON a.access_id = ad.access_id');
					
		return $this;
	}
}

/*
Dungeon Alpha 0.1.7.5
./dungeon/modules/access/models/access.php
*/