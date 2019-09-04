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

class m_recruits extends Module
{
	public $title       = 'Recrutements';
	public $description = '';
	public $icon        = 'fa-bullhorn';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = '1.0';
	public $dungeon_version  = 'Alpha 0.1.6';
	public $path        = __FILE__;
	public $admin       = TRUE;
	public $routes      = [
		//Index
		'{page}'                                  => 'index',
		'{id}/{url_title}'                        => '_recruit',
		'postulate/{id}/{url_title}'              => '_postulate',
		'candidacy/{id}/{url_title}'              => '_candidacy',
		//Admin
		'admin{pages}'                            => 'index',
		'admin/{id}/{url_title}'                  => '_edit',
		'admin/candidacies/{id}/{url_title}'      => '_candidacies',
		'admin/candidacy/{id}/{url_title}'        => '_candidacies_edit',
		'admin/candidacy/delete/{id}/{url_title}' => '_candidacies_delete'
	];

	public function settings()
	{
		$this	->form
				->add_rules([
					[
						'label'       => 'Paramètres des offres',
						'type'        => 'legend'
					],
					'recruits_per_page' => [
						'label'       => 'Nombre d\'offre par page',
						'value'       => $this->config->recruits_per_page ?: '5',
						'type'        => 'number',
						'rules'       => 'required',
						'size'        => 'col-md-2'
					],
					'recruits_hide_unavailable' => [
						'type'        => 'checkbox',
						'checked'     => ['on' => $this->config->recruits_hide_unavailable],
						'values'      => ['on' => 'Masquer les offres indisponibles']
					],
					'recruits_alert' => [
						'type'        => 'checkbox',
						'checked'     => ['on' => $this->config->recruits_alert],
						'values'      => ['on' => 'Être avertis par message privé des nouvelles candidatures']
					],
					[
						'label'       => 'Réponse aux candidats',
						'type'        => 'legend'
					],
					'recruits_send' => [
						'label'       => 'Avertir les postulants',
						'type'        => 'checkbox',
						'checked'     => [
							'mp'   => $this->config->recruits_send_mp,
							'mail' => $this->config->recruits_send_mail
						],
						'values'      => [
							'mp'   => 'Par message privé',
							'mail' => 'Par e-mail'
						]
					]
				])
				->add_submit($this->lang('edit'))
				->add_back('admin/addons#modules');

		if ($this->form->is_valid($post))
		{
			$this	->config('recruits_per_page', $post['recruits_per_page'])
					->config('recruits_hide_unavailable', in_array('on', $post['recruits_hide_unavailable']))
					->config('recruits_alert', in_array('on', $post['recruits_alert']))
					->config('recruits_send_mp', in_array('mp', $post['recruits_send']))
					->config('recruits_send_mail', in_array('mail', $post['recruits_send']));

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
						'title'  => 'Offres de recrutement',
						'icon'   => 'fa-bullhorn',
						'access' => [
							'add_recruit' => [
								'title' => 'Ajouter',
								'icon'  => 'fa-plus',
								'admin' => TRUE
							],
							'modify_recruit' => [
								'title' => 'Modifier',
								'icon'  => 'fa-edit',
								'admin' => TRUE
							],
							'delete_recruit' => [
								'title' => 'Supprimer',
								'icon'  => 'fa-trash-o',
								'admin' => TRUE
							]
						]
					],
					[
						'title'  => 'Candidatures',
						'icon'   => 'fa-black-tie',
						'access' => [
							'candidacy_vote' => [
								'title' => 'Déposer son avis',
								'icon'  => 'fa-star-o',
								'admin' => TRUE
							],
							'candidacy_reply' => [
								'title' => 'Accepter / Refuser les candidats',
								'icon'  => 'fa-lock',
								'admin' => TRUE
							],
							'candidacy_delete' => [
								'title' => 'Supprimer',
								'icon'  => 'fa-trash-o',
								'admin' => TRUE
							]
						]
					]
				]
			],
			'recruit' => [
				'get_all' => function(){
					return Dungeon()->db->select('recruit_id', 'CONCAT_WS(" ", "Offre", title)')->from('dungeon_recruits')->get();
				},
				'check' => function($recruit_id){
					if (($recruit = Dungeon()->db->select('title')->from('dungeon_recruits')->where('recruit_id', $recruit_id)->row()) !== [])
					{
						return 'Offre '.$recruit;
					}
				},
				'init' => [
					'recruit_postulate' => [
						['visitors', FALSE]
					]
				],
				'access' => [
					[
						'title'  => 'Postulants',
						'icon'   => 'fa-black-tie',
						'access' => [
							'recruit_postulate' => [
								'title' => 'Déposer une candidature',
								'icon'  => 'fa-briefcase'
							]
						]
					]
				]
			]
		];
	}
}

/*
Dungeon Alpha 0.1.6.1
./modules/recruits/recruits.php
*/