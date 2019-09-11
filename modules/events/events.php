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

class m_events extends Module
{
	public $title       = 'Events';
	public $description = '';
	public $icon        = 'fa-calendar';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1.7';
	public $dungeon_version  = 'Alpha 0.1.7';
	public $path        = __FILE__;
	public $admin       = TRUE;
	public $routes      = [
		//Index
		'{page}'                                    => 'index',
		'standards{page}'                           => 'standards',
		'matches{page}'                             => 'matches',
		'upcoming{page}'                            => 'upcoming',
		'{id}/{url_title}'                          => '_event',
		'type/{id}/{url_title}{page}'               => '_type',
		'team/{id}/{url_title}{page}'               => '_team',
		'participant/{id}/{url_title}/{id}'         => '_participant_add',
		'participant/delete/{id}/{url_title}/{id}'  => '_participant_delete',

		//Ajax
		'ajax/{id}/{url_title}'                     => '_event',

		//Admin
		'admin{pages}'                              => 'index',
		'admin/{id}/{url_title}'                    => '_edit',
		'admin/types/add'                           => '_types_add',
		'admin/types/{id}/{url_title}'              => '_types_edit',
		'admin/types/delete/{id}/{url_title}'       => '_types_delete',
		'admin/rounds/delete/{id}/{url_title}/{id}' => '_round_delete'
	];

	public function settings()
	{
		$this	->form
				->add_rules([
					'events_per_page' => [
						'label'       => 'Number of events per page',
						'value'       => $this->config->events_per_page ?: '10',
						'type'        => 'number',
						'rules'       => 'required',
						'size'        => 'col-md-2'
					],
					'events_alert_mp' => [
						'type'        => 'checkbox',
						'checked'     => ['on' => $this->config->events_alert_mp],
						'values'      => ['on' => 'Be notified by private message of invitations']
					]
				])
				->add_submit($this->lang('edit'))
				->add_back('admin/addons#modules');

		if ($this->form->is_valid($post))
		{
			$this	->config('events_per_page', $post['events_per_page'])
					->config('events_alert_mp', in_array('on', $post['events_alert_mp']));

			redirect_back('admin/addons#modules');
		}

		return $this->panel()
					->body($this->form->display());
	}

	public static function permissions()
	{
		return [
			'default' => [
				'access'  => [
					[
						'title'  => 'Events',
						'icon'   => 'fa-calendar',
						'access' => [
							'add_event' => [
								'title' => 'Add',
								'icon'  => 'fa-plus',
								'admin' => TRUE
							],
							'modify_event' => [
								'title' => 'Modify',
								'icon'  => 'fa-edit',
								'admin' => TRUE
							],
							'delete_event' => [
								'title' => 'Delete',
								'icon'  => 'fa-trash-o',
								'admin' => TRUE
							]
						]
					],
					[
						'title'  => 'Types',
						'icon'   => 'fa-bookmark-o',
						'access' => [
							'add_events_type' => [
								'title' => 'Add type',
								'icon'  => 'fa-plus',
								'admin' => TRUE
							],
							'modify_events_type' => [
								'title' => 'Modify type',
								'icon'  => 'fa-edit',
								'admin' => TRUE
							],
							'delete_events_type' => [
								'title' => 'Delete type',
								'icon'  => 'fa-trash-o',
								'admin' => TRUE
							]
						]
					]
				]
			],
			'type' => [
				'get_all' => function(){
					return Dungeon()->db->select('type_id', 'CONCAT_WS(" ", "Type", title)')->from('dungeon_events_types')->get();
				},
				'check'   => function($type_id){
					if (($type = Dungeon()->db->select('title')->from('dungeon_events_types')->where('type_id', $type_id)->row()) !== [])
					{
						return 'Type '.$type;
					}
				},
				'init'    => [
					'access_events_type' => []
				],
				'access'  => [
					[
						'title'  => 'Types',
						'icon'   => 'fa-bookmark-o',
						'access' => [
							'access_events_type' => [
								'title' => 'Visibilité',
								'icon'  => 'fa-eye'
							]
						]
					]
				]
			]
		];
	}

	public function comments($event_id)
	{
		$event = $this->db	->select('title')
							->from('dungeon_events')
							->where('event_id', $event_id)
							->row();

		if ($event)
		{
			return [
				'title' => $event,
				'url'   => 'events/'.$event_id.'/'.url_title($event)
			];
		}
	}
}

/*
Dungeon Alpha 0.1.7.7
./modules/events/events.php
*/