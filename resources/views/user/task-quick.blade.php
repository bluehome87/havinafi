<div class="row">
    <div class="col-xs-8">
        <div class="form-group">
            <input class="form-control" type="text" name="quick_name" placeholder="Name or reg. nr.">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group data-toggle" id="quick-task-carry-form" data-toggle="buttons">
            <label id="quick_task_passenger_delivery_control" class="btn btn-link col-xs-4" value="passenger_delivery" onclick="toggleTaskTypeQuickControl()">
                <i class="fa fa-users" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> Passenger Task
            </label>

            <label id="quick_task_package_delivery_control" class="btn btn-link col-xs-4" value="package_delivery" onclick="toggleTaskTypeQuickControl()">
                <i class="fa fa-dropbox" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> Cargo Task
            </label>

            <label id="quick_task_one_stop_task_control" class="btn btn-link col-xs-4" value="one_stop_task" onclick="toggleTaskTypeQuickControl()">
                <i class="fa fa-coffee" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> Single Stop
            </label>
        </div>
    </div>

    <div class="col-xs-4">
        <div class="form-group">
            <input class="form-control" type="number" name="quick_passengers" id="quick_passengers" placeholder="3 seats">
        </div>
    </div>

    <div class="col-xs-4">
        <div class="form-group">
            <input class="form-control" type="number" name="quick_total_volume" id="quick_total_volume" placeholder="14.4&#13221;" step="0.1">
        </div>
    </div>

    <div class="col-xs-4">
        <div class="form-group">
            <input class="form-control" type="number" name="quick_loading_time" id="quick_loading_time" placeholder="Stop (3min)">
        </div>
    </div>
</div>

<div class="row quick-location">
    <div class="col-xs-5">
        <div class="form-group">
            <input class="form-control" type="text" name="quick_from_address" id="quick_from_address" placeholder="Address">
        </div>

        <div class="form-group">
            <input class="form-control" type="text" name="quick_from_city" placeholder="City">
        </div>
    </div>

    <span class="glyphicon glyphicon-chevron-right"></span>

    <div class="col-xs-5 col-xs-offset-2" id="quick-location-to">
        <div class="form-group">
            <input class="form-control" type="text" name="quick_to_address" id="quick_to_address" placeholder="Address">
        </div>

        <div class="form-group">
            <input class="form-control" type="text" name="quick_to_city" placeholder="City">
        </div>
    </div>
</div>