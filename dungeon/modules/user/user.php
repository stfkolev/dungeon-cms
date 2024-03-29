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

class m_user extends Module
{
	public $title         = '{lang member_area}';
	public $description   = '';
	public $icon          = 'fa-user';
	public $link          = 'http://www.dungeon.com';
	public $author        = 'Evil <inkyzfx@gmail.com>';
	public $licence       = 'http://www.dungeon.com/license.html LGPLv3';
	public $version       = 'Alpha 0.1.7';
	public $dungeon_version    = 'Alpha 0.1.7';
	public $admin         = FALSE;
	public $routes        = [
		//Index
		'sessions{pages}'                        => 'sessions',
		'sessions/delete/{key_id}'               => '_session_delete',
		'messages{pages}'                        => '_messages_inbox',
		'messages/sent{pages}'                   => '_messages_sent',
		'messages/archives{pages}'               => '_messages_archives',
		'messages/{id}/{url_title}'              => '_messages_read',
		'messages/compose(?:/{id}/{url_title})?' => '_messages_compose',
		'messages/delete/{id}/{url_title}'       => '_messages_delete',
		'lost-password/{key_id}'                 => '_lost_password',
		'auth/{url_title}'                       => '_auth',
		'{id}/{url_title}'                       => '_member',
		'ajax/{id}/{url_title}'                  => '_member',
		
		//Admin
		'admin{pages}'                                   => 'index',
		'admin/{id}/{url_title}'                         => '_edit',
		'admin/ban'                                      => '_ban',
		'admin/ban/{id}/{url_title}'                     => '_ban',
		'admin/groups/add'                               => '_groups_add',
		'admin/groups/edit/(admins|members|visitors)'    => '_groups_edit',
		'admin/groups/edit/{url_title}-{id}/{url_title}' => '_groups_edit',
		'admin/groups/edit/{id}/{url_title}'             => '_groups_edit',
		'admin/groups/delete/{id}/{url_title}'           => '_groups_delete',
		'admin/ajax/groups/sort'                         => '_groups_sort',
		'admin/sessions{pages}'                          => '_sessions',
		'admin/sessions/delete/{url_title}'              => '_sessions_delete'
	];
	public $path          = __FILE__;
}

/*
Dungeon Alpha 0.1.7
./dungeon/modules/user/user.php
*/