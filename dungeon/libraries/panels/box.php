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

class Panel_Box extends Panel
{
	protected $_color;

	public function __toString()
	{
		$this->css('dungeon.panel-box');

		return '<div class="small-box '.$this->_color.'">
					<div class="inner">
						<h3>'.$this->_body.'</h3>
						<p>'.$this->_heading[0]->title().'</p>
					</div>
					<div class="icon">'.$this->_heading[0]->icon().'</div>
					<a class="small-box-footer" href="'.$this->_heading[0]->url().'">
						'.$this->_footer[0]->title().'
					</a>
				</div>';
	}

	public function color($color)
	{
		$this->_color = $color;
		return $this;
	}

}

/*
Dungeon Alpha 0.1.6.1
./dungeon/libraries/panels/box.php
*/