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

$rules = [
	'title' => [
		'label'         => '{lang page_title}',
		'value'         => $this->form->value('title'),
		'type'          => 'text',
		'rules'         => 'required'
	],
	'subtitle' => [
		'label'         => '{lang subtitle}',
		'value'         => $this->form->value('subtitle'),
		'type'          => 'text'
	],
	'name' => [
		'label'         => '{lang access_path}',
		'value'         => $name = $this->form->value('name'),
		'type'          => 'text',
		'check'         => function($value, $post) use ($name){
			if (!$value)
			{
				$value = $post['title'];
			}
			
			$value = url_title($value);
			
			if ($value != $name && Dungeon()->db->select('1')->from('dungeon_pages')->where('name', $value)->row())
			{
				return $this->lang('access_path_already_used');
			}
		}
	],
	'content' => [
		'label'			=> '{lang content}',
		'value'			=> $this->form->value('content'),
		'type'			=> 'editor'
	],
	'published' => [
		'type'			=> 'checkbox',
		'checked'		=> ['on' => $this->form->value('published')],
		'values'        => ['on' => '{lang publish_now}']
	]
];

/*
Dungeon Alpha 0.1.7
./dungeon/modules/pages/forms/pages.php
*/