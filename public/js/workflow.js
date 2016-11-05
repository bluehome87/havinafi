$(document).ready(function() {
	$('#vehicle-modal button.submit').click(function(e) {

		// save new vehicle data using ajax function
	    addNewVehicle();
	    e.preventDefault();
	});

	$('.fa-question-circle').click( function(){
		refreshVehicleList();
	});
});

function addNewVehicle()
{
	var url = $('#vehicle-modal form').attr('action');
    $('#vehicle-modal fieldset .errors').remove();

    post_data = $('#vehicle-modal form').serialize();

    // TODO: check delivery type( passenger and cargo ) and add new param
    // cargo: 		package_delivery 0 : 1
    // passenger: 	passenger_delivery 0 : 1

    package_delivery = 1;
    passenger_delivery = 1;

    post_data += '&package_delivery='+package_delivery+'&passenger_delivery='+passenger_delivery;
    $.ajax({
        type: 'POST',
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
}

function refreshVehicleList()
{
	container_obj = $('.my_vehicle_block .tab-pane');
	container_obj.html('');
	$.ajax({
        type: 'POST',
        url: '/get-vehicle-list',
        success: function(data)
        {
            if(data['status'] == 'success') {
                is_empty = true;

                $.each( data['data'], function( index, value ){
                    element = '<div class="input-group"><span class="input-group-addon">';
                    element += '<input type="checkbox" aria-label="own-vehicles'+value['id']+'" name="my_vehicles['+value['id']+']">';
                    element += '</span><span class="form-control" aria-label="own-vehicles'+value['id']+'">'+value['name'];
                    element += '<button class="btn-link pull-right"><span class="glyphicon glyphicon-share" aria-hidden="true"></span>';
                    element += '</button></span></div>';

                    container_obj.append(element);
                    is_empty = false;
                });

                if (is_empty === true) {
                    container_obj.html('<p>You don\'t have any vehicles.</p>');
                }
            }
            else if(data['status'] == 'danger') {
                container_obj.html('<p>You don\'t have any vehicles.</p>');
            }
        },
        error: function(data)
        {
            container_obj.html('<p>You don\'t have any vehicles.</p>');
        }
    });
}