<div class="text-center">
	<b>Most awarded team</b>
	<h1><?php echo icon('fa-trophy'); ?></h1>
	Team <a href="<?php echo url('awards/team/'.$data['team_id'].'/'.$data['name']); ?>"><b><?php echo $data['team_title']; ?></b></a><br />
	With <?php echo $data['nb_awards'] > 1 ? $data['nb_awards'].' trophies' : $data['nb_awards'].' trophy'; ?>
</div>