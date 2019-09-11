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
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Dungeon. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

class w_dserv_c_index extends Controller_Widget
{
	public function index($settings = array())
	{
		require_once 'widgets/dserv/SourceQuery/SourceQuery.class.php';

		$Query = new SourceQuery;

		$title = $content = '';

		try
		{
			$Query->Connect($settings['addr'], $settings['port'], 1, SourceQuery::SOURCE);

			if ($dservData = $Query->GetInfo())
			{
				$content = $this->view('index', array(
					'dserv_hostname' => $dservData['HostName'],
					'dserv_game'     => $title = $dservData['ModDesc'],
					'dserv_users'    => $dservData['Players'].'/'.$dservData['MaxPlayers'],
					'dserv_vac'      => $dservData['Secure'] ? 'VAC' : 'noVAC',
					'dserv_map'      => $dservData['Map']
				));
			}
			else
			{
				$content = '<h3>Game not supported or the server is offline<h3>';
			}
		}
		catch (Exception $e)
		{
			$content = 'Game not supported or the server is offline';
		}

		$Query->Disconnect();

		return $this->panel()
					->heading($title, 'fa-gamepad')
					->body($content)
					->footer('<a class="btn btn-primary btn-lg btn-block" href="steam://connect/'.$settings['addr'].':'.$settings['port'].'"><i class="fa fa-steam"></i> Connect to the server</a>', 'right');
	}
}

/*
Dungeon Alpha 0.1.7.3
./widgets/dserv/controllers/index.php
*/