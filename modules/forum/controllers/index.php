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

class m_forum_c_index extends Controller_Module
{
	public function index()
	{
		$panels = [];
		
		foreach ($this->model()->get_categories() as $category)
		{
			$panels[] = $this->panel()->body($this->view('index', $category), FALSE);
		}
		
		if (empty($panels))
		{
			$panels[] = $this	->panel()
								->heading($this->lang('forum'), 'fa-comments')
								->body('<div class="text-center">'.$this->lang('no_forum').'</div>')
								->color('info');
		}
		
		if ($this->user())
		{
			$actions = $this->panel()
							->body('<a class="btn btn-default" href="'.url('forum/mark-all-as-read').'" data-toggle="tooltip" title="'.$this->lang('mark_all_as_read').'">'.icon('fa-eye').'</a>', FALSE)
							->color('back text-right');

			array_unshift($panels, $panels[] = $actions);
		}

		return $panels;
	}
	
	public function _forum($forum_id, $title, $category_id, $subforums, $announces, $topics)
	{
		$this	->title($title)
				->_breadcrumb($category_id, $forum_id);
		
		$panels = [];
		
		if (!empty($subforums))
		{
			$panels[] = $this	->panel()
								->body($this->view('index', [
									'title'  => $this->lang('subforums'),
									'forums' => $subforums
								]), FALSE);
		}
		
		if (!empty($announces))
		{
			$panels[] = $this	->panel()
								->body($this->view('forum', [
									'title'  => $this->lang('announces'),
									'icon'   => 'fa-flag',
									'topics' => $announces
								]), FALSE);
		}
		
		$panels[] = $this	->panel()
							->body($this->view('forum', [
								'title'  => $title,
								'icon'   => 'fa-navicon',
								'topics' => $topics
							]), FALSE);
		
		$content = '<a class="btn btn-default" href="'.url(($this->session->get_back() ?: 'forum')).'">'.$this->lang('back').'</a>';
		
		if ($pagination = $this->pagination->get_pagination())
		{
			$content .= $pagination;
		}
		
		if ($this->access('forum', 'category_write', $category_id))
		{
			$content .= '<a class="pull-right btn btn-primary" href="'.url('forum/new/'.$forum_id.'/'.url_title($title)).'">'.$this->lang('new_topic').'</a>';
		}

		if ($this->user())
		{
			$content .= '<a class="pull-right btn btn-default" href="'.url('forum/mark-all-as-read/'.$forum_id.'/'.url_title($title)).'" data-toggle="tooltip" title="'.$this->lang('mark_all_as_read').'">'.icon('fa-eye').'</a>';
		}

		array_unshift($panels, $panels[] = $this->panel()
												->body($content, FALSE)
												->color('back'));
		
		return $panels;
	}
	
	public function _new($forum_id, $title, $category_id)
	{
		$this	->title($this->lang('new_topic'))
				->_breadcrumb($category_id, $forum_id)
				->breadcrumb()
				->css('wbbtheme')
				->js('jquery.wysibb.min')
				->js_load('$(\'textarea.editor\').wysibb();')
				->form
				->add_rules([
					'title' => [
						'rules' => 'required'
					],
					'message' => [
						'type'  => 'editor',
						'rules' => 'required'
					]
				]);
		
		if ($this->access('forum', 'category_announce', $category_id))
		{
			$this->form->add_rules([
				'announce' => [
					'type' => 'checkbox'
				]
			]);
		}

		if ($this->form->is_valid($post))
		{
			$topic_id = $this->model()->add_topic(	$forum_id,
													$post['title'],
													$post['message'],
													!empty($post['announce']) && in_array('on', $post['announce']));

			notify('Topic posted');

			redirect('forum/topic/'.$topic_id.'/'.url_title($post['title']));
		}
		
		$panels = [];
		
		if ($errors = $this->form->get_errors())
		{
			$panels[] = $this->row($this->col(
				$this	->panel()
						->heading($this->lang('fill_all_fields'), 'fa-warning')
						->color('danger')
			));
		}
		
		$panels[] = $this	->panel()
							->heading($this->lang('new_topic'), 'fa-file-text-o')
							->body($this->view('new', [
								'form_id'     => $this->form->token(),
								'post'        => $post,
								'forum_id'    => $forum_id,
								'category_id' => $category_id,
								'title'       => $title
							]), FALSE);
		
		return $panels;
	}
	
