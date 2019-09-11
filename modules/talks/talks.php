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

class m_talks extends Module
{
	public $title       = '{lang talks}';
	public $description = '';
	public $icon        = 'fa-comment-o';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1.7';
	public $dungeon_version  = 'Alpha 0.1.7';
	public $path        = __FILE__;
	public $admin       = TRUE;
	public $routes      = [
		'admin{pages}'            => 'index',
		'admin/{id}/{url_title*}' => '_edit'
	];

	public static function permissions()
	{
		return [
			'talk' => [
				'get_all' => function(){
					return Dungeon()->db->select('talk_id', 'CONCAT_WS(" ", "{lang talks}", name)')->from('dungeon_talks')->where('talk_id >', 1)->get();
				},
				'check'   => function($talk_id){
					if ($talk_id > 1 && ($talk = Dungeon()->db->select('name')->from('dungeon_talks')->where('talk_id', $talk_id)->row()) !== [])
					{
						return '{lang talks} '.$talk;
					}
				},
				'init'    => [
					'read'   => [
					],
					'write'  => [
						['visitors', FALSE]
					],
					'delete' => [
						['admins', TRUE]
					]
				],
				'access'  => [
					[
						'title'  => '{lang talks}',
						'icon'   => 'fa-comment-o',
						'access' => [
							'read' => [
								'title' => '{lang read}',
								'icon'  => 'fa-eye'
							],
							'write' => [
								'title' => '{lang write}',
								'icon'  => 'fa-reply'
							]
						]
					],
					[
						'title'  => '{lang moderation}',
						'icon'   => 'fa-user',
						'access' => [
							'delete' => [
								'title' => '{lang delete_message}',
								'icon'  => 'fa-trash-o'
							]
						]
					]
				]
			]
		];
	}
}

/*
Dungeon Alpha 0.1.7
./modules/talks/talks.php
*/