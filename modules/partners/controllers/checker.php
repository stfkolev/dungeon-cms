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

class m_partners_c_checker extends Controller_Module
{
	public function _partner($partner_id, $name)
	{
		if ($partner = $this->model()->check_partner($partner_id, $name))
		{
			$this->db	->where('partner_id', $partner_id)
						->update('dungeon_partners', [
							'count' => $partner['count'] + 1
						]);

			header('Location: '.$partner['website']);
			exit;
		}
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/partners/controllers/checker.php
*/