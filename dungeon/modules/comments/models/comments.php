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

class m_comments_m_comments extends Model
{
	private $_modules = [];

	public function get_comments()
	{
		$comments =  $this->db	->select('module_id', 'module', 'count(*) as count')
												->from('dungeon_comments')
												->group_by('module_id', 'module')
												->get();
												
		if ($comments)
		{
			$list = [];

			foreach ($comments as $comment)
			{
				if ($tmp = $this->check_comment($comment['module'], $comment['module_id']))
				{
					$list[] = array_merge($comment, $tmp);
				}
			}
			
			return $list;
		}
		else
		{
			return [];
		}
	}

	public function check_comment($module_name, $module_id)
	{
		if (isset($this->_modules[$module_name]))
		{
			$module = $this->_modules[$module_name];
		}
		else
		{
			$this->_modules[$module_name] = $module = $this->module($module_name);
		}

		if (method_exists($module, 'comments'))
		{
			$comment = $module->comments($module_id);
			
			$comment['module_title'] = $module->get_title();
			$comment['icon']         = $module->icon;

			return $comment;
		}
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/modules/comments/models/comments.php
*/