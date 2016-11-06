//
// MAP FUNCTIONALITY
//

var map = L.map('map', {
    center: [64.840, 24.356],
    zoom: 5
});

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiZWVzdGFhcyIsImEiOiJjaWxud2VvcG8wMDJndWlsdWZ0eXVwc2Z0In0.OlcAjkJYWYxnYpT1DWWl4A', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
    '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
    'Imagery © <a href="http://mapbox.com">Mapbox</a>',
    id: 'mapbox.streets'
}).addTo(map);

//
// END OF MAP FUNCTIONALITY
//



//
// GENERAL SETUP, INITIAL CONFIG, VISUAL OPTIONS
//

$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
});

$(document).ready(function() {
    // resize front-end sections at beginning
    resizeSections();

    // resize the map so it fits exactly browser window size
    resizeMap();

    // auto show dismissable system messages (hidden by default due to visual distractions)
    $("#system-message .alert-dismissible").fadeTo("fast", 500).slideDown("fast");

    // auto close dismissable system messages
    $("#system-message .alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
        $("#system-message .alert-dismissible").alert('close');
    });

    // place map controls where they should be when document is open
    // $('#map .leaflet-control-container .leaflet-left').addClass('open');
    $('#map .leaflet-control-container .leaflet-left').css('transition', 'all ease-in 300ms');
});

$(window).resize(function() {
    // resize front-end sections on window resize
    resizeSections();

    // resize the map on window resize
    resizeMap();
});

// resize front-end sections
function resizeSections() {
    winHeight = $(window).height();
    userSectionsH = winHeight - $('.navbar').height() - 4;

    // defined height of sections is 492px. if screen is bigger than this + header and defined margins
    // then set bigger margins (equal from top and bottom)
    // else set appropriate sections height so they fit screen's height and are scrollable inside if required
    if(winHeight > (492 + 52 + 20 * 2)) {
        newMargin = (winHeight - 52 - 492) / 2;

        $('#sections .section').css('height', 492);
        $('.guest').css('padding-top', newMargin);
        $('#sections').css('padding-bottom', newMargin);
        $('.user #sections').css('height', userSectionsH);
        $('.user #sections').css('padding-top', newMargin);
        $('#sections .section').css('margin-bottom', 0);
    }
    else {
        sectionHeight = winHeight - (52 + 20 * 2);

        $('#sections .section').css('height', sectionHeight);
        $('.guest').css('padding-top', 20);
        $('.user #sections').css('padding-top', 20);
        $('#sections').css('padding-bottom', 20);
        $('.user #sections').css('height', userSectionsH);
        $('#sections .section').css('margin-bottom', 0);
        $('#sections .section').css('overflow-y', 'scroll');
    }

    $('.user #sidebar').css('height', userSectionsH);
}

// resize the map on background
function resizeMap() {
    //mapHeight = $(window).height() - $('.navbar').height() - 4;
    //$('#map').css('height', mapHeight);
    sidebar_width = $('#sidebar').width();

    if($('#sidebar').hasClass('closed')) {      
        setTimeout(
            function() {
                $('#map').css('margin-left', 0 );
                $('#map').width( '100%' );
                $("#sidebar-toggle").css('left', 0 );
                $("#map .leaflet-control-container .leaflet-left").css('left', 0 );
            }, 50
        );
    }
    else {
        setTimeout(
            function() {
                $('#map').width( $('#main').width() - ( sidebar_width ) / 2 );
                $('#map').css('margin-left', sidebar_width / 2 );
                $("#sidebar-toggle").css('left', sidebar_width );
                $("#map .leaflet-control-container .leaflet-left").css('left', sidebar_width / 2 );
            }, 50
        );
    }

    map.invalidateSize();
}

// toggle sidebar when button is clicked
function toggleSidebar(input) {
    if($('#sidebar').hasClass('closed')) {

        $('#sidebar').removeClass('closed');
        $('#sidebar-toggle').html('<span class="glyphicon glyphicon-chevron-left"></span>');

        if(input == 'mobile') {
            $('#mobile-switcher').removeClass('pressed');
        }
    }
    else {
        $('#sidebar').addClass('closed');
        $('#sidebar-toggle').html('<span class="glyphicon glyphicon-chevron-right"></span>');

        if(input == 'mobile') {
            $('#mobile-switcher').addClass('pressed');
        }
    }
    resizeMap();
}

// send a System Message (on top)
function sendSystemMessage(status, message) {
    content = '<div class="alert alert-' + status + ' alert-dismissible fade in" role="alert">';
    content += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    content += '<span aria-hidden="true">×</span></button>' + message + '</div>';

    $('#system-message .row').html(content);

    $("#system-message .alert-dismissible").fadeTo("fast", 500).slideDown("fast");

    $("#system-message .alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
        $("#system-message .alert-dismissible").alert('close');
    });
}

//
// END OF GENERAL CONFIGURATION
//



//
// NAVIGATION RULES AND CONFIG, SHOWING SECTIONS
//

//catch user manual navigation (back/forward buttons) and show appropriate page
window.onpopstate = function(event) {
    setInitialPage();

    return true;
};

// set appropriate page content during page load
setInitialPage();

// show appropriate page content based on current url
function setInitialPage() {
    currentUrl = $(location).attr('pathname').substring(1);

    if(currentUrl.indexOf('reset-password') >= 0) {
        showResetPasswordBlock(false);
    }
    if(currentUrl.indexOf('view-vehicle') >= 0) {
        vehicleId = currentUrl.substring(currentUrl.indexOf('/') +1);
        viewVehicle(vehicleId);
    }
    if(currentUrl.indexOf('view-task') >= 0) {
        taskId = currentUrl.substring(currentUrl.indexOf('/') +1);
        viewTask(taskId);
    }
    if(currentUrl.indexOf('view-transport-time') >= 0) {
        jobId = currentUrl.substring(currentUrl.indexOf('/') +1);
        $('#jobs-accordion #job-collapse'+jobId).addClass('in');
        $('#jobs-accordion #job-collapse'+jobId+' .nav li').removeClass('active');
        $('#jobs-accordion #job-collapse'+jobId+' .nav li:eq(0)').addClass('active');
        $('#jobs-accordion #job-collapse'+jobId+' .tab-content .tab-pane').removeClass('active');
        $('#jobs-accordion #job-collapse'+jobId+' .tab-content .tab-pane:eq(0)').addClass('active');
        viewJobTime(jobId,1);
    }
    if(currentUrl.indexOf('edit-job') >= 0) {
        jobId = currentUrl.substring(currentUrl.indexOf('/') +1);
        showEditJobForm(jobId);
    }
    else {
        switch (currentUrl) {
            case 'login':
                showLoginBlock();
                break;

            case 'register':
                showRegisterBlock();
                break;

            case 'forgot-password':
                showForgotPasswordBlock();
                break;

            case 'about-us':
                showAboutUsBlock();
                break;

            case 'faq':
                showFAQBlock();
                break;

            case 'profile':
                showProfileBlock();
                break;

            case 'edit-vehicle':
                showCreateVehicleForm();
                break;

            case 'create-vehicle':
                showCreateVehicleForm();
                break;

            case 'edit-task':
                showCreateTaskForm();
                break;

            case 'create-task':
                showCreateTaskForm();
                break;

            case 'transports':
                showTransportsSection();
                break;

            default:
                true;
        }
    }
}

// show homepage
function showHomepage() {
    history.pushState(null, 'Welcome', '/');
    changePageTitle('Welcome - Transportation');
}

// show login block
function showLoginBlock() {
    history.pushState(null, 'Login', '/login');
    changePageTitle('Login - Transportation');

    hideSectionThreeBlocks();

    if($('#login-block').length) {
        $('#login-block').show();
    }
    else {
        showProfileBlock();
    }

    $('#section-three').show();
}

// show registration block
function showRegisterBlock() {
    history.pushState(null, 'Register', '/register');
    changePageTitle('Register - Transportation');

    hideSectionThreeBlocks();

    if($('#register-block').length) {
        $('#register-block').show();
    }
    else {
        showProfileBlock();
    }
    $('#section-three').show();
}

// show forgot password block
function showForgotPasswordBlock() {
    history.pushState(null, 'Forgot Password', '/forgot-password');
    changePageTitle('Forgot Password - Transportation');

    hideSectionThreeBlocks();

    if($('#forgot-password-block').length) {
        $('#forgot-password-block').show();
    }
    else {
        showProfileBlock();
    }

    $('#section-three').show();
}

// show reset password block
function showResetPasswordBlock(rewrite) {
    if(rewrite) {
        history.pushState(null, 'Reset Password', '/reset-password');
    }
    changePageTitle('Reset Password - Transportation');

    hideSectionThreeBlocks();

    if($('#reset-password-block').length) {
        $('#reset-password-block').show();
    }
    else {
        showProfileBlock();
    }

    $('#section-three').show();
}

// show about us block
function showAboutUsBlock() {
    history.pushState(null, 'Abous Us', '/about-us');
    changePageTitle('About Us - Transportation');

    hideSectionThreeBlocks();
    $('#aboutUs-block').show();
    $('#section-three').show();
}

// show F.A.Q. block
function showFAQBlock() {
    history.pushState(null, 'F.A.Q.', '/faq');
    changePageTitle('F.A.Q. - Transportation');
    hideSectionThreeBlocks();
    $('#FAQ-block').show();
    $('#section-three').show();
}

// show profile block
function showProfileBlock() {
    history.pushState(null, 'Profile', '/profile');
    changePageTitle('Profile - Transportation');
    hideSectionThreeBlocks();

    if($('#profile-block').length) {
        $('#profile-block').show();
    }
    else {
        showLoginBlock();
    }

    $('#profile-block').show();
    $('#section-three').show();
}

// hide Section Three when close button is clicked
function hideSectionThree() {
    hideSectionThreeBlocks();
    $('#section-three').hide();
    showHomepage();
}

// hide all blocks in Section Three
function hideSectionThreeBlocks() {
    $('#sections #section-three .block').each(function() {
        $(this).hide();
    });
}

// show Transports section
function showTransportsSection() {
    /*history.pushState(null, 'Transports', '/transports');
    changePageTitle('Transports - Transportation');

    $('#sidebar > div > .nav-tabs > li').removeClass('active');
    $('#sidebar > div > .nav-tabs > li:eq(2)').addClass('active');
    $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
    $('#sidebar > div > .tab-content > #transports').addClass('active');*/
}

//
// END OF NAVIGATION
//

//
// RESPONSIVE STUFF
//

// Close responsive Menu in Header when any link there is clicked
$(function() {
    var navMain = $("#top-navbar");
    navMain.on("click", "a", null, function () {
        if(!$(this).hasClass('dropdown-toggle')) {
            navMain.collapse('hide');
        }
    });
});

//
// END OF RESPONSIVE STUFF
//



//
// VEHICLE FUNCTIONALITY
//

// show a New Vehicle form
function showCreateVehicleForm() {
    $('#sidebar > div > .nav-tabs > li').removeClass('active');
    $('#sidebar > div > .nav-tabs > li:eq(0)').addClass('active');
    $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
    $('#sidebar > div > .tab-content > #my-vehicles').addClass('active');

    history.pushState(null, 'Create Vehicle', '/create-vehicle');
    changePageTitle('Create Vehicle - Transportation');

    $('#my-vehicles form').attr('action', '/create-vehicle');
    $('#my-vehicles form button[type=submit]').text('Create');

    $('#my-vehicles form input').val('');

    max_speed_sel = $('#my-vehicles form select[name="max_speed"] option:selected').val();
    if(max_speed_sel > 0 && $.isNumeric(max_speed_sel)) {
        $('#my-vehicles form select[name="max_speed"] option').removeAttr('selected');
        $('#my-vehicles form select[name="max_speed"] option:eq(0)').attr('selected', 'selected');
    }
    type_sel = $('#my-vehicles form select[name="type"] option:selected').val();
    if(type_sel > 0 && $.isNumeric(type_sel)) {
        $('#my-vehicles form select[name="type"] option').removeAttr('selected');
        $('#my-vehicles form select[name="type"] option:eq(0)').attr('selected', 'selected');
    }
    quick_max_speed_sel = $('#my-vehicles form select[name="quick_max_speed"] option:selected').val();
    if(quick_max_speed_sel > 0 && $.isNumeric(quick_max_speed_sel)) {
        $('#my-vehicles form select[name="quick_max_speed"] option').removeAttr('selected');
        $('#my-vehicles form select[name="quick_max_speed"] option:eq(0)').attr('selected', 'selected');
    }

    $('#my-vehicles form #vehicle_passenger_delivery_control').removeClass('active');
    $('#my-vehicles form #vehicle_package_delivery_control').removeClass('active');
    $('#my-vehicles form .cargo-items .btn').removeClass('active');
    $('#my-vehicles form .cargo-items .btn input').prop('checked', false);

    $('#my-vehicles .new-vehicle').hide();
    $('#my-vehicles .vehicle-selector').hide();
    $('#my-vehicles .errors').remove();
    $('#my-vehicles .actions').hide();
    $('#my-vehicles .nav-tabs').show();
    $('#my-vehicles .nav-tabs li').removeClass('active');
    $('#my-vehicles .nav-tabs li:eq(0)').addClass('active');
    $('#my-vehicles #vehicle-detailed-mode').removeClass('active');
    $('#my-vehicles #vehicle-quick-mode').addClass('active');;
    $('#my-vehicles .tab-content').show();
    $('#my-vehicles .buttons').show();
    $('#my-vehicles #vehicle-location button').show();

    $('#my-vehicles form input').removeClass('input-show');
    $('#my-vehicles textarea').removeClass('disabled');
    $('#my-vehicles textarea').removeAttr('disabled');
    $('#my-vehicles textarea').val('');
    $('#my-vehicles form textarea[name="notes"]').show();
    $('#my-vehicles form input').removeAttr('disabled');
    $('#my-vehicles form .select-show').hide();
    $('#my-vehicles select').show();
    $('#my-vehicles #vehicle-carry-form').show();
    $('#my-vehicles .overflow').hide();
    $('#my-vehicles form input').show();
    $('#my-vehicles .cost-label').addClass('edit');
    $('#my-vehicles #trunk-size').hide();
    $('#my-vehicles #cargo-size').show();
    $('#my-vehicles #cargo-weight').show();
    $('#my-vehicles select[name=quick_max_speed]').removeAttr('required');

    toggleVehicleTypeQuickControl();
    toggleVehicleTypeControl();
    toggleTempControl();

    $('#my-vehicles #vehicle-cancel').attr('onclick', 'restoreMyVehiclesBlock()');
}

