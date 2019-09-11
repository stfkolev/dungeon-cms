/* Declaration of the image download area */
Dropzone.autoDiscover = false;
$('#gallery-dropzone').dropzone({
	dictDefaultMessage: '<div class="text-center"><h2><?php echo icon('fa-cloud-upload'); ?> DropZone</h2><p class="text-muted">Drop your images in this area, or click here</p></div>',
	addRemoveLinks: true,
	autoProcessQueue: false,
	parallelUploads: 20,
	init: function() {
		var myDropzone   = this;
		var submitButton = $('#gallery-dropzone-add');
		var progressBar  = $('.progress-bar');
		submitButton.hide();
		$('.upload-infos').hide();
		submitButton.prop('disabled', false);

		/* We launch the upload on click of the button */
		submitButton.on('click', function() {
			submitButton.html('<i class="fa fa-spinner fa-spin"></i> Téléchargement en cours...');
			submitButton.prop('disabled', true);
			myDropzone.processQueue();
		});
		
		/* Event: when a file is added, we display the upload button */
		myDropzone.on('addedfile', function() {
			submitButton.show();
			submitButton.html('<?php echo icon('fa-cloud-upload'); ?> Add images');
			submitButton.prop('disabled', false);
			$('.label-dropzone').hide();
		});
		
		/* Event: added file, remove it from DropZone */
		myDropzone.on('complete', function(file, total_files) {
			myDropzone.removeFile(file);
			if(myDropzone.getQueuedFiles().length > 0 && myDropzone.getUploadingFiles().length > 0) {
				myDropzone.processQueue();
			}
		});

		/* Event: when a file is deleted */
		myDropzone.on('removedfile', function() {
			if(myDropzone.getQueuedFiles().length == 0 && myDropzone.getUploadingFiles().length == 0) {
				submitButton.hide();
				$('.upload-infos').hide();
				$('.label-dropzone').show();
			}
		});
		
		/* Event: when all files are upload, we hide the button */
		myDropzone.on('queuecomplete', function() {
			submitButton.hide();
			$('.upload-infos').hide();
			location.reload();
		});
		
		myDropzone.on('totaluploadprogress', function(totalPercentage, totalBytesToBeSent, totalBytesSent) {
			var sizeInMB     = (totalBytesToBeSent / (1024*1024)).toFixed(2);
			var sentsizeInMB = (totalBytesSent / (1024*1024)).toFixed(2);
			progressBar.css({width:totalPercentage+'%'});
			if(totalPercentage === 100) {
				$('.progress-percent').html('<i class="fa fa-spinner fa-spin"></i> Just a moment...');
			} else {
				$('.progress-percent').html('<b><i class="fa fa-spinner fa-spin"></i> '+Math.round(totalPercentage)+'%</b> Please wait...');
			}
			$('.progress-size').html(sentsizeInMB+'/'+sizeInMB+' Mo');
			$('.upload-infos').show();
		});
	}
});

/* Actions pour changer de type d'affichage */
$('.vignettes-content > #gallery-table').hide();
$('.vignettes-content > #gallery-vignettes').show();

$('#gallery-display-vignettes').on('click', function() {
	$('.vignettes-content > #gallery-table').hide();
	$('.vignettes-content > #gallery-vignettes').show();
	
	$(this).toggleClass('active');
	
	$('#gallery-display-tableau').removeClass('active');
});

$('#gallery-display-tableau').on('click', function() {
	$('.vignettes-content > #gallery-table').show();
	$('.vignettes-content > #gallery-vignettes').hide();
	
	$(this).toggleClass('active');

	$('#gallery-display-vignettes').removeClass('active');
});