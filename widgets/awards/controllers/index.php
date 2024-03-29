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

class w_awards_c_index extends Controller_Widget
{
	public function index($settings = [])
	{
		if ($awards = $this->model()->get_awards())
		{
			$this->css('awards');

			return $this->panel()
						->heading('All our awards')
						->body($this->view('index', [
							'awards' => array_slice($awards, 0, 5)
						]), FALSE)
						->footer('<a href="'.url('awards').'">'.icon('fa-arrow-circle-o-right').' All our awards</a>', 'right');
		}
		else
		{
			return $this->panel()
						->heading('Awards')
						->body('No awards at the moment...');
		}
	}
	
	public function best_team($settings = [])
	{
		if ($best_team = $this->model()->get_best_team_awards())
		{
			return $this->panel()
						->heading('Awards')
						->body($this->view('best_team', [
							'team_id'    => $best_team[0]['team_id'],
							'name'       => $best_team[0]['name'],
							'team_title' => $best_team[0]['team_title'],
							'nb_awards'  => $best_team[0]['nb_awards']
						]))
						->footer('<a href="'.url('awards').'">'.icon('fa-arrow-circle-o-right').' All our awards</a>', 'right');
		}
		else
		{
			return $this->panel()
						->heading('Awards')
						->body('No awards at the moment...');
		}
	}
	
	public function best_game($settings = [])
	{
		if ($best_game = $this->model()->get_best_game_awards())
		{
			return $this->panel()
						->heading('Awards')
						->body($this->view('best_game', [
							'game_id'    => $best_game[0]['game_id'],
							'name'       => $best_game[0]['name'],
							'game_title' => $best_game[0]['game_title'],
							'nb_awards'  => $best_game[0]['nb_awards']
						]))
						->footer('<a href="'.url('awards').'">'.icon('fa-arrow-circle-o-right').' All our awards</a>', 'right');
		}
		else
		{
			return $this->panel()
						->heading('Awards')
						->body('No awards at the moment...');
		}
	}
}

/*
Dungeon Alpha 0.1.7
./widgets/awards/controllers/index.php
*/