// show View Vehicle details
function viewVehicle(id) {
    $('#sidebar > div > .nav-tabs > li').removeClass('active');
    $('#sidebar > div > .nav-tabs > li:eq(0)').addClass('active');
    $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
    $('#sidebar > div > .tab-content > #my-vehicles').addClass('active');

    if($.isNumeric(id)) {
        $('#my-vehicles .selectpicker').selectpicker('render');
        $('#my-vehicles .selectpicker').selectpicker('val', id);
        $('#my-vehicles .selectpicker').selectpicker('render');
        $('#my-vehicles form input').addClass('input-show');
        $('#my-vehicles textarea').addClass('disabled');
        $('#my-vehicles textarea').prop('disabled', 'disabled');
        $('#my-vehicles form input').prop('disabled', 'disabled');
        $('#my-vehicles select').hide();
        $('#my-vehicles #vehicle-location button').hide();
        $('#my-vehicles #vehicle-carry-form').show();
        $('#my-vehicles .overflow').show();
        $('#my-vehicles form .select-show').show();

        history.pushState(null, 'View Vehicle', '/view-vehicle/' + id);
        changePageTitle('View Vehicle - Transportation');

        // get info about current vehicle from backend with AJAX
        $.ajax({
            type: "POST",
            url: '/get-vehicle-info/' + id,
            success: function (data) {
                if(data['status'] == 'success') {
                    $('#my-vehicles form input[name="name"]').val(data['data']['name']);
                    $('#my-vehicles form select[name="type"]').val(data['data']['type']);
                    $('#my-vehicles .select-show[name="select-vehicle-type"]').html(vehicleTypeIcon(data['data']['type']));
                    $('#my-vehicles form select[name="max_speed"]').val(data['data']['max_speed']);
                    $('#my-vehicles .select-show[name="select-max-speed"]').text("Max "+$('#my-vehicles form select[name="max_speed"]').find(":selected").text());
                    if(data['data']['notes'].length > 0) {
                        $('#my-vehicles form textarea[name="notes"]').val(data['data']['notes']);
                        $('#my-vehicles form textarea[name="notes"]').show();
                        $('#my-vehicles form textarea[name="notes"]').attr('data-show', 'show');
                    }
                    else {
                        $('#my-vehicles form textarea[name="notes"]').hide();
                        $('#my-vehicles form textarea[name="notes"]').attr('data-show', 'hide');
                    }
                    if(data['data']['passenger_delivery'] == 1) {
                        $('#vehicle_passenger_delivery_control').attr('data-show', 'passenger_delivery');
                        $('#vehicle_passenger_delivery_control').addClass('active');
                        $('#my-vehicles form input[name="passenger_delivery"]').prop('checked', true);

                    }
                    else {
                        $('#vehicle_passenger_delivery_control').attr('data-show', 'hide');
                        $('#vehicle_passenger_delivery_control').removeClass('active');
                        $('#my-vehicles form input[name="passenger_delivery"]').prop('checked', false);
                    }
                    if(data['data']['package_delivery'] == 1) {
                        $('#vehicle_package_delivery_control').attr('data-show', 'package_delivery');
                        $('#vehicle_package_delivery_control').addClass('active');
                        $('#my-vehicles form input[name="package_delivery"]').prop('checked', true);
                    }
                    else {
                        $('#vehicle_package_delivery_control').attr('data-show', 'hide');
                        $('#vehicle_package_delivery_control').removeClass('active');
                        $('#my-vehicles form input[name="package_delivery"]').prop('checked', false);
                    }
                    $('#my-vehicles form input[name="from_address"]').val(data['data']['from_address']);
                    $('#my-vehicles form input[name="from_city"]').val(data['data']['from_city']);
                    $('#my-vehicles form input[name="from_time"]').val(data['data']['from_time'].substring(0, data['data']['from_time'].length - 3)).hide();
                    $('#my-vehicles form input[name="from_time"]').attr('data-show', 'hide');
                    $('#my-vehicles .select-show[name="select-from-time"]').text(data['data']['from_time'].substring(0, data['data']['from_time'].length - 3));
                    $('#my-vehicles form input[name="to_address"]').val(data['data']['to_address']);
                    $('#my-vehicles form input[name="to_city"]').val(data['data']['to_city']);
                    $('#my-vehicles form input[name="to_time"]').val(data['data']['to_time'].substring(0, data['data']['to_time'].length - 3)).hide();
                    $('#my-vehicles form input[name="to_time"]').attr('data-show', 'hide');
                    $('#my-vehicles .select-show[name="select-to-time"]').text(data['data']['to_time'].substring(0, data['data']['to_time'].length - 3));
                    $('#my-vehicles form input[name="cost_eur_task"]').val(data['data']['cost_eur_task']);
                    $('#my-vehicles form input[name="cost_eur_km"]').val(data['data']['cost_eur_km']);
                    $('#my-vehicles form input[name="cost_eur_h"]').val(data['data']['cost_eur_h']);
                    $('#my-vehicles form input[name="max_passengers"]').val(data['data']['max_passengers']);
                    $('#my-vehicles form input[name="invalid_seats"]').val(data['data']['invalid_seats']);
                    $('#my-vehicles form input[name="trunk_length"]').val(data['data']['trunk_length']).hide();
                    $('#my-vehicles form input[name="trunk_width"]').val(data['data']['trunk_width']).hide();
                    $('#my-vehicles form input[name="trunk_height"]').val(data['data']['trunk_height']).hide();
                    $('#my-vehicles form input[name="max_weight"]').val(data['data']['max_weight']).hide();
                    $('#my-vehicles form input[name="trunk_length"]').attr('data-show', 'hide');
                    $('#my-vehicles form input[name="trunk_width"]').attr('data-show', 'hide');
                    $('#my-vehicles form input[name="trunk_height"]').attr('data-show', 'hide');
                    $('#my-vehicles form input[name="max_weight"]').attr('data-show', 'hide');
                    $('#my-vehicles .select-show[name="select-trunk-size"]').html(data['data']['trunk_length']+' x '+data['data']['trunk_width']+' x '+data['data']['trunk_height']+' m');
                    $('#my-vehicles .select-show[name="select-max-weight"]').html(data['data']['max_weight']+' kg');
                    $('#my-vehicles form input[name="temp_min"]').val(data['data']['temp_min']).hide();
                    $('#my-vehicles form input[name="temp_min"]').attr('data-show', 'hide');
                    $('#my-vehicles .select-show[name="select-temp-min"]').html('Min '+data['data']['temp_min']+'°C');
                    $('#my-vehicles form input[name="temp_max"]').val(data['data']['temp_max']).hide();
                    $('#my-vehicles form input[name="temp_max"]').attr('data-show', 'hide');
                    $('#my-vehicles .select-show[name="select-temp-max"]').html('Max '+data['data']['temp_max']+'°C');
                    if(data['data']['weather_protection'] == 1) {
                        $('#my-vehicles form #weather_protection').addClass('active');
                        $('#my-vehicles form input[name="weather_protection"]').prop('checked', true);
                        $('#my-vehicles form input[name="weather_protection"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-vehicles form .weather_protection').removeClass('active');
                        $('#my-vehicles form input[name="weather_protection"]').prop('checked', false);
                        $('#my-vehicles form input[name="weather_protection"]').attr('data-checked', 'false');
                    }
                    if(data['data']['food_accepted'] == 1) {
                        $('#my-vehicles form #food_accepted').addClass('active');
                        $('#my-vehicles form input[name="food_accepted"]').prop('checked', true);
                        $('#my-vehicles form input[name="food_accepted"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-vehicles form #food_accepted').removeClass('active');
                        $('#my-vehicles form input[name="food_accepted"]').prop('checked', false);
                        $('#my-vehicles form input[name="food_accepted"]').attr('data-checked', 'false');
                    }
                    if(data['data']['crane'] == 1) {
                        $('#my-vehicles form .crane').addClass('active');
                        $('#my-vehicles form input[name="crane"]').prop('checked', true);
                        $('#my-vehicles form input[name="crane"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-vehicles form #crane').removeClass('active');
                        $('#my-vehicles form input[name="crane"]').prop('checked', false);
                        $('#my-vehicles form input[name="crane"]').attr('data-checked', 'false');
                    }
                    if(data['data']['rear_lift'] == 1) {
                        $('#my-vehicles form .rear_lift').addClass('active');
                        $('#my-vehicles form input[name="rear_lift"]').prop('checked', true);
                        $('#my-vehicles form input[name="rear_lift"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-vehicles form .rear_lift').removeClass('active');
                        $('#my-vehicles form input[name="rear_lift"]').prop('checked', false);
                        $('#my-vehicles form input[name="rear_lift"]').attr('data-checked', 'false');
                    }
                    if(data['data']['temp_control'] == 1) {
                        $('#my-vehicles form .temp_control').addClass('active');
                        $('#my-vehicles form input[name="temp_control"]').prop('checked', true);
                        $('#my-vehicles form input[name="temp_control"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-vehicles form .temp_control').removeClass('active');
                        $('#my-vehicles form input[name="temp_control"]').prop('checked', false);
                        $('#my-vehicles form input[name="temp_control"]').attr('data-checked', 'false');
                    }

                    toggleVehicleTypeControl();
                    toggleTempControl();
                }
                else if (data['status'] == 'danger') {
                    sendSystemMessage(data['status'], data['message']);
                }
            },
            error: function (data) {
                var errors = data.responseJSON;
                showErrors(errors, 'my-vehicles');
            }
        });

        $('#my-vehicles .errors').remove();
        $('#my-vehicles .actions').show();
        $('#my-vehicles .nav-tabs').hide();
        $('#my-vehicles #vehicle-detailed-mode').addClass('active');
        $('#my-vehicles #vehicle-quick-mode').removeClass('active');
        $('#my-vehicles .tab-content').show();
        $('#my-vehicles .buttons').hide();
        $('#my-vehicles .cost-label').removeClass('edit');
        $('#my-vehicles #trunk-size').show();
        $('#my-vehicles #cargo-size').hide();
        $('#my-vehicles #cargo-weight').hide();

        $('#my-vehicles .actions i:eq(0)').attr('onclick', 'cloneVehicle('+id+')');
        $('#my-vehicles .actions i:eq(1)').attr('onclick', 'showEditVehicleBlock('+id+')');
        $('#my-vehicles .actions i:eq(2)').attr('onclick', 'deleteVehicle('+id+')');
    }
    else {
        showCreateVehicleForm();
    }
}

// return html code of vehicle type to show as an icon
function vehicleTypeIcon(id) {
    switch(parseInt(id)) {
        case 1:
            html = '<i class="fa fa-bicycle text-primary" aria-hidden="true"></i>';
            break;
        case 2:
            html = '<i class="fa fa-car text-primary" aria-hidden="true"></i>';
            break;
        case 3:
            html = '<i class="fa fa-motorcycle text-primary" aria-hidden="true"></i>';
            break;
        case 4:
            html = '<i class="fa fa-truck text-primary" aria-hidden="true"></i>';
            break;
        case 5:
            html = '<i class="fa fa-truck text-primary" aria-hidden="true"></i>';
            break;
        default:
            html = '<i class="fa fa-truck text-primary" aria-hidden="true"></i>';
    }

    return html;
}