	public function _topic($topic_id, $title, $forum_id, $forum_title, $category_id, $views, $nb_users, $nb_messages, $is_announce, $is_locked, $topic, $messages)
	{
		$this	->title($title)
				->_breadcrumb($category_id, $forum_id)
				->breadcrumb()
				->js('dungeon.delete');
		
		$last_message_read = NULL;
		
		$is_last_page = $nb_messages <= $this->pagination->get_items_per_page() || $this->pagination->get_page() == ceil($nb_messages / $this->pagination->get_items_per_page());
		
		if ($this->user())
		{
			$last_message_date = $messages ? end($messages)['date'] : $topic['date'];
			$last_message_read = $this->db->select('UNIX_TIMESTAMP(date)')->from('dungeon_forum_topics_read')->where('user_id', $this->user('user_id'))->where('topic_id', $topic_id)->row();
			
			$forum_read = $this->db	->select('MAX(UNIX_TIMESTAMP(date))')
									->from('dungeon_forum_read')
									->where('user_id', $this->user('user_id'))
									->where('forum_id', [0, $forum_id])
									->row();
			
			if ($forum_read && $last_message_read)
			{
				$last_message_read = max($last_message_read, $forum_read);
			}
			else if ($forum_read)
			{
				$last_message_read = $forum_read;
			}
			
			if (empty($last_message_read) || $last_message_read < $last_message_date)
			{
				$this->db	->where('topic_id', $topic_id)
							->where('user_id', $this->user('user_id'))
							->delete('dungeon_forum_topics_read');
				
				$this->db->insert('dungeon_forum_topics_read', [
					'user_id'  => $this->user('user_id'),
					'topic_id' => $topic_id,
					'date'     => date('Y-m-d H:i:s', $last_message_date)
				]);
				
				$this->db	->where('topic_id', $topic_id)
							->update('dungeon_forum_topics', 'views = views + 1');
				
				if ($is_last_page)
				{
					$this->model()->get_topics($forum_id);
				}
			}
		}
		
		$content = '<a class="btn btn-default" href="'.url($this->session->get_back() ?: 'forum/'.$forum_id.'/'.url_title($forum_title)).'">'.$this->lang('back').'</a>';
		
		if ($pagination = $this->pagination->get_pagination())
		{
			$content .= $pagination;
		}
		
		if (!$is_locked && $this->access('forum', 'category_write', $category_id))
		{
			$page = '';
		
			if ($nb_messages > $this->pagination->get_items_per_page() && $this->pagination->get_page() != ($last_page = ceil($nb_messages / $this->pagination->get_items_per_page())))
			{
				$page = url('forum/topic/'.$topic_id.'/'.url_title($title).'/page/'.$last_page);
			}
			
			$content .= '<a class="pull-right btn btn-primary" href="'.$page.'#reply">'.$this->lang('reply').'</a>';
		}

		if (($this->user() && $topic['user_id'] == $this->user('user_id')) || $this->access('forum', 'category_delete', $category_id))
		{
			$content .= '<a class="pull-right btn btn-default delete" href="'.url('forum/message/delete/'.$topic['message_id'].'/'.url_title($title)).'" data-toggle="tooltip" title="'.$this->lang('remove_topic').'">'.icon('fa-close').'</a>';
		}

		if ($this->access('forum', 'category_lock', $category_id))
		{
			if ($is_locked)
			{
				$content .= '<a class="pull-right btn btn-default" href="'.url('forum/lock/'.$topic_id.'/'.url_title($title)).'" data-toggle="tooltip" title="'.$this->lang('unlock_topic').'">'.icon('fa-unlock').'</a>';
			}
			else
			{
				$content .= '<a class="pull-right btn btn-default" href="'.url('forum/lock/'.$topic_id.'/'.url_title($title)).'" data-toggle="tooltip" title="'.$this->lang('lock_topic').'">'.icon('fa-lock').'</a>';
			}
		}

		if ($this->access('forum', 'category_announce', $category_id))
		{
			if ($is_announce)
			{
				$content .= '<a class="pull-right btn btn-default" href="'.url('forum/announce/'.$topic_id.'/'.url_title($title)).'" data-toggle="tooltip" title="'.$this->lang('unset_announce').'">'.icon('fa-flag-o').'</a>';
			}
			else
			{
				$content .= '<a class="pull-right btn btn-default" href="'.url('forum/announce/'.$topic_id.'/'.url_title($title)).'" data-toggle="tooltip" title="'.$this->lang('set_announce').'">'.icon('fa-flag').'</a>';
			}
		}

		if ($this->access('forum', 'category_move', $category_id))
		{
			$this	->css('move')
					->js('move');

			$content .= '<span class="pull-right btn btn-default topic-move" data-toggle="tooltip" data-action="'.url('ajax/forum/topic/move/'.$topic_id.'/'.url_title($title)).'" title="'.$this->lang('move_topic').'">'.icon('fa-reply fa-flip-horizontal').'</span>';
		}
		
		$panels = [];
		
		if ($is_locked)
		{
			$panels[] = $this	->panel()
								->heading('<a name="reply"></a>'.$this->lang('locked_topic'), 'fa-warning')
								->color('danger');
		}
		
		$panels[] = $this	->panel()
							->body($this->view('topic', array_merge($topic, [
								'category_id'       => $category_id,
								'topic_id'          => $topic_id,
								'title'             => $title,
								'views'             => $views,
								'last_message_read' => $last_message_read
							])), FALSE);
		
		$actions = $this->panel()
						->body($content, FALSE)
						->color('back');
		
		if (!empty($messages))
		{
			$panels[] = $actions;
			
			$panels[] = $this->panel()->body($this->view('messages', [
				'category_id'       => $category_id,
				'topic_id'          => $topic_id,
				'title'             => $title,
				'nb_users'          => $nb_users,
				'nb_messages'       => $nb_messages, 
				'messages'          => $messages,
				'last_message_read' => $last_message_read
			]), FALSE);
		}
		
		$panels[] = $actions;
		
		if ($is_last_page && $this->access('forum', 'category_write', $category_id) && !$is_locked)
		{
			$this	->css('wbbtheme')
					->js('jquery.wysibb.min')
					->js_load('$(\'textarea.editor\').wysibb();')
					->form
					->add_rules([
						'message' => [
							'type'  => 'editor',
							'rules' => 'required'
						]
					])
					->add_submit($this->lang('reply'));
			
			if ($this->form->is_valid($post))
			{
				$message_id = $this->model()->add_message($topic_id, $post['message']);

				//notify('success', $this->lang('add_reply_success'));
			
				$page = '';
			
				if (++$nb_messages > $this->pagination->get_items_per_page())
				{
					$page = '/page/'.ceil($nb_messages / $this->pagination->get_items_per_page());
				}

				redirect('forum/topic/'.$topic_id.'/'.url_title($title).$page.'#'.$message_id);
			}
			
			if ($errors = $this->form->get_errors())
			{
				$panels[] = $this->row($this->col(
					$this	->panel()
							->heading('<a name="reply"></a>'.$this->lang('message_needed'), 'fa-warning')
							->color('danger')
				));
			}

			$panels[] = $this	->panel()
								->heading('<a name="reply"></a>'.$this->lang('reply_topic'), 'fa-file-text-o')
								->body($this->view('new', [
									'form_id'  => $this->form->token()
								]), FALSE);
		}
		
		return $panels;
	}
	
