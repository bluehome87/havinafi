$(document).ready(function() {
	$('.new_vehicle_link').click( function(){
		$('.vehicle-modal').modal('show');
		setTimeout(function() {
			$('#vehicle-modal .bootstrap-select').addClass('open');
		}, 50);
	});
});