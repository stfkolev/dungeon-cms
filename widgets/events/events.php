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

class w_events extends Widget
{
	public $title       = 'Événements';
	public $description = '';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1.4';
	public $dungeon_version  = 'Alpha 0.1.4';
	public $path        = __FILE__;
	public $types       = [
		'index'       => 'Calendrier des événements',
		'types'       => 'Liste des types d\'événements',
		'events'      => 'Liste des événements',
		'event'       => 'Un événement en détail',
		'matches'     => 'Derniers résultats',
		'upcoming'    => 'Prochains matchs'
	];
}

/*
Dungeon Alpha 0.1.6
./widgets/events/events.php
*/