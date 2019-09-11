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

class Col extends Childrenable
{
	protected $_size;

	public function size($size)
	{
		$this->_size = $size;
		return $this;
	}

	public function __toString()
	{
		$size = '';

		foreach ($this->_children as $i => $child)
		{
			if (method_exists($child, 'size') && !$size)
			{
				$size = $child->size();
			}
		}

		if ($this->_id !== NULL)
		{
			foreach ($this->_children as $i => $child)
			{
				$child->id($i);
			}
		}

		$output = implode($this->_children);

		if ($this->_id !== NULL && Dungeon::live_editor() & Dungeon::COLS)
		{
			$output = '<div class="live-editor-col">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default live-editor-size" data-size="-1" data-toggle="tooltip" data-container="body" title="'.$this->lang('reduce').'">'.icon('fa-compress fa-rotate-45').'</button>
								<button type="button" class="btn btn-sm btn-default live-editor-size" data-size="1" data-toggle="tooltip" data-container="body" title="'.$this->lang('increase').'">'.icon('fa-expand fa-rotate-45').'</button>
								<button type="button" class="btn btn-sm btn-danger live-editor-delete" data-toggle="tooltip" data-container="body" title="'.$this->lang('remove').'">'.icon('fa-close').'</button>
							</div>
							<h3>'.$this->lang('col').' <div class="btn-group"><button type="button" class="btn btn-xs btn-success live-editor-add-widget" data-toggle="tooltip" data-container="body" title="'.$this->lang('new_widget').'">'.icon('fa-plus').'</button></div></h3>
							'.$output.'
						</div>';
		}

		return '<div class="'.($this->_size ?: $size ?: 'col-md-12').'"'.($this->_id !== NULL ? ' data-col-id="'.$this->_id.'"' : '').'>'.$output.'</div>';
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/libraries/col.php
*/