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

class t_default extends Theme
{
	public $title       = '{lang default_theme}';
	public $description = '{lang default_theme_description}';
	public $thumbnail   = 'dungeon/themes/default/images/thumbnail.png';
	public $link        = 'http://www.dungeon.com';
	public $author      = 'Evil <inkyzfx@gmail.com>';
	public $licence     = 'http://www.dungeon.com/license.html LGPLv3';
	public $version     = 'Alpha 0.1';
	public $dungeon_version  = 'Alpha 0.1';
	public $path        = __FILE__;
	public $zones       = ['{lang content}', '{lang pre_content}', '{lang post_content}', '{lang header}', '{lang top}', '{lang footer}'];

	public function load()
	{
		$this	->css('font.open-sans.300.400.600.700.800')
				->css('font.economica.400.700')
				->css('style');
				
		return parent::load();
	}
	
	public function styles_row()
	{
		return $this->view('live_editor/row');
	}
	
	public function styles_widget()
	{
		return $this->view('live_editor/widget');
	}
	
	public function install($dispositions = [])
	{
		$this	->config('default_background',            0, 'int')
				->config('default_background_repeat',     'no-repeat')
				->config('default_background_attachment', 'scroll')
				->config('default_background_position',   'center top')
				->config('default_background_color',      '#141d26')
				->config('dungeon_version_css',                time());
		
		$header = function(){
			return $this->row(
					$this->col(
						$this->panel_widget($this->db->insert('dungeon_widgets', [
							'widget'   => 'header',
							'type'     => 'index',
							'settings' => serialize([
								'align'             => 'text-center',
								'title'             => '',
								'description'       => '',
								'color-title'       => '',
								'color-description' => '#DC351E'
							])
						]))
					)
				)
				->style('row-default');
		};
		
		$navbar = function(){
			return $this->row(
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget'   => 'navigation',
									'type'     => 'index',
									'settings' => serialize([
										'display' => TRUE,
										'links'   => [
											[
												'title' => utf8_htmlentities($this->lang('home')),
												'url'   => ''
											],
											[
												'title' => utf8_htmlentities($this->lang('forum')),
												'url'   => 'forum'
											],
											[
												'title' => utf8_htmlentities($this->lang('teams')),
												'url'   => 'teams'
											],
											[
												'title' => utf8_htmlentities('Matches'),
												'url'   => 'events/matches'
											],
											[
												'title' => utf8_htmlentities('Partners'),
												'url'   => 'partners'
											],
											[
												'title' => utf8_htmlentities('Awards'),
												'url'   => 'awards'
											]
										]
									])
								]))
								->size('col-md-7')
					),
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget' => 'user',
									'type'   => 'index_mini'
								]))
								->size('col-md-5')
					)
				)
				->style('row-black');
		};
		
		$breadcrumb = function($search = TRUE){
			return $this->row(
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
										'widget' => 'breadcrumb',
										'type'   => 'index'
								]))
								->size('col-md-8')
					),
					$search ? $this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget' => 'search',
									'type'   => 'index'
								]))
								->size('col-md-4')
					) : NULL
				)
				->style('row-white');
		};
		
		$dispositions['*']['{lang content}'] = [
			$breadcrumb(),
			$this->row(
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget' => 'module',
									'type'   => 'index'
								]))
								->size('col-md-8')
					),
					$this	->col(
								$this->panel_widget($this->db->insert('dungeon_widgets', [
									'widget'   => 'navigation',
									'type'     => 'index',
									'settings' => serialize([
										'display' => FALSE,
										'links'   => [
											[
												'title' => utf8_htmlentities($this->lang('news')),
												'url'   => 'news'
											],
											[
												'title' => utf8_htmlentities($this->lang('members')),
												'url'   => 'members'
											],
											[
												'title' => utf8_htmlentities('Recruitment'),
												'url'   => 'recruits'
											],
											[
												'title' => utf8_htmlentities('Gallery'),
												'url'   => 'gallery'
											],
											[
												'title' => utf8_htmlentities($this->lang('search')),
												'url'   => 'search'
											],
											[
												'title' => utf8_htmlentities($this->lang('contact')),
												'url'   => 'contact'
											]
										]
									])
								])),
								$this	->panel_widget($this->db->insert('dungeon_widgets', [
											'widget' => 'partners',
											'type'   => 'column',
											'settings' => serialize([
												'display_style' => 'light'
											])
										]))
										->style('panel-dark'),
								$this	->panel_widget($this->db->insert('dungeon_widgets', [
											'widget' => 'user',
											'type'   => 'index'
										]))
										->style('panel-dark'),
								$this->panel_widget($this->db->insert('dungeon_widgets', [
									'widget' => 'news',
									'type'   => 'categories'
								])),
								$this->panel_widget($this->db->insert('dungeon_widgets', [
									'widget'   => 'talks',
									'type'     => 'index',
									'settings' => serialize([
										'talk_id' => 2
									])
								])),
								$this	->panel_widget($this->db->insert('dungeon_widgets', [
											'widget' => 'members',
											'type'   => 'online'
										]))
										->style('panel-red')
							)
							->size('col-md-4')
				)
				->style('row-light')
		];
		
		$dispositions['*']['{lang pre_content}'] = [
			$this->row(
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget' => 'forum',
									'type'   => 'topics'
								]))
								->size('col-md-4')
					),
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget' => 'news',
									'type'   => 'index'
								]))
								->style('panel-dark')
								->size('col-md-4')
					),
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget' => 'members',
									'type'   => 'index'
								]))
								->style('panel-red')
								->size('col-md-4')
					)
				)
				->style('row-default')
		];
		
		$dispositions['*']['{lang post_content}'] = [];
		
		$dispositions['*']['{lang header}'] = [
			$header(),
			$navbar()
		];

		$dispositions['*']['{lang top}'] = [
			$this->row(
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget'   => 'navigation',
									'type'     => 'index',
									'settings' => serialize([
										'display' => TRUE,
										'links'   => [
											[
												'title' => 'Facebook',
												'url'   => '#'
											],
											[
												'title' => 'Twitter',
												'url'   => '#'
											],
											[
												'title' => 'Origin',
												'url'   => '#'
											],
											[
												'title' => 'Steam',
												'url'   => '#'
											]
										]
									])
								]))
								->size('col-md-8')
					),
					$this->col(
						$this->panel_widget($this->db->insert('dungeon_widgets', [
							'widget' => 'members',
							'type'   => 'online_mini'
						]))
						->size('col-md-4')
					)
				)
				->style('row-default')
		];
		
		$dispositions['*']['{lang footer}'] = [
			$this->row(
					$this->col(
						$this	->panel_widget($this->db->insert('dungeon_widgets', [
									'widget'   => 'html',
									'type'     => 'index',
									'settings' => serialize([
										'content' => utf8_htmlentities($this->lang('powered_by_dungeon'))
									])
								]))
								->style('panel-dark')
					)
				)
				->style('row-default')
		];
		
		$dispositions['/']['{lang header}'] = [
			$header(),
			$navbar(),
			$this->row(
					$this->col(
						$this->panel_widget($this->db->insert('dungeon_widgets', [
							'widget'   => 'slider',
							'type'     => 'index'
						]))
					)
				)
				->style('row-default')
		];
		
		foreach (['forum/*', 'news/_news/*', 'user/*', 'search/*'] as $page)
		{
			$dispositions[$page]['{lang content}'] = [
				$breadcrumb($page != 'search/*'),
				$this	->row(
							$this->col(
								$this->panel_widget($this->db->insert('dungeon_widgets', [
									'widget' => 'module',
									'type'   => 'index'
								]))
							)
						)
						->style('row-light')
			];
		}
		
		$dispositions['forum/*']['{lang post_content}'] = [
			$this	->row(
						$this->col(
							$this	->panel_widget($this->db->insert('dungeon_widgets', [
										'widget' => 'forum',
										'type'   => 'statistics'
									]))
									->style('panel-red')
									->size('col-md-4')
						),
						$this->col(
							$this	->panel_widget($this->db->insert('dungeon_widgets', [
										'widget' => 'forum',
										'type'   => 'activity'
									]))
									->style('panel-dark')
									->size('col-md-8')
						)
					)
					->style('row-light')
		];

		return parent::install($dispositions);
	}
	
	public function uninstall($remove = TRUE)
	{
		$this->file->delete($this->config->default_background);
		$this->db->where('name LIKE', 'default_%')->delete('dungeon_settings');
		return parent::uninstall($remove);
	}
}

/*
Dungeon Alpha 0.1.6.1
./dungeon/themes/default/default.php
*/