	public function _topic_announce($topic_id, $title, $is_announce, $is_locked)
	{
		$this->db	->where('topic_id', $topic_id)
					->update('dungeon_forum_topics', [
						'status' => (string)($is_announce ? ($is_locked ? -1 : 0) : ($is_locked ? -2 : 1))
					]);
		//notify('success', $this->lang('toggle_announce_topic'));
		redirect('forum/topic/'.$topic_id.'/'.url_title($title));
	}
	
	public function _topic_lock($topic_id, $title, $is_announce, $is_locked)
	{
		$this->db	->where('topic_id', $topic_id)
					->update('dungeon_forum_topics', [
						'status' => (string)($is_locked ? ($is_announce ? 1 : 0) : ($is_announce ? -2 : -1))
					]);
		//notify('success', $this->lang('toggle_lock_topic'));
		redirect('forum/topic/'.$topic_id.'/'.url_title($title));
	}
	
	public function _topic_move($topic_id, $title, $forum_id)
	{
		$forums = [];
		
		foreach ($this->model()->get_forums_tree() as $category_id => $category)
		{
			foreach ($category['forums'] as $f_id => $forum)
			{
				$forums = array_merge($forums, [$f_id], array_keys($forum['subforums']));
			}
		}
		
		$this->load	->form
					->set_id('3a27fa5555e6f34491793733f32169db')
					->add_rules([
						'forum_id' => [
							'type'   => 'radio',
							'values' => array_flip($forums)
						]
					]);

		if ($this->form->is_valid($post) && $forum_id != $post['forum_id'])
		{
			$this->db	->where('topic_id', $topic_id)
						->update('dungeon_forum_topics', [
							'forum_id' => $post['forum_id']
						]);

			$count_messages = $this->model()->count_messages($topic_id);
			
			$this->db	->where('forum_id', $forum_id)
						->update('dungeon_forum', 'count_topics = count_topics - 1');
			
			$this->db	->where('forum_id', $forum_id)
						->update('dungeon_forum', 'count_messages = count_messages - '.$count_messages);
			
			$last_message_id = $this->model()->get_last_message_id($forum_id);
			
			$this->db	->where('forum_id', $forum_id)
						->update('dungeon_forum', [
							'last_message_id' => $last_message_id
						]);
			
			$this->db	->where('forum_id', $post['forum_id'])
						->update('dungeon_forum', 'count_topics = count_topics + 1');
			
			$this->db	->where('forum_id', $post['forum_id'])
						->update('dungeon_forum', 'count_messages = count_messages + '.$count_messages);
						
			
			$last_message_id = $this->model()->get_last_message_id($post['forum_id']);
			
			$this->db	->where('forum_id', $post['forum_id'])
						->update('dungeon_forum', [
							'last_message_id' => $last_message_id
						]);
			
			//notify('success', ....);
		}

		redirect('forum/topic/'.$topic_id.'/'.url_title($title));
	}
	
