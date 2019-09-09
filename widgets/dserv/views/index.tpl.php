<div class="panel-body">
	<div class="text-center">
		<h3><?php echo $data['dserv_hostname']; ?></h3> <?php echo $data['dserv_game']; ?>   
	</div>
<br>
	<div class="col-xs-4 text-center">
		<h2 class="no-margin"><i class="fa fa-signal"> </i></h2> <?php echo $data['dserv_users']; ?>
	</div>
	<div class="col-xs-4 text-center">
		<h2 class="no-margin"><i class="fa fa-shield"> </i></h2> <?php echo $data['dserv_vac']; ?>
	</div>
	<div class="col-xs-4 text-center">
		<h2 class="no-margin"><i class="fa fa-map-marker"> </i></h2> <?php echo $data['dserv_map']; ?>
	</div>
</div>