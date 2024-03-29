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

class m_access_c_admin extends Controller_Module
{
	public function index($objects, $modules, $tab)
	{
		if (!$modules)
		{
			return $this->panel()
						->heading($this->lang('permissions'), 'fa-unlock-alt')
						->body($this->lang('no_permission'));
		}
		
		$this->js('access');

		foreach ($modules as $module_name => $module)
		{
			list($module, $icon, $type, $all_access) = $module;
			
			$title = $module->get_title();

			$this->tab->add_tab($module_name, icon($icon).' '.$module->get_title(), function() use ($objects, $title, $module, $type, $all_access){
				$this	->subtitle($title)
						->table
						->add_columns([
							[
								'title'   => $this->lang('name'),
								'content' => function($data){
									return $data['title'];
								}
							]
						]);

				foreach ($all_access['access'] as $a)
				{
					foreach ($a['access'] as $action => $access)
					{
						$this	->table
								->add_columns([
									[
										'title'   => '<div class="text-center" data-toggle="tooltip" title="'.$module->lang($access['title'], NULL).'">'.icon($access['icon']).'</div>',
										'content' => function($data) use ($module, $action){
											return Dungeon()->access->count($module->name, $action, $data['id']);
										},
										'class'   => 'col-md-1'
									]
								]);
					}
				}
				
				return $this->table
							->add_columns([
								[
									'content' => [
										function($data) use ($module, $type){
											return $this->button()->tooltip($this->lang('reset'))->icon('fa-refresh')->color('info access-reset')->compact()->outline()->data([
												'module' => $module->name,
												'type'   => $type,
												'id'     => $data['id']
											]);
										},
										function($data) use ($module, $type){
											return $this->button_access($data['id'], $type, $module->name, $this->lang('edit'));
										}
									]
								]
							])
							->data($objects)
							->display();
			});
		}

		return $this->panel()->body($this->tab->display($tab));
	}

	public function _edit($module, $type, $access, $id, $title = NULL)
	{
		$this	->title($module->get_title())
				->subtitle($title ?: $this->lang('permissions_management'))
				->icon($module->icon)
				->css('access')
				->js('access')
				->css('dungeon.table')
				->js('dungeon.table');
		
		return [
			$this->row(
				$this->col(
					$this	->panel()
							->heading($this->lang('permissions_list').'<div class="pull-right">'.$this->button()->tooltip($this->lang('reset_all_permissions'))->icon('fa-refresh')->color('info access-reset')->compact()->outline()->data([
								'module' => $module->name,
								'type'   => $type,
								'id'     => $id
							]).'</div>', 'fa-unlock-alt')
							->body($this->view('index', [
								'loader' => $module->load,
								'module' => $module->name,
								'type'   => $type,
								'id'     => $id,
								'access' => $access
							]))
							->size('col-md-12 col-lg-5')
				)
			),
			$this->panel_back()
		];
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/modules/access/controllers/admin.php
*/