	public function _message_edit($message_id, $topic_id, $title, $is_topic, $message, $category_id, $forum_id, $user_id, $locked)
	{
		$this	->title($this->lang($is_topic ? 'edit_topic' : 'edit_message'))
				->_breadcrumb($category_id, $forum_id)
				->breadcrumb($title, 'forum/topic/'.$topic_id.'/'.url_title($title))
				->breadcrumb()
				->css('wbbtheme')
				->js('jquery.wysibb.min')
				->js_load('$(\'textarea.editor\').wysibb();')
				->form
				->add_rules([
					'message' => [
						'type'  => 'editor',
						'rules' => 'required'
					]
				]);
		
		if ($is_topic)
		{
			$this->form->add_rules([
				'title' => [
					'rules' => 'required'
				]
			]);
		}

		if ($this->form->is_valid($post))
		{
			if ($is_topic && $title != $post['title'])
			{
				$this->db	->where('topic_id', $topic_id)
							->update('dungeon_forum_topics', [
								'title' => $post['title']
							]);
			}
			
			$this->db	->where('message_id', $message_id)
						->update('dungeon_forum_messages', [
							'message' => $post['message']
						]);

			//notify('success', $this->lang('edit_message_success'));

			redirect('forum/topic/'.$topic_id.'/'.url_title($is_topic ? $post['title'] : $title));
		}
		
		$panels = [];
		
		if ($errors = $this->form->get_errors())
		{
			$panels[] = $this->row($this->col(
				$this	->panel()
						->heading($this->lang($is_topic ? 'fill_all_fields' : 'message_needed'), 'fa-warning')
						->color('danger')
			));
		}
		
		$panels[] = $this	->panel()
							->heading($this->lang($is_topic ? 'edit_topic' : 'edit_message'), 'fa-file-text-o')
							->body($this->view('new', [
								'form_id'  => $this->form->token(),
								'post'     => $post,
								'topic_id' => $topic_id,
								'is_topic' => $is_topic,
								'title'    => $title,
								'message'  => $message,
								'user_id'  => $user_id
							]), FALSE);
		
		return $panels;
	}
	
