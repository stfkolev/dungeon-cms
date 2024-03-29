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

class m_talks_c_admin extends Controller_Module
{
	public function index($talks)
	{
		$this	->table
				->add_columns([
					[
						'title'   => $this->lang('talks'),
						'content' => function($data){
							return $data['name'];
						},
						'sort'    => function($data){
							return $data['name'];
						},
						'search'  => function($data){
							return $data['name'];
						}
					],
					[
						'content' => [
							function($data){
								if ($data['talk_id'] > 1)
								{
									return $this->button_access($data['talk_id'], 'talk');
								}
							},
							function($data){
								if ($data['talk_id'] > 1)
								{
									return $this->button_update('admin/talks/'.$data['talk_id'].'/'.url_title($data['name']));
								}
							},
							function($data){
								if ($data['talk_id'] > 1)
								{
									return $this->button_delete('admin/talks/delete/'.$data['talk_id'].'/'.url_title($data['name']));
								}
							}
						],
						'size'    => TRUE
					]
				])
				->data($talks)
				->no_data($this->lang('no_talks'));
						
		return $this->panel()
					->heading($this->lang('talks_list'), 'fa-comment-o')
					->body($this->table->display())
					->footer($this->button_create('admin/talks/add', $this->lang('create_talk')));
	}
	
	public function add()
	{
		$this	->subtitle($this->lang('add_talk'))
				->form
				->add_rules('talks')
				->add_submit($this->lang('add'))
				->add_back('admin/talks');

		if ($this->form->is_valid($post))
		{
			$this->model()->add_talk($post['title']);
			
			notify($this->lang('add_success_message'));

			redirect_back('admin/talks');
		}
		
		return $this->panel()
					->heading($this->lang('add_talk'), 'fa-comment-o')
					->body($this->form->display());
	}

	public function _edit($talk_id, $title)
	{
		$this	->subtitle($title)
				->form
				->add_rules('talks', [
					'title' => $title
				])
				->add_submit($this->lang('edit'))
				->add_back('admin/talks');
		
		if ($this->form->is_valid($post))
		{	
			$this->model()->edit_talk($talk_id, $post['title']);
		
			notify($this->lang('edit_success_message'));

			redirect_back('admin/talks');
		}
		
		return $this->panel()
					->heading($this->lang('edit_talk'), 'fa-comment-o')
					->body($this->form->display());
	}
	
	public function delete($talk_id, $title)
	{
		$this	->title($this->lang('delete_talk_title'))
				->subtitle($title)
				->form
				->confirm_deletion($this->lang('delete_confirmation'), $this->lang('delete_talk', $title));

		if ($this->form->is_valid())
		{
			$this->model()->delete_talk($talk_id);

			return 'OK';
		}

		echo $this->form->display();
	}
}

/*
Dungeon Alpha 0.1.7
./modules/talks/controllers/admin.php
*/