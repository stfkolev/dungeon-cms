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

class m_live_editor_c_index extends Controller_Module
{
	public function index()
	{
		$this	->css('font.open-sans.300.400.600.700.800')
				->css('live-editor')
				->js('live-editor');

		$modules = [];
		
		foreach ($this->addons->get_modules() as $module)
		{
			if ($module->controller('index') && !in_array($module->name, ['live_editor', 'pages']))
			{
				$modules[$module->name] = $module->get_title();
			}
		}
		
		array_natsort($modules);
		
		$modules = array_merge([
			'index' => Dungeon()->lang('home')
		], $modules);

		echo $this->view('index', [
			'modules'       => $modules,
			'styles_row'    => Dungeon()->theme->styles_row(),
			'styles_widget' => Dungeon()->theme->styles_widget()
		]);
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/modules/live_editor/controllers/index.php
*/