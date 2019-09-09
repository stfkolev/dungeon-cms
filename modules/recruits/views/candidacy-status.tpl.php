<?php if ($data['status'] == 1): ?>
	<div class="alert alert-info no-margin">Application <b>under review</b> by recruiters.</div>
<?php elseif ($data['status'] == 2): ?>
	<div class="alert alert-success no-margin">Application <b>accepted</b> !</div>
<?php else: ?>
	<div class="alert alert-danger no-margin">Application <b>refused</b> !</div>
<?php endif; ?>
<?php if ($data['reply_text']): ?>
	<h3>Recruiters' response</h3>
	<?php echo $data['reply_text']; ?>
<?php endif; ?>