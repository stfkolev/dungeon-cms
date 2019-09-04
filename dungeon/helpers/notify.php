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

function notify($message, $type = 'success')
{
	if (!in_array($type, array_keys(get_colors())))
	{
		$type = 'success';
	}

	Dungeon()->session->add('notifications', [
		'message' => $message,
		'type'    => $type
	]);
}

function notifications()
{
	if ($notifications = Dungeon()->session('notifications'))
	{
		foreach ($notifications as $notification)
		{
			Dungeon()->js_load('notify(\''.$notification['message'].'\', \''.$notification['type'].'\');');
		}

		Dungeon()->session->destroy('notifications');
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/helpers/notify.php
*/