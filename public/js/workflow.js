$(document).ready(function() {
	$("#vehicle-modal button.submit").click(function(e) {
	    var url = $("#vehicle-modal form").attr('action');
	    $('#vehicle-modal fieldset .errors').remove();

	    post_data = $("#vehicle-modal form").serialize();

	    // TODO: check delivery type( passenger and cargo ) and add new param
	    // cargo: 		package_delivery 0 : 1
	    // passenger: 	passenger_delivery 0 : 1

	    package_delivery = 1;
	    passenger_delivery = 1;

	    post_data += "&package_delivery="+package_delivery+"&passenger_delivery="+passenger_delivery;
	    $.ajax({
	        type: "POST",
	        url: url,
	        data: post_data,
	        success: function(data)
	        {
	            sendSystemMessage(data['status'], data['message']);
	            if(data['status'] == 'success') {
	                //restoreMyVehiclesBlock();
	                //updateVehiclesList('id');
	                //updateJobVehiclesList();
	                closeVehicleModal();
	            }
	        },
	        error: function(data)
	        {
	            var errors = data.responseJSON;
	            showErrors(errors, 'vehicle-modal');
	        }
	    });

	    e.preventDefault();
	});
});
