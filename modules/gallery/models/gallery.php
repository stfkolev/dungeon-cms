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

class m_gallery_m_gallery extends Model
{
	public function get_gallery($category_id = FALSE)
	{
		$this->db	->select('g.*', 'gl.title', 'gl.description', 'g.image_id as image', 'c.icon_id as category_icon', 'c.name as category_name', 'cl.title as category_title', 'COUNT(DISTINCT gi.image_id) as images')
					->from('dungeon_gallery g')
					->join('dungeon_gallery_lang gl',            'g.gallery_id  = gl.gallery_id')
					->join('dungeon_gallery_categories c',       'g.category_id = c.category_id')
					->join('dungeon_gallery_categories_lang cl', 'c.category_id = cl.category_id')
					->join('dungeon_gallery_images gi',          'g.gallery_id  = gi.gallery_id')
					->where('gl.lang', $this->config->lang)
					->where('cl.lang', $this->config->lang)
					->group_by('g.gallery_id')
					->order_by('g.gallery_id DESC');
		
		if (!empty($category_id))
		{
			$this->db->where('g.category_id', $category_id);
		}
		
		if (!$this->url->admin)
		{
			$this->db->where('g.published', TRUE);
		}
		
		return $this->db->get();
	}
	
	public function check_gallery($gallery_id, $name, $lang = 'default')
	{
		if ($lang == 'default')
		{
			$lang = $this->config->lang;
		}

		$this->db	->select('g.*', 'gl.title', 'gl.description', 'c.name as category_name', 'cl.title as category_title', 'g.image_id as image', 'c.icon_id as category_icon')
					->from('dungeon_gallery g')
					->join('dungeon_gallery_lang gl',            'g.gallery_id  = gl.gallery_id')
					->join('dungeon_gallery_categories c',       'g.category_id = c.category_id')
					->join('dungeon_gallery_categories_lang cl', 'c.category_id = cl.category_id')
					->where('g.gallery_id', $gallery_id)
					->where('g.name', $name)
					->where('gl.lang', $lang)
					->where('cl.lang', $lang);
		
		if (!$this->url->admin)
		{
			$this->db->where('g.published', TRUE);
		}
		
		if ($gallery = $this->db->row())
		{
			return $gallery;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function add_gallery($title, $category_id, $image_id, $description, $published)
	{
		$gallery_id = 	$this->db->insert('dungeon_gallery', [
							'category_id' => $category_id,
							'image_id'    => $image_id,
							'name'        => url_title($title),
							'published'   => $published
						]);

		$this->db	->insert('dungeon_gallery_lang', [
						'gallery_id'  => $gallery_id,
						'lang'        => $this->config->lang,
						'title'       => $title,
						'description' => $description
					]);
					
		return $gallery_id;
	}
	
	public function edit_gallery($gallery_id, $category_id, $image_id, $published, $title, $description, $lang)
	{
		$this->db	->where('gallery_id', $gallery_id)
					->update('dungeon_gallery', [
						'category_id' => $category_id,
						'image_id'    => $image_id,
						'name'        => url_title($title),
						'published'   => $published
					]);

		$this->db	->where('gallery_id', $gallery_id)
					->where('lang', $lang)
					->update('dungeon_gallery_lang', [
						'title'       => $title,
						'description' => $description
					]);
	}
	
	public function delete_gallery($gallery_id)
	{
		$this->file->delete($this->db->select('image_id')->from('dungeon_gallery')->where('gallery_id', $gallery_id)->row());
		
		foreach ($this->db->select('image_id')->from('dungeon_gallery_images')->where('gallery_id', $gallery_id)->get() as $image_id)
		{
			$this->delete_image($image_id);
		}

		$this->db	->where('gallery_id', $gallery_id)
					->delete('dungeon_gallery');
	}
	
	public function get_images($gallery_id)
	{
		return $this->db->from('dungeon_gallery_images')
						->where('gallery_id', $gallery_id)
						->order_by('date DESC')
						->get();
	}
	
	public function check_image($image_id, $name)
	{
		$this->db	->select('i.*', 'g.name as gallery_name', 'gl.title as gallery_title', 'g.published')
					->from('dungeon_gallery_images i')
					->join('dungeon_gallery g', 'i.gallery_id  = g.gallery_id')
					->join('dungeon_gallery_lang gl', 'i.gallery_id  = gl.gallery_id')
					->where('i.image_id', $image_id);
		
		$image = $this->db->row();

		if ($image && url_title($image['title']) == $name)
		{
			return $image;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function add_image($file_id, $gallery_id, $title, $description = '')
	{
		$file = $this->db	->select('name', 'path')
							->from('dungeon_files')
							->where('file_id', $file_id)
							->row();
		
		dir_create('upload/gallery/thumbnails', 'upload/gallery/originals');
		
		copy($file['path'], $thumbnail = str_replace('upload/gallery/', 'upload/gallery/thumbnails/', $file['path']));
		copy($file['path'], $original  = str_replace('upload/gallery/', 'upload/gallery/originals/', $file['path']));
		
		list($thumbnail_width, $thumbnail_height, $thumbnail_type, $thumbnail_attr) = getimagesize($thumbnail);
		
		image_resize($thumbnail, 300);
		image_resize($file['path'], 1250);
		
		$title = empty($title) ? $file['name'] : $title;
		
		$this->db->insert('dungeon_gallery_images', [
			'thumbnail_file_id' => $this->file->add($thumbnail, $title),
			'original_file_id'  => $this->file->add($original, $title),
			'file_id'           => $file_id,
			'gallery_id'        => $gallery_id,
			'title'             => $title,
			'description'       => $description
		]);
	}
	
	public function edit_image($image_id, $title, $description)
	{
		$this->db	->where('image_id', $image_id)
					->update('dungeon_gallery_images', [
						'title'       => $title,
						'description' => $description
					]);
	}
	
	public function delete_image($image_id)
	{
		$this->file->delete($this->db->select('file_id', 'thumbnail_file_id', 'original_file_id')->from('dungeon_gallery_images')->where('image_id', $image_id)->row());
	}
	
	public function check_category($category_id, $name, $lang = 'default')
	{
		if ($lang == 'default')
		{
			$lang = $this->config->lang;
		}
		
		return $this->db->select('c.category_id', 'c.name', 'cl.title', 'c.image_id', 'c.icon_id')
						->from('dungeon_gallery_categories c')
						->join('dungeon_gallery_categories_lang cl', 'c.category_id = cl.category_id')
						->where('c.category_id', $category_id)
						->where('c.name', $name)
						->where('cl.lang', $lang)
						->row();
	}

	public function get_categories()
	{
		return $this->db->select('c.category_id', 'c.image_id', 'c.icon_id', 'c.name', 'cl.title', 'COUNT(g.gallery_id) as nb_gallery')
						->from('dungeon_gallery_categories c')
						->join('dungeon_gallery_categories_lang cl', 'c.category_id = cl.category_id')
						->join('dungeon_gallery g', 'c.category_id = g.category_id')
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
		$category_id = $this->db->insert('dungeon_gallery_categories', [
			'name'        => url_title($title),
			'image_id'    => $image,
			'icon_id'     => $icon
		]);

		$this->db->insert('dungeon_gallery_categories_lang', [
			'category_id' => $category_id,
			'lang'        => $this->config->lang,
			'title'       => $title
		]);
	}

	public function edit_category($category_id, $title, $image_id, $icon_id)
	{
		$this->db	->where('category_id', $category_id)
					->update('dungeon_gallery_categories', [
						'image_id' => $image_id,
						'icon_id'  => $icon_id,
						'name'     => url_title($title)
					]);

		$this->db	->where('category_id', $category_id)
					->where('lang', $this->config->lang)
					->update('dungeon_gallery_categories_lang', [
						'title' => $title
					]);
	}
	
	public function delete_category($category_id)
	{
		$this->file->delete($this->db->select('image_id')->from('dungeon_gallery_categories')->where('category_id', $category_id)->row());
		
		foreach ($this->db->select('gallery_id')->from('dungeon_gallery')->where('category_id', $category_id)->get() as $gallery_id)
		{
			$this->delete_gallery($gallery_id);
		}
		
		$this->db	->where('category_id', $category_id)
					->delete('dungeon_gallery_categories');
	}
}

/*
Dungeon Alpha 0.1.7
./modules/gallery/models/gallery.php
*/