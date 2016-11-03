<div class="row">
    <div class="col-xs-8">
        <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Task name">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group data-toggle" id="task-carry-form" data-toggle="buttons">
            <div class="overflow"></div>

            <label id="task_passenger_delivery_control" class="btn btn-link col-xs-4" value="passenger_delivery" onclick="toggleTaskTypeControl()">
                <i class="fa fa-users" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> Passenger Task
            </label>

            <label id="task_package_delivery_control" class="btn btn-link col-xs-4" value="package_delivery" onclick="toggleTaskTypeControl()">
                <i class="fa fa-dropbox" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> Cargo Task
            </label>

            <label id="task_one_stop_task_control" class="btn btn-link col-xs-4" value="one_stop_task" onclick="toggleTaskTypeControl()">
                <i class="fa fa-coffee" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> Single Stop
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            <textarea class="form-control" rows="3" id="notes" name="notes" aria-describedby="notes" placeholder="Additional information"></textarea>
        </div>
    </div>
</div>

<div class="panel-group" id="task-accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="task-location-heading">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#task-accordion" href="#task-location" aria-expanded="false" aria-controls="task-location">
                    Location
                </a>
            </h4>
        </div>

        <div id="task-location" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-location-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="form-group">
                            <input class="form-control" type="text" name="from_address" id="from_address" placeholder="Address">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="from_city" placeholder="City">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="from_time_start" placeholder="From" step="60">
                            <span class="select-show" name="select-from-time-start"></span>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="from_time_end" placeholder="To" step="60">
                            <span class="select-show" name="select-from-time-end"></span>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="loading_time" placeholder="Loading: 1min">
                            <span class="select-show" name="select-loading-time"></span>
                        </div>
                    </div>

                    <span class="glyphicon glyphicon-chevron-right"></span>

                    <div class="col-xs-5 col-xs-offset-2" id="location-to">
                        <div class="form-group">
                            <input class="form-control" type="text" name="to_address" id="to_address" placeholder="Address">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="to_city" placeholder="City">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="to_time_start" placeholder="From" step="60">
                            <span class="select-show" name="select-to-time-start"></span>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="to_time_end" placeholder="To" step="60">
                            <span class="select-show" name="select-to-time-end"></span>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="unload_time" placeholder="Unload: 1min">
                            <span class="select-show" name="select-unload-time"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="task-passengers-heading">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#task-accordion" href="#task-passengers" aria-expanded="false" aria-controls="task-passengers">
                    Passenger Details
                </a>
            </h4>
        </div>

        <div id="task-passengers" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-passengers-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <input class="form-control" type="number" name="passengers" id="passengers" placeholder="3">
                    </div>

                    <div class="col-xs-2">
                        <span class="cost-label">passengers</span>
                    </div>

                    <div class="col-xs-3">
                        <input class="form-control" type="number" name="invalids" id="invalids" placeholder="1">
                    </div>

                    <div class="col-xs-3">
                        <span class="cost-label">+ invalids</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="task-cargo-heading">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#task-accordion" href="#task-cargo" aria-expanded="false" aria-controls="task-cargo">
                    Cargo Details
                </a>
            </h4>
        </div>

        <div id="task-cargo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-cargo-heading">
            <div class="panel-body">
                <div class="row" id="trunk-size">
                    <div class="col-xs-5">
                        <span class="select-show" name="select-trunk-size"></span>
                    </div>

                    <div class="col-xs-3">
                        <span class="select-show" name="select-max-weight"></span>
                    </div>

                    <div class="col-xs-4">
                        <span class="select-show" name="select-total-packages"></span>
                    </div>
                </div>

                <div class="row" id="cargo-size">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <input class="form-control" type="number" name="cargo_length" id="cargo_length" placeholder="4" step="0.1">
                        </div>
                    </div>

                    <span class="cost-label cargo-label">x</span>

                    <div class="col-xs-3">
                        <div class="form-group">
                            <input class="form-control" type="number" name="cargo_width" id="cargo_width" placeholder="1.8" step="0.1">
                        </div>
                    </div>

                    <span class="cost-label cargo-label">x</span>

                    <div class="col-xs-3">
                        <div class="form-group">
                            <input class="form-control" type="number" name="cargo_height" id="cargo_height" placeholder="2" step="0.1">
                        </div>
                    </div>

                    <span class="cost-label cargo-label">m</span>
                </div>

                <div class="row">
                    <div id="cargo-weight">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <input class="form-control" type="number" name="weight" id="weight" placeholder="300">
                            </div>
                        </div>

                        <span class="cost-label cargo-label">kg</span>
                    </div>

                    <div id="total-packages">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <input class="form-control" type="number" name="total_packages" id="total_packages" placeholder="5">
                            </div>
                        </div>

                        <span class="cost-label cargo-label">packages</span>
                    </div>
                </div>

                <div class="row cargo-items">
                    <div class="overflow"></div>

                    <div class="col-xs-2">
                        <div class="form-group data-toggle" data-toggle="buttons">
                            <label id="weather_protection" class="btn btn-link">
                                <i class="fa fa-umbrella" aria-hidden="true"></i>
                                <input type="checkbox" autocomplete="off" name="weather_protection">
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="form-group data-toggle" data-toggle="buttons">
                            <label id="fragile" class="btn btn-link">
                                <i class="fa fa-glass" aria-hidden="true"></i>
                                <input type="checkbox" autocomplete="off" name="fragile">
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="form-group data-toggle" data-toggle="buttons">
                            <label id="crane" class="btn btn-link">
                                <span class="icon crane"></span>
                                <input type="checkbox" autocomplete="off" name="crane">
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="form-group data-toggle" data-toggle="buttons">
                            <label id="rear_lift" class="btn btn-link">
                                <span class="icon lift"></span>
                                <input type="checkbox" autocomplete="off" name="rear_lift">
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="form-group data-toggle" data-toggle="buttons">
                            <label id="food" class="btn btn-link">
                                <span class="icon food"></span>
                                <input type="checkbox" autocomplete="off" name="food">
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="form-group data-toggle" data-toggle="buttons">
                            <label id="temp_control" class="btn btn-link" onclick="toggleTaskTempControl()">
                                <span class="icon temperature"></span>
                                <input type="checkbox" autocomplete="off" name="temp_control">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="task-temperature-values">
                    <div class="col-xs-4 col-xs-offset-8">
                        <div class="form-group">
                            <input class="form-control" type="number" name="temp_min" id="temp_min" placeholder="Min °C">
                            <span class="select-show" name="select-temp-min"></span>
                        </div>
                    </div>

                    <div class="col-xs-4 col-xs-offset-8">
                        <div class="form-group">
                            <input class="form-control" type="number" name="temp_max" id="temp_max" placeholder="Max °C">
                            <span class="select-show" name="select-temp-max"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>