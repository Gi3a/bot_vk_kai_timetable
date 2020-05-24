/* ===================
    Ajax load

    Project: Feed;
    Type: Ajax load;
    Author: Giza;

=================== */

$(document).ready(function() {
	$('form').submit(function(event) {
		var json;
		$(".block-load").show();
		event.preventDefault();
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(result) {
				json = jQuery.parseJSON(result);
				if(json.status && json.url){
					swal({
						title: '', 
						text: json.message,
						timer: 5000,
						type: json.status,
						icon: json.status
					}).then(function() {
						location.href = '/' + json.url;;
					});
				} else if (json.url) {
					window.location.href = '/' + json.url;
				}
				else {
					swal('',json.message,json.status);
					$(".block-load").hide();
				}
			},
		});
	});
});