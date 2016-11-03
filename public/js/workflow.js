$(document).ready(function() {
	//$('.task-modal').modal('show');

	$('.new_vehicle_link').click( function(){
		$('#vehicle-modal').modal('show');
		$('.modal-body .tab-pane').removeClass('active');
		$('.modal-body .nav-tabs li').removeClass('active');		
		setTimeout(function() {
			$('#vehicle-modal .bootstrap-select').addClass('open');
		}, 50);
	});

	$('.new_task_link').click( function(){
		$('#task-modal').modal('show');
		$('.modal-body .tab-pane').removeClass('active');
		$('.modal-body .nav-tabs li').removeClass('active');
		setTimeout(function() {
			$('#task-modal .bootstrap-select').addClass('open');
		}, 50);
	});
});