// show Edit Vehicle form
function showEditVehicleBlock(id) {
    $('#sidebar > div > .nav-tabs > li').removeClass('active');
    $('#sidebar > div > .nav-tabs > li:eq(0)').addClass('active');
    $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
    $('#sidebar > div > .tab-content > #my-vehicles').addClass('active');

    if($.isNumeric(id)) {
        history.pushState(null, 'Edit Vehicle', '/edit-vehicle');
        changePageTitle('Edit Vehicle - Transportation');

        $('#my-vehicles form').attr('action', '/edit-vehicle/' + id);
        $('#my-vehicles form button[type=submit]').text('Update');

        $('#my-vehicles .new-vehicle').hide();
        $('#my-vehicles .vehicle-selector').hide();
        $('#my-vehicles .errors').remove();
        $('#my-vehicles .actions').hide();
        $('#my-vehicles .nav-tabs').hide();
        $('#my-vehicles .nav-tabs li').removeClass('active');
        $('#my-vehicles .nav-tabs li:eq(1)').addClass('active');
        $('#my-vehicles #vehicle-detailed-mode').addClass('active');
        $('#my-vehicles #vehicle-quick-mode').removeClass('active');
        $('#my-vehicles .tab-content').show();
        $('#my-vehicles .buttons').show();
        $('#my-vehicles #vehicle-location button').show();

        $('#my-vehicles form input').removeClass('input-show');
        $('#my-vehicles textarea').removeClass('disabled');
        $('#my-vehicles textarea').removeAttr('disabled');
        $('#my-vehicles textarea').show();
        $('#my-vehicles form input').removeAttr('disabled');
        $('#my-vehicles form input').show();
        $('#my-vehicles form .select-show').hide();
        $('#my-vehicles select').show();
        $('#my-vehicles #vehicle-carry-form').show();
        $('#my-vehicles .overflow').hide();
        $('#my-vehicles .cost-label').addClass('edit');
        $('#my-vehicles #trunk-size').hide();
        $('#my-vehicles #cargo-size').show();
        $('#my-vehicles #cargo-weight').show();
        $('#my-vehicles select[name=quick_max_speed]').removeAttr('required');

        $('#my-vehicles #vehicle-cancel').attr('onclick', 'restoreViewVehicleBlock('+id+')');
    }
    else {
        showCreateVehicleForm();
    }
}

// get back from Edit Vehicle mode to View Vehicle mode
function restoreViewVehicleBlock(id) {
    history.pushState(null, 'View Vehicle', '/view-vehicle/' + id);
    changePageTitle('View Vehicle - Transportation');

    viewVehicle(id);

    $('#my-vehicles .selectpicker').selectpicker('render');
    $('#my-vehicles .selectpicker').selectpicker('val', id);
    $('#my-vehicles form input').addClass('input-show');
    $('#my-vehicles textarea').addClass('disabled');
    $('#my-vehicles textarea').prop('disabled', 'disabled');
    $('#my-vehicles form input').prop('disabled', 'disabled');
    $('#my-vehicles select').hide();

    if($('#vehicle_passenger_delivery_control').attr('data-show') == 'passenger_delivery') {
        $('#vehicle_passenger_delivery_control').addClass('active');
        $('#my-vehicles form input[name="passenger_delivery"]').prop('checked', true);

    }
    else {
        $('#vehicle_passenger_delivery_control').removeClass('active');
        $('#my-vehicles form input[name="passenger_delivery"]').prop('checked', false);
    }
    if($('#vehicle_package_delivery_control').attr('data-show') == 'package_delivery') {
        $('#vehicle_package_delivery_control').addClass('active');
        $('#my-vehicles form input[name="package_delivery"]').prop('checked', true);
    }
    else {
        $('#vehicle_package_delivery_control').removeClass('active');
        $('#my-vehicles form input[name="package_delivery"]').prop('checked', false);
    }

    toggleVehicleTypeControl();
    toggleTempControl();

    $('#my-vehicles .new-vehicle').show();
    $('#my-vehicles .vehicle-selector').show();
    $('#my-vehicles .errors').remove();
    $('#my-vehicles .actions').show();
    $('#my-vehicles .nav-tabs').hide();
    $('#my-vehicles .buttons').hide();
    //
    $('#my-vehicles form input').addClass('input-show');
    $('#my-vehicles textarea').addClass('disabled');
    $('#my-vehicles textarea').prop('disabled', 'disabled');
    $('#my-vehicles textarea[data-show="hide"]').hide();
    $('#my-vehicles form input').prop('disabled', 'disabled');
    $('#my-vehicles form input').show();
    $('#my-vehicles form input[data-show="hide"]').hide();
    $('#my-vehicles form input[data-checked="false"]').hide();
    $('#my-vehicles form .select-show').show();
    $('#my-vehicles select').hide();
    $('#my-vehicles #vehicle-carry-form').show();
    $('#my-vehicles .overflow').show();
    $('#my-vehicles .cost-label').removeClass('edit');
}

// get back from New Vehicle mode to default My Vehicles section
function restoreMyVehiclesBlock() {
    $('#my-vehicles .new-vehicle').show();
    $('#my-vehicles .vehicle-selector').show();
    $('#my-vehicles .errors').remove();

    if($('#my-vehicles .vehicle-selector select').val() > 0) {
        viewVehicle($('#my-vehicles .vehicle-selector select').val());
    }
    else {
        showHomepage();

        $('#my-vehicles .actions').hide();
        $('#my-vehicles .nav-tabs').hide();
        $('#my-vehicles .nav-tabs li').removeClass('active');
        $('#my-vehicles .nav-tabs li:eq(1)').addClass('active');
        $('#my-vehicles #vehicle-detailed-mode').addClass('active');
        $('#my-vehicles #vehicle-quick-mode').removeClass('active');;
        $('#my-vehicles .tab-content').hide();
        $('#my-vehicles .buttons').hide();
    }
}

// show or hide Package/Passengers Delivery input fields
function toggleVehicleTypeControl() {
    setTimeout(function() {
        if ($('#vehicle_package_delivery_control').hasClass("active")) {
            $('#vehicle-cargo-heading').parent().show();
        }
        else {
            $('#vehicle-cargo-heading').parent().hide();
        }

        if ($('#vehicle_passenger_delivery_control').hasClass("active")) {
            $('#vehicle-passengers-heading').parent().show();
        }
        else {
            $('#vehicle-passengers-heading').parent().hide();
        }

        $('#vehiclePurpose').val($('#vehicle-carry-form label.active').attr('value'));
    }, 50);
}

// show vehicle details when appropriate vehicle is selected in My Vehicles list
$('#my-vehicles .vehicle-selector select').on('change', function() {
    viewVehicle(this.value);
});

// submit a New/Edit Vehicle form
$("#my-vehicles form").submit(function(e) {
    var url = $("#my-vehicles form").attr('action');
    $('#my-vehicles fieldset .errors').remove();

    if($('#my-vehicles .nav-tabs li:eq(0)').hasClass('active')) {
        // quick mode is chosen, auto-fill proper fields
        $('#my-vehicles input[name="name"]').val($('#my-vehicles input[name="quick_name"]').val());
        $('#my-vehicles select[name="max_speed"]').val($('#my-vehicles select[name="quick_max_speed"]').val());
        if($('#quick_vehicle_passenger_delivery_control').hasClass('active')) {
            $('#my-vehicles select[name="type"]').val(2);
        }
        else {
            $('#my-vehicles select[name="type"]').val(4);
        }
        $('#my-vehicles input[name="from_address"]').val($('#my-vehicles input[name="quick_from_address"]').val());
        $('#my-vehicles input[name="from_city"]').val($('#my-vehicles input[name="quick_from_city"]').val());
        $('#my-vehicles input[name="from_time"]').val('08:00');
        $('#my-vehicles input[name="to_address"]').val($('#my-vehicles input[name="quick_to_address"]').val());
        $('#my-vehicles input[name="to_city"]').val($('#my-vehicles input[name="quick_to_city"]').val());
        $('#my-vehicles input[name="to_time"]').val('20:00');
        $('#my-vehicles input[name="cost_eur_task"]').val(10);
        $('#my-vehicles input[name="cost_eur_h"]').val(10);
        $('#my-vehicles input[name="cost_eur_km"]').val(10);
        $('#my-vehicles input[name="max_passengers"]').val($('#my-vehicles input[name="quick_max_passengers"]').val());
        $('#my-vehicles input[name="trunk_volume"]').val($('#my-vehicles input[name="quick_trunk_volume"]').val());
    }
    else {
        $('#quick_max_passengers').removeAttr('required');
        $('#quick_trunk_volume').removeAttr('required');
    }

    $.ajax({
        type: "POST",
        url: url,
        data: $("#my-vehicles form").serialize(),
        success: function(data)
        {
            sendSystemMessage(data['status'], data['message']);
            if(data['status'] == 'success') {
                restoreMyVehiclesBlock();
                updateVehiclesList('id');
                updateJobVehiclesList();
            }
        },
        error: function(data)
        {
            var errors = data.responseJSON;
            showErrors(errors, 'my-vehicles');
        }
    });

    e.preventDefault();
});

// update My Vehicles list
function updateVehiclesList(view_vehicle) {
    $('#my-vehicles .vehicle-selector select option').remove();
    $('#my-vehicles .selectpicker').selectpicker('refresh');
    last_id = 0;

    $.ajax({
        type: "POST",
        url: '/get-vehicle-list',
        success: function(data)
        {
            if(data['status'] == 'success') {
                is_empty = true;

                $.each( data['data'], function( index, value ){
                    element = '<option name="my_vehicles['+value['id']+']" value="'+value['id']+'">'+value['name']+'</option>';

                    $('#my-vehicles .vehicle-selector select').append(element);
                    $('#my-vehicles .selectpicker').selectpicker('refresh');
                    is_empty = false;
                    last_id = value['id'];
                });

                if (is_empty === true) {
                    $('#my-vehicles .nothing').show();
                }
                else {
                    $('#my-vehicles .nothing').hide();
                }

                $('#my-vehicles .selectpicker').selectpicker('render');
                $('#my-vehicles .selectpicker').selectpicker('val', last_id);

                if(view_vehicle == 'id' && last_id > 0) {
                    viewVehicle(last_id);
                }
            }
            else if(data['status'] == 'danger') {
                $('#my-vehicles .vehicle-selector').after('<div class="col-lg-12"><p>You don\'t have any vehicles.</p></div>');
            }
        },
        error: function(data)
        {
            $('#my-vehicles .vehicle-selector').after('<div class="col-lg-12"><p>Error occured, please reload the page.</p></div>');
        }
    });
}

// delete selected vehicle
function deleteVehicle(id) {
    $.ajax({
        type: "POST",
        url: '/delete-vehicle/' + id,
        success: function(data)
        {
            sendSystemMessage(data['status'], data['message']);
            updateVehiclesList('id');
            restoreMyVehiclesBlock();
            updateJobVehiclesList();
        },
        error: function(data)
        {
            sendSystemMessage('danger', 'Some problems occured, please reload the page and try again.');
            updateVehiclesList('id');
        }
    });
}

// clone selected vehicle
function cloneVehicle(id) {
    $.ajax({
        type: "POST",
        url: '/clone-vehicle/' + id,
        success: function(data)
        {
            sendSystemMessage(data['status'], data['message']);
            updateVehiclesList('id');
            updateJobVehiclesList();
        },
        error: function(data)
        {
            sendSystemMessage('danger', 'Some problems occured, please reload the page and try again.');
            updateVehiclesList('id');
        }
    });
}

// set End Address the same as Start Address in Quick Mode
function setVehicleEndAddress() {
    $('#my-vehicles form input[name="to_address"]').val($('#my-vehicles form input[name="from_address"]').val());
    $('#my-vehicles form input[name="to_city"]').val($('#my-vehicles form input[name="from_city"]').val());
}

// set End Address the same as Start Address in Detailed Mode
function setVehicleQuickEndAddress() {
    $('#my-vehicles form input[name="quick_to_address"]').val($('#my-vehicles form input[name="quick_from_address"]').val());
    $('#my-vehicles form input[name="quick_to_city"]').val($('#my-vehicles form input[name="quick_from_city"]').val());
}

