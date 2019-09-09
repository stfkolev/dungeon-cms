<ul class="list-group">
	<?php if ($data['team_id']): ?>
	<li class="list-group-item">
		<span class="pull-right"><b><?php echo $data['team_name']; ?></b></span>
		<?php echo icon('fa-gamepad'); ?> Team
	</li>
	<?php endif; ?>
	<li class="list-group-item">
		<span class="pull-right"><b><?php echo $data['role']; ?></b></span>
		<?php echo icon('fa-sitemap'); ?> Proposed Position
	</li>
	<li class="list-group-item">
		<span class="pull-right"><b><?php echo $data['size']; ?></b></span>
		<?php echo icon('fa-users').' '.($data['size'] > 1 ? 'Available positions' : 'Available position'); ?>
	</li>
	<?php if ($data['date_end']): ?>
	<li class="list-group-item">
		<span class="pull-right"><b><?php echo timetostr('%e %b %Y', $data['date_end']); ?></b></span>
		<?php echo icon('fa-calendar-o'); ?> Deadline
	</li>
	<?php endif; ?>
</ul>