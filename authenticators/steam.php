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

class a_steam extends Authenticator
{
	protected $_keys = ['key'];

	public $title = 'Steam';
	public $color = '#171a21';
	public $icon  = 'fa-steam';
	public $help  = 'http://steamcommunity.com/dev/apikey';

	public function config()
	{
		return [
			'applicationId'     => $this->_settings['key'],
			'applicationSecret' => ''
		];
	}

	public function data(&$params = [])
	{
		if (!empty($_GET['openid_sig']))
		{
			$params = $_GET;

			return function($data){
				return [
					'id'            => $data->steamid,
					'username'      => $data->personaname,
					'email'         => '',
					'first_name'    => '',
					'last_name'     => '',
					'date_of_birth' => '',
					'sex'           => '',
					'language'      => strtolower($data->loccountrycode),
					'location'      => '',
					'signature'     => '',
					'website'       => '',
					'avatar'        => $data->avatarfull
				];
			};
		}
	}

	protected function _params()
	{
		return [
			'domain' => $_SERVER['HTTP_HOST']
		];
	}
}

/*
Dungeon Alpha 0.1.6
./authenticators/steam.php
*/