// show Vehicle details in popup --- redefined on workflow.js ( Yakov )
function showVehiclePopup(id) {
    $.ajax({
        type: "POST",
        url: '/get-vehicle-info/' + id,
        success: function (data) {
            if(data['status'] == 'success') {
                modal = '<div id="vehicle-modal'+id+'" class="popup-modal vehicle-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="vehicle-modal'+id+'">';
                modal += '<div class="modal-dialog" role="document"><div class="modal-content modal-sm"><div class="modal-header">';
                modal += '<button type="button" onclick="closeVehicleModal('+id+')" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                modal += '<h4 class="modal-title" id="myModalLabel">';
                modal += vehicleTypeIcon(data['data']['type']);
                modal += data['data']['name']+'</h4></div><div class="modal-body">';
                if(data['is_other_user'] == 1) {
                    modal += '<div class="owner"><div class="owner-name">'+data['owner_name']+'</div><div class="owner-phone">'+data['owner_phone']+'</div></div><hr>';
                }
                if(data['data']['notes'].length > 0) {
                    modal += '<textarea class="notes" disabled="">'+data['data']['notes']+'</textarea><hr>';
                }
                modal += '<div class="location" style="z-index:100;"><div class="from"><div class="from-address">'+data['data']['from_address']+', '+data['data']['from_city']+'</div>';
                modal += '<div class="from-time">'+data['data']['from_time'].substring(0, data['data']['from_time'].length - 3)+'</div></div>';
                modal += '<div class="arrow"><span class="glyphicon glyphicon-chevron-right"></span></div>';
                modal += '<div class="to"><div class="to-address">'+data['data']['to_address']+', '+data['data']['to_city']+'</div>';
                modal += '<div class="to-time">'+data['data']['to_time'].substring(0, data['data']['to_time'].length - 3)+'</div></div></div><hr>';

                if(data['data']['passenger_delivery'] == 1) {
                    modal += '<div class="seats">' + data['data']['max_passengers'] + ' passenger seats';
                    if (data['data']['invalid_seats'] > 0) {
                        modal += ' + ' + data['data']['invalid_seats'] + ' inva';
                    }
                    modal += '</div><hr>';
                }

                if(data['data']['package_delivery'] == 1) {
                    modal += '<div class="packages"><div class="size">' + data['data']['trunk_length'] + ' x ' + data['data']['trunk_width'];
                    modal += ' x ' + data['data']['trunk_height'] + ' m (' + data['data']['trunk_volume'] + '㎥)</div>';
                    modal += '<div class="weight">' + data['data']['max_weight'] + ' kg</div></div>';
                    modal += '<div class="icons">';
                    if (data['data']['weather_protection'] == 1) {
                        modal += '<span class="icon icon-active"><i class="fa fa-umbrella" aria-hidden="true"></i></span>';
                    }
                    else {
                        modal += '<span class="icon"><i class="fa fa-umbrella" aria-hidden="true"></i></span>';
                    }
                    if (data['data']['crane'] == 1) {
                        modal += '<span class="icon icon-active crane"></span>';
                    }
                    else {
                        modal += '<span class="icon crane"></span>';
                    }
                    if (data['data']['rear_lift'] == 1) {
                        modal += '<span class="icon icon-active lift"></span>';
                    }
                    else {
                        modal += '<span class="icon lift"></span>';
                    }
                    if (data['data']['food_accepted'] == 1) {
                        modal += '<span class="icon icon-active food"></span>';
                    }
                    else {
                        modal += '<span class="icon food"></span>';
                    }
                    if (data['data']['temp_control'] == 1) {
                        modal += '<span class="icon icon-active temperature"></span>';
                        modal += '<div class="temp">' + data['data']['temp_min'] + ' - ' + data['data']['temp_max'] + ' °C</div>';
                    }
                    else {
                        modal += '<span class="icon temperature"></span>';
                    }
                    modal += '</div>';
                }

                modal += '</div></div></div></div>';
                $('#main').append(modal);
                $('#vehicle-modal'+id).modal('show');
            }
            else if (data['status'] == 'danger') {
                sendSystemMessage(data['status'], data['message']);
            }
        },
        error: function () {
            sendSystemMessage('danger', 'Can\'t show vehicle details. Please reload the page.');
        }
    });
}

//remove Vehicle Details Modal from DOM when close button is clicked --- removed because of useless
function closeVehicleModal(id) {
    setTimeout(function(){
        $('#vehicle-modal'+id).remove();
        $('.vehicle-modal').modal('hide');
        $('.modal-body .tab-pane').removeClass('active');
        $('.modal-body .nav-tabs li').removeClass('active');
    }, 500);
};

//
// END OF VEHICLE FUNCTIONALITY
//



//
// TASK FUNCTIONALITY
//

// show a New Task form
function showCreateTaskForm() {
    $('#sidebar > div > .nav-tabs > li').removeClass('active');
    $('#sidebar > div > .nav-tabs > li:eq(1)').addClass('active');
    $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
    $('#sidebar > div > .tab-content > #my-tasks').addClass('active');

    history.pushState(null, 'Create Task', '/create-task');
    changePageTitle('Create Task - Transportation');

    $('#my-tasks form').attr('action', '/create-task');
    $('#my-tasks form button[type=submit]').text('Create');

    $('#my-tasks form input').val('');
    $('#my-tasks form select option').removeAttr('selected');
    $('#my-tasks form select option:eq(0)').attr('selected', 'selected');
    $('#my-tasks form #task_passenger_delivery_control').removeClass('active');
    $('#my-tasks form #task_package_delivery_control').removeClass('active');
    $('#my-tasks form .cargo-items .btn').removeClass('active');
    $('#my-tasks form .cargo-items .btn input').prop('checked', false);

    $('#my-tasks .new-task').hide();
    $('#my-tasks .task-selector').hide();
    $('#my-tasks .errors').remove();
    $('#my-tasks .actions').hide();
    $('#my-tasks .nav-tabs').show();
    $('#my-tasks .nav-tabs li').removeClass('active');
    $('#my-tasks .nav-tabs li:eq(0)').addClass('active');
    $('#my-tasks #task-detailed-mode').removeClass('active');
    $('#my-tasks #task-quick-mode').addClass('active');;
    $('#my-tasks .tab-content').show();
    $('#my-tasks .buttons').show();

    $('#my-tasks form input').removeClass('input-show');
    $('#my-tasks textarea').removeClass('disabled');
    $('#my-tasks textarea').removeAttr('disabled');
    $('#my-tasks textarea').val('');
    $('#my-tasks form textarea[name="notes"]').show();
    $('#my-tasks form input').removeAttr('disabled');
    $('#my-tasks form .select-show').hide();
    $('#my-tasks select').show();
    $('#my-tasks #task-carry-form').show();
    $('#my-tasks .overflow').hide();
    $('#my-tasks form input').show();
    $('#my-tasks .cost-label').addClass('edit');
    $('#my-tasks #trunk-size').hide();
    $('#my-tasks #cargo-size').show();
    $('#my-tasks #cargo-weight').show();
    $('#my-tasks #total-packages').show();
    $('#quick-task-carry-form > label').removeClass('active');

    toggleTaskTypeQuickControl();
    toggleTaskTypeControl();
    toggleTaskTempControl();

    $('#my-tasks #task-cancel').attr('onclick', 'restoreMyTasksBlock()');
}

// show View Task details
function viewTask(id) {
    $('#sidebar > div > .nav-tabs > li').removeClass('active');
    $('#sidebar > div > .nav-tabs > li:eq(1)').addClass('active');
    $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
    $('#sidebar > div > .tab-content > #my-tasks').addClass('active');

    if($.isNumeric(id)) {
        $('#my-tasks .selectpicker').selectpicker('render');
        $('#my-tasks .selectpicker').selectpicker('val', id);
        $('#my-tasks .selectpicker').selectpicker('render');
        $('#my-tasks form input').addClass('input-show');
        $('#my-tasks textarea').addClass('disabled');
        $('#my-tasks textarea').prop('disabled', 'disabled');
        $('#my-tasks form input').prop('disabled', 'disabled');
        $('#my-tasks select').hide();
        $('#my-tasks #task-carry-form').show();
        $('#my-tasks .overflow').show();
        $('#my-tasks form .select-show').show();

        history.pushState(null, 'View Task', '/view-task/' + id);
        changePageTitle('View Task - Transportation');

        // get info about current task from backend with AJAX
        $.ajax({
            type: "POST",
            url: '/get-task-info/' + id,
            success: function (data) {
                if(data['status'] == 'success') {
                    $('#my-tasks form input[name="name"]').val(data['data']['name']);
                    if(data['data']['notes'].length > 0) {
                        $('#my-tasks form textarea[name="notes"]').val(data['data']['notes']);
                        $('#my-tasks form textarea[name="notes"]').show();
                        $('#my-tasks form textarea[name="notes"]').attr('data-show', 'show');
                    }
                    else {
                        $('#my-tasks form textarea[name="notes"]').hide();
                        $('#my-tasks form textarea[name="notes"]').attr('data-show', 'hide');
                    }
                    if(data['data']['passenger_delivery'] == 1) {
                        $('#task_passenger_delivery_control').attr('data-show', 'passenger_delivery');
                        $('#task_passenger_delivery_control').addClass('active');
                        $('#my-tasks form input[name="passenger_delivery"]').prop('checked', true);
                        $('#my-tasks form .select-show[name="select-loading-time"]').text("Loading: "+data['data']['loading_time']+"min");

                    }
                    else {
                        $('#task_passenger_delivery_control').attr('data-show', 'hide');
                        $('#task_passenger_delivery_control').removeClass('active');
                        $('#my-tasks form input[name="passenger_delivery"]').prop('checked', false);
                    }
                    if(data['data']['package_delivery'] == 1) {
                        $('#task_package_delivery_control').attr('data-show', 'package_delivery');
                        $('#task_package_delivery_control').addClass('active');
                        $('#my-tasks form input[name="package_delivery"]').prop('checked', true);
                        $('#my-tasks form .select-show[name="select-loading-time"]').text("Loading: "+data['data']['loading_time']+"min");
                    }
                    else {
                        $('#task_package_delivery_control').attr('data-show', 'hide');
                        $('#task_package_delivery_control').removeClass('active');
                        $('#my-tasks form input[name="package_delivery"]').prop('checked', false);
                    }
                    if(data['data']['one_stop_task'] == 1) {
                        $('#task_one_stop_task_control').attr('data-show', 'one_stop_task');
                        $('#task_one_stop_task_control').addClass('active');
                        $('#my-tasks form input[name="one_stop_task"]').prop('checked', true);
                        $('#my-tasks form .select-show[name="select-loading-time"]').text("Stop duration: "+data['data']['loading_time']+"min");
                    }
                    else {
                        $('#task_one_stop_task_control').attr('data-show', 'hide');
                        $('#task_one_stop_task_control').removeClass('active');
                        $('#my-tasks form input[name="one_stop_task"]').prop('checked', false);
                    }
                    $('#my-tasks form input[name="from_address"]').val(data['data']['from_address']);
                    $('#my-tasks form input[name="from_city"]').val(data['data']['from_city']);
                    $('#my-tasks form input[name="from_time_start"]').val(data['data']['from_time_start'].substring(0, data['data']['from_time_start'].length - 3)).hide();
                    $('#my-tasks form input[name="from_time_end"]').attr('data-show', 'hide');
                    $('#my-tasks form input[name="from_time_start"]').attr('data-show', 'hide');
                    $('#my-tasks form input[name="from_time_end"]').val(data['data']['from_time_end'].substring(0, data['data']['from_time_end'].length - 3)).hide();
                    $('#my-tasks .select-show[name="select-from-time-start"]').text("From: "+data['data']['from_time_start'].substring(0, data['data']['from_time_start'].length - 3));
                    $('#my-tasks .select-show[name="select-from-time-end"]').text("To: "+data['data']['from_time_end'].substring(0, data['data']['from_time_end'].length - 3));
                    $('#my-tasks form input[name="loading_time"]').val(data['data']['loading_time']).hide();
                    $('#my-tasks form input[name="loading_time"]').attr('data-show', 'hide');
                    $('#my-tasks .select-show[name="select-loading-time"]').text("Loading: "+data['data']['loading_time']+"min");
                    $('#my-tasks form input[name="to_address"]').val(data['data']['to_address']);
                    $('#my-tasks form input[name="to_city"]').val(data['data']['to_city']);
                    $('#my-tasks form input[name="to_time_start"]').val(data['data']['to_time_start'].substring(0, data['data']['to_time_start'].length - 3)).hide();
                    $('#my-tasks form input[name="to_time_end"]').val(data['data']['to_time_end'].substring(0, data['data']['to_time_end'].length - 3)).hide();
                    $('#my-tasks form input[name="to_time_start"]').attr('data-show', 'hide');
                    $('#my-tasks form input[name="to_time_end"]').attr('data-show', 'hide');
                    $('#my-tasks .select-show[name="select-to-time-start"]').text("From: "+data['data']['to_time_start'].substring(0, data['data']['to_time_start'].length - 3));
                    $('#my-tasks .select-show[name="select-to-time-end"]').text("To: "+data['data']['to_time_end'].substring(0, data['data']['to_time_end'].length - 3));
                    $('#my-tasks form input[name="unload_time"]').val(data['data']['unload_time']).hide();
                    $('#my-tasks form input[name="unload_time"]').attr('data-show', 'hide');
                    $('#my-tasks .select-show[name="select-unload-time"]').text("Unload: "+data['data']['unload_time']+"min");
                    $('#my-tasks form input[name="passengers"]').val(data['data']['passengers']);
                    $('#my-tasks form input[name="invalids"]').val(data['data']['invalids']);
                    $('#my-tasks form input[name="cargo_length"]').val(data['data']['cargo_length']).hide();
                    $('#my-tasks form input[name="cargo_width"]').val(data['data']['cargo_width']).hide();
                    $('#my-tasks form input[name="cargo_height"]').val(data['data']['cargo_height']).hide();
                    $('#my-tasks form input[name="weight"]').val(data['data']['weight']).hide();
                    $('#my-tasks form input[name="total_packages"]').val(data['data']['total_packages']).hide();
                    $('#my-tasks form input[name="cargo_length"]').attr('data-show', 'hide');
                    $('#my-tasks form input[name="cargo_width"]').attr('data-show', 'hide');
                    $('#my-tasks form input[name="cargo_height"]').attr('data-show', 'hide');
                    $('#my-tasks form input[name="weight"]').attr('data-show', 'hide');
                    $('#my-tasks form input[name="total_packages"]').attr('data-show', 'hide');
                    $('#my-tasks .select-show[name="select-total-volume"]').html(data['data']['total_volume']+'m');
                    $('#my-tasks .select-show[name="select-trunk-size"]').html(data['data']['cargo_length']+' x '+data['data']['cargo_width']+' x '+data['data']['cargo_height']+' m');
                    $('#my-tasks .select-show[name="select-max-weight"]').html(data['data']['weight']+' kg');
                    $('#my-tasks .select-show[name="select-total-packages"]').html(data['data']['total_packages']+' packages');
                    $('#my-tasks form input[name="temp_min"]').val(data['data']['temp_min']).hide();
                    $('#my-tasks form input[name="temp_min"]').attr('data-show', 'hide');
                    $('#my-tasks .select-show[name="select-temp-min"]').html('Min '+data['data']['temp_min']+'°C');
                    $('#my-tasks form input[name="temp_max"]').val(data['data']['temp_max']).hide();
                    $('#my-tasks form input[name="temp_max"]').attr('data-show', 'hide');
                    $('#my-tasks .select-show[name="select-temp-max"]').html('Max '+data['data']['temp_max']+'°C');
                    if(data['data']['weather_protection'] == 1) {
                        $('#my-tasks form #weather_protection').addClass('active');
                        $('#my-tasks form input[name="weather_protection"]').prop('checked', true);
                        $('#my-tasks form input[name="weather_protection"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-tasks form #weather_protection').removeClass('active');
                        $('#my-tasks form input[name="weather_protection"]').prop('checked', false);
                        $('#my-tasks form input[name="weather_protection"]').attr('data-checked', 'false');
                    }
                    if(data['data']['food'] == 1) {
                        $('#my-tasks form #food').addClass('active');
                        $('#my-tasks form input[name="food"]').prop('checked', true);
                        $('#my-tasks form input[name="food"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-tasks form #food').removeClass('active');
                        $('#my-tasks form input[name="food"]').prop('checked', false);
                        $('#my-tasks form input[name="food"]').attr('data-checked', 'false');
                    }
                    if(data['data']['fragile'] == 1) {
                        $('#my-tasks form #food').addClass('active');
                        $('#my-tasks form input[name="fragile"]').prop('checked', true);
                        $('#my-tasks form input[name="fragile"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-tasks form #fragile').removeClass('active');
                        $('#my-tasks form input[name="fragile"]').prop('checked', false);
                        $('#my-tasks form input[name="fragile"]').attr('data-checked', 'false');
                    }
                    if(data['data']['crane'] == 1) {
                        $('#my-tasks form #crane').addClass('active');
                        $('#my-tasks form input[name="crane"]').prop('checked', true);
                        $('#my-tasks form input[name="crane"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-tasks form #crane').removeClass('active');
                        $('#my-tasks form input[name="crane"]').prop('checked', false);
                        $('#my-tasks form input[name="crane"]').attr('data-checked', 'false');
                    }
                    if(data['data']['rear_lift'] == 1) {
                        $('#my-tasks form #rear_lift').addClass('active');
                        $('#my-tasks form input[name="rear_lift"]').prop('checked', true);
                        $('#my-tasks form input[name="rear_lift"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-tasks form #rear_lift').removeClass('active');
                        $('#my-tasks form input[name="rear_lift"]').prop('checked', false);
                        $('#my-tasks form input[name="rear_lift"]').attr('data-checked', 'false');
                    }
                    if(data['data']['temp_control'] == 1) {
                        $('#my-tasks form #temp_control').addClass('active');
                        $('#my-tasks form input[name="temp_control"]').prop('checked', true);
                        $('#my-tasks form input[name="temp_control"]').attr('data-checked', 'true');
                    }
                    else {
                        $('#my-tasks form #temp_control').removeClass('active');
                        $('#my-tasks form input[name="temp_control"]').prop('checked', false);
                        $('#my-tasks form input[name="temp_control"]').attr('data-checked', 'false');
                    }

                    toggleTaskTypeControl();
                    toggleTaskTempControl();
                }
                else if (data['status'] == 'danger') {
                    sendSystemMessage(data['status'], data['message']);
                }
            },
            error: function (data) {
                var errors = data.responseJSON;
                showErrors(errors, 'my-tasks');
            }
        });

        $('#my-tasks .errors').remove();
        $('#my-tasks .actions').show();
        $('#my-tasks .nav-tabs').hide();
        $('#my-tasks #task-detailed-mode').addClass('active');
        $('#my-tasks #task-quick-mode').removeClass('active');
        $('#my-tasks .tab-content').show();
        $('#my-tasks .buttons').hide();
        $('#my-tasks .cost-label').removeClass('edit');
        $('#my-tasks #trunk-size').show();
        $('#my-tasks #cargo-size').hide();
        $('#my-tasks #cargo-weight').hide();
        $('#my-tasks #total-packages').hide();

        $('#my-tasks .actions i:eq(0)').attr('onclick', 'cloneTask('+id+')');
        $('#my-tasks .actions i:eq(1)').attr('onclick', 'showEditTaskBlock('+id+')');
        $('#my-tasks .actions i:eq(2)').attr('onclick', 'deleteTask('+id+')');
    }
    else {
        showCreateVehicleForm();
    }
}