	public function _message_delete($message_id, $title, $topic_id, $forum_id, $is_topic)
	{
		$this	->title($this->lang($is_topic ? 'delete_topic' : 'delete_message'))
				->subtitle($title)
				->form
				->confirm_deletion($this->lang('delete_confirmation'), $is_topic ? $this->lang('topic_confirmation', $title) : $this->lang('message_confirmation'));

		if ($this->form->is_valid())
		{
			$delete = TRUE;
			
			if ($is_topic)
			{
				$count_messages = $this->model()->count_messages($topic_id);
				
				$this->db	->where('topic_id', $topic_id)
							->delete('dungeon_forum_topics');
				
				$this->db	->where('forum_id', $forum_id)
							->update('dungeon_forum', 'count_topics = count_topics - 1');
				
				$this->db	->where('forum_id', $forum_id)
							->update('dungeon_forum', 'count_messages = count_messages - '.$count_messages);
			}
			else if ($this->db->select('message_id')->from('dungeon_forum_messages')->where('topic_id', $topic_id)->order_by('message_id DESC')->limit(1)->row() == $message_id)
			{
				$this->db	->where('message_id', $message_id)
							->delete('dungeon_forum_messages');

				$this->db	->where('topic_id', $topic_id)
							->update('dungeon_forum_topics', 'count_messages = count_messages - 1');

				$this->db	->where('forum_id', $forum_id)
							->update('dungeon_forum', 'count_messages = count_messages - 1');

				if (($last_message_id = $this->db->select('message_id')->from('dungeon_forum_messages')->where('topic_id', $topic_id)->order_by('message_id DESC')->limit(1)->row()) &&
					 $last_message_id != $this->db->select('message_id')->from('dungeon_forum_topics')->where('topic_id', $topic_id)->row())
				{
					$this->db	->where('topic_id', $topic_id)
								->update('dungeon_forum_topics', [
									'last_message_id' => $last_message_id
								]);
				}
			}
			else
			{
				$this->db	->where('message_id', $message_id)
							->update('dungeon_forum_messages', [
								'message' => NULL
							]);
				
				$delete = FALSE;
			}

			if ($delete)
			{
				$last_message_id = $this->model()->get_last_message_id($forum_id);

				$this->db	->where('forum_id', $forum_id)
							->update('dungeon_forum', [
								'last_message_id' => $last_message_id
							]);
			}

			return 'OK';
		}

		echo $this->form->display();
	}

	public function mark_all_as_read()
	{
		$this->model()->mark_all_as_read();
		//notify('success', $this->lang('marked_as_read'));
		redirect('forum');
	}
	
	public function _mark_all_as_read($forum_id, $title)
	{
		foreach (array_merge([$forum_id], $this->db->select('forum_id')->from('dungeon_forum')->where('parent_id', $forum_id)->where('is_subforum', TRUE)->get()) as $id)
		{
			$this->model()->mark_all_as_read($id);
		}
		
		//notify('success', $this->lang('forum_marked_as_read', $title));
		redirect('forum/'.$forum_id.'/'.url_title($title));
	}
	
	private function _breadcrumb($category_id, $forum_id)
	{
		if ($category = $this->db->select('title')->from('dungeon_forum_categories')->where('category_id', $category_id)->row())
		{
			$this->breadcrumb($category, 'forum');
		}
		
		if (list($title, $parent_forum_id) = array_values($this->db->select('title', 'IF(is_subforum = "1", parent_id, 0)')->from('dungeon_forum')->where('forum_id', $forum_id)->row()))
		{
			if ($parent_forum_id && $parent_forum = $this->db->select('title')->from('dungeon_forum')->where('forum_id', $parent_forum_id)->row())
			{
				$this->breadcrumb($parent_forum, 'forum/'.$parent_forum_id.'/'.url_title($parent_forum));
			}
			
			$this->breadcrumb($title, 'forum/'.$forum_id.'/'.url_title($title));
		}
		
		return $this;
	}
}

/*
Dungeon Alpha 0.1.7
./modules/forum/controllers/index.php
*/