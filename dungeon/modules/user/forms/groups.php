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
		'label' => '{lang name}',
		'value' => $this->form->value('title'),
		'rules' => 'required'.($this->form->value('auto') ? '|disabled' : '')
	],
	'color' => [
		'label' => '{lang color}',
		'value' => $this->form->value('color'),
		'type'  => 'colorpicker'
	],
	'icon' => [
		'label'   => '{lang icon}',
		'value'   => $this->form->value('icon'),
		'default' => 'fa-user',
		'type'    => 'iconpicker'
	],
	'hidden' => [
		'checked' => ['on' => $this->form->value('hidden')],
		'values'  => ['on' => 'Hidden Group'],
		'type'    => 'checkbox'
	]
];

/*
Dungeon Alpha 0.1.6
./dungeon/modules/user/forms/groups.php
*/