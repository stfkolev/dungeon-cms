<div role="tabpanel">
	<ul id="navigation-tabs" class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#options" aria-controls="links" role="tab" data-toggle="tab"><?php echo icon('fa-cogs'); ?> Options</a></li>
	</ul>
	<div class="tab-content">
		<div id="options" class="tab-pane active" role="tabpanel">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="settings-title" class="col-sm-3 control-label">Alignment</label>
					<div class="col-sm-5">
						<label class="radio-inline">
							<input type="radio" name="settings[align]" value="navbar-left"<?php if (!isset($data['align']) || $data['align'] != 'navbar-right') echo ' checked="checked"'; ?> /> Left
						</label>
						<label class="radio-inline">
							<input type="radio" name="settings[align]" value="navbar-right"<?php if (isset($data['align']) && $data['align'] == 'navbar-right') echo ' checked="checked"'; ?> /> Right
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>