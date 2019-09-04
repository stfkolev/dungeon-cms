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

class m_comments_c_ajax extends Controller_Module
{
	public function delete($comment_id, $module_id, $module)
	{
		$this	->title($this->lang('delete_confirmation'))
				->form
				->confirm_deletion($this->lang('delete_confirmation'), $this->lang('comment_confirmation'));

		if ($this->form->is_valid())
		{
			if ($this->db->select('comment_id')->from('dungeon_comments')->where('module', $module)->where('module_id', $module_id)->order_by('comment_id DESC')->limit(1)->row() == $comment_id)
			{
				$this->db	->where('comment_id', $comment_id)
							->delete('dungeon_comments');
			}
			else
			{
				$this->db	->where('comment_id', $comment_id)
							->update('dungeon_comments', [
								'content' => NULL
							]);
			}

			return 'OK';
		}

		echo $this->form->display();
	}
}

/*
Dungeon Alpha 0.1.6
./dungeon/modules/comments/controllers/ajax.php
*/