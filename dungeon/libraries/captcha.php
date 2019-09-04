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

class Captcha extends Library
{
	public function is_ok()
	{
		return $this->config->dungeon_captcha_public_key && $this->config->dungeon_captcha_private_key;
	}

	public function is_valid()
	{
		if ($response = post('g-recaptcha-response'))
		{
			return !empty($this->network('https://www.google.com/recaptcha/api/siteverify')->get([
				'secret'   => $this->config->dungeon_captcha_private_key,
				'response' => $response,
				'remoteip' => $_SERVER['REMOTE_ADDR']
			])->success);
		}

		return FALSE;
	}

	public function display()
	{
		return '<div class="g-recaptcha" data-sitekey="'.$this->config->dungeon_captcha_public_key.'"></div>';
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/libraries/captcha.php
*/