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
		'label'       => 'Title',
		'value'       => $this->form->value('title'),
		'type'        => 'text',
		'rules'       => 'required'
	],
	'type' => [
		'label'       => 'Type',
		'values'      => array_map(function($a){
			return $a['title'];
		}, $this->model('types')->get_types()),
		'value'       => $this->form->value('type_id'),
		'type'        => 'select',
		'size'        => 'col-md-3',
		'rules'       => 'required'
	],
	'date' => [
		'label'       => 'Start Date',
		'value'       => $this->form->value('date'),
		'type'        => 'datetime',
		'size'        => 'col-md-3',
		'rules'       => 'required'
	],
	'date_end' => [
		'label'       => 'End date',
		'value'       => $this->form->value('date_end'),
		'type'        => 'datetime',
		'size'        => 'col-md-3',
		'description' => 'Leave blank to indicate no duration'
	],
	'description' => [
		'label'       => 'Description',
		'value'       => $this->form->value('description'),
		'type'        => 'editor'
	],
	'private_description' => [
		'label'       => 'Private Description',
		'value'       => $this->form->value('private_description'),
		'type'        => 'editor',
		'description' => 'Only visible to participants'
	],
	'location' => [
		'label'       => 'Location',
		'value'       => $this->form->value('location'),
		'type'        => 'textarea',
		'description' => 'Only visible to participants'
	],
	'image' => [
		'label'       => 'Image',
		'value'       => $this->form->value('image_id'),
		'type'        => 'file',
		'upload'      => 'events',
		'info'        => $this->lang('file_picture', file_upload_max_size() / 1024 / 1024),
		'check'       => function($filename, $ext){
			if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
			{
				return $this->lang('select_image_file');
			}
		}
	],
	'published' => [
		'type'        => 'checkbox',
		'checked'     => ['on' => $this->form->value('published')],
		'values'      => ['on' => 'Publish']
	]
];

/*
Dungeon Alpha 0.1.6
./modules/events/forms/events.php
*/