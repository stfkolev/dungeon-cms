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

class m_news_m_categories extends Model
{
	public function check_category($category_id, $name, $lang = 'default')
	{
		if ($lang == 'default')
		{
			$lang = $this->config->lang;
		}
		
		return $this->db->select('c.category_id', 'cl.title', 'c.image_id', 'c.icon_id')
						->from('dungeon_news_categories c')
						->join('dungeon_news_categories_lang cl', 'c.category_id = cl.category_id')
						->where('c.category_id', $category_id)
						->where('c.name', $name)
						->where('cl.lang', $lang)
						->row();
	}

	public function get_categories()
	{
		return $this->db->select('c.category_id', 'c.icon_id', 'c.name', 'cl.title', 'COUNT(n.news_id) as nb_news')
						->from('dungeon_news_categories c')
						->join('dungeon_news_categories_lang cl', 'c.category_id = cl.category_id')
						->join('dungeon_news n', 'c.category_id = n.category_id')
						->where('cl.lang', $this->config->lang)
						->group_by('c.category_id')
						->order_by('cl.title')
						->get();
	}

	public function get_categories_list()
	{
		$list = [];

		foreach ($this->get_categories() as $category)
		{
			$list[$category['category_id']] = $category['title'];
		}

		array_natsort($list);

		return $list;
	}
	
	public function add_category($title, $image, $icon)
	{
		$category_id = $this->db->insert('dungeon_news_categories', [
			'name'        => url_title($title),
			'image_id'    => $image,
			'icon_id'     => $icon
		]);

		$this->db->insert('dungeon_news_categories_lang', [
			'category_id' => $category_id,
			'lang'        => $this->config->lang,
			'title'       => $title
		]);
	}

	public function edit_category($category_id, $title, $image_id, $icon_id)
	{
		$this->db	->where('category_id', $category_id)
					->update('dungeon_news_categories', [
						'image_id' => $image_id,
						'icon_id'  => $icon_id,
						'name'     => url_title($title)
					]);

		$this->db	->where('category_id', $category_id)
					->where('lang', $this->config->lang)
					->update('dungeon_news_categories_lang', [
						'title'        => $title
					]);
	}
	
	public function delete_category($category_id)
	{
		$this->file->delete(array_merge(
			array_values($this->db->select('image_id', 'icon_id')->from('dungeon_news_categories')->where('category_id', $category_id)->row()),
			$this->db->select('image_id')->from('dungeon_news')->where('category_id', $category_id)->get()
		));
		
		$this->db	->where('category_id', $category_id)
					->delete('dungeon_news_categories');
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/news/models/categories.php
*/