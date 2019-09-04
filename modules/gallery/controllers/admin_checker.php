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

class m_gallery_c_admin_checker extends Controller_Module
{
	public function index($page = '')
	{
		return [$this->pagination->get_data($this->model()->get_gallery(), $page)];
	}
	
	public function _edit($gallery_id, $title)
	{
		if ($gallery = $this->model()->check_gallery($gallery_id, $title, 'default'))
		{
			return $gallery;
		}
	}
	
	public function delete($gallery_id, $title)
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			$this->ajax();
		}

		if ($gallery = $this->model()->check_gallery($gallery_id, $title, 'default'))
		{
			return [$gallery['gallery_id'], $gallery['title']];
		}
	}
	
	public function _categories_edit($category_id, $name)
	{
		if ($category = $this->model()->check_category($category_id, $name, 'default'))
		{
			return $category;
		}
	}
	
	public function _categories_delete($category_id, $name)
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			$this->ajax();
		}

		if ($category = $this->model()->check_category($category_id, $name, 'default'))
		{
			return [$category_id, $category['title']];
		}
	}

	public function _image_edit($image_id, $name)
	{
		if ($image = $this->model()->check_image($image_id, $name))
		{
			return [
				$image_id,
				$image['thumbnail_file_id'],
				$image['title'],
				$image['description'],
				$image['gallery_id'],
				$image['gallery_title']
			];
		}
	}
	
	public function _image_delete($image_id, $name)
	{
		$this->ajax();

		if ($image = $this->model()->check_image($image_id, $name))
		{
			return [$image_id, $image['title']];
		}
	}
}

/*
Dungeon Alpha 0.1.5
./modules/gallery/controllers/admin_checker.php
*/