<div id="vehicle-modal" class="vehicle-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="vehicle-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    <div class="panel-heading no-padding">
                        <h4 class="panel-title">
                            <select class="selectpicker col-xs-2 no-padding">
                              <option value=1>&#xf206</option>
                              <option value=2>&#xf1b9</option>
                              <option value=3>&#xf21c</option>
                              <option value=4>&#xf0d1</option>
                              <option value=5 class="big_truck">&#xf0d1</option>
                            </select>
                            <div class="form-group col-xs-6">
                                <input class="form-control" type="text" name="name" placeholder="VEH NAME">
                            </div>
                            <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                        </h4>
                    </div>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row no-padding address_row">
                    <div class="col-xs-6">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Street Address"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="City"/>
                            </div>
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <div class="col-xs-6">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Street Address"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="City"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <ul class="nav nav-tabs col-xs-12 no-padding" role="tablist" id="vehicle-tab-menu">
                        <li role="presentation" class="active">
                            <a href="#cargo-tab" aria-controls="my-vehicles" role="tab" data-toggle="tab">
                                <i class="fa fa-cubes"></i>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#passenger-tab" aria-controls="my-tasks" role="tab" data-toggle="tab">
                                <i class="fa fa-male"></i>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#other-spec" aria-controls="transports" role="tab" data-toggle="tab">
                                <i class="fa fa-clock-o"></i>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#description-tab" aria-controls="transports" role="tab" data-toggle="tab">
                                <i class="fa fa-file-text-o"></i>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#driving-cost" aria-controls="transports" role="tab" data-toggle="tab">
                                <i class="fa fa-euro"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane transports active" id="cargo-tab">
                            <div class="col-xs-12 no-padding">
                                <div class="panel-heading">
                                    <h4 class="panel-title">CargoSpace Details
                                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                                    </h4>
                                </div>
                                <div class="tabpanel col-xs-12">
                                    <div class="panel-body col-xs-12">
                                        <div class="row" id="cargo-size">
                                            <div class="col-xs-2">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="trunk_length" id="trunk_length" placeholder="L" step="0.3" min="0">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">x</span>
                                            <div class="col-xs-2">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="trunk_width" id="trunk_width" placeholder="W" step="0.3" min="0">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">x</span>
                                            <div class="col-xs-2">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="trunk_height" id="trunk_height" placeholder="H" step="0.3" min="0">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">m</span>
                                            <div class="col-xs-2 col-xs-offset-1 responsive_input">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="trunk_volume" id="trunk_volume" placeholder="" step="0.3" min="0">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">&#13221;</span>
                                            <div class="col-xs-2">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="max_weight" id="max_weight" placeholder="300">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">kg</span>
                                        </div>

                                        <!-- <div class="row" id="cargo-weight">
                                            <div class="col-xs-5">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="max_weight" id="max_weight" placeholder="300">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">kg</span>
                                        </div> -->

                                        <div class="row cargo-items">
                                            <div class="overflow"></div>

                                            <div class="col-xs-1">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label id="weather_protection" class="btn btn-link">
                                                        <i class="fa fa-umbrella" aria-hidden="true"></i>
                                                        <input type="checkbox" autocomplete="off" name="weather_protection">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-1">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label id="crane" class="btn btn-link">
                                                        <span class="icon crane"></span>
                                                        <input type="checkbox" autocomplete="off" name="crane">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-1">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label id="rear_lift" class="btn btn-link">
                                                        <span class="icon lift"></span>
                                                        <input type="checkbox" autocomplete="off" name="rear_lift">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-1" style="margin-right:1px;">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label class="btn btn-link food_accepted" onclick="toggleVehicleTempIcon( this )">
                                                        <span class="icon food"></span>
                                                        <input type="checkbox" autocomplete="off" name="food_accepted">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-1 vehicle-temperature-icon">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label class="btn btn-link temp_control" onclick="toggleVehicleTempControl( this )">
                                                        <i class="icon temperature"></i>
                                                        <input type="checkbox" autocomplete="off" name="temp_control">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-2 col-xs-offset-1 vehicle-temperature-values responsive_input">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="temp_min" id="temp_min" placeholder="Min">
                                                    <span class="select-show" name="select-temp-min"></span>
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label vehicle-temperature-values">&#151</span>
                                            <div class="col-xs-2 vehicle-temperature-values">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="temp_max" id="temp_max" placeholder="Max">
                                                    <span class="select-show" name="select-temp-max"></span>
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label vehicle-temperature-values">°C</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane transports" id="passenger-tab">
                            <div class="col-xs-12 no-padding">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Passenger Details
                                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                                    </h4>
                                </div>
                                <div class="tabpanel col-xs-10 col-xs-offset-1">
                                    <div class="panel-body col-xs-12">
                                        <div class="col-xs-1 no-padding col-xs-offset-1">
                                            <span class="cost-label cargo-label">Max</span>
                                        </div>
                                        <div class="col-xs-7">
                                            <input class="form-control" type="number" name="max_passengers" id="max_passengers" placeholder="3" min="0">
                                        </div>
                                        <div class="col-xs-3 no-padding">
                                            <span class="cost-label cargo-label">Passengers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane transports" id="other-spec">
                            <div class="col-xs-12 no-padding">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Time details
                                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                                    </h4>
                                </div>
                                <div class="tabpanel col-xs-12">
                                    <div class="panel-body col-xs-12">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label class="col-xs-12">Vehicle Starts</label>
                                                <div class="col-xs-4 no-padding col-xs-offset-1">
                                                    <span class="cost-label cargo-label">At earliest</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <input class="form-control" type="text" name="from_time" placeholder="08:00" step="60" min="0">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label class="col-xs-12">Vehicle Ends</label>
                                                <div class="col-xs-3 no-padding col-xs-offset-1">
                                                    <span class="cost-label cargo-label">At latest</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <input class="form-control" type="text" name="to_time" placeholder="21:00" step="60" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row next-row">
                                            <div class="col-xs-12">
                                                <div class="col-xs-4 no-padding col-xs-offset-1">
                                                    <span class="cost-label cargo-label">Max Vehicle Speed</span>
                                                </div>
                                                <div class="col-xs-5">
                                                    <input class="form-control" type="text" name="select-max-speed" id="select-max-speed" step="10" min="0" value="80">
                                                </div>
                                                <div class="col-xs-1 no-padding">
                                                    <span class="cost-label cargo-label">km/h</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane transports" id="description-tab">
                            <div class="col-xs-12 no-padding">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Vehicle Description
                                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                                    </h4>
                                </div>
                                <div class="tabpanel col-xs-12">
                                    <div class="panel-body col-xs-10 col-xs-offset-1">
                                        <div class="col-xs-12">
                                            <textarea class="form-control" rows="4" name="vehicle_desc" id="vehicle_desc" placeholder="Vehicle Description for other users"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane transports" id="driving-cost">
                            <div class="col-xs-12 no-padding">
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Driving Costs
                                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                                    </h4>
                                </div>
                                <div class="tabpanel col-xs-12">
                                    <div class="panel-body col-xs-12">
                                        <div class="col-xs-4">
                                            <input class="form-control" type="number" name="cost_eur_km" id="cost_eur_km" placeholder="10" step="0.1" min="0">
                                        </div>
                                        <div class="col-xs-2">
                                            <span class="cost-label">€/km</span>
                                        </div>  

                                        <div class="col-xs-4">
                                            <input class="form-control" type="number" name="cost_eur_h" id="cost_eur_h" placeholder="10" step="0.1" min="0">
                                        </div>
                                        <div class="col-xs-2">
                                            <span class="cost-label">€/h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row action_row">
                    <div class="col-xs-4 col-xs-offset-2">
                        <button type="button" class="btn btn-primary btn-block center-block find_route">SAVE</button>
                    </div>
                    <div class="col-xs-4">
                        <button type="button" class="btn btn-primary btn-block center-block find_route" onclick="closeVehicleModal()">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>