// show Edit Task form
function showEditTaskBlock(id) {
    $('#sidebar > div > .nav-tabs > li').removeClass('active');
    $('#sidebar > div > .nav-tabs > li:eq(1)').addClass('active');
    $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
    $('#sidebar > div > .tab-content > #my-tasks').addClass('active');

    if($.isNumeric(id)) {
        history.pushState(null, 'Edit Task', '/edit-task');
        changePageTitle('Edit Task - Transportation');

        $('#my-tasks form').attr('action', '/edit-task/' + id);
        $('#my-tasks form button[type=submit]').text('Update');

        $('#my-tasks .new-task').hide();
        $('#my-tasks .task-selector').hide();
        $('#my-tasks .errors').remove();
        $('#my-tasks .actions').hide();
        $('#my-tasks .nav-tabs').hide();
        $('#my-tasks .nav-tabs li').removeClass('active');
        $('#my-tasks .nav-tabs li:eq(1)').addClass('active');
        $('#my-tasks #task-detailed-mode').addClass('active');
        $('#my-tasks #task-quick-mode').removeClass('active');
        $('#my-tasks .tab-content').show();
        $('#my-tasks .buttons').show();

        $('#my-tasks form input').removeClass('input-show');
        $('#my-tasks textarea').removeClass('disabled');
        $('#my-tasks textarea').removeAttr('disabled');
        $('#my-tasks textarea').show();
        $('#my-tasks form input').removeAttr('disabled');
        $('#my-tasks form input').show();
        $('#my-tasks form .select-show').hide();
        $('#my-tasks select').show();
        $('#my-tasks #task-carry-form').show();
        $('#my-tasks .overflow').hide();
        $('#my-tasks .cost-label').addClass('edit');
        $('#my-tasks #trunk-size').hide();
        $('#my-tasks #cargo-size').show();
        $('#my-tasks #cargo-weight').show();
        $('#my-tasks #total-packages').show();

        $('#my-tasks #task-cancel').attr('onclick', 'restoreViewTaskBlock('+id+')');
    }
    else {
        showCreateTaskForm();
    }
}

// get back from Edit Task mode to View Task mode
function restoreViewTaskBlock(id) {
    history.pushState(null, 'View Task', '/view-task/' + id);
    changePageTitle('View Task - Transportation');

    viewTask(id);

    $('#my-tasks .selectpicker').selectpicker('render');
    $('#my-tasks .selectpicker').selectpicker('val', id);
    $('#my-tasks form input').addClass('input-show');
    $('#my-tasks textarea').addClass('disabled');
    $('#my-tasks textarea').prop('disabled', 'disabled');
    $('#my-tasks form input').prop('disabled', 'disabled');
    $('#my-tasks select').hide();

    if($('#task_passenger_delivery_control').attr('data-show') == 'passenger_delivery') {
        $('#task_passenger_delivery_control').addClass('active');
        $('#my-tasks form input[name="passenger_delivery"]').prop('checked', true);

    }
    else {
        $('#task_passenger_delivery_control').removeClass('active');
        $('#my-tasks form input[name="passenger_delivery"]').prop('checked', false);
    }
    if($('#task_package_delivery_control').attr('data-show') == 'package_delivery') {
        $('#task_package_delivery_control').addClass('active');
        $('#my-tasks form input[name="package_delivery"]').prop('checked', true);
    }
    else {
        $('#task_package_delivery_control').removeClass('active');
        $('#my-tasks form input[name="package_delivery"]').prop('checked', false);
    }
    if($('#task_one_stop_task_control').attr('data-show') == 'package_delivery') {
        $('#task_one_stop_task_control').addClass('active');
        $('#my-tasks form input[name="one_stop_task"]').prop('checked', true);
    }
    else {
        $('#task_one_stop_task_control').removeClass('active');
        $('#my-tasks form input[name="one_stop_task"]').prop('checked', false);
    }

    toggleTaskTypeControl();
    toggleTaskTempControl();

    $('#my-tasks .new-task').show();
    $('#my-tasks .task-selector').show();
    $('#my-tasks .errors').remove();
    $('#my-tasks .actions').show();
    $('#my-tasks .nav-tabs').hide();
    $('#my-tasks .buttons').hide();
    //
    $('#my-tasks form input').addClass('input-show');
    $('#my-tasks textarea').addClass('disabled');
    $('#my-tasks textarea').prop('disabled', 'disabled');
    $('#my-tasks textarea[data-show="hide"]').hide();
    $('#my-tasks form input').prop('disabled', 'disabled');
    $('#my-tasks form input').show();
    $('#my-tasks form input[data-show="hide"]').hide();
    $('#my-tasks form input[data-checked="false"]').hide();
    $('#my-tasks form .select-show').show();
    $('#my-tasks select').hide();
    $('#my-tasks #task-carry-form').show();
    $('#my-tasks .overflow').show();
    $('#my-tasks .cost-label').removeClass('edit');
}

// get back from New Task mode to default My Tasks section
function restoreMyTasksBlock() {
    $('#my-tasks .new-task').show();
    $('#my-tasks .task-selector').show();
    $('#my-tasks .errors').remove();

    if($('#my-tasks .task-selector select').val() > 0) {
        viewTask($('#my-tasks .task-selector select').val());
    }
    else {
        showHomepage();

        $('#my-tasks .actions').hide();
        $('#my-tasks .nav-tabs').hide();
        $('#my-tasks .nav-tabs li').removeClass('active');
        $('#my-tasks .nav-tabs li:eq(1)').addClass('active');
        $('#my-tasks #task-detailed-mode').addClass('active');
        $('#my-tasks #task-quick-mode').removeClass('active');;
        $('#my-tasks .tab-content').hide();
        $('#my-tasks .buttons').hide();
    }
}

// change page Title depending on current page
function changePageTitle(title) {
    $(document).prop('title', title);
}

// get back from New Task mode to default My Tasks section
function toggleTaskTypeControl() {
    setTimeout(function() {
        if ($('#task_package_delivery_control').hasClass("active")) {
            $('#task-cargo-heading').parent().show();
            $('#task-location #location-to').show();
            $('#task-location .glyphicon-chevron-right').css('display', 'inline-block');
        }
        else {
            $('#task-cargo-heading').parent().hide();
        }

        if ($('#task_passenger_delivery_control').hasClass("active")) {
            $('#task-passengers-heading').parent().show();
            $('#task-location #location-to').show();
            $('#task-location .glyphicon-chevron-right').css('display', 'inline-block');
        }
        else {
            $('#task-passengers-heading').parent().hide();
        }

        if ($('#task_one_stop_task_control').hasClass("active")) {
            $('#task-location #location-to').hide();
            $('#task-location .glyphicon-chevron-right').hide();
            $('#task-location input[name="loading_time"]').attr('placeholder', 'Stop (3min)');
        }
        else {
            $('#task-location #location-to').show();
            $('#task-location .glyphicon-chevron-right').css('display', 'inline-block');
            $('#task-location input[name="loading_time"]').attr('placeholder', 'Loading: 1min');
        }

        $('#taskPurpose').val($('#task-carry-form label.active').attr('value'));
    }, 50);
}

