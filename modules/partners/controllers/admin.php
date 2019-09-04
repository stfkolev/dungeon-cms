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

class m_partners_c_admin extends Controller_Module
{
	public function index()
	{
		$this	->table
				->add_columns([
					[
						'content' => function($data){
							return $this->button_sort($data['partner_id'], 'admin/ajax/partners/sort');
						},
						'size'    => TRUE
					],
					[
						'title'   => 'Nom',
						'content' => function($data){
							return $data['title'];
						}
					],
					[
						'title'   => 'Site internet',
						'content' => function($data){
							return '<a href="'.$data['website'].'" target="_blank">'.$data['website'].'</a>';
						}
					],
					[
						'title'   => '<span data-toggle="tooltip" title="Visites">'.icon('fa-line-chart').'</span>',
						'content' => function($data){
							return $data['count'];
						}
					],
					[
						'content' => [
							function($data){
								return $this->button_update('admin/partners/'.$data['partner_id'].'/'.$data['name']);
							},
							function($data){
								return $this->button_delete('admin/partners/delete/'.$data['partner_id'].'/'.$data['name']);
							}
						],
						'size'    => TRUE
					]
				])
				->data($this->model()->get_partners())
				->no_data('Aucun partenaire');

		return $this->panel()
					->heading('List of partners', 'fa-star-o')
					->body($this->table->display())
					->footer($this->button_create('admin/partners/add', 'Add a partner'));
	}

	public function add()
	{
		$this	->subtitle('Add a partner')
				->form
				->add_rules('partners')
				->add_submit($this->lang('add'))
				->add_back('admin/partners');

		if ($this->form->is_valid($post))
		{
			$this->model()->add_partner($post['title'],
										$post['logo_light'],
										$post['logo_dark'],
										$post['description'],
										$post['website'],
										$post['facebook'],
										$post['twitter'],
										$post['code']);

			notify('The partner was added successfully');

			redirect('admin/partners');
		}

		return $this->panel()
					->heading('Add a partner', 'fa-star-o')
					->body($this->form->display());
	}

	public function _edit($partner_id, $name, $logo_light, $logo_dark, $website, $facebook, $twitter, $count, $code, $title, $description)
	{
		$this	->subtitle($title)
				->form
				->add_rules('partners', [
					'title'       => $title,
					'logo_light'  => $logo_light,
					'logo_dark'   => $logo_dark,
					'description' => $description,
					'website'     => $website,
					'facebook'    => $facebook,
					'twitter'     => $twitter,
					'code'        => $code
				])
				->add_submit($this->lang('edit'))
				->add_back('admin/partners');

		if ($this->form->is_valid($post))
		{
			$this->model()->edit_partner(	$partner_id,
											$post['title'],
											$post['logo_light'],
											$post['logo_dark'],
											$post['description'],
											$post['website'],
											$post['facebook'],
											$post['twitter'],
											$post['code']);

			notify('The partner was modified successfully');

			redirect_back('admin/partners');
		}

		return $this->panel()
					->heading('Edit partner', 'fa-star-o')
					->body($this->form->display());
	}

	public function delete($partner_id, $title)
	{
		$this	->title('Delete partner')
				->subtitle($title)
				->form
				->confirm_deletion($this->lang('delete_confirmation'), 'Are you sure you want to delete the partner <b>'.$title.'</b> ?');

		if ($this->form->is_valid())
		{
			$this->model()->delete_partner($partner_id);

			return 'OK';
		}

		echo $this->form->display();
	}
}

/*
Dungeon Alpha 0.1.6
./modules/partners/controllers/admin.php
*/