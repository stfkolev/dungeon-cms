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
 
class m_forum_c_checker extends Controller
{
	public function _forum($forum_id, $title, $page = '')
	{
		if (($forum = $this->model()->check_forum($forum_id, $title)) !== FALSE)
		{
			if ($this->access('forum', 'category_read', $forum['category_id']))
			{
				if ($forum['url'] !== NULL)
				{
					header('Location: '.$forum['url']);
					$this->model()->increment_redirect($forum_id);
					exit;
				}
				else
				{
					$announces = $messages = [];
					
					foreach ($this->model()->get_topics($forum_id) as $topic)
					{
						if ($topic['announce'])
						{
							$announces[] = $topic;
						}
						else
						{
							$messages[] = $topic;
						}
					}
					
					return [
						$forum_id,
						$title,
						$forum['category_id'],
						$forum['subforums'] ? $this->model()->get_forums($forum_id) : [],
						$announces,
						$this->pagination->fix_items_per_page($this->config->forum_topics_per_page)->get_data($messages, $page)
					];
				}
			}
			else
			{
				throw new Exception(Dungeon::UNAUTHORIZED);
			}
		}
	}
	
	public function _new($forum_id, $title)
	{
		if (($forum = $this->model()->check_forum($forum_id, $title)) !== FALSE && $forum['url'] === NULL)
		{
			if ($this->access('forum', 'category_write', $forum['category_id']))
			{
				return [$forum_id, $title, $forum['category_id']];
			}
			else
			{
				throw new Exception(Dungeon::UNAUTHORIZED);
			}
		}
	}
	
	public function _topic($topic_id, $title, $page = '')
	{
		if ($topic = $this->model()->check_topic($topic_id, $title))
		{
			if ($this->access('forum', 'category_read', $topic['category_id']))
			{
				return [
					$topic_id,
					$title,
					$topic['forum_id'],
					$topic['title'],
					$topic['category_id'],
					$topic['views'],
					count(array_unique(array_map(function($a){ return $a['user_id']; }, $messages = $this->model()->get_messages($topic_id, $topic['forum_id'])))),
					count($messages) - 1,
					$topic['announce'],
					$topic['locked'],
					array_shift($messages),
					$this->pagination->fix_items_per_page($this->config->forum_messages_per_page)->get_data($messages, $page)
				];
			}
			else
			{
				throw new Exception(Dungeon::UNAUTHORIZED);
			}
		}
	}
	
	public function _topic_announce($topic_id, $title, $permission = 'category_announce')
	{
		if ($topic = $this->model()->check_topic($topic_id, $title))
		{
			if ($this->access('forum', $permission, $topic['category_id']))
			{
				return [$topic_id, $topic['topic_title'], $topic['announce'], $topic['locked']];
			}
			else
			{
				throw new Exception(Dungeon::UNAUTHORIZED);
			}
		}
	}
	
	public function _topic_lock($topic_id, $title)
	{
		return $this->_topic_announce($topic_id, $title, 'category_lock');
	}
	
	public function _topic_move($topic_id, $title)
	{
		if ($topic = $this->model()->check_topic($topic_id, $title))
		{
			if ($this->access('forum', 'category_move', $topic['category_id']))
			{
				return [$topic_id, $topic['topic_title'], $topic['forum_id']];
			}
			else
			{
				throw new Exception(Dungeon::UNAUTHORIZED);
			}
		}
	}
	
	public function _message_edit($message_id, $title)
	{
		if ($message = $this->model()->check_message($message_id, $title))
		{
			if ($this->access('forum', 'category_modify', $message['category_id']) || (!$message['locked'] && $this->user() && $message['user_id'] == $this->user('user_id')))
			{
				return $message;
			}
			else
			{
				throw new Exception(Dungeon::UNAUTHORIZED);
			}
		}
	}
	
	public function _message_delete($message_id, $title)
	{
		$this->ajax();

		$message = $this->db	->select('m.user_id', 'f.forum_id', 'f.parent_id as category_id', 't.topic_id', 't.title', 't.message_id = m.message_id as is_topic')
								->from('dungeon_forum_messages m')
								->join('dungeon_forum_topics t', 'm.topic_id = t.topic_id')
								->join('dungeon_forum        f', 't.forum_id = f.forum_id')
								->where('m.message_id', (int)$message_id)
								->row();
		
		if ($message && $title == url_title($message['title']))
		{
			if ($this->access('forum', 'category_delete', $message['category_id']) || ($this->user() && $message['user_id'] == $this->user('user_id')))
			{
				return [$message_id, $message['title'], $message['topic_id'], $message['forum_id'], $message['is_topic']];
			}
			
			throw new Exception(Dungeon::UNAUTHORIZED);
		}
	}
	
	public function mark_all_as_read()
	{
		if (!$this->user())
		{
			throw new Exception(Dungeon::UNAUTHORIZED);
		}

		return [];
	}
	
	public function _mark_all_as_read($forum_id, $title)
	{
		if (($forum = $this->model()->check_forum($forum_id, $title)) !== FALSE && $forum['url'] === NULL)
		{
			if ($this->user() && $this->access('forum', 'category_read', $forum['category_id']))
			{
				return [$forum_id, $title];
			}
			else
			{
				throw new Exception(Dungeon::UNAUTHORIZED);
			}
		}
	}
}

/*
Dungeon Alpha 0.1.7.5
./modules/forum/controllers/checker.php
*/