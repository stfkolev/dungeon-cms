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

class w_partners_c_index extends Controller_Widget
{
	public function index($settings = [])
	{
		$this->js('partners');
		
		$partners = $this->model()->get_partners();

		if (!empty($partners))
		{
			$total_partners = count($partners);

			return $this->panel()->body($this->view('index', [
				'partners'       => $partners,
				'total_partners' => $total_partners,
				'total_slides'   => ceil($total_partners / $settings['display_number']),
				'display_style'  => $settings['display_style'],
				'display_number' => $settings['display_number'],
				'display_height' => $settings['display_height'],
				'id'             => $settings['id']
			]), FALSE);
		}
	}

	public function column($settings = [])
	{
		$this	->css('partners')
				->js('partners');

		$partners = $this->model()->get_partners();

		if (!empty($partners))
		{
			return $this->panel()
						->heading('Partners')
						->body($this->view('column', [
							'partners'      => $partners,
							'display_style' => $settings['display_style']
						]));
		}
	}
}

/*
Dungeon Alpha 0.1.6
./widgets/partners/controllers/index.php
*/