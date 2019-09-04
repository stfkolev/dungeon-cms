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

class m_pages_m_pages extends Model
{
	public function get_pages()
	{
		return $this->db->select('p.page_id', 'p.name', 'p.published', 'pl.title', 'pl.subtitle')
						->from('dungeon_pages p')
						->join('dungeon_pages_lang pl', 'p.page_id = pl.page_id')
						->where('pl.lang', $this->config->lang)
						->order_by('pl.title ASC')
						->get();
	}
	
	public function check_page($page_id, $title, $lang = 'default', $all = FALSE)
	{
		if ($lang == 'default')
		{
			$lang = $this->config->lang;
		}

		$this->db	->select('p.*', 'pl.title', 'pl.subtitle', 'pl.content')
					->from('dungeon_pages p')
					->join('dungeon_pages_lang pl', 'p.page_id = pl.page_id')
					->where('p.page_id', $page_id);
		
		if (!$all)
		{
			$this->db->where('p.published', TRUE);
		}
							
		$page = $this->db	->where('pl.lang', $lang)
							->row();

		if ($page && url_title($page['title']) == $title)
		{
			return $page;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function add_page($name, $title, $published, $subtitle, $content)
	{
		$page_id = $this->db->insert('dungeon_pages', [
			'name'           => $name ?: url_title($title),
			'published'      => $published
		]);

		$this->db->insert('dungeon_pages_lang', [
			'page_id'        => $page_id,
			'lang'           => $this->config->lang,
			'title'          => $title,
			'subtitle'       => $subtitle,
			'content'        => $content
		]);
	}

	public function edit_page($page_id, $name, $title, $published, $subtitle, $content, $lang)
	{
		if ($this->db	->select('1')
						->from('dungeon_pages p')
						->join('dungeon_pages_lang l', 'p.page_id = l.page_id')
						->where('p.page_id', $page_id)
						->where('l.lang', $lang)
						->row())
		{
			$this->db	->where('page_id', $page_id)
						->where('lang', $lang)
						->update('dungeon_pages_lang', [
							'title'    => $title,
							'subtitle' => $subtitle,
							'content'  => $content
						]);
						
			$this->db	->where('page_id', $page_id)
						->update('dungeon_pages', [
							'name'           => $name ?: url_title($title),
							'published'      => $published
						]);
		}
		else
		{
			$this->db	->insert('dungeon_pages_lang', [
							'page_id'  => $page_id,
							'lang'     => $lang,
							'title'    => $title,
							'subtitle' => $subtitle,
							'content'  => $content
						]);

			$this->db	->where('page_id', $page_id)
						->update('dungeon_pages', [
							'name'           => $name ?: url_title($title),
							'published'      => $published
						]);
		}
	}
	
	public function delete_page($page_id)
	{
		$this->db	->where('page_id', $page_id)
					->delete('dungeon_pages');
	}
}

/*
Dungeon Alpha 0.1.5
./dungeon/modules/pages/models/pages.php
*/