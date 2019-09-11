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

class m_monitoring_m_monitoring extends Model
{
	public $folders = ['authenticators', 'backups', 'cache', 'config', 'lib', 'modules', 'dungeon', 'overrides', 'themes', 'upload', 'widgets'];

	public function get_info()
	{
		return [
			'php_server'       => 'PHP '.PHP_VERSION,
			'web_server'       => preg_match('#(.+?)/(.+?) #', $_SERVER['SERVER_SOFTWARE'], $match) ? $match[1].' '.$match[2] : $_SERVER['SERVER_SOFTWARE'],
			'databases_server' => $this->db->get_info('server').' '.$this->db->get_info('version'),
			'databases_innodb' => $this->db->get_info('innodb')
		];
	}
	
	public function check_server()
	{
		$server = $this->get_info();

		return [
			[
				'title' => $server['php_server'],
				'icon'  => 'fa-server',
				'check' => [
					'php_curl' => [
						'title' => 'cURL',
						'check' => function(&$errors){
							if (!extension_loaded('curl'))
							{
								$errors[] = ['The cURL extension must be enabled', 'danger'];
								return FALSE;
							}
							
							return TRUE;
						}
					],
					'php_gd' => [
						'title' => 'GD',
						'check' => function(&$errors){
							if (!extension_loaded('gd'))
							{
								$errors[] = ['The GD extension must be enabled', 'danger'];
								return FALSE;
							}
							
							return TRUE;
						}
					],
					'php_json' => [
						'title' => 'JSON',
						'check' => function(&$errors){
							if (!extension_loaded('json'))
							{
								$errors[] = ['The JSON extension must be enabled', 'danger'];
								return FALSE;
							}
							
							return TRUE;
						}
					],
					'php_mbstring' => [
						'title' => 'mbstring',
						'check' => function(&$errors){
							if (!extension_loaded('mbstring'))
							{
								$errors[] = ['The mbstring extension must be enabled', 'danger'];
								return FALSE;
							}
							
							return TRUE;
						}
					],
					'php_zip' => [
						'title' => 'Zip',
						'check' => function(&$errors){
							if (!extension_loaded('zip'))
							{
								$errors[] = ['The zip extension must be enabled', 'danger'];
								return FALSE;
							}
							
							return TRUE;
						}
					]
				]
			],
			[
				'title' => $server['web_server'],
				'icon'  => 'fa-globe',
				'check' => [
					'mod_rewrite' => [
						'title' => 'mod_rewrite',
						'check' => function(&$errors){
							if (!1)
							{
								$errors[] = ['URL rewrite option must be enabled', 'danger'];
								return FALSE;
							}
							
							return TRUE;
						}
					]
				]
			],
			[
				'title' => $server['databases_server'],
				'icon'  => 'fa-database',
				'check' => [
					'innodb' => [
						'title' => 'InnoDB',
						'check' => function(&$errors) use ($server){
							if (!$server['databases_innodb'])
							{
								$errors[] = ['InnoDB storage engine must be enabled', 'danger'];
								return FALSE;
							}
							
							return TRUE;
						}
					]
				]
			],
			[
				'title' => 'Mail Service',
				'icon'  => 'fa-envelope-o',
				'check' => [
					'email' => [
						'title' => 'Server test...',
						'check' => function(&$errors, &$title){
							if (!$this->email->to('inkyzfx@gmail.com')->subject('email_check')->message('default', ['content' => ''])->send())
							{
								$errors[] = ['The sending email server must be configured', 'danger'];
								$title = 'Failure';
								return FALSE;
							}
							
							$title = 'OK';
							return TRUE;
						}
					]
				]
			]
		];
	}
}

/*
Dungeon Alpha 0.1.7.5.2
./dungeon/modules/monitoring/models/monitoring.php
*/