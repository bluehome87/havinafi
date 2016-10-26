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
            $('.datepicker .panel-title span').html( $('.datepicker .job_datepicker').val() );
        }
    });

    
});