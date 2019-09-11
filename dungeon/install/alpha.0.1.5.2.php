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

class i_0_1_5_2 extends Install
{
	public function up()
	{
		$this->db	->execute('ALTER TABLE `dungeon_sessions_history` CHANGE `user_agent` `user_agent` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL')
					->config('dungeon_cookie_name', 'session')
					->delete('dungeon_sessions');
	}
}

/*
Dungeon Alpha 0.1.7.5.2
./dungeon/install/alpha.0.1.5.2.php
*/