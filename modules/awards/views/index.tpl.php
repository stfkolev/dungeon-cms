<?php if ($data['stats-team'] || $data['stats-game']): ?>
	<?php if ($data['image_id']): ?>
		<img class="img-responsive" src="<?php echo path($data['image_id']); ?>" alt="" />
	<?php endif; ?>
	<div class="panel-body">
		<div class="well text-center">
			<h4><?php echo $data['stats-team'] ? 'Awards on this team' : 'Awards on this game'; ?></h4>
			<ul class="list-inline no-margin">
				<li>
					<span data-toggle="tooltip" title="1ère place"><?php echo icon('fa-trophy fa-2x trophy-gold'); ?></span><br />
					<b><?php echo $data['total_gold'][0].($data['total_gold'][0] > 1 ? ' trophies' : ' trophy'); ?></b>
				</li>
				<li>
					<span data-toggle="tooltip" title="2ème place"><?php echo icon('fa-trophy fa-2x trophy-silver'); ?></span><br />
					<b><?php echo $data['total_silver'][0].($data['total_silver'][0] > 1 ? ' trophies' : ' trophy'); ?></b>
				</li>
				<li>
					<span data-toggle="tooltip" title="3ème place"><?php echo icon('fa-trophy fa-2x trophy-bronze'); ?></span><br />
					<b><?php echo $data['total_bronze'][0].($data['total_bronze'][0] > 1 ? ' trophies' : ' trophy'); ?></b>
				</li>
			</ul>
		</div>
<?php else: ?>
<div class="panel-body">
<?php endif; ?>
	<div class="table-responsive">
		<table class="table table-hover no-margin">
			<thead>
				<tr>
					<th class="col-md-1"></th>
					<th class="col-md-1 text-center"><span data-toggle="tooltip" title="Ranking"><?php echo icon('fa-trophy'); ?></span></th>
					<th class="col-md-2"><span data-toggle="tooltip" title="Platform"><?php echo icon('fa-tv'); ?></span></th>
					<th class="col-md-8" colspan="2">Event</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($data['awards']):
					foreach ($data['awards'] as $award): ?>
					<tr>
						<td>
							<span data-toggle="tooltip" title="<?php echo timetostr($this->lang('date_long'), $award['date']); ?>"><?php echo icon('fa-calendar-o'); ?></span>
						</td>
						<td class="text-center">
							<?php
							if ($award['ranking'] == 1)
							{
								echo '<span data-toggle="tooltip" title="'.$award['ranking'].'st / '.$award['participants'].' teams">'.icon('fa-trophy trophy-gold').'</span>';
							}
							else if ($award['ranking'] == 2)
							{
								echo '<span data-toggle="tooltip" title="'.$award['ranking'].'nd / '.$award['participants'].' teams">'.icon('fa-trophy trophy-silver').'</span>';
							}
							else if ($award['ranking'] == 3)
							{
								echo '<span data-toggle="tooltip" title="'.$award['ranking'].'rd / '.$award['participants'].' teams">'.icon('fa-trophy trophy-bronze').'</span>';
							}
							else
							{
								echo $award['ranking'].'<small>th</small>';
							}
							?>
						</td>
						<td><?php echo $award['platform']; ?></td>
						<td>
							<a href="<?php echo url('awards/'.$award['award_id'].'/'.url_title($award['name'])); ?>"><?php echo $award['name']; ?></a>
						</td>
						<td>
							<?php if ($award['location']): ?><div><span data-toggle="tooltip" title="Lieu"><?php echo icon('fa-map-marker').' '.$award['location']; ?></span></div><?php endif; ?>
						</td>
					</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="3" class="text-center">No trophies...</td>
				</tr>
				<?php
				endif;
				?>
			</tbody>
		</table>
	</div>
</div>