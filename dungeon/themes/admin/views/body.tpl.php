<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
		<a href="<?php echo url(); ?>" class="btn btn-default back-to visible-xs"><?php echo icon('fa-sign-out'); ?></a>
		<a href="#" class="btn btn-default touch-menu visible-xs"><?php echo icon('fa-bars'); ?></a>
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo url('admin'); ?>"><b>Dungeon</b> CMS<span class="dungeon-version"><?php echo DUNGEON_VERSION; ?></span></a>
		</div>
		<div class="collapse navbar-collapse" id="main-navbar-collapse-1">
			<ul class="nav nav navbar-nav navbar-left">
				<li><a href="#" class="toggle-menu" data-toggle="sidebar"><?php echo icon('fa-bars'); ?></a></li>
			</ul>
			<a class="btn btn-default navbar-btn navbar-right" href="<?php echo url(); ?>"><?php echo icon('fa-sign-out'); ?><span class="hidden-xs hidden-sm"> <?php echo $this->lang('back_front'); ?></span></a>
		</div>
	</nav>
	<nav class="navbar-default sidebar">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
				<li class="sidebar-user">
					<div class="row">
						<div class="col-md-3 col-xs-12">
							<?php echo $this->user->avatar($this->user('avatar'), $this->user('sex')); ?>
						</div>
						<div class="col-md-9 col-xs-12">
							<span class="user-name"><b><?php echo $this->user('username'); ?></b></span>
						</div>
						<div class="col-md-9 col-xs-12">
							<div class="btn-group">
								<button type="button" class="btn btn-user btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<?php echo icon('fa-user').' '.icon('fa-angle-down'); ?>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo url('user'); ?>"><?php echo icon('fa-user').$this->lang('my_account'); ?></a></li>
									<li><a href="<?php echo url('user/edit'); ?>"><?php echo icon('fa-cogs').$this->lang('manage_my_account'); ?></a></li>
									<li><a href="<?php echo url('user/'.$this->user('user_id').'/'.url_title($this->user('username'))); ?>"><?php echo icon('fa-eye').$this->lang('view_my_profile'); ?></a></li>
								</ul>
							</div>
							<!--<div class="btn-group">
								<button type="button" class="btn btn-user btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<span class="alert-badge">3</span>
									<?php echo icon('fa-envelope-o').' '.icon('fa-angle-down'); ?>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#"><?php echo icon('fa-inbox'); ?>Inbox</a></li>
									<li><a href="#"><?php echo icon('fa-sign-out'); ?>Sent Messages</a></li>
									<li><a href="#"><?php echo icon('fa-file-text-o'); ?>Compose PM</a></li>
								</ul>
							</div>-->
							<a href="<?php echo url('user/logout'); ?>" class="btn btn-user-logout" ><?php echo icon('fa-close'); ?></a>
						</div>
					</div>
				</li>
				<?php if (!empty($data['update'])): ?>
					<li class="sidebar-update">
						<div class="row">
							<div class="col-md-12 col-xs-12 text-center">
							</div>
							<div class="col-md-12 col-xs-12 text-center">
								<h5>
								New update !
									<small>Dungeon <?php echo $data['update']->version; ?></small>
								</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-update">Install !</a>
							</div>
						</div>
					</li>
				<?php endif; ?>
<?php
	$actives  = [];

	foreach ($data['menu'] as $link)
	{
		if (is_array($link['url']))
		{
			foreach ($link['url'] as $sublink)
			{
				if (strpos($this->url->request, $sublink['url']) === 0)
				{
					$actives[] = $sublink['url'];
				}
			}
		}
	}

	usort($actives, function($a, $b){
		return strlen($a) < strlen($b);
	});

	foreach ($data['menu'] as $link)
	{
		if (is_array($link['url']))
		{
			$active  = FALSE;
			$submenu = '';

			foreach ($link['url'] as $sublink)
			{
				if (!isset($sublink['access']) || $sublink['access'])
				{
					$class = [];

					if (!empty($sublink['pro']))
					{
						$class[] = 'forbidden';
					}

					if ($actives && $actives[0] == $sublink['url'])
					{
						$active  = TRUE;
						$class[] = 'active';
					}

					$submenu .= '<li><a'.(!empty($class) ? ' class="'.implode(' ', $class).'"' : '').' href="'.url($sublink['url']).'">'.icon($sublink['icon']).$sublink['title'].'</a></li>';
				}
			}

			if ($submenu)
			{
				echo '<li'.($active ? ' class="active"' : '').'><a data-toggle="collapse" href="#menu_'.url_title($link['title']).'">'.icon($link['icon']).' <span class="hidden-xs">'.$link['title'].'</span><span class="fa arrow"></span></a><ul class="nav nav-second-level'.(!$active ? ' collapse' : '').'">'.$submenu.'</ul></li>';
			}
		}
		else if (!isset($link['access']) || $link['access'])
		{
			echo '<li><a'.($this->url->request == $link['url'] ? ' class="active"' : '').' href="'.url($link['url']).'">'.icon($link['icon']).' <span class="hidden-xs">'.$link['title'].'</span></a></li>';
		}
	}
