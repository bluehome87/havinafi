<div id="vehicle-block" class="col-lg-12 block">
    <h1>Create Vehicle</h1>
    <br>

    <form role="form" method="POST" action="{{ url('/create-vehicle') }}">
        <fieldset>
            {!! csrf_field() !!}
            <input type="hidden" name="purpose" id="vehiclePurpose">

            @if (count($errors) > 0 && Request::is('vehicle'))
                <div class="alert alert-danger errors" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span>Errors:</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="panel-group" id="vehicle-accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="vehicle-general-heading">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#vehicle-accordion" href="#vehicle-general" aria-expanded="true" aria-controls="vehicle-general">
                                Vehicle Type
                            </a>
                        </h4>
                    </div>

                    <div id="vehicle-general" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="vehicle-general-heading">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" type="name" name="name" placeholder="Vehicle name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" type="max_speed" name="max_speed" placeholder="Max speed (km/h)">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control" name="type">
                                            <option disabled="">Vehicle type</option>
                                            @foreach ($vehicle_types as $vehicle_type)
                                                <option value="{{$vehicle_type->id}}">{{$vehicle_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" id="vehicle-carry-form" data-toggle="buttons">
                                        <label id="vehicle_passenger_delivery_control" class="btn btn-default" value="passenger_delivery" onclick="toggleVehicleTypeControl()">
                                            <input type="radio" autocomplete="off"> For Passengers
                                        </label>

                                        <label id="vehicle_package_delivery_control" class="btn btn-default" value="package_delivery" onclick="toggleVehicleTypeControl()">
                                            <input type="radio" autocomplete="off"> For Cargo
                                        </label>
                                    </div>
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="notes">Notes</span>
                                            <textarea class="form-control" rows="3" id="notes" name="notes" aria-describedby="notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="vehicle-from-to-heading">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#vehicle-accordion" href="#vehicle-from-to" aria-expanded="false" aria-controls="vehicle-from-to">
                                Address & Time
                            </a>
                        </h4>
                    </div>

                    <div id="vehicle-from-to" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-from-to-heading">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="from_address">From</label>

                                        <input class="form-control" type="text" name="from_address" id="from_address" placeholder="Address">
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="from_city" placeholder="City">
                                    </div>

                                    <div>
                                        <input class="form-control" type="text" name="from_time" placeholder="08:00" step="60">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="to_address">To</label>

                                        <input class="form-control" type="text" name="to_address" id="to_address" placeholder="Address">
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="to_city" placeholder="City">
                                    </div>

                                    <div>
                                        <input class="form-control" type="text" name="to_time" placeholder="20:00"step="60">
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
                                <div class="col-lg-4">
                                    <div>
                                        <label class="control-label" for="cost_eur_task">€/task</label>

                                        <input class="form-control" type="number" name="cost_eur_task" id="cost_eur_task" placeholder="0" step="0.1">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div>
                                        <label class="control-label" for="cost_eur_km">€/km</label>

                                        <input class="form-control" type="number" name="cost_eur_km" id="cost_eur_km" placeholder="0" step="0.1">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div>
                                        <label class="control-label" for="cost_eur_h">€/h</label>

                                        <input class="form-control" type="number" name="cost_eur_h" id="cost_eur_h" placeholder="0" step="0.1">
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
                                Passengers
                            </a>
                        </h4>
                    </div>

                    <div id="vehicle-passengers" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-passengers-heading">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <label class="control-label" for="max_passengers">Max passengers</label>

                                        <input class="form-control" type="number" name="max_passengers" id="max_passengers" placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="vehicle-cargo-heading">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#vehicle-accordion" href="#vehicle-cargo" aria-expanded="false" aria-controls="vehicle-cargo">
                                Cargo
                            </a>
                        </h4>
                    </div>

                    <div id="vehicle-cargo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-cargo-heading">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="trunk_length">Cargo space length (m)</label>

                                        <input class="form-control" type="number" name="trunk_length" id="trunk_length" placeholder="0" step="0.01">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="trunk_width">Cargo space width (m)</label>

                                        <input class="form-control" type="number" name="trunk_width" id="trunk_width" placeholder="0" step="0.01">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="trunk_height">Cargo space height (m)</label>

                                        <input class="form-control" type="number" name="trunk_height" id="trunk_height" placeholder="0" step="0.01">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="max_weight">Max weight (kg)</label>

                                        <input class="form-control" type="number" name="max_weight" id="max_weight" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group data-toggle" data-toggle="buttons">
                                        <label id="weather_protection" class="btn btn-default">
                                            <input type="checkbox" autocomplete="off" name="weather_protection"> Weather protection
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group data-toggle" data-toggle="buttons">
                                        <label id="food_accepted" class="btn btn-default">
                                            <input type="checkbox" autocomplete="off" name="food_accepted"> Accepted for food
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group data-toggle" data-toggle="buttons">
                                        <label id="crane" class="btn btn-default">
                                            <input type="checkbox" autocomplete="off" name="crane"> Crane
                                        </label>

                                        <label id="rear_lift" class="btn btn-default">
                                            <input type="checkbox" autocomplete="off" name="rear_lift"> Rear lift
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group data-toggle" data-toggle="buttons">
                                        <label id="temp_control" class="btn btn-default" onclick="toggleVehicleTempControl()">
                                            <input type="checkbox" autocomplete="off" name="temp_control"> Temperature control
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="vehicle-temperature-values">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="temp_min" id="temp_min" placeholder="Min °C" step="0.01">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="temp_max" id="temp_max" placeholder="Max °C" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <button class="btn btn-primary pull-right" type="submit">Create</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>