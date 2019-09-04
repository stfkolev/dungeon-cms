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
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Dungeon. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

class m_gallery_c_checker extends Controller_Module
{
	public function _gallery($gallery_id, $name, $page = '')
	{
		if ($gallery = $this->model()->check_gallery($gallery_id, $name))
		{
			return [
				$gallery_id,
				$gallery['category_id'],
				$gallery['image_id'],
				$name,
				$gallery['published'],
				$gallery['title'],
				$gallery['description'],
				$gallery['category_name'],
				$gallery['category_title'],
				$gallery['image'],
				$gallery['category_icon'],
				$this->pagination->fix_items_per_page($this->config->forum_messages_per_page)->get_data($this->model()->get_images($gallery_id), $page)
			];
		}
	}
	
	public function _category($category_id, $name)
	{
		if ($category = $this->model()->check_category($category_id, $name))
		{
			return $category;
		}
	}
	
	public function _image($image_id, $name)
	{
		if ($image = $this->model()->check_image($image_id, $name))
		{
			return $image;
		}
	}
}

/*
Dungeon Alpha 0.1
./modules/gallery/controllers/checker.php
*/