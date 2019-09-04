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
		'label'       => 'Name',
		'value'       => $this->form->value('title'),
		'type'        => 'text',
		'rules'       => 'required',
		'size'        => 'col-md-6'
	],
	'logo_light'      => [
		'label'       => 'Light logo',
		'value'       => $this->form->value('logo_light'),
		'type'        => 'file',
		'upload'      => 'partners',
		'info'        => $this->lang('file_picture', file_upload_max_size() / 1024 / 1024),
		'check'       => function($filename, $ext){
			if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
			{
				return $this->lang('select_image_file');
			}
		},
		'description' => 'To be displayed on a dark background <i>(following the current theme)</i>'
	],
	'logo_dark' => [
		'label'       => 'Dark Logo',
		'value'       => $this->form->value('logo_dark'),
		'type'        => 'file',
		'upload'      => 'partners',
		'info'        => $this->lang('file_picture', file_upload_max_size() / 1024 / 1024),
		'check'       => function($filename, $ext){
			if (!in_array($ext, ['gif', 'jpeg', 'jpg', 'png']))
			{
				return $this->lang('select_image_file');
			}
		},
		'description' => 'To be displayed on a light background <i>(following the current theme)</i>'
	],
	'description' => [
		'label'       => 'Présentation',
		'value'       => $this->form->value('description'),
		'type'        => 'editor'
	],
	'website' => [
		'label'       => 'Website',
		'icon'        => 'fa-globe',
		'value'       => $this->form->value('website'),
		'type'        => 'url',
		'rules'       => 'required',
		'size'        => 'col-md-5'
	],
	'facebook' => [
		'label'       => 'Facebook Page',
		'icon'        => 'fa-facebook',
		'value'       => $this->form->value('facebook'),
		'type'        => 'url',
		'size'        => 'col-md-5'
	],
	'twitter' => [
		'label'       => 'Twitter Page',
		'icon'        => 'fa-twitter',
		'value'       => $this->form->value('twitter'),
		'type'        => 'url',
		'size'        => 'col-md-5'
	],
	'code' => [
		'label'       => 'Promotional code',
		'icon'        => 'fa-gift',
		'value'       => $this->form->value('code'),
		'type'        => 'text',
		'description' => 'Indicate the promotional code your users can use to take advantage of promotions through your partner',
		'size'        => 'col-md-3'
	],
];

/*
Dungeon Alpha 0.1.6
./modules/partners/forms/partners.php
*/