// show or hide Package/Passengers/1-Stop Delivery input fields in Quick mode
function toggleTaskTypeQuickControl() {
    setTimeout(function() {
        if ($('#quick_task_package_delivery_control').hasClass("active")) {
            $('#quick_total_volume').show();
            $('#quick_total_volume').prop('required', 'required');
        }
        else {
            $('#quick_total_volume').hide();
            $('#quick_total_volume').removeAttr('required');
        }

        if ($('#quick_task_passenger_delivery_control').hasClass("active")) {
            $('#quick_passengers').show();
            $('#quick_passengers').prop('required', 'required');
        }
        else {
            $('#quick_passengers').hide();
            $('#quick_passengers').removeAttr('required');
        }

        if ($('#quick_task_one_stop_task_control').hasClass("active")) {
            $('#quick_loading_time').show();
            $('#quick_loading_time').prop('required', 'required');
            $('.quick-location #quick-location-to').hide();
            $('.quick-location .glyphicon-chevron-right').hide();
        }
        else {
            $('#quick_loading_time').hide();
            $('#quick_loading_time').removeAttr('required');
            $('.quick-location #quick-location-to').show();
            $('.quick-location .glyphicon-chevron-right').css('display', 'inline-block');
        }

        $('#taskPurpose').val($('#quick-task-carry-form label.active').attr('value'));
    }, 50);
}

// show or hide Temperature Control input fields
function toggleTaskTempControl() {
    setTimeout(function() {
        if ($('#my-tasks #temp_control').hasClass("active")) {
            $('#task-temperature-values').show();
        }
        else {
            $('#task-temperature-values').hide();
        }
    }, 50);
}

// show task details when appropriate task is selected in My Tasks list
$('#my-tasks .task-selector select').on('change', function() {
    viewTask(this.value);
});

// submit a New/Edit Task form
$("#my-tasks form").submit(function(e) {
    var url = $("#my-tasks form").attr('action');
    $('#my-tasks fieldset .errors').remove();

    if($('#my-tasks .nav-tabs li:eq(0)').hasClass('active')) {
        // quick mode is chosen, auto-fill proper fields
        $('#my-tasks input[name="name"]').val($('#my-tasks input[name="quick_name"]').val());
        $('#my-tasks input[name="from_address"]').val($('#my-tasks input[name="quick_from_address"]').val());
        $('#my-tasks input[name="from_city"]').val($('#my-tasks input[name="quick_from_city"]').val());
        $('#my-tasks input[name="from_time_start"]').val('08:00');
        $('#my-tasks input[name="from_time_end"]').val('09:00');
        $('#my-tasks input[name="to_address"]').val($('#my-tasks input[name="quick_to_address"]').val());
        $('#my-tasks input[name="to_city"]').val($('#my-tasks input[name="quick_to_city"]').val());
        $('#my-tasks input[name="to_time_start"]').val('19:00');
        $('#my-tasks input[name="to_time_end"]').val('20:00');
        $('#my-tasks input[name="passengers"]').val($('#my-tasks input[name="quick_passengers"]').val());
        $('#my-tasks input[name="total_volume"]').val($('#my-tasks input[name="quick_total_volume"]').val());
        $('#my-tasks input[name="loading_time"]').val($('#my-tasks input[name="quick_loading_time"]').val());
    }
    else {
        $('#quick_passengers').removeAttr('required');
        $('#quick_total_volume').removeAttr('required');
        $('#quick_loading_time').removeAttr('required');
    }

    $.ajax({
        type: "POST",
        url: url,
        data: $("#my-tasks form").serialize(),
        success: function(data)
        {
            sendSystemMessage(data['status'], data['message']);
            if(data['status'] == 'success') {
                restoreMyTasksBlock();
                updateTasksList('id');
                updateJobTasksList();
            }
        },
        error: function(data)
        {
            var errors = data.responseJSON;
            showErrors(errors, 'my-tasks');
        }
    });

    e.preventDefault();
});

// update My Tasks list
function updateTasksList(view_task) {
    $('#my-tasks .task-selector select option').remove();
    $('#my-tasks .selectpicker').selectpicker('refresh');
    last_id = 0;

    $.ajax({
        type: "POST",
        url: '/get-task-list',
        success: function(data)
        {
            if(data['status'] == 'success') {
                is_empty = true;

                $.each( data['data'], function( index, value ){
                    element = '<option name="my_tasks['+value['id']+']" value="'+value['id']+'">'+value['name']+'</option>';

                    $('#my-tasks .task-selector select').append(element);
                    $('#my-tasks .selectpicker').selectpicker('refresh');
                    is_empty = false;
                    last_id = value['id'];
                });

                if (is_empty === true) {
                    $('#my-tasks .nothing').show();
                }
                else {
                    $('#my-tasks .nothing').hide();
                }

                $('#my-tasks .selectpicker').selectpicker('render');
                $('#my-tasks .selectpicker').selectpicker('val', last_id);

                if(view_task == 'id' && last_id > 0) {
                    viewTask(last_id);
                }
            }
            else if(data['status'] == 'danger') {
                $('#my-tasks .task-selector').after('<div class="col-lg-12"><p>You don\'t have any tasks.</p></div>');
            }
        },
        error: function(data)
        {
            $('#my-tasks .task-selector').after('<div class="col-lg-12"><p>Error occured, please reload the page.</p></div>');
        }
    });
}

// delete selected task
function deleteTask(id) {
    $.ajax({
        type: "POST",
        url: '/delete-task/' + id,
        success: function(data)
        {
            sendSystemMessage(data['status'], data['message']);
            updateTasksList('id');
            restoreMyTasksBlock();
            updateJobTasksList();
        },
        error: function(data)
        {
            sendSystemMessage('danger', 'Some problems occured, please reload the page and try again.');
            updateTasksList('id');
        }
    });
}

// clone selected task
function cloneTask(id) {
    $.ajax({
        type: "POST",
        url: '/clone-task/' + id,
        success: function(data)
        {
            sendSystemMessage(data['status'], data['message']);
            updateTasksList('id');
            updateJobTasksList();
        },
        error: function(data)
        {
            sendSystemMessage('danger', 'Some problems occured, please reload the page and try again.');
            updateTasksList('id');
        }
    });
}

// show Task details in popup
function showTaskPopup(id) {
    $.ajax({
        type: "POST",
        url: '/get-task-info/' + id,
        success: function (data) {
            if(data['status'] == 'success') {
                modal = '<div id="task-modal'+id+'" class="popup-modal task-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="task-modal'+id+'">';
                modal += '<div class="modal-dialog" role="document"><div class="modal-content modal-sm"><div class="modal-header">';
                modal += '<button type="button" onclick="closeTaskModal('+id+')" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                modal += '<h4 class="modal-title" id="myModalLabel">';
                if(data['data']['passenger_delivery'] == 1) {
                    modal += '<i class="fa fa-users" aria-hidden="true"></i>';
                }
                if(data['data']['package_delivery'] == 1) {
                    modal += '<i class="fa fa-dropbox" aria-hidden="true"></i>';
                }
                if(data['data']['one_stop_task'] == 1) {
                    modal += '<i class="fa fa-coffee" aria-hidden="true"></i>';
                }
                modal += data['data']['name']+'</h4></div><div class="modal-body">';
                if(data['is_other_user'] == 1) {
                    modal += '<div class="owner"><div class="owner-name">'+data['owner_name']+'</div><div class="owner-phone">'+data['owner_phone']+'</div></div><hr>';
                }
                if(data['data']['notes'].length > 0) {
                    modal += '<textarea class="notes" disabled="">'+data['data']['notes']+'</textarea><hr>';
                }
                modal += '<div class="location"><div class="from"><div class="from-address">'+data['data']['from_address']+', '+data['data']['from_city']+'</div>';
                modal += '<div class="from-time">'+data['data']['from_time_start'].substring(0, data['data']['from_time_start'].length - 3)+' - ';
                modal += data['data']['from_time_end'].substring(0, data['data']['from_time_end'].length - 3)+'</div></div>';
                if(data['data']['one_stop_task'] != 1) {
                    modal += '<div class="arrow"><span class="glyphicon glyphicon-chevron-right"></span></div>';
                    modal += '<div class="to"><div class="to-address">' + data['data']['to_address'] + ', ' + data['data']['to_city'] + '</div>';
                    modal += '<div class="to-time">' + data['data']['to_time_start'].substring(0, data['data']['to_time_start'].length - 3) + ' - ';
                    modal += data['data']['to_time_start'].substring(0, data['data']['to_time_start'].length - 3) + '</div></div>';
                }
                modal += '</div><hr>';

                if(data['data']['passenger_delivery'] == 1) {
                    modal += '<div class="seats">' + data['data']['passengers'] + ' passengers';
                    if (data['data']['invalids'] > 0) {
                        modal += ' + ' + data['data']['invalids'] + ' inva';
                    }
                    modal += '</div><hr>';
                }

                if(data['data']['package_delivery'] == 1) {
                    modal += '<div class="packages"><div class="size">' + data['data']['cargo_length'] + ' x ' + data['data']['cargo_width'];
                    modal += ' x ' + data['data']['cargo_height'] + ' m (' + data['data']['total_volume'] + '㎥)</div>';
                    modal += '<div class="weight">' + data['data']['weight'] + ' kg</div></div>';
                    modal += '<div class="icons">';
                    if (data['data']['weather_protection'] == 1) {
                        modal += '<span class="icon icon-active"><i class="fa fa-umbrella" aria-hidden="true"></i></span>';
                    }
                    else {
                        modal += '<span class="icon"><i class="fa fa-umbrella" aria-hidden="true"></i></span>';
                    }
                    if (data['data']['fragile'] == 1) {
                        modal += '<span class="icon icon-active"><i class="fa fa-glass" aria-hidden="true"></i></span>';
                    }
                    else {
                        modal += '<span class="icon"><i class="fa fa-glass" aria-hidden="true"></i></span>';
                    }
                    if (data['data']['crane'] == 1) {
                        modal += '<span class="icon icon-active crane"></span>';
                    }
                    else {
                        modal += '<span class="icon crane"></span>';
                    }
                    if (data['data']['rear_lift'] == 1) {
                        modal += '<span class="icon icon-active lift"></span>';
                    }
                    else {
                        modal += '<span class="icon lift"></span>';
                    }
                    if (data['data']['food_accepted'] == 1) {
                        modal += '<span class="icon icon-active food"></span>';
                    }
                    else {
                        modal += '<span class="icon food"></span>';
                    }
                    if (data['data']['temp_control'] == 1) {
                        modal += '<span class="icon icon-active temperature"></span>';
                        modal += '<div class="temp">' + data['data']['temp_min'] + ' - ' + data['data']['temp_max'] + ' °C</div>';
                    }
                    else {
                        modal += '<span class="icon temperature"></span>';
                    }
                    modal += '</div>';
                }

                modal += '</div></div></div></div>';
                $('#main').append(modal);
                $('#task-modal'+id).modal('show');
            }
            else if (data['status'] == 'danger') {
                sendSystemMessage(data['status'], data['message']);
            }
        },
        error: function () {
            sendSystemMessage('danger', 'Can\'t show task details. Please reload the page.');
        }
    });
}

// remove Task Details Modal from DOM when close button is clicked
function closeTaskModal(id) {
    setTimeout(function(){
        $('#task-modal'+id).remove();
        $('.task-modal').modal('hide');
        $('.modal-body .tab-pane').removeClass('active');
        $('.modal-body .nav-tabs li').removeClass('active');
    }, 500);
};

//
// TRANSPORTS FUNCTIONALITY
//

// show New Job form
function showCreateJobForm() {
    $('#sidebar > div > .nav-tabs > li').removeClass('active');
    $('#sidebar > div > .nav-tabs > li:eq(2)').addClass('active');
    $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
    $('#sidebar > div > .tab-content > #transports').addClass('active');

    $('#choose-job-date').datetimepicker({
        timepicker: false,
        inline: true,
        format: 'Y.m.d',
        yearStart: new Date().getFullYear(),
        yearEnd: new Date().getFullYear() + 2,
        scrollMonth: false,
        defaultSelect: false,
        minDate: 0,
        onSelectDate: function() {
            $('#job-date-accordion h4 .job-chosen-date').text($('#choose-job-date').val());
            $('#job-date-collapse').removeClass('in');
        }
    });
    $('#job-date-collapse').addClass('in');
    $('#job-date-accordion h4 .job-chosen-date').text('Choose transport date');

    $('#job-new').hide();
    $('#jobs-accordion').hide();
    $('#job-date-accordion #choose-job-date').val('');
    $('#job-date-accordion .xdsoft_calendar .xdsoft_date').removeClass('xdsoft_current');
    $('#job-edit input[name="transjob_name"]').val('');
    $('#job-choose-vehicles .nav li').removeClass('active');
    $('#job-choose-vehicles .tab-content .tab-pane').removeClass('active');
    $('#job-choose-vehicles #job-own-vehicles input[type=checkbox]').removeAttr('checked');
    $('#job-choose-tasks .panel-body input[type=checkbox]').removeAttr('checked');
    $('#job-choose-tasks .panel-body').hide();
    $('#job-edit').show();
    $('#job-edit .button .btn.btn-primary').text('Create');
    $('#job-edit .button .btn.btn-primary').attr('onclick', 'sendOptimizationRequest()');
}