?>
			</ul>
		</div>
	</nav>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><?php echo $this->output->data['module_title']; if (!empty($this->output->data['module_subtitle'])) echo '<small>'.$this->output->data['module_subtitle'].'</small>'; ?></h1>
				<div class="page-actions pull-right">
					<?php if ($data['module_method'] == 'index' && Dungeon()->module->get_permissions('default') && $this->module('access')->is_authorized()): ?>
						<a class="btn btn-outline btn-success btn-sm" href="<?php echo url('admin/access/edit/'.Dungeon()->module->name); ?>"><?php echo icon('fa-unlock-alt'); ?><span class="hidden-sm"> Permissions</span></a>
					<?php endif; ?>
					<?php if (method_exists(Dungeon()->module, 'settings') && $this->module('addons')->is_authorized()): ?>
						<a class="btn btn-outline btn-warning btn-sm" href="<?php echo url('admin/addons/module/'.Dungeon()->module->name); ?>"><?php echo icon('fa-wrench'); ?><span class="hidden-sm"> <?php echo $this->lang('configuration'); ?></span></a>
					<?php endif; ?>
					<?php if (($help = Dungeon()->module->controller('admin_help')) && $help->has_method($data['module_method'])): ?>
					<?php Dungeon()->js('dungeon.help'); ?>
					<a class="btn btn-outline btn-info btn-sm" href="<?php echo url($this->url->request); ?>" data-help="<?php echo 'admin/help/'.Dungeon()->module->name.'/'.$data['module_method']; ?>"><?php echo icon('fa-life-bouy'); ?><span class="hidden-sm"> <?php echo $this->lang('help'); ?></span></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div id="alerts"></div>
			<?php echo $this->view('actions', $data); ?>
		</div>
		<div class="module module-admin module-<?php echo Dungeon()->module->name; ?>"><?php echo Dungeon()->module; ?></div>
	</div>
</div>
<?php if (!empty($data['update'])): ?>
	<div id="modal-update" class="modal fade">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Dungeon <?php echo version_format(DUNGEON_VERSION).' '.icon('fa-chevron-right').' '.version_format($data['update']->version); ?></h4>
				</div>
				<div class="modal-body">
					<?php if (!empty($data['update']->features)): ?>
						<div class="update-features">
							<?php echo $data['update']->features; ?>
						</div>
						<hr />
					<?php endif; ?>
					<div class="steps-body text-center">
						<div class="row" style="padding: 0 110px;">
							<div class="col-md-4">
								<div class="progress">
									<div class="progress-bar" role="progressbar" data-step="50,50"></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="progress">
									<div class="progress-bar" role="progressbar" data-step="100"></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="progress">
									<div class="progress-bar" role="progressbar" data-step="95,5"></div>
								</div>
							</div>
						</div>
						<div class="row steps-legends">
							<div class="col-md-3">
								<div class="step">
									<?php echo icon('fa-refresh'); ?>
								</div>
								<span class="span-legend">Launching</span>
							</div>
							<div class="col-md-3">
								<div class="step">
									<?php echo icon('fa-floppy-o'); ?>
								</div>
								<span class="span-legend">Backing up</span>
							</div>
							<div class="col-md-3">
								<div class="step">
									<?php echo icon('fa-arrow-circle-o-down'); ?>
								</div>
								<span class="span-legend">Downloading</span>
							</div>
							<div class="col-md-3">
								<div class="step">
									<?php echo icon('fa-cog'); ?>
								</div>
								<span class="span-legend">Installation</span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link pull-left" data-dismiss="modal">Later</button>
					<button type="button" class="btn btn-primary" data-loading-text="Loading installation...">Start the update</button>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
