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

class w_talks_c_index extends Controller_Widget
{
	public function index($settings = [])
	{
		if (!$this->access('talks', 'read', $settings['talk_id']))
		{
			return;
		}

		$this	->js('talks')
				->css('talks')
				->js('jquery.mCustomScrollbar.min')
				->css('jquery.mCustomScrollbar.min');

		$panel = $this	->panel()
						->body('<div data-talk-id="'.$settings['talk_id'].'">'.$this->view('index', [
							'messages' => $this->model()->get_messages($settings['talk_id'])
						]).'</div>');

		if ($this->access('talks', 'write', $settings['talk_id']))
		{
			$panel->footer('<form>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="'.$this->lang('your_message').'" />
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">'.icon('fa-check').'</button>
									</span>
								</div>
							</form>');
		}

		return $panel;
	}
}

/*
Dungeon Alpha 0.1.7
./widgets/talks/controllers/index.php
*/