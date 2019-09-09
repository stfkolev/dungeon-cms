Sent on <b><?php echo timetostr('%e %b %Y', $data['date']); ?></b>, requesting to <?php echo $data['team_id'] ? ' join the team <b>'.$data['team_name'].'</b> in the position of <b>'.$data['role'].'</b>' : ' in the position of <b>'.$data['role'].'</b>'; ?>
<hr />
<h4>Introduction</h4>
<?php echo $data['presentation'] ? $data['presentation'] : 'Not specified.'; ?>
<hr />
<h4>Motivation</h4>
<?php echo $data['motivations'] ? $data['motivations'] : 'Not specified.'; ?>
<hr />
<h4>Experiences</h4>
<?php echo $data['experiences'] ? $data['experiences'] : 'Not specified.'; ?>