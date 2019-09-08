<div class="modal fade" id="modalTerms" tabindex="-1" role="dialog" aria-labelledby="modalTermsLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalTermsLabel">Terms of usage</h4>
			</div>
			<div class="modal-body">
				<?php echo bbcode($this->config->dungeon_registration_terms); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo icon('fa-check'); ?> I have read the terms of usage</button>
			</div>
		</div>
	</div>
</div>
