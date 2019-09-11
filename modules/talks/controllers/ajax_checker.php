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

class m_talks_c_ajax_checker extends Controller_Module
{
	public function index()
	{
		if ($check = post_check('talk_id', 'message_id'))
		{
			if ($this->access('talks', 'read', $check['talk_id']))
			{
				return $check;
			}
			
			throw new Exception(Dungeon::UNAUTHORIZED);
		}
	}
	
	public function older()
	{
		if ($check = post_check('talk_id', 'message_id', 'position'))
		{
			if ($this->access('talks', 'read', $check['talk_id']))
			{
				return $check;
			}
			
			throw new Exception(Dungeon::UNAUTHORIZED);
		}
	}
	
	public function add_message()
	{
		if ($check = post_check('talk_id', 'message'))
		{
			if ($this->access('talks', 'write', $check['talk_id']))
			{
				return $check;
			}
			
			throw new Exception(Dungeon::UNAUTHORIZED);
		}
	}

	public function delete($message_id)
	{
		$this->ajax();

		$message = $this->db	->select('user_id', 'talk_id')
								->from('dungeon_talks_messages')
								->where('message_id', (int)$message_id)
								->row();
		
		if ($message)
		{
			if ($this->access('talks', 'delete', $message['talk_id']) || ($this->user() && $message['user_id'] == $this->user('user_id')))
			{
				return [$message_id, $message['talk_id']];
			}
			
			throw new Exception(Dungeon::UNAUTHORIZED);
		}
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/talks/controllers/ajax_checker.php
*/