// show Tasks list when any Vehicle button is clicked
// then check which Vehicle option is selected and hide/show other tasks
$('#transports #job-choose-vehicles .nav li a').on('click', function() {
    $('#transports #job-choose-tasks .panel-body').show();

    if($(this).attr('aria-controls') == 'job-own-vehicles') {
        $('#transports #job-choose-tasks #input-find-tasks').show();
    }
    else if($(this).attr('aria-controls') == 'job-find-vehicles') {
        $('#transports #job-choose-tasks #input-find-tasks').hide();
        $('#transports #job-choose-tasks #input-find-tasks').prop('checked', false);
    }
});

// check if all fields are filled in / selected and if not then show an error message
function checkIfEverythingIsReady() {
    if($('#choose-job-date').val() == '') {
        sendSystemMessage('danger', 'Please select job date.');
        return false;
    }

    if($('#transports #job-edit input[name="transjob_name"]').val() == '') {
        sendSystemMessage('danger', 'Please type job name.');
        return false;
    }

    if(!$('#job-choose-vehicles .nav li').hasClass('active')) {
        sendSystemMessage('danger', 'Please choose whose vehicles to use.');
        return false;
    }
    else {
        if($('#job-choose-vehicles .nav li:eq(0)').hasClass('active')) {
            if(!$('#job-choose-vehicles #job-own-vehicles input[type=checkbox]:checked').length) {
                sendSystemMessage('danger', 'At least one vehicle should be selected.');
                return false;
            }
        }
    }

    if(!$('#job-choose-tasks .panel-body input[type=checkbox]:checked').length) {
        sendSystemMessage('danger', 'At least one task should be selected.');
        return false;
    }

    return true;
}

// send a request to optimization engine
function sendOptimizationRequest() {
    if(!checkIfEverythingIsReady()) {
        return false;
    }

    if($('#job-choose-vehicles .nav li:eq(0)').hasClass('active')) {
        $('input[name="is_own_vehicles"]').val(1);

        if($('#job-choose-tasks .panel-body .input-group:not(#input-find-tasks) input[type=checkbox]:checked').length) {
            $('input[name="is_own_tasks"]').val(1);
        }
        else {
            $('input[name="is_own_tasks"]').val(0);
        }

        if($('#job-choose-tasks .panel-body #input-find-tasks input[type=checkbox]:checked').length) {
            $('input[name="is_other_tasks"]').val(1);
        }
        else {
            $('input[name="is_other_tasks"]').val(0);
        }
    }
    else {
        $('input[name="is_own_vehicles"]').val(0);
        $('input[name="is_own_tasks"]').val(1);
        $('input[name="is_other_tasks"]').val(0);
    }

    $.ajax({
        type: "POST",
        url: '/optimize-problem',
        data: $("#job-edit form").serialize(),
        success: function(data)
        {
            sendSystemMessage(data['status'], data['message']);
            if(data['status'] == 'success') {
                updateTransjobsList();
                restoreTransjobsTab();
            }
        },
        error: function(data)
        {
            sendSystemMessage('danger', 'Some problems occured, please reload the page and try again.');
        }
    });
}

// restore default Transports tab with all Transports listed
function restoreTransjobsTab() {
    $('#job-new').show();
    $('#jobs-accordion').show();
    $('#job-edit').hide();

    showTransportsSection();
}

// clear entire input in Transports form so it's completely empty
function clearTransjobsForm() {
    $('#job-date-accordion #choose-job-date').val('');
    $('#job-date-accordion .xdsoft_calendar .xdsoft_date').removeClass('xdsoft_current');
    $('#job-edit input[name="transjob_name"]').val('');
    $('#job-choose-vehicles .nav li').removeClass('active');
    $('#job-choose-vehicles .tab-content .tab-pane').removeClass('active');
    $('#job-choose-vehicles #job-own-vehicles input[type=checkbox]').removeAttr('checked');
    $('#job-choose-tasks .panel-body input[type=checkbox]').removeAttr('checked');
    $('#job-choose-tasks .panel-body').hide();
}

// show edit job form
function showEditJobForm(id) {
    if($.isNumeric(id)) {
        $('#sidebar > div > .nav-tabs > li').removeClass('active');
        $('#sidebar > div > .nav-tabs > li:eq(2)').addClass('active');
        $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
        $('#sidebar > div > .tab-content > #transports').addClass('active');

        $('#job-edit .buttons .btn.btn-primary').text('Update');
        $('#job-edit .buttons .btn.btn-primary').attr('onclick', 'updateOptimizationRequest('+id+')');

        history.pushState(null, 'Edit Job', '/edit-job/' + id);
        changePageTitle('Edit Job - Transportation');

        $('#job-date-collapse').addClass('in');
        $('#job-date-accordion h4 .job-chosen-date').text('Choose transport date');

        $('#job-new').hide();
        $('#jobs-accordion').hide();
        $('#job-date-accordion #choose-job-date').val('');
        $('#job-date-accordion .xdsoft_calendar .xdsoft_date').removeClass('xdsoft_current');
        $('#job-edit input[name="transjob_name"]').val('');
        $('#job-choose-vehicles .nav li').removeClass('active');
        $('#job-choose-vehicles .tab-content .tab-pane').removeClass('active');
        $('#job-choose-vehicles #job-own-vehicles input[type=checkbox]').removeAttr('checked');
        $('#job-choose-tasks .panel-body input[type=checkbox]').removeAttr('checked');
        $('#job-choose-tasks .panel-body').show();

        // get info about current job from backend with AJAX
        $.ajax({
            type: "POST",
            url: '/get-edit-job-details/' + id,
            dataType: "json",
            success: function (data) {
                if(data['status'] == 'success') {
                    request = $.parseJSON(data['request']);

                    $('#job-edit input[name="is_own_vehicles"]').val(request.is_own_vehicles);
                    $('#job-edit input[name="is_own_tasks"]').val(request.is_own_tasks);
                    $('#job-edit input[name="is_other_tasks"]').val(request.is_other_tasks);

                    $('#job-edit #choose-job-date').val(data['date']);
                    $('#choose-job-date').datetimepicker({
                        timepicker: false,
                        inline: true,
                        format: 'Y.m.d',
                        yearStart: new Date().getFullYear(),
                        yearEnd: new Date().getFullYear() + 2,
                        scrollMonth: false,
                        defaultSelect: false,
                        minDate: 0,
                        onSelectDate: function() {
                            $('#job-date-accordion h4 .job-chosen-date').text($('#choose-job-date').val());
                            $('#job-date-collapse').removeClass('in');
                        }
                    });

                    $('#job-edit input[name="transjob_name"]').val(data['name']);

                    if(request.is_own_vehicles == 1) {
                        $('#job-edit #job-choose-vehicles .nav li:eq(0)').addClass('active');
                        $('#job-edit #job-choose-vehicles .tab-content .tab-pane:eq(0)').addClass('active');
                    }
                    else {
                        $('#job-edit #job-choose-vehicles .nav li:eq(1)').addClass('active');
                        $('#job-edit #job-choose-vehicles .tab-content .tab-pane:eq(1)').addClass('active');
                    }

                    if(request.is_other_tasks == 1) {
                        $('#job-edit #job-choose-tasks #input-find-tasks input[type=checkbox]').prop('checked', true);
                    }
                    else {
                        $('#job-edit #job-choose-tasks #input-find-tasks').hide();
                        $('#job-edit #job-choose-tasks #input-find-tasks').prop('checked', false);;
                    }

                    if(request.is_own_vehicles == 1) {
                        $.each(request.my_vehicles, function (id, veh) {
                            $('#job-edit #job-choose-vehicles .input-group input[name="my_vehicles[' + id + ']"]').prop('checked', true);
                        });
                    }

                    if(request.is_own_tasks == 1) {
                        $.each(request.my_tasks, function (id, veh) {
                            $('#job-edit #job-choose-tasks .input-group input[name="my_tasks[' + id + ']"]').prop('checked', true);
                        });
                    }
                }
                else if (data['status'] == 'danger') {
                    sendSystemMessage(data['status'], data['message']);
                }
            },
            error: function (data) {
                var errors = data.responseJSON;
                showErrors(errors, 'job-edit');
            }
        });

        $('#job-edit').show();
    }
}

// update an existing job
function updateOptimizationRequest(id) {
    if(!checkIfEverythingIsReady()) {
        return false;
    }

    if($('#job-choose-vehicles .nav li:eq(0)').hasClass('active')) {
        $('input[name="is_own_vehicles"]').val(1);

        if($('#job-choose-tasks .panel-body .input-group:not(#input-find-tasks) input[type=checkbox]:checked').length) {
            $('input[name="is_own_tasks"]').val(1);
        }
        else {
            $('input[name="is_own_tasks"]').val(0);
        }

        if($('#job-choose-tasks .panel-body #input-find-tasks input[type=checkbox]:checked').length) {
            $('input[name="is_other_tasks"]').val(1);
        }
        else {
            $('input[name="is_other_tasks"]').val(0);
        }
    }
    else {
        $('input[name="is_own_vehicles"]').val(0);
        $('input[name="is_own_tasks"]').val(1);
        $('input[name="is_other_tasks"]').val(0);
    }

    if($.isNumeric(id)) {
        $.ajax({
            type: "POST",
            url: '/update-problem/' + id,
            data: $("#job-edit form").serialize(),
            success: function (data) {
                sendSystemMessage(data['status'], data['message']);
                if(data['status'] == 'success') {
                    updateTransjobsList();
                    restoreTransjobsTab();
                }
            },
            error: function (data) {
                sendSystemMessage('danger', 'Some problems occured, please reload the page and try again.');
            }
        });
    }
}

// make New Job tab look like on initialization
function restoreNewJobTab() {
    $('input[name="is_own_vehicles"]').val(0);
    $('input[name="is_own_tasks"]').val(0);
    $('input[name="is_other_tasks"]').val(0);

    $('#transjob_name').val('');
    $('#transjob_date').val('');

    $('#own-vehicles-block-button').parent('li').removeClass('active');
    $('#find-vehicles-block-button').parent('li').removeClass('active');

    $('#own-tasks label.btn').removeClass('active');
    $('#own-tasks label.btn input').prop('checked', false);
    $('#find-tasks label.btn').removeClass('active');
    $('#find-tasks label.btn input').prop('checked', false);

    $('a[href="#new-route-block"]').html('<i class="fa fa-truck"></i> New');
    $('#job-edit-button').hide();
    $('#job-restore-button').hide();
    $('#job-create-button').show();

    $('.my-vehicles .vehicles-list label').removeClass('active');
    $('.my-vehicles .vehicles-list label input').prop('checked', false);
    $('.my-tasks .tasks-list label').removeClass('active');
    $('.my-tasks .tasks-list label input').prop('checked', false);

    $('#new-route-block .step-two').hide();
    $('#new-route-block .step-two .collapse').removeClass('in');
    $('#new-route-block .step-one .tab-pane').removeClass('active');

    showHomepage();
}

// update my transjobs list
function updateTransjobsList() {
    $('#jobs-accordion .panel').remove('');

    $.ajax({
        type: "POST",
        url: '/get-jobs-list',
        success: function(data)
        {
            if(data['status'] == 'success') {
                is_empty = true;

                $.each( data['data'], function( index, value ){
                    element = '<div class="panel panel-default">'+'<div class="panel-heading" role="tab" id="job-heading'+value['id']+'">';
                    element += '<h4 class="panel-title">'+'<a role="button" onclick="viewJobTime('+value['id']+',1)" data-toggle="collapse" data-parent="#jobs-accordion" href="#job-collapse'+value['id']+'" aria-expanded="false" aria-controls="job-collapse'+value['id']+'">';
                    element += '<div class="job-date pull-left">'+value['job_date']+'</div>'+'<div class="job-name ellipsis_label">'+value['name']+'</div>';
                    element += '<div class="job-actions pull-right">'+'<i class="fa fa-clone text-success" onclick="cloneJob('+value['id']+')"></i>';
                    element += ' <i class="fa fa-pencil-square-o text-warning" onclick="showEditJobForm('+value['id']+')"></i>';
                    element += ' <i class="fa fa-trash-o text-danger" onclick="deleteJob('+value['id']+')"></i>';
                    element += '</div></a></h4></div>';
                    element += '<div id="job-collapse'+value['id']+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="job-heading'+value['id']+'">';
                    element += '<div class="panel-body"><div class="row">';
                    element += '<div class="col-lg-12 job-details" id="job'+value['id']+'-details"></div></div></div>';
                    element += '</div></div></div>';

                    $('#jobs-accordion').append(element);
                    is_empty = false;
                });

                if (is_empty === true) {
                    $('#jobs-accordion .nothing').show();
                }
                else {
                    $('#jobs-accordion .nothing').hide();
                }
            }
            else if(data['status'] == 'danger') {
                $('#jobs-accordion').after('<div class="col-lg-12"><p>You don\'t have any transports.</p></div>');
            }
        },
        error: function(data)
        {
            $('#jobs-accordion').after('<div class="col-lg-12"><p>Error occured, please reload the page.</p></div>');
        }
    });
}

