$(document).ready(function() {

    $('.job_datepicker').datetimepicker({
        timepicker: false,
        inline: true,
        format: 'Y.m.d',
        yearStart: new Date().getFullYear(),
        yearEnd: new Date().getFullYear() + 2,
        scrollMonth: false,
        defaultSelect: false,
        minDate: 0,
        onSelectDate: function() {
            choosen_date = $(this).parent().find('.job_datepicker').val();
            $(this).parent().parent().find('.panel-title span').html( choosen_date );
        }
    });
    // Initially reset checkbox
    $('.form-control input[type=checkbox]').prop('checked', false);

    $('.record_name').click( function(){
        $(this).parent().toggleClass('checked');
        obj = $(this).parent().find('input[type=checkbox]');
        if( obj.is(':checked') )
            obj.prop('checked', false);
        else
            obj.prop('checked', true );
    });

    $('.find_tasks').click( function(){
        $(this).toggleClass('checked');
        if( $(this).hasClass('checked') ){
            $(this).closest( ".transport_form" ).find('.datepicker').show();
            $('#own_delivery_form .button-text').html('FIND ROUTE & TASKS');
        }
        else{
            $(this).closest( ".transport_form" ).find('.datepicker').hide();
            $('#own_delivery_form .button-text').html('FIND ROUTE');
        }
    });

    // loading spinner function
    $(document)
        .ajaxStart(function() {
            $('#loadingDiv').show();
        })
        .ajaxStop(function() {
            $('#loadingDiv').hide();
        })
        .ajaxComplete(function() {
            $('#loadingDiv').hide();
        })
        .ajaxSuccess(function() {
            $('#loadingDiv').hide();
        })
        .ajaxError(function() {
            $('#loadingDiv').hide();
        });

    $('.vehicle-temperature-values, .vehicle-temperature-icon').hide();
    $('.selectpicker').selectpicker({
        style: 'btn-default',
        showIcon: true,
    });
    $('#vehicle-modal .bootstrap-select').addClass('open');
    $('#vehicle-modal #trunk_length, #vehicle-modal #trunk_width, #vehicle-modal #trunk_height').change(function(){
        t_length = parseFloat( $('#vehicle-modal #trunk_length').val()); 
        t_width = parseFloat( $('#vehicle-modal #trunk_width').val()); 
        t_height = parseFloat( $('#vehicle-modal #trunk_height').val()); 

        $('#vehicle-modal #trunk_volume').val( t_length * t_width * t_height );
    });

    $('.selectpicker').on('change', function (e) {
        setMaxVehicleSpeed( $(this) );
    });
});

function setMaxVehicleSpeed( obj ){
    vehicle_type = obj.val();
    switch (vehicle_type){
        case '1':
            max_speed = 100;
        break;
        case '2':
            max_speed = 120;
        break;
        case '3':
            max_speed = 120;
        break;
        case '4':
            max_speed = 80;
        break;
        case '5':
            max_speed = 80;
        break;
        default:
            max_speed = 80;
        break;
    }

    $('#vehicle-modal #select-max-speed').val( max_speed );
}

// show or hide Temperature Control input fields
function toggleVehicleTempIcon( obj ) {
    setTimeout(function() {
        if ( $(obj).hasClass("active")) {
            $(obj).closest('.cargo-items').find('.vehicle-temperature-icon').show();
        }
        else {
            $(obj).closest('.cargo-items').find('.vehicle-temperature-icon').hide();
        }
        $(obj).closest('.cargo-items').find('.temp_control').removeClass("active");
        toggleVehicleTempControl( $(obj).closest('.cargo-items').find('.temp_control') );
    }, 30);
}

// show or hide Temperature icon on modal
function toggleVehicleTempControl( obj ) {
    setTimeout(function() {
        if ($(obj).hasClass("active")) {
            $(obj).closest('.cargo-items').find('.vehicle-temperature-values').show();
        }
        else {
            $(obj).closest('.cargo-items').find('.vehicle-temperature-values').hide();
        }
    }, 30);
}
