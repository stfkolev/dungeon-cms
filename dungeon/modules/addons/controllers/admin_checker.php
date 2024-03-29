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

class m_addons_c_admin_checker extends Controller_Module
{
	public function _module_settings($name)
	{
		if (($module = $this->module($name)) && method_exists($module, 'settings'))
		{
			return [$module];
		}
	}

	public function _module_delete($name)
	{
		$this->ajax();

		if (($module = $this->module($name)) && $module->is_removable())
		{
			return [$module];
		}
	}

	public function _theme_settings($name)
	{
		if (($theme = $this->theme($name)) && ($controller = $theme->controller('admin')) && $controller->has_method('index'))
		{
			return [$theme, $controller];
		}
	}

	public function _theme_delete($name)
	{
		$this->ajax();

		if (($theme = $this->theme($name)) && $theme->is_removable())
		{
			return [$theme];
		}
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/modules/addons/controllers/admin_checker.php
*/