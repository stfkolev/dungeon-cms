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

class m_news extends Module
{
	public $title       = '{lang news}';
	public $description = '';
	public $icon        = 'fa-file-text-o';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1.7';
	public $dungeon_version  = 'Alpha 0.1.7';
	public $path        = __FILE__;
	public $admin       = TRUE;
	public $routes      = [
		//Index
		'{page}'                                   => 'index',
		'{id}/{url_title}'                         => '_news',
		'tag/{url_title}{pages}'                   => '_tag',
		'category/{id}/{url_title}{pages}'         => '_category',

		//Admin
		'admin{pages}'                             => 'index',
		'admin/{id}/{url_title}'                   => '_edit',
		'admin/categories/add'                     => '_categories_add',
		'admin/categories/{id}/{url_title}'        => '_categories_edit',
		'admin/categories/delete/{id}/{url_title}' => '_categories_delete'
	];

	public static function permissions()
	{
		return [
			'default' => [
				'access'  => [
					[
						'title'  => 'News',
						'icon'   => 'file-text-o',
						'access' => [
							'add_news' => [
								'title' => 'Add',
								'icon'  => 'fa-plus',
								'admin' => TRUE
							],
							'modify_news' => [
								'title' => 'Modify',
								'icon'  => 'fa-edit',
								'admin' => TRUE
							],
							'delete_news' => [
								'title' => 'Delete',
								'icon'  => 'fa-trash-o',
								'admin' => TRUE
							]
						]
					],
					[
						'title'  => 'Categories',
						'icon'   => 'fa-align-left',
						'access' => [
							'add_news_category' => [
								'title' => 'Add category',
								'icon'  => 'fa-plus',
								'admin' => TRUE
							],
							'modify_news_category' => [
								'title' => 'Modify category',
								'icon'  => 'fa-edit',
								'admin' => TRUE
							],
							'delete_news_category' => [
								'title' => 'Delete category',
								'icon'  => 'fa-trash-o',
								'admin' => TRUE
							]
						]
					]
				]
			]
		];
	}

	public function comments($news_id)
	{
		$news = $this->db	->select('title')
							->from('dungeon_news_lang')
							->where('news_id', $news_id)
							->where('lang', $this->config->lang)
							->row();

		if ($news)
		{
			return [
				'title' => $news,
				'url'   => 'news/'.$news_id.'/'.url_title($news)
			];
		}
	}
	
	public function settings()
	{
		$this	->form
				->add_rules([
					'news_per_page' => [
						'label' => '{lang news_per_page}',
						'value' => $this->config->news_per_page,
						'type'  => 'number',
						'rules' => 'required'
					]
				])
				->add_submit($this->lang('edit'))
				->add_back('admin/addons#modules');

		if ($this->form->is_valid($post))
		{
			$this->config('news_per_page', $post['news_per_page']);
			
			redirect_back('admin/addons#modules');
		}

		return $this->panel()->body($this->form->display());
	}
}

/*
Dungeon Alpha 0.1.7
./modules/news/news.php
*/