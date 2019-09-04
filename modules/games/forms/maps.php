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
	'game_id' => [
		'label'  => 'Jeu',
		'value'  => $this->form->value('game_id'),
		'values' => $this->form->value('games'),
		'type'   => 'select',
		'rules'  => 'required'
	],
	'title' => [
		'label' => 'Nom de la carte',
		'value' => $this->form->value('title'),
		'type'  => 'text',
		'rules' => 'required'
	],
	'image' => [
		'label' => 'Image',
		'value' => $this->form->value('image_id'),
		'upload'=> 'games/maps',
		'type'  => 'file',
		'info'  => $this->lang('file_picture', file_upload_max_size() / 1024 / 1024),
		'check'  => function($filename, $ext){
			if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
			{
				return $this->lang('select_image_file');
			}
		}
	]
];

/*
Dungeon Alpha 0.1.6
./modules/games/forms/maps.php
*/