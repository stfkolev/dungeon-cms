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

class Label extends Html
{
	protected $_title;
	protected $_icon;
	protected $_url;
	protected $_tooltip;
	protected $_popover;
	protected $_color;
	protected $_align;

	public function __invoke()
	{
		$args = func_get_args();

		$this->_tag = 'span';

		if (func_num_args())
		{
			$this->_title = $args[0];

			if (isset($args[1]))
			{
				$this->_icon = $args[1];

				if (isset($args[2]))
				{
					$this->_color = $args[2];

					if (isset($args[3]))
					{
						$this->_url = $args[3];
					}
				}
			}
		}

		$this->_template[] = function(&$content, &$attrs, &$tag){
			$output = [];

			if ($this->_icon)
			{
				$output[] = icon($this->_icon);
			}

			if ($this->_title)
			{
				$output[] = $this->lang($this->_title, NULL);
			}

			$content = implode(' ', $output);

			if ($this->_url !== NULL)
			{
				$attrs['href'] = url($this->_url);
				$tag           = 'a';
			}

			if ($this->_tooltip)
			{
				$attrs['data-toggle'] = 'tooltip';
				$attrs['data-html']   = 'true';
				$attrs['title']       = $this->_tooltip;
			}
			else if ($this->_popover)
			{
				$attrs['data-toggle']  = 'popover';
				$attrs['data-html']    = 'true';
				$attrs['title']        = $this->_popover[1];
				$attrs['data-content'] = $this->_popover[0];
			}

			if ($color = $this->_color)
			{
				if (preg_match('/#([0-9A-F]{3}){1,2}/i', $color))
				{
					$attrs['style'] = 'background-color: '.$color;
					$color = 'default';
				}

				if (isset(get_colors()[$color]))
				{
					$attrs['class'] = 'label label-'.$color;
				}
			}
		};

		return $this->reset();
	}

	public function url($url = '')
	{
		if (func_num_args())
		{
			$this->_url = $url;
			return $this;
		}
		else
		{
			return url($this->_url);
		}
	}

	public function title($title = '')
	{
		if (func_num_args())
		{
			$this->_title = $title;
			return $this;
		}
		else
		{
			return $this->_title;
		}
	}

	public function tooltip($title)
	{
		$this->_tooltip = $title;
		return $this;
	}

	public function popover($content, $title = '')
	{
		$this->_popover = [$content, $title];
		return $this;
	}

	public function icon($icon = '')
	{
		if (func_num_args())
		{
			$this->_icon = $icon;
			return $this;
		}
		else
		{
			return icon($this->_icon);
		}
	}

	public function color($color)
	{
		$this->_color = $color;
		return $this;
	}

	public function align($align = '')
	{
		if (func_num_args())
		{
			$this->_align = $align;
			return $this;
		}
		else
		{
			return $this->_align;
		}
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/libraries/label.php
*/