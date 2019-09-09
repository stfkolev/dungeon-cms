<div role="tabpanel">
	<ul id="navigation-tabs" class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#dserv-options" aria-controls="dserv-options" role="tab" data-toggle="tab"><?php echo icon('fa-cogs'); ?> Options</a></li>
		<li role="presentation"><a href="#dserv-listgame" aria-controls="dserv-listgame" role="tab" data-toggle="tab"><?php echo icon('fa-icon gamepad'); ?> <?php echo $this->lang('games_list'); ?></a></li>
	</ul>
	<div class="tab-content">
		<div id="dserv-options" class="tab-pane active" role="tabpanel">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="settings-group" class="col-sm-4 control-label"><?php echo $this->lang('ip'); ?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="settings[addr]" value="<?php echo $data['addr']; ?>" id="settings-group" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label for="settings-group" class="col-sm-4 control-label"><?php echo $this->lang('port'); ?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="settings[port]" value="<?php echo $data['port']; ?>" id="settings-group" placeholder="">
					</div>
				</div>
			</div>
		</div>
		<div id="dserv-listgame" class="tab-pane" role="tabpanel">
			<div class="form-horizontal">
				<div class="panel panel-info">
					<div class="panel-body">
						<?php echo $this->lang('text'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>