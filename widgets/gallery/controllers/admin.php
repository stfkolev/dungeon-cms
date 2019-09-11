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

class w_gallery_c_admin extends Controller
{
	public function albums($settings = [])
	{
		return $this->view('admin_gallery', [
			'category_id' => isset($settings['category_id']) ? $settings['category_id'] : 0,
			'categories'  => $this->model()->get_categories(),
		]);
	}
	
	public function image($settings = [])
	{
		return $this->view('admin_image', [
			'gallery_id' => isset($settings['gallery_id']) ? $settings['gallery_id'] : 0,
			'gallery'    => $this->model()->get_gallery(),
		]);
	}
	
	public function slider($settings = [])
	{
		return $this->view('admin_slider', [
			'gallery_id' => isset($settings['gallery_id']) ? $settings['gallery_id'] : 0,
			'gallery'    => $this->model()->get_gallery(),
		]);
	}
}

/*
Dungeon Alpha 0.1.7.7
./widgets/gallery/controllers/admin.php
*/