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

class m_talks_c_ajax extends Controller_Module
{
	public function index($talk_id, $message_id)
	{
		echo $this->view('index', [
			'messages' => $this->model()->get_messages($talk_id, $message_id)
		]);
	}
	
	public function older($talk_id, $message_id, $position)
	{
		echo $this->view('index', [
			'position' => $position,
			'user_id'  => $this->db->select('user_id')->from('dungeon_talks_messages')->where('message_id', $message_id)->row(),
			'messages' => $this->model()->get_messages($talk_id, $message_id, TRUE)
		]);
	}
	
	public function add_message($talk_id, $message)
	{
		if ($message = trim($message))
		{
			$this->db->insert('dungeon_talks_messages', [
				'talk_id' => $talk_id,
				'user_id' => $this->user('user_id'),
				'message' => utf8_htmlentities($message)
			]);
		}
	}
	
	public function delete($message_id, $talk_id)
	{
		$this	->title($this->lang('delete_confirmation'))
				->form
				->confirm_deletion($this->lang('delete_confirmation'), $this->lang('delete_message_ajax'));

		if ($this->form->is_valid())
		{
			if ($this->db->select('message_id')->from('dungeon_talks_messages')->where('talk_id', $talk_id)->order_by('message_id DESC')->limit(1)->row() == $message_id)
			{
				$this->db	->where('message_id', $message_id)
							->delete('dungeon_talks_messages');
			}
			else
			{
				$this->db	->where('message_id', $message_id)
							->update('dungeon_talks_messages', [
								'message' => NULL
							]);
			}

			return 'OK';
		}

		echo $this->form->display();
	}
}

/*
Dungeon Alpha 0.1.7
./modules/talks/controllers/ajax.php
*/