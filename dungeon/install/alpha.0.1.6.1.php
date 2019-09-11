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

class i_0_1_6_1 extends Install
{
	public function up()
	{
		foreach ($this->db->from('dungeon_dispositions')->get() as $disposition)
		{
			$this->db	->where('disposition_id', $disposition['disposition_id'])
						->update('dungeon_dispositions', [
							'disposition' => preg_replace_callback('/s:\d+:"((.)\*\2_color)";(.*?;)/', function($a){
								$style = unserialize($a[3]);

								if ($style && !preg_match('/^panel-/', $style))
								{
									$style = 'panel-'.$style;
								}

								return 's:'.strlen($a = $a[2].'*'.$a[2].'_style').':"'.$a.'";'.serialize($style);
							}, $disposition['disposition'])
						]);
		}
	}
}

/*
Dungeon Alpha 0.1.7.7
./dungeon/install/alpha.0.1.6.1.php
*/