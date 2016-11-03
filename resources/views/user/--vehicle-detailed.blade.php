<div class="row">
    <div class="col-xs-5">
        <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Vehicle name">
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group">
            <select class="form-control" name="type">
                <option disabled="" selected="">Type</option>
                @foreach ($vehicle_types as $vehicle_type)
                    <option value="{{$vehicle_type->id}}">{{$vehicle_type->name}}</option>
                @endforeach
            </select>

            <span class="select-show" name="select-vehicle-type"></span>
        </div>
    </div>

    <div class="col-xs-4">
        <div class="form-group">
            <select class="form-control" name="max_speed">
                <option disabled="" selected="">Max speed</option>
                <option value="80">80km/h</option>
                <option value="90">90km/h</option>
                <option value="100">100km/h</option>
                <option value="110">110km/h</option>
                <option value="120">120km/h</option>
            </select>

            <span class="select-show" name="select-max-speed"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group data-toggle" id="vehicle-carry-form" data-toggle="buttons">
            <div class="overflow"></div>

            <label id="vehicle_passenger_delivery_control" class="btn btn-link col-xs-6" value="passenger_delivery" onclick="toggleVehicleTypeControl()">
                <i class="fa fa-users" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> For Passengers
            </label>

            <label id="vehicle_package_delivery_control" class="btn btn-link col-xs-6" value="package_delivery" onclick="toggleVehicleTypeControl()">
                <i class="fa fa-dropbox" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> For Cargo
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

<div class="panel-group" id="vehicle-accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="vehicle-location-heading">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#vehicle-accordion" href="#vehicle-location" aria-expanded="false" aria-controls="vehicle-location">
                    Location
                </a>
            </h4>
        </div>

        <div id="vehicle-location" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-location-heading">
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
                            <input class="form-control" type="text" name="from_time" placeholder="Earliest: 08:00" step="60">
                            <span class="select-show" name="select-from-time"></span>
                        </div>
                    </div>

                    <span class="glyphicon glyphicon-chevron-right"></span>

                    <div class="col-xs-5 col-xs-offset-2">
                        <div class="form-group">
                            <input class="form-control" type="text" name="to_address" id="to_address" placeholder="Address">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="to_city" placeholder="City">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="to_time" placeholder="Latest: 20:00"step="60">
                            <span class="select-show" name="select-to-time"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-5 col-xs-offset-7">
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm" type="button" onclick="setVehicleEndAddress()">
                                Same as start address
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="vehicle-passengers-heading">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#vehicle-accordion" href="#vehicle-passengers" aria-expanded="false" aria-controls="vehicle-passengers">
                    Passenger Details
                </a>
            </h4>
        </div>

        <div id="vehicle-passengers" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-passengers-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-5">
                        <input class="form-control" type="number" name="max_passengers" id="max_passengers" placeholder="3">
                    </div>

                    <div class="col-xs-1">
                        <span class="cost-label">seats</span>
                    </div>

                    <div class="col-xs-3">
                        <input class="form-control" type="number" name="invalid_seats" id="invalid_seats" placeholder="1">
                    </div>

                    <div class="col-xs-3">
                        <span class="cost-label">+ inva seats</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="vehicle-cargo-heading">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#vehicle-accordion" href="#vehicle-cargo" aria-expanded="false" aria-controls="vehicle-cargo">
                    Cargo Details
                </a>
            </h4>
        </div>

        <div id="vehicle-cargo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-cargo-heading">
            <div class="panel-body">
                <div class="row" id="trunk-size">
                    <div class="col-xs-8">
                        <span class="select-show" name="select-trunk-size"></span>
                    </div>

                    <div class="col-xs-4">
                        <span class="select-show" name="select-max-weight"></span>
                    </div>
                </div>

                <div class="row" id="cargo-size">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <input class="form-control" type="number" name="trunk_length" id="trunk_length" placeholder="4" step="0.1">
                        </div>
                    </div>

                    <span class="cost-label cargo-label">x</span>

                    <div class="col-xs-3">
                        <div class="form-group">
                            <input class="form-control" type="number" name="trunk_width" id="trunk_width" placeholder="1.8" step="0.1">
                        </div>
                    </div>

                    <span class="cost-label cargo-label">x</span>

                    <div class="col-xs-3">
                        <div class="form-group">
                            <input class="form-control" type="number" name="trunk_height" id="trunk_height" placeholder="2" step="0.1">
                        </div>
                    </div>

                    <span class="cost-label cargo-label">m</span>
                </div>

                <div class="row" id="cargo-weight">
                    <div class="col-xs-5">
                        <div class="form-group">
                            <input class="form-control" type="number" name="max_weight" id="max_weight" placeholder="300">
                        </div>
                    </div>

                    <span class="cost-label cargo-label">kg</span>
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
                            <label id="food_accepted" class="btn btn-link">
                                <span class="icon food"></span>
                                <input type="checkbox" autocomplete="off" name="food_accepted">
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="form-group data-toggle" data-toggle="buttons">
                            <label id="temp_control" class="btn btn-link" onclick="toggleVehicleTempControl()">
                                <span class="icon temperature"></span>
                                <input type="checkbox" autocomplete="off" name="temp_control">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="vehicle-temperature-values">
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

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="vehicle-costs-heading">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#vehicle-accordion" href="#vehicle-costs" aria-expanded="false" aria-controls="vehicle-costs">
                    Costs
                </a>
            </h4>
        </div>

        <div id="vehicle-costs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-costs-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-3">
                        <input class="form-control" type="number" name="cost_eur_task" id="cost_eur_task" placeholder="10" step="0.1" min="0">
                    </div>

                    <div class="col-xs-1">
                        <span class="cost-label">€/task</span>
                    </div>

                    <div class="col-xs-3">
                        <input class="form-control" type="number" name="cost_eur_h" id="cost_eur_h" placeholder="10" step="0.1" min="0">
                    </div>

                    <div class="col-xs-1">
                        <span class="cost-label">€/h</span>
                    </div>

                    <div class="col-xs-3">
                        <input class="form-control" type="number" name="cost_eur_km" id="cost_eur_km" placeholder="10" step="0.1" min="0">
                    </div>

                    <div class="col-xs-1">
                        <span class="cost-label">€/km</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>