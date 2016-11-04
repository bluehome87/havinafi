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
            $(this).closest( '.transport_form' ).find('.datepicker').show();
            $('#own_delivery_form .button-text').html('FIND ROUTE & TASKS');
        }
        else{
            $(this).closest( '.transport_form' ).find('.datepicker').hide();
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

    // W x H x L event for Popup
    $('.trunk_length, .trunk_width, .trunk_height').keyup(function(){
        t_length = parseFloat( $(this).closest('.popup-modal').find('.trunk_length').val()); 
        t_width = parseFloat( $(this).closest('.popup-modal').find('.trunk_width').val()); 
        t_height = parseFloat( $(this).closest('.popup-modal').find('.trunk_height').val()); 
        t_volume = t_length * t_width * t_height;
        $(this).closest('.popup-modal').find('.trunk_volume').val( t_volume );
    });
    $('.trunk_volume').keypress(function(){
        $('.trunk_length').val('');
        $('.trunk_width').val('');
        $('.trunk_height').val('');
    });
    // -------------------------------

    $('#vehicle-modal .selectpicker').on('change', function (e) {
        setMaxVehicleSpeed( $(this) );
    });

    $('#task-modal .selectpicker').on('change', function (e) {
        setTaskTabs( $(this) );
    });

    $('.new_vehicle_link').click( function(){
        $('#vehicle-modal').modal('show');
        $('.modal-body .tab-pane').removeClass('active');
        $('.modal-body .nav-tabs li').removeClass('active');
        hideErrors();
        setTimeout(function() {
            $('#vehicle-modal .bootstrap-select').addClass('open');
        }, 50);
    });

    $('.new_task_link').click( function(){
        $('#task-modal').modal('show');
        $('.modal-body .tab-pane').removeClass('active');
        $('.modal-body .nav-tabs li').removeClass('active');
        hideErrors();
        setTimeout(function() {
            $('#task-modal .bootstrap-select').addClass('open');
        }, 50);
    });
});

// show errors in a selected block (e.g. when form was submitted, but some fields have errors)
function showErrors(errors, block) {
    response = '<div class="alert alert-danger errors" role="alert">';
    response += '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
    response += '<span> Errors: </span><ul>';
    $.each( errors, function( index, value ){
        response += '<li>' + value + '</li>';
    });
    response += '</ul></div>';

    $('#' + block + ' fieldset').prepend(response);
}

function hideErrors(){
    $('.alert.errors').remove();
}

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

// show or hide Temperature icon on modal
function toggleTempIcon( obj ) {
    setTimeout(function() {
        if ( $(obj).hasClass('active')) {
            $(obj).closest('.cargo-items').find('.vehicle-temperature-icon').show();
        }
        else {
            $(obj).closest('.cargo-items').find('.vehicle-temperature-icon').hide();
        }
        $(obj).closest('.cargo-items').find('.temp_control').removeClass('active');
        toggleTempControl( $(obj).closest('.cargo-items').find('.temp_control') );
    }, 30);
}

// show or hide Temperature Control input fields
function toggleTempControl( obj ) {
    setTimeout(function() {
        if ($(obj).hasClass('active')) {
            $(obj).closest('.cargo-items').find('.vehicle-temperature-values').show();
        }
        else {
            $(obj).closest('.cargo-items').find('.vehicle-temperature-values').hide();
        }
    }, 30);
}

function setTaskTabs( obj ){
    task_type = obj.val();
    switch (task_type){
        case '1':
            $('.task-modal .nav-tabs li').css('width', '25%');
            $('.task-modal .nav-tabs li').removeClass('active');
            $('#t_cargo-menu').addClass("show");
            $('#t_passenger-menu').addClass("show");

            $('.task-modal .tab-pane').removeClass("active");
        break;
        case '2':
            $('.task-modal .nav-tabs li').css('width', '33.3333333%');
            $('.task-modal .nav-tabs li').removeClass('active');
            $('#t_cargo-menu').removeClass("show");
            $('#t_cargo-menu').addClass("hide");
            $('#t_passenger-menu').addClass("show");

            $('.task-modal .tab-pane').removeClass("active");
        break;
        case '3':
            $('.task-modal .nav-tabs li').css('width', '33.3333333%');
            $('.task-modal .nav-tabs li').removeClass('active');
            $('#t_passenger-menu').removeClass("show");
            $('#t_passenger-menu').addClass("hide");
            $('#t_cargo-menu').addClass("show");

            $('.task-modal .tab-pane').removeClass("active");
        break;
    }
}