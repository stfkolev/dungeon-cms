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

class m_addons_c_admin_ajax extends Controller_Module
{
	public function index()
	{
		if ($this->has_method($addon = '_'.post('addon').'_list'))
		{
			return $this->col($this->$addon()->size('col-md-8 col-lg-9'));
		}
	}

	public function active($type, $object)
	{
		$this->extension('json');

		if ($type == 'authenticator')
		{
			if (!$object->is_setup())
			{
				return [
					'danger' => 'You must configure the authenticator'
				];
			}

			$table      = 'dungeon_settings_authenticators';
			$is_enabled = !$object->is_enabled();
			$title      = 'The authenticator '.$object->title;
		}
		else
		{
			$table      = 'dungeon_settings_addons';
			$is_enabled = !$this->db->select('is_enabled')
									->from('dungeon_settings_addons')
									->where('name', $object->name)
									->where('type', $type)
									->row();

			$this->db->where('type', $type);

			$title = 'Le '.$type.' '.$object->get_title();
		}

		$this->db	->where('name', $object->name)
					->update($table, [
						'is_enabled' => $is_enabled
					]);

		return [
			'success' => $title.' is '.($is_enabled ? 'activated' : 'deactivated')
		];
	}
	
	public function install()
	{
		$this->extension('json');
		
		if (!empty($_FILES['file']) && extension($_FILES['file']['name']) == 'zip')
		{
			if ($zip = zip_open($_FILES['file']['tmp_name']))
			{
				while (file_exists($tmp = sys_get_temp_dir().'/'.unique_id()));
				
				dir_create($tmp);

				while ($zip_entry = zip_read($zip))
				{
					$entry_name = zip_entry_name($zip_entry);

					if (substr($entry_name, -1) == '/')
					{
						dir_create($tmp.'/'.$entry_name);
					}
					else if (zip_entry_open($zip, $zip_entry, 'r'))
					{
						file_put_contents($tmp.'/'.$entry_name, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
					}

					zip_entry_close($zip_entry);
				}

				zip_close($zip);
				
				$folders = array_filter(scandir($tmp), function($a) use ($tmp){
					return !in_array($a, ['.', '..']) && is_dir($tmp.'/'.$a);
				});

				$install_addon = function ($dir, $types = NULL) {
					if ($types === NULL)
					{
						$types = ['Module', 'Widget', 'Theme'];
					}
					else if (!is_array($types))
					{
						$types = (array)$types;
					}
					
					foreach (scandir($dir) as $filename)
					{
						if (!is_dir($file = $dir.'/'.$filename) &&
							preg_match('/^(.+?)\.php$/', $filename, $match) &&
							preg_match('/class ('.implode('|', array_map(function($a){ return strtolower(substr($a, 0, 1)); }, $types)).')_('.$match[1].') extends ('.implode('|', $types).')/', $content = php_strip_whitespace($file), $match) &&
							$match[1] == strtolower(substr($match[3], 0, 1)))
						{
							foreach (['version', 'dungeon_version'] as $var)
							{
								$$var = preg_match('/\$'.$var.'[ \t]*?=[ \t]*?([\'"])(.+?)\1;/', $content, $match2) ? version_format($match2[2]) : NULL;
							}
							
							if (!empty($version) && !empty($dungeon_version))
							{
								$type = strtolower($match[3]);

								$addon = Dungeon()->$type($name = strtolower($match[2]), TRUE);

								if ($addon)
								{
									$update = TRUE;
									
									if (($cmp = version_compare($version, version_format($addon->version))) === 0)
									{
										return [
											'warning' => 'The '.$type.' '.$addon->get_title().' is already installed '.$version
										];
									}
									else if ($cmp === -1)
									{
										return [
											'danger' => 'The '.$type.' '.$addon->get_title().' is already installed with a higher version'
										];
									}
								}

								if (($cmp = version_compare($dungeon_version, version_format(DUNGEON_VERSION))) !== 1)
								{
									dir_copy($dir, $type.'s/'.$name);

									if ($addon = Dungeon()->$type($name, TRUE))
									{
										$addon->reset();
										
										return [
											'success' => 'The '.$type.' '.$addon->get_title().' has been '.(empty($update) ? 'installed' : 'updated')
										];
									}

									return [
										'danger' => 'The '.$type.' '.($addon ? $addon->get_title() : $name).' could not be '.(empty($update) ? 'installed' : 'updated')
									];
								}
								
								return [
									'danger' => 'The '.$type.' '.($addon ? $addon->get_title() : $name).' requires version '.$dungeon_version.' of Dungeon, please update your site'
								];
							}
							
							return [
								'danger' => 'The component can not be installed, please check the versions'
							];
						}
					}
					
					return [
						'danger' => 'The component can not be installed, please check its contents'
					];
				};

				$types   = ['modules', 'widgets', 'themes'];

				$results = [
					'danger'  => [],
					'success' => [],
					'warning' => []
				];

				if (count($folders) == 1 && !in_array($folder = current($folders), $types))
				{
					$results = array_merge_recursive($results, $install_addon($tmp.'/'.$folder));
				}
				else
				{
					foreach (array_intersect($folders, $types) as $folder)
					{
						foreach (scandir($tmp.'/'.$folder) as $dir)
						{
							if (!in_array($dir, ['.', '..']) && is_dir($dir = $tmp.'/'.$folder.'/'.$dir))
							{
								$results = array_merge_recursive($results, $install_addon($dir, substr(ucfirst($folder), 0, -1)));
							}
						}
					}
				}

				$this->extension('json');

				dir_remove($tmp);

				return array_filter($results);
			}
			
			return [
				'danger' => ['Error transferring to the server']
			];
		}
		
		return [
			'danger' => [$this->lang('zip_file_required')]
		];
	}
	
	private function _modules_list()
	{
		return $this->panel()
					->heading('List of modules', 'fa-edit')
					->body($this->view('modules'), FALSE);
	}
	
	private function _themes_list()
	{
		return $this->panel()
					->heading('List of themes', 'fa-tint')
					->body($this->view('themes'));
	}
	
	private function _widgets_list()
	{
		return $this->panel()
					->heading('List of widgets', 'fa-cubes')
					->body($this->view('widgets'), FALSE);
	}
	
	private function _languages_list()
	{
		return $this->panel()
					->heading('List of languages', 'fa-book')
					->body($this->view('languages', [
						'languages' => $this->addons->get_languages()
					]), FALSE);
	}
	
	private function _authenticators_list()
	{
		return $this->panel()
					->heading('List of authenticators', 'fa-user-circle')
					->body($this->view('authenticators', [
						'authenticators' => $this->addons->get_authenticators(TRUE)
					]), FALSE);
	}

	/*private function _smileys_list()
	{
		return array(
			'title' => 'List of smileys',
			'icon'  => 'fa-smile-o'
		);
	}
	
	private function _bbcodes_list()
	{
		return array(
			'title' => 'List of BBCodes',
			'icon'  => 'fa-code'
		);
	}*/

	public function _theme_activation($theme)
	{
		$this	->extension('json')
				->config('dungeon_default_theme', $theme->name);
		
		return [
			'success' => 'The theme '.$theme->get_title().' has been activated'
		];
	}

	public function _theme_reset($theme)
	{
		$theme->reset()->extension('json');
		
		return [
			'success' => 'The theme '.$theme->get_title().' has been reinstalled by default'
		];
	}

	public function _theme_settings($controller)
	{
		return $controller->index();
	}
	
	public function _language_sort($language, $position)
	{
		$languages = [];
		
		foreach ($this->db->select('code')->from('dungeon_settings_languages')->where('code !=', $language)->order_by('order')->get() as $code)
		{
			$languages[] = $code;
		}
		
		foreach (array_merge(array_slice($languages, 0, $position, TRUE), [$language], array_slice($languages, $position, NULL, TRUE)) as $order => $code)
		{
			$this->db	->where('code', $code)
						->update('dungeon_settings_languages', [
							'order' => $order
						]);
		}
	}

	public function _authenticator_sort($auth, $position)
	{
		$authenticators = [];

		foreach ($this->db->select('name')->from('dungeon_settings_authenticators')->where('name !=', $auth)->order_by('order')->get() as $name)
		{
			$authenticators[] = $name;
		}

		foreach (array_merge(array_slice($authenticators, 0, $position, TRUE), [$auth], array_slice($authenticators, $position, NULL, TRUE)) as $order => $name)
		{
			$this->db	->where('name', $name)
						->update('dungeon_settings_authenticators', [
							'order' => $order
						]);
		}
	}

	public function _authenticator_admin($authenticator)
	{
		return $authenticator->admin();
	}

	public function _authenticator_update($authenticator, $settings)
	{
		$authenticator->update($settings);
	}
}

/*
Dungeon Alpha 0.1.7
./dungeon/modules/addons/controllers/admin_ajax.php
*/