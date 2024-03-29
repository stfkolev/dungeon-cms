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

class m_access_c_admin_ajax extends Controller_Module
{
	public function index($action, $title, $icon, $module_name, $id)
	{
		$groups = [];
		
		foreach (array_keys($this->groups()) as $group_id)
		{
			$groups[$group_id] = Dungeon()->access($module_name, $action, $id, $group_id);
		}

		return $this->col(
			$this	->panel()
					->heading('<span class="pull-right">'.$this->button()->tooltip($this->lang('users'))->icon('fa-users')->color('info access-users')->compact()->outline().'</span>'.$title, $icon)
					->body($this->view('details', [
						'groups' => $groups
					]), FALSE)
					->size('col-md-12 col-lg-7')
		);
	}
	
	public function update($module_name, $action, $id, $groups, $user, $title, $icon)
	{
		$output = [];
		
		if ($groups)
		{
			$count      = array_count_values($groups);
			$authorized = isset($count[0]) ? $count[0] >= $count[1] : 0;
			
			$this->model()	->delete($module_name, $action, $id, 'group')
							->add($module_name, $action, $id, 'group', array_keys(array_filter($groups, function($a) use ($authorized){
								return $a == $authorized;
							})), $authorized);
		}
		else if ($user)
		{
			$this->model()->delete($module_name, $action, $id, 'user', $user_id = array_keys($user)[0]);
			
			if (($authorized = current($user)) != -1)
			{
				$this->model()->add($module_name, $action, $id, 'user', $user_id, $authorized);
			}
		}
		
		$this->access->reload();
		
		if ($groups)
		{
			$output['details'] = display($this->index($action, $title, $icon, $module_name, $id));
		}
		else if ($user)
		{
			$output['user_authorized'] = $authorized = $this->access($module_name, $action, $id, NULL, $user_id);
			$output['user_forced']     = is_int($authorized);
		}
		
		$output['count'] = $this->access->count($module_name, $action, $id);
		
		return $output;
	}
	
	public function users($action, $title, $icon, $module_name, $id)
	{
		$this	->table
				->add_columns([
						[
						'title'   => $this->lang('member'),
						'content' => function($data){
							return Dungeon()->user->link($data['user_id'], $data['username']).'<span data-user-id="'.$data['user_id'].'"></span>';
						},
						'sort'    => function($data){
							return $data['username'];
						},
						'search'  => function($data){
							return $data['username'];
						}
					],
					[
						'title'   => $this->lang('groups'),
						'content' => function($data){
							return Dungeon()->groups->user_groups($data['user_id']);
						},
						'sort'    => function($data){
							return Dungeon()->groups->user_groups($data['user_id'], FALSE);
						},
						'search'  => function($data){
							return Dungeon()->groups->user_groups($data['user_id'], FALSE);
						}
					],
					[
						'content' => function($data){
							$output = '';
							
							if (is_int($data['active']))
							{
								$output = '<a class="access-revoke" href="#" data-toggle="tooltip" title="'.$this->lang('reset_automatic').'">'.icon('fa-thumb-tack').'</a>';
							}
							
							return '<td class="access-status">'.$output.'</td>';
						},
						'sort'    => function($data){
							return $data['active'] === NULL;
						},
						'size'    => TRUE,
						'td'      => FALSE
					],
					[
						'title'   => '<div class="text-center" data-toggle="tooltip" title="'.$this->lang('authorized_member').'">'.icon('fa-check').'</i></div>',
						'content' => function($data){
							return $this->view('radio', [
								'class'  => 'success',
								'active' => $data['active']
							]);
						},
						'td'      => FALSE
					],
					[
						'title'   => '<div class="text-center" data-toggle="tooltip" title="'.$this->lang('forbidden_member').'">'.icon('fa-ban').'</i></div>',
						'content' => function($data){
							static $admins;
							
							if ($admins === NULL)
							{
								$admins = Dungeon()->groups()['admins']['users'];
							}
							
							return in_array($data['user_id'], $admins) ? '<td></td>' : $this->view('radio', [
								'class'  => 'danger',
								'active' => !$data['active'] && $data['active'] !== NULL
							]);
						},
						'td'      => FALSE
					]
				])
				->data($this->db->select('user_id', 'username')->from('dungeon_users')->where('deleted', FALSE)->get())
				->preprocessing(function($row) use ($module_name, $action, $id){
					$row['active'] = Dungeon()->access($module_name, $action, $id, NULL, $row['user_id']);
					return $row;
				})
				->sort_by(3, SORT_DESC)
				->sort_by(2, SORT_ASC)
				->sort_by(1, SORT_ASC);

		return $this->view('users', [
			'title' => $title,
			'icon'  => $icon,
			'users' => $this->table->display()
		]);
	}
	
	public function reset($module, $type, $id)
	{
		$this->access	->delete($module, $id)
						->init($module, $type, $id);
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/modules/access/controllers/admin_ajax.php
*/