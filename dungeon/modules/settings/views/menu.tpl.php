<div class="list-group">
	<a class="list-group-item<?php echo $this->url->request == 'admin/settings' ? ' active' : ''; ?>" href="<?php echo url('admin/settings'); ?>"><?php echo icon('fa-cog'); ?> General</a>
	<a class="list-group-item<?php echo $this->url->request == 'admin/settings/registration' ? ' active' : ''; ?>" href="<?php echo url('admin/settings/registration'); ?>"><?php echo icon('fa-sign-in fa-rotate-90'); ?> Registrations</a>
	<a class="list-group-item<?php echo $this->url->request == 'admin/settings/team' ? ' active' : ''; ?>" href="<?php echo url('admin/settings/team'); ?>"><?php echo icon('fa-users'); ?> Teams</a>
	<a class="list-group-item<?php echo $this->url->request == 'admin/settings/socials' ? ' active' : ''; ?>" href="<?php echo url('admin/settings/socials'); ?>"><?php echo icon('fa-globe'); ?> Socials</a>
	<a class="list-group-item<?php echo $this->url->request == 'admin/settings/captcha' ? ' active' : ''; ?>" href="<?php echo url('admin/settings/captcha'); ?>"><?php echo icon('fa-shield'); ?> Anti-bot Security</a>
	<a class="list-group-item<?php echo $this->url->request == 'admin/settings/email' ? ' active' : ''; ?>" href="<?php echo url('admin/settings/email'); ?>"><?php echo icon('fa-envelope-o'); ?> SMTP Server</a>
</div>