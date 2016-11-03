$(document).ready(function() {
	//$('.task-modal').modal('show');

	$('.new_vehicle_link').click( function(){
		$('#vehicle-modal').modal('show');
		setTimeout(function() {
			$('#vehicle-modal .bootstrap-select').addClass('open');
		}, 50);
	});

	$('.new_task_link').click( function(){
		$('#task-modal').modal('show');
		setTimeout(function() {
			$('#task-modal .bootstrap-select').addClass('open');
		}, 50);
	});
});