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

class File extends Library
{
	public function filename($dir, $extension)
	{
		dir_create($dir = 'upload/'.($dir ?: 'unknow'));
		
		do
		{
			$file = unique_id().'.'.$extension;
		}
		while (check_file($filename = $dir.'/'.$file));
		
		return $filename;
	}

	public function upload($files, $dir = NULL, &$filename = NULL, $file_id = NULL, $var = NULL)
	{
		$filename = $this->filename($dir, extension(basename($var ? $files['name'][$var] : $files['name'])));

		if (move_uploaded_file($var ? $files['tmp_name'][$var] : $files['tmp_name'], $filename))
		{
			if ($file_id)
			{
				$this->_unlink($file_id);
				
				$this->db	->where('file_id', $file_id)
							->update('dungeon_files', [
								'user_id' => $this->user() ? $this->user('user_id') : NULL,
								'path'    => $filename,
								'name'    => $var ? $files['name'][$var] : $files['name']
							]);
				
				return $file_id;
			}
			else
			{
				return $this->add($filename, $var ? $files['name'][$var] : $files['name']);
			}
		}
		
		return FALSE;
	}
	
	public function add($path, $name)
	{
		return $this->db->insert('dungeon_files', [
			'user_id' => $this->user() ? $this->user('user_id') : NULL,
			'path'    => $path,
			'name'    => $name
		]);
	}
	
	public function delete($files)
	{
		foreach (array_filter((array)$files) as $file_id)
		{
			$this->_unlink($file_id);
			
			$this->db	->where('file_id', $file_id)
						->delete('dungeon_files');
		}
		
		return $this;
	}
	
	private function _unlink($file_id)
	{
		if (check_file($file = $this->db->select('path')->from('dungeon_files')->where('file_id', $file_id)->row()))
		{
			unlink($file);
		}
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/libraries/file.php
*/