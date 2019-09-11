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

class m_news_c_search extends Controller
{
	public function index($result, $keywords)
	{
		$result['introduction'] = highlight($result['introduction']."\r\r".$result['content'], $keywords);
		return $this->view('search/index', $result);
	}

	public function detail($result, $keywords)
	{
		$result['introduction'] = highlight($result['introduction']."\r\r".$result['content'], $keywords, 1024);
		return $this->view('search/index', $result);
	}

	public function search()
	{
		$this->db	->select('n.news_id', 'n.date', 'nl.title', 'nl.introduction', 'nl.content', 'u.user_id', 'u.username', 'c.category_id', 'cl.title as category')
					->from('dungeon_news n')
					->join('dungeon_news_lang nl',            'n.news_id     = nl.news_id')
					->join('dungeon_news_categories c',       'n.category_id = c.category_id')
					->join('dungeon_news_categories_lang cl', 'c.category_id = cl.category_id')
					->join('dungeon_users u',                 'n.user_id     = u.user_id AND u.deleted = "0"')
					->where('nl.lang', $this->config->lang)
					->where('cl.lang', $this->config->lang)
					->where('n.published', TRUE)
					->order_by('n.date DESC');

		return ['nl.title', 'nl.introduction', 'nl.content'];
	}
}

/*
Dungeon Alpha 0.1.7
./modules/news/controllers/search.php
*/