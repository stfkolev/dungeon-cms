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

class m_user_m_messages extends Model
{
	public function get_messages_inbox($box = 'inbox')
	{
		$inbox = [];
		
		if ($box == 'inbox' || $box == 'archives')
		{
			$this->db->having('SUM(IF(mr2.user_id <> '.$this->user('user_id').', 1, 0))');
		}
		else if ($box == 'sent')
		{
			$this->db->having('SUM(IF(mr2.user_id = '.$this->user('user_id').', 1, 0)) = COUNT(mr2.user_id)');
		}

		$messages = $this->db	->select('m.message_id', 'm.title', 'UNIX_TIMESTAMP(mr.date) as date')
								->from('dungeon_users_messages            m')
								->join('dungeon_users_messages_recipients r',   'r.message_id   = m.message_id'.($box != 'sent' ? ' AND r.deleted = "'.(int)($box == 'archives').'"' : ''), 'INNER')
								->join('dungeon_users_messages_replies    mr',  'mr.reply_id    = m.last_reply_id')
								->join('dungeon_users_messages_replies    mr2', 'mr2.message_id = m.message_id', 'INNER')
								->where('r.user_id', $this->user('user_id'))
								->group_by('m.message_id')
								->get();
		
		foreach ($messages as $message)
		{
			if ($box == 'inbox')
			{
				$message['unread'] = (bool)$this->db->select('1')
													->from('dungeon_users_messages_recipients r')
													->where('r.message_id', $message['message_id'])
													->where('r.user_id', $this->user('user_id'))
													->where('r.date', NULL, 'OR', 'UNIX_TIMESTAMP(r.date) <', $message['date'])
													->row();
			}
			else
			{
				$message['unread'] = FALSE;
			}
			
			$last_message = $this->db	->select('UNIX_TIMESTAMP(date) as date')
										->from('dungeon_users_messages_replies')
										->where('message_id', $message['message_id'])
										->order_by('reply_id DESC')
										->limit(1)
										->row(FALSE);
			
			if ($box == 'sent')
			{
				$last_user = $this->db	->select('r.user_id', 'u.username', 'up.avatar', 'up.sex')
										->from('dungeon_users_messages_recipients r')
										->join('dungeon_users                     u',  'r.user_id = u.user_id')
										->join('dungeon_users_profiles            up', 'r.user_id = up.user_id')
										->where('u.user_id <>', $this->user('user_id'))
										->where('r.message_id', $message['message_id'])
										->order_by('u.username')
										->limit(1)
										->row();
			}
			else
			{
				$last_user = $this->db	->select('mr.user_id', 'u.username', 'up.avatar', 'up.sex')
										->from('dungeon_users_messages_replies mr')
										->join('dungeon_users                  u',  'mr.user_id = u.user_id')
										->join('dungeon_users_profiles         up', 'mr.user_id = up.user_id')
										->where('u.user_id <>', $this->user('user_id'))
										->where('mr.message_id', $message['message_id'])
										->order_by('mr.reply_id DESC')
										->limit(1)
										->row();
			}
			
			$inbox[] = array_merge($message, $last_message, $last_user);
		}
		
		usort($inbox, function($a, $b){
			if ($a['unread'] == $b['unread'])
			{
				return $a['date'] < $b['date'];
			}
			
			return strcmp($b['unread'], $a['unread']);
		});

		return $inbox;
	}

	public function get_message($message_id, $title)
	{
		return $this->db->select('m.message_id', 'm.title')
						->from('dungeon_users_messages            m')
						->join('dungeon_users_messages_recipients r',  'r.message_id  = m.message_id', 'INNER')
						->where('m.message_id', $message_id)
						->where('r.user_id', $this->user('user_id'))
						->row();
	}

	public function get_replies($message_id)
	{
		$this->db	->where('message_id', $message_id)
					->where('user_id', $this->user('user_id'))
					->update('dungeon_users_messages_recipients', [
						'date' => now()
					]);

		return $this->db->select('mr.reply_id', 'mr.message_id', 'mr.message', 'UNIX_TIMESTAMP(mr.date) as date', 'mr.user_id', 'u.username', 'up.avatar', 'up.sex')
						->from('dungeon_users_messages_replies mr')
						->join('dungeon_users_messages         m',  'mr.message_id = m.message_id')
						->join('dungeon_users                  u',  'mr.user_id    = u.user_id')
						->join('dungeon_users_profiles         up', 'mr.user_id    = up.user_id')
						->where('m.message_id', $message_id)
						->order_by('mr.date ASC')
						->get();
	}

	public function reply($message_id, $message)
	{
		$reply_id = $this->db->insert('dungeon_users_messages_replies', [
			'message_id' => $message_id,
			'user_id'    => $this->user('user_id'),
			'message'    => $message
		]);

		$this->db	->where('message_id', $message_id)
					->update('dungeon_users_messages', [
						'last_reply_id' => $reply_id
					]);

		$this->db	->where('message_id', $message_id)
					->update('dungeon_users_messages_recipients', [
						'deleted' => FALSE
					]);
	}

	public function insert_message($recipients, $title, $message, $auto = FALSE)
	{
		$recipients = array_diff(array_unique(array_map(function($a){
			return (int)$this->db->select('user_id')->from('dungeon_users')->where('deleted', FALSE)->where('username', $a)->row();
		}, explode(';', $recipients)), SORT_NUMERIC), [$user_id = $this->user('user_id')]);

		if ($recipients)
		{
			$message_id = $this->db	->ignore_foreign_keys()
									->insert('dungeon_users_messages', [
										'title' => $title
									]);

			$reply_id = $this->db	->insert('dungeon_users_messages_replies', [
										'message_id' => $message_id,
										'user_id'  => $author_id = $auto ? $this->config->dungeon_welcome_user_id : $this->user('user_id'),
										'message'  => $message
									]);
		
			$this->db	->where('message_id', $message_id)
						->update('dungeon_users_messages', [
							'reply_id'      => $reply_id,
							'last_reply_id' => $reply_id
						]);

			$recipients[] = $author_id;

			foreach ($recipients as $recipient)
			{
				$this->db->insert('dungeon_users_messages_recipients', [
					'user_id'    => $recipient,
					'message_id' => $message_id,
					'date'       => $recipient == $author_id ? now() : NULL
				]);
			}

			return $message_id;
		}
		else
		{
			return FALSE;
		}
	}
}

/*
Dungeon Alpha 0.1.5
./dungeon/modules/user/models/messages.php
*/