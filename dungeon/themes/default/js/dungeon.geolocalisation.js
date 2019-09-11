$('body').on('dungeon.load', function(){
	$.ajax({
		url: 'https://dungeon.com/geolocalisation.json',
		type: 'POST',
		data: {
			ip_address: $.makeArray($.unique($('[data-geolocalisation]').map(function(){
				return $(this).attr('data-geolocalisation');
			})))
		},
		crossDomain: false,
		success: function(data){
			$.each(data, function(ip, data){
				$('[data-geolocalisation="'+ip+'"]').replaceWith('<img src="'+(data['flag'] ? '<?php echo url('dungeon/themes/default/images/flags/'); ?>'+data['flag'] : '<?php echo url('dungeon/themes/default/images/icons/user-silhouette-question.png'); ?>')+'" data-toggle="tooltip" title="'+data['location']+'" style="margin-right: 10px;" alt="" />');
			});
		}
	});
});