// view job's driving list by provided ID
function viewJobTime(id, fresh) {
    if($.isNumeric(id)) {
        $('#top-navbar .nav-tabs > li').removeClass('active');
        $('#top-navbar .nav-tabs > li.transport_menu').addClass('active');
        $('#sidebar > div > .tab-content > .tab-pane').removeClass('active');
        $('#sidebar > div > .tab-content > #transports').addClass('active');

        history.pushState(null, 'View Job', '/view-transport-time/' + id);
        changePageTitle('View Transport - Transportation');

        if($('#jobs-accordion #job-heading'+id+' a').hasClass('collapsed') || fresh === 1) {
            // get info about current job from backend with AJAX
            $.ajax({
                type: "POST",
                url: '/get-job-driving-list/' + id,
                dataType: "json",
                success: function (data) {
                    if (data['status'] == 'success') {
                        $('#jobDrivingList').html('');
                        solution = $.parseJSON(data['data']);
                        job_info = $.parseJSON(data['job_info']);
                        total_tasks = $.parseJSON(data['total_tasks']);

                        clearMap();

                        $('#job' + id + '-details').html('');

                        details = '<div id="tasks-transported">' + total_tasks + ' tasks transported</div>';
                        if(job_info.is_own_vehicles == 1) {
                            details += '<div id="total-info">Total: ' + job_info.distance + ' m, ' + job_info.completion_time + ' s, ' + job_info.costs + ' cents</div>';
                        }
                        $('#job' + id + '-details').append(details);

                        $.each(solution, function (index, vehicle) {
                            route = "<div class='route' id='" + vehicle.vehicle_id + "'>";
                            route += "<h5><span> " + vehicleTypeIcon(vehicle.vehicle_type) + "</span> " + vehicle.vehicle_name;
                            if(job_info.is_own_vehicles == 0) {
                                route += " (owned by "+vehicle.vehicle_owner_name+")";
                            }
                            route += " - " + vehicle.activities_count + " tasks:</h5>";
                            route += "<div class='table-responsive'><table class='table table-bordered table-condensed table-striped'><tbody>";
                            i = 0;

                            $.each(vehicle.activities, function (key, activity) {
                                if((job_info.is_own_vehicles == 1) || (activity.type != 'Vehicle start' && activity.type != 'Vehicle end')) {
                                    i++;
                                    switch (activity.type) {
                                        case 'Vehicle start':
                                            arrow = '<span class="glyphicon glyphicon-play" aria-hidden="true"></span>';
                                            break;
                                        case 'pickup':
                                            arrow = '<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>';
                                            break;
                                        case 'delivery':
                                            arrow = '<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>';
                                            break;
                                        case 'Vehicle end':
                                            arrow = '<span class="glyphicon glyphicon-stop" aria-hidden="true"></span>';
                                            break;
                                        default:
                                            arrow = '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>';
                                    }
                                    route += "<tr id='" + activity.id + "'><td>" + i + ".</td>";
                                    if (activity.type == 'pickup' || activity.type == 'delivery' || activity.type == 'one-stop') {
                                        route += "<td>" + activity.task_name + "</td>";
                                    }
                                    if (activity.type == 'Vehicle start' || activity.type == 'Vehicle end') {
                                        route += "<td>" + activity.task_name + " " + activity.type + "</td>";
                                    }
                                    route += "<td>" + arrow + "</td>";
                                    route += "<td>" + activity.arrival;
                                    if (activity.arrival != '' && activity.departure != '') {
                                        route += " - ";
                                    }
                                    route += activity.departure + "</td>";
                                    if (activity.type == 'pickup' || activity.type == 'delivery' || activity.type == 'one-stop') {
                                        route += "<td><button onclick='showTaskPopup(" + activity.task_id + ")' class='btn-link pull-right'>";
                                        route += "<span class='glyphicon glyphicon-share' aria-hidden='true'></span></button>";
                                    }
                                    if (activity.type == 'Vehicle start' || activity.type == 'Vehicle end') {
                                        route += "<td><button onclick='showVehiclePopup(" + vehicle.vehicle_id + ")' class='btn-link pull-right'>";
                                        route += "<span class='glyphicon glyphicon-share' aria-hidden='true'></span></button>";
                                    }
                                    route += "</td></tr>";

                                    if ((activity.start_lat != 0) && (activity.start_lon != 0)) {
                                        if (activity.type == 'Vehicle start' || activity.type == 'Vehicle end') {
                                            var marker = L.marker(
                                                [activity.start_lat, activity.start_lon],
                                                {
                                                    title: 'Vehicle ' + vehicle.vehicle_name + ' start',
                                                    alt: 'marMarker'
                                                }
                                            ).addTo(map).on('click', function (e) {
                                                showVehiclePopup(vehicle.vehicle_id);
                                            });
                                        }
                                        else {
                                            var marker = L.marker(
                                                [activity.start_lat, activity.start_lon],
                                                {
                                                    title: activity.task_name,
                                                    alt: 'marMarker'
                                                }
                                            ).addTo(map).on('click', function (e) {
                                                showTaskPopup(activity.task_id);
                                            });
                                        }
                                    }
                                    if ((activity.stop_lat != 0) && (activity.stop_lon != 0)) {
                                        if (activity.type == 'Vehicle start' || activity.type == 'Vehicle end') {
                                            var marker = L.marker(
                                                [activity.stop_lat, activity.stop_lon],
                                                {
                                                    title: 'Vehicle ' + vehicle.vehicle_name + ' end',
                                                    alt: 'marMarker'
                                                }
                                            ).addTo(map).on('click', function (e) {
                                                showVehiclePopup(vehicle.vehicle_id);
                                            });
                                        }
                                        else {
                                            var marker = L.marker(
                                                [activity.stop_lat, activity.stop_lon],
                                                {
                                                    title: activity.task_name,
                                                    alt: 'marMarker'
                                                }
                                            ).addTo(map).on('click', function (e) {
                                                showTaskPopup(activity.task_id);
                                            });
                                        }
                                    }
                                }
                            });
                            route += "</tbody></table></div></div>";

                            $('#job' + id + '-details').append(route);


                            // create a  polyline from an array of LatLng points and zoom map to it
                            var back = ["#226666", "#2D882D", "#2E4272", "#403075", "#582A72", "#892E61", "#AB6D39", "#AB8539", "#1F1C16", "#43403A"];
                            var rand = back[Math.floor(Math.random() * back.length)];
                            var polyline = L.polyline(vehicle.directions, {color: rand}).addTo(map);
                            map.fitBounds(polyline.getBounds());

                            // set vehicle heading color in Job Details of same color as route on the map
                            $('#job'+id+'-details #'+vehicle.vehicle_id+'.route h5').css('background-color', rand);
                        });
                    }
                    else if (data['status'] == 'danger') {
                        sendSystemMessage(data['status'], data['message']);
                    }
                },
                error: function (data) {
                    sendSystemMessage('danger', 'Some errors occured. Please reload the page.');
                }
            });
        }
        else {
            clearMap();
        }

        $('#jobs-accordion .panel .panel-heading a').each(function () {
            action = $(this).attr('onclick');
            last_three = action.slice(-3);
            if(last_three == ',1)') {
                action = action.slice(0, -3);
                action += ')';
                $(this).attr('onclick', action);
            }
        });
    }
}

// deletes selected transjob
function deleteJob(id) {
    if($.isNumeric(id)) {
        $.ajax({
            type: "POST",
            url: '/delete-problem/' + id,
            success: function (data) {
                sendSystemMessage(data['status'], data['message']);
                if (data['status'] == 'success') {
                    updateTransjobsList();
                    showTransportsSection();
                    clearMap();
                }
            },
            error: function (data) {
                sendSystemMessage('danger', 'Some problems occured, please reload the page and try again.');
            }
        });
    }
}

// clones selected transjob
function cloneJob(id) {
    if($.isNumeric(id)) {
        $.ajax({
            type: "POST",
            url: '/clone-problem/' + id,
            success: function (data) {
                sendSystemMessage(data['status'], data['message']);
                if (data['status'] == 'success') {
                    updateTransjobsList();
                    showEditJobForm(data['id']);
                }
            },
            error: function (data) {
                sendSystemMessage('danger', 'Some problems occured, please reload the page and try again.');
            }
        });
    }
}

// filter Tasks in the list in Transports tab
$("#filter-choose-tasks").keyup(function() {
    var rows = $("#transports #job-choose-tasks").find(".input-group").hide();
    var data = this.value.split(" ");

    rows.filter(function (i, v) {
        var $t = $(this);
        for (var d = 0; d < data.length; ++d) {
            if ($t.text().toLowerCase().indexOf(data[d].toLowerCase()) > -1) {
                return true;
            }
        }
        return false;
    }).show();
});

// enable or disable filtering task names from input field in New Transports
function toggleTasksFilter() {
    if($('#transports #filter-choose-tasks').hasClass('active-input')) {
        $('#transports #filter-choose-tasks').removeClass('active-input');
        $("#transports #job-choose-tasks .input-group").show();
        $('#transports #filter-choose-tasks').val('Choose tasks');
        $('#transports #filter-choose-tasks').attr('disabled', 'disabled');
    }
    else {
        $('#transports #filter-choose-tasks').addClass('active-input');
        $('#transports #filter-choose-tasks').val('');
        $('#transports #filter-choose-tasks').removeAttr('disabled');
    }
}

// remove old markers and polyline from Map - completely clear the Route
function clearMap() {
    for (i in map._layers) {
        try {
            if (map._layers[i]._path != undefined) {
                map.removeLayer(map._layers[i]);
            }
            if (map._layers[i].options.alt == "marMarker") {
                map.removeLayer(map._layers[i]);
            }
        }
        catch (e) {
        }
    }
}

// update Vehicles in New/Edit Job form
function updateJobVehiclesList() {
    $('#job-own-vehicles').html('');

    $.ajax({
        type: "POST",
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

                    $('#job-own-vehicles').append(element);
                    is_empty = false;
                });

                if (is_empty === true) {
                    $('#job-own-vehicles').html('<p>You don\'t have any vehicles.</p>');
                }
            }
            else if(data['status'] == 'danger') {
                $('#job-own-vehicles').html('<p>You don\'t have any vehicles.</p>');
            }
        },
        error: function(data)
        {
            $('#job-own-vehicles').html('<p>You don\'t have any vehicles.</p>');
        }
    });
}

// update Tasks in New/Edit Job form
function updateJobTasksList() {
    $('#job-choose-tasks .panel-body').html('');

    $.ajax({
        type: "POST",
        url: '/get-task-list',
        success: function(data)
        {
            first_element = '<div class="input-group" id="input-find-tasks"><span class="input-group-addon label-success">';
            first_element += '<input type="checkbox" aria-label="input-find-tasks" name="input_find_tasks"></span>';
            first_element += '<span class="form-control label-success" aria-label="input-find-tasks">';
            first_element += 'Find new tasks for my transport</span></div>';

            if(data['status'] == 'success') {
                is_empty = true;

                $('#job-choose-tasks .panel-body').html(first_element);

                $.each( data['data'], function( index, value ){
                    element = '<div class="input-group"><span class="input-group-addon">';
                    element += '<input type="checkbox" aria-label="own-tasks'+value['id']+'" name="my_tasks['+value['id']+']">';
                    element += '</span><span class="form-control" aria-label="own-tasks'+value['id']+'">'+value['name'];
                    element += '<button class="btn-link pull-right"><span class="glyphicon glyphicon-share" aria-hidden="true"></span>';
                    element += '</button></span></div>';

                    $('#job-choose-tasks .panel-body').append(element);
                    is_empty = false;
                });
            }
            else if(data['status'] == 'danger') {
                $('#job-choose-tasks .panel-body').html(first_element);
            }
        },
        error: function(data)
        {
            $('#job-choose-tasks .panel-body').html('<p>You don\'t have any tasks.</p>');
        }
    });
}

//
// END OF TRANSPORTS FUNCTIONALITY
//