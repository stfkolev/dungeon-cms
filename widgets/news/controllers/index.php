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

class w_news_c_index extends Controller_Widget
{
	public function index($config = [])
	{
		$news = array_filter($this->model()->get_news(), function($a){
			return $a['published'];
		});
		
		if (!empty($news))
		{
			return $this->panel()
						->heading($this->lang('recent_news'))
						->body($this->view('index', [
							'news' => array_slice($news, 0, 3)
						]))
						->footer('<a href="'.url('news').'">'.icon('fa-arrow-circle-o-right').' '.$this->lang('show_more').'</a>', 'right');
		}
		else
		{
			return $this->panel()
						->heading($this->lang('recent_news'))
						->body($this->lang('no_news'));
		}
	}
	
	public function categories($config = [])
	{
		$categories = $this->model('categories')->get_categories();
		
		if (!empty($categories))
		{
			return $this->panel()
						->heading($this->lang('categories'))
						->body($this->view('categories', [
							'categories' => $categories
						]), FALSE);
		}
		else
		{
			return $this->panel()
						->heading($this->lang('categories'))
						->body($this->lang('no_category'));
		}
	}
}

/*
Dungeon Alpha 0.1.7
./widgets/news/controllers/index.php
*/