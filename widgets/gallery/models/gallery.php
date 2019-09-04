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

class w_gallery_m_gallery extends Model
{
	public function get_gallery($category_id = FALSE)
	{
		$this->db	->select('g.*', 'gl.title', 'gl.description', 'g.image_id as image', 'COUNT(DISTINCT gi.image_id) as images')
					->from('dungeon_gallery g')
					->join('dungeon_gallery_lang gl',            'g.gallery_id  = gl.gallery_id')
					->join('dungeon_gallery_images gi',          'g.gallery_id  = gi.gallery_id')
					->where('gl.lang', $this->config->lang)
					->where('g.published', TRUE)
					->group_by('g.gallery_id')
					->order_by('g.gallery_id DESC');
		
		if (!empty($category_id))
		{
			$this->db->where('g.category_id', $category_id);
		}
		
		return $this->db->get();
	}
	
	public function get_random_image($gallery_id = FALSE)
	{
		$this->db	->from('dungeon_gallery_images')
					->order_by('RAND()')
					->limit(1);
					
		if (!empty($gallery_id) || ($gallery_id > 0))
		{
			$this->db->where('gallery_id', $gallery_id);
		}
		
		return $this->db->row();
	}
	
	public function get_images($gallery_id)
	{
		return $this->db->from('dungeon_gallery_images')
						->where('gallery_id', $gallery_id)
						->order_by('date DESC')
						->get();
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
}

/*
Dungeon Alpha 0.1.3
./widgets/gallery/models/gallery.php
*/