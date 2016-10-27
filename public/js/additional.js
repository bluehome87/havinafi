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
        if( $(this).hasClass('checked') )
            $('.datepicker').show();
        else
            $('.datepicker').hide();
    });
});


function refreshTaskContents()
{

}

function refreshVehicleContents()
{

}