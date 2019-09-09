<?php if(!empty($data['votes'])): ?>
<div class="pull-right text-right">
	<ul class="list-inline no-margin">
		<li class="text-success"><?php echo $data['total_up']; ?> <?php echo icon('fa-thumbs-o-up'); ?></li>
		<li class="text-danger"><?php echo $data['total_down']; ?> <?php echo icon('fa-thumbs-o-down'); ?></li>
	</ul>
</div>
<p><b>Voting trend</b></p>
<div class="progress">
	<div class="progress-bar progress-bar-success" style="width: <?php echo ceil(($data['total_up']/$data['total_votes'])*100); ?>%"><?php echo ceil(($data['total_up']/$data['total_votes'])*100); ?>%</div>
	<div class="progress-bar progress-bar-danger" style="width: <?php echo ceil(($data['total_down']/$data['total_votes'])*100) - 1; ?>%"><?php echo ceil(($data['total_down']/$data['total_votes'])*100) - 1; ?>%</div>
</div>
<div class="row">
	<?php foreach ($data['votes'] as $vote): ?>
	<div class="well">
		<div class="media">
			<div class="media-left">
				<?php echo $this->user->avatar($vote['avatar'], $vote['sex']); ?>
			</div>
			<div class="media-body">
				<div class="pull-right">
					<span class="label<?php echo $vote['vote'] ? ' label-success' : ' label-danger' ?>" style="display: inline-block"><?php echo $vote['vote'] ? icon('fa-thumbs-o-up').' Agree' : icon('fa-thumbs-o-down').' Disagree' ?></span>
				</div>
				<h4 class="media-heading"><?php echo $this->user->link($vote['user_id'], $vote['username']); ?></h4>
				<?php echo bbcode($vote['comment']); ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
<?php else: ?>
There are no votes yet ...
<?php endif; ?>
<?php if ($data['status'] == 1): ?>
<hr />
<h4>My opinion on this application</h4>
<?php echo $data['vote_form']; ?>
<?php endif; ?>