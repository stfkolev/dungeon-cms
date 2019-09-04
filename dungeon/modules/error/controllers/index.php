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

class m_error_c_index extends Controller_Module
{
	public function index()
	{
		header('HTTP/1.0 404 Not Found');

		$this->title($this->lang('unfound'));

		return [
			$this	->panel()
					->heading($this->lang('unfound'), 'fa-warning')
					->body($this->lang('page_unfound'))
					->color('danger'),
			$this->panel_back()
		];
	}

	public function unauthorized()
	{
		header('HTTP/1.0 401 Unauthorized');

		$this->title($this->lang('unauthorized'));

		return [
			$this	->panel()
					->heading($this->lang('unauthorized'), 'fa-warning')
					->body($this->lang('required_permissions'))
					->color('danger'),
			$this->panel_back()
		];
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/modules/error/controllers/index.php
*/