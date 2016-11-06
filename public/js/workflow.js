$(document).ready(function() {
	$('#vehicle-modal button.submit').click(function(e) {

		// save new vehicle data using ajax function
	    addNewVehicle();
	    e.preventDefault();
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
                refreshVehicleList();
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
                    element = '<div class="input-group">';
                    element += '    <span class="form-control" aria-label="own-vehicles'+value['id']+'">';
                    element += vehicleTypeIcon( value['type'] );
                    element += '        <input type="checkbox" class="vehicle_id" data-vehicle-id="'+value['id']+'">';
                    element += '        <span class="record_name ellipsis_label">';
                    element += '            '+value['name']+'';
                    element += '        </span>';
                    element += '       <button class="btn-link pull-right" onclick="showVehiclePopup('+value['id']+')" type="button">';
                    element += '           <i class="fa fa-info-circle"></i>';
                    element += '        </button>';
                    element += '   </span>';
                    element += '</div>';

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

            element = '<div class="input-group">';
            element += '    <span class="form-control">';
            element += '        <a class="add_new_link new_vehicle_link" href="#"><i class="fa fa-plus"></i> ADD NEW VEHICLE</a>';
            element += '    </span>';
            element += '</div>';
            container_obj.append(element);
        },
        error: function(data)
        {
            container_obj.html('<p>You don\'t have any vehicles.</p>');
        }
    });
}