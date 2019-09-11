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
	'team_id' => [
		'label'       => 'Associate with the team',
		'value'       => $this->form->value('team_id'),
		'values'      => $this->form->value('teams'),
		'type'        => 'select',
		'size'        => 'col-md-4',
		'description' => 'Leave empty to not associate team.<br />If an application is accepted, the player will be automatically added to the selected team with the associated role'
	],
	'role' => [
		'label'       => 'Position',
		'value'       => $this->form->value('role'),
		'type'        => 'text',
		'icon'        => 'fa-sitemap',
		'description' => 'Example: Development, Server Manager, etc...',
		'size'        => 'col-md-4',
		'rules'       => 'required'
	],
	'icon' => [
		'label'       => 'Icon',
		'value'       => $this->form->value('icon'),
		'default'     => 'fa-bullhorn',
		'type'        => 'iconpicker'
	],
	'size' => [
		'label'       => 'Available spots',
		'value'       => $this->form->value('size') ?: '1',
		'type'        => 'number',
		'size'        => 'col-md-2',
		'rules'       => 'required'
	],
	'date_end' => [
		'label'       => 'Deadline',
		'value'       => $this->form->value('date_end'),
		'type'        => 'date',
		'check'       => function($value){
			if ($value && strtotime($value) < strtotime(date('Y-m-d')))
			{
				return 'Really ?! 2.1 Gigwatt !';
			}
		},
		'size'        => 'col-md-4',
		'description' => 'Leave empty to create a permanent offer'
	],
	'image' => [
		'label'       => 'Image',
		'value'       => $this->form->value('image_id'),
		'type'        => 'file',
		'upload'      => 'news',
		'info'        => ' image (max. '.(file_upload_max_size() / 1024 / 1024).' MB)',
		'check'       => function($filename, $ext){
			if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
			{
				return 'Please choose an image file';
			}
		}
	],
	'introduction' => [
		'label'       => 'Introduction',
		'value'       => $this->form->value('introduction'),
		'type'        => 'editor',
		'rules'       => 'required'
	],
	'description' => [
		'label'       => 'Description',
		'value'       => $this->form->value('description'),
		'type'        => 'editor'
	],
	'requierments' => [
		'label'       => 'Requirements',
		'value'       => $this->form->value('requierments'),
		'type'        => 'editor'
	],
	'closed' => [
		'type'        => 'checkbox',
		'checked'     => ['on' => $this->form->value('closed')],
		'values'      => ['on' => 'Close the submission of applications']
	]
];

/*
Dungeon Alpha 0.1.7.7
./modules/recruits/forms/recruit.php
*/