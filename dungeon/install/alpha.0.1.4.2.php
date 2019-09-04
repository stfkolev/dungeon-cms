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

class i_0_1_4_2 extends Install
{
	public function up()
	{
		$this	->config('dungeon_captcha_private_key', '', 'string')
				->config('dungeon_captcha_public_key', '', 'string')
				->config('dungeon_email_password', '', 'string')
				->config('dungeon_email_port', '25', 'int')
				->config('dungeon_email_secure', '', 'string')
				->config('dungeon_email_smtp', '', 'string')
				->config('dungeon_email_username', '', 'string')
				->config('dungeon_registration_charte', '', 'string')
				->config('dungeon_registration_status', '0', 'string')
				->config('dungeon_social_behance', '', 'string')
				->config('dungeon_social_deviantart', '', 'string')
				->config('dungeon_social_dribble', '', 'string')
				->config('dungeon_social_facebook', '', 'string')
				->config('dungeon_social_flickr', '', 'string')
				->config('dungeon_social_github', '', 'string')
				->config('dungeon_social_google', '', 'string')
				->config('dungeon_social_instagram', '', 'string')
				->config('dungeon_social_steam', '', 'string')
				->config('dungeon_social_twitch', '', 'string')
				->config('dungeon_social_twitter', '', 'string')
				->config('dungeon_social_youtube', '', 'string')
				->config('dungeon_team_biographie', '', 'string')
				->config('dungeon_team_creation', '', 'string')
				->config('dungeon_team_name', '', 'string')
				->config('dungeon_team_type', '', 'string')
				->config('dungeon_welcome', '0', 'bool')
				->config('dungeon_welcome_content', '', 'string')
				->config('dungeon_welcome_title', '', 'string')
				->config('dungeon_welcome_user_id', '0', 'int');
	}
}

/*
Dungeon Alpha 0.1.5
./dungeon/install/alpha.0.1.4.2.php
*/