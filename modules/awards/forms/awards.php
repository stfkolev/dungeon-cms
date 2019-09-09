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
	'name' => [
		'label' => 'Event Title',
		'value' => $this->form->value('name'),
		'type'  => 'text',
		'rules' => 'required'
	],
	'location' => [
		'label' => 'Location',
		'icon'  => 'fa-map-marker',
		'value' => $this->form->value('location'),
		'type'  => 'text'
	],
	'date' => [
		'label' => 'Date',
		'value' => $this->form->value('date') ? timetostr($this->lang('date_short'), strtotime($this->form->value('date'))) : '',
		'type'  => 'date',
		'check' => function($value){
			if ($value && strtotime($value) > strtotime(date('Y-m-d')))
			{
				return $this->lang('invalid_birth_date');
			}
		},
		'size'  => 'col-md-3',
		'rules' => 'required'
	],
	'team' => [
		'label'  => 'Team',
		'value'  => $this->form->value('team_id'),
		'values' => $this->form->value('teams'),
		'type'   => 'select',
		'size'   => 'col-md-4',
		'rules'  => 'required'
	],
	'game' => [
		'label'  => 'Game',
		'value'  => $this->form->value('game_id'),
		'values' => $this->form->value('games'),
		'type'   => 'select',
		'size'   => 'col-md-4',
		'rules'  => 'required'
	],
	'platform' => [
		'label'  => 'Platform',
		'icon'   => 'fa-tv',
		'value'  => $this->form->value('platform'),
		'values' => [
			'PC'       => 'PC',
			'PS3'      => 'PS3',
			'PS4'      => 'PS4',
			'Wii'      => 'Wii',
			'Wii U'    => 'Wii U',
			'Xbox 360' => 'Xbox 360',
			'Xbox One' => 'Xbox One',
		],
		'type'   => 'select',
		'size'   => 'col-md-2',
		'rules'  => 'required'
	],
	'ranking' => [
		'label' => 'Ranking',
		'icon'  => 'fa-trophy',
		'value' => $this->form->value('ranking'),
		'type'  => 'number',
		'size'  => 'col-md-2',
		'rules' => 'required'
	],
	'participants' => [
		'label' => 'Participants',
		'icon'  => 'fa-users',
		'value' => $this->form->value('participants'),
		'type'  => 'number',
		'size'  => 'col-md-2',
		'rules' => 'required'
	],
	'description' => [
		'label' => 'Description',
		'value' => $this->form->value('description'),
		'type'  => 'editor'
	],
	'image' => [
		'label'  => 'Image',
		'value'  => $this->form->value('image'),
		'type'   => 'file',
		'upload' => 'awards',
		'info'   => $this->lang('file_picture', file_upload_max_size() / 1024 / 1024),
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
./modules/awards/forms/awards.php
*/