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

class w_html_c_admin extends Controller_Widget
{
	public function index($settings = [])
	{
		return $this->view('bbcode', $settings);
	}
	
	public function html($settings = [])
	{
		return '<textarea class="form-control" name="settings[content]" placeholder="'.$this->lang('html_code').'" rows="6">'.(isset($settings['content']) ? $settings['content'] : '').'</textarea>';
	}
}

/*
Dungeon Alpha 0.1.7.7
./dungeon/widgets/html/controllers/admin.php
*/