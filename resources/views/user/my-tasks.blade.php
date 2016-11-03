<div id="task-modal" class="task-modal popup-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="task-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <div class="panel-heading no-padding">
                        <h4 class="panel-title">
                            <select class="selectpicker col-xs-2 no-padding">
                              <option value=1>&#xf1b3 &#xf183</option>
                              <option value=2>&#xf183</option>
                              <option value=3>&#xf1b3</option>
                            </select>
                            <div class="form-group col-xs-6 col-xs-offset-1">
                                <input class="form-control" type="text" name="name" placeholder="TASK NAME">
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
                    <ul class="nav nav-tabs col-xs-12 no-padding" role="tablist">
                        <li role="presentation" class="active" id="t_cargo-menu">
                            <a href="#t_cargo-tab" aria-controls="my-tasks" role="tab" data-toggle="tab">
                                <i class="fa fa-cubes"></i>
                            </a>
                        </li>
                        <li role="presentation" id="t_passenger-menu">
                            <a href="#t_passenger-tab" aria-controls="my-tasks" role="tab" data-toggle="tab">
                                <i class="fa fa-male"></i>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#t_other-spec" aria-controls="transports" role="tab" data-toggle="tab">
                                <i class="fa fa-clock-o"></i>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#t_description-tab" aria-controls="transports" role="tab" data-toggle="tab">
                                <i class="fa fa-file-text-o"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane transports active cargo-tab" id="t_cargo-tab">
                            <div class="col-xs-12 no-padding">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Cargo Details
                                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                                    </h4>
                                </div>
                                <div class="tabpanel col-xs-12">
                                    <div class="panel-body col-xs-12">
                                        <div class="row cargo-size">
                                            <div class="col-xs-2 row-4-elem">
                                                <div class="form-group">
                                                    <input class="form-control trunk_length" type="number" name="trunk_length" placeholder="L" step="0.3" min="0">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">x</span>
                                            <div class="col-xs-2 row-4-elem">
                                                <div class="form-group">
                                                    <input class="form-control trunk_width" type="number" name="trunk_width" placeholder="W" step="0.3" min="0">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">x</span>
                                            <div class="col-xs-2 row-4-elem">
                                                <div class="form-group">
                                                    <input class="form-control trunk_height" type="number" name="trunk_height" placeholder="H" step="0.3" min="0">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">m</span>
                                            <div class="col-xs-2 row-4-elem">
                                                <div class="form-group">
                                                    <input class="form-control trunk_volume" type="number" name="trunk_volume" placeholder="" step="0.3" min="0">
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label">&#13221;</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="col-xs-6 no-padding">
                                                    <span class="cost-label cargo-label" style="margin-left:0; padding-left:0;">Number of Packages</span>
                                                    <div class="form-group col-xs-2" style="width:78px;">
                                                        <input class="form-control" type="number" name="package_num" placeholder="5">
                                                    </div>
                                                </div>
                                                <div  class="col-xs-6">
                                                    <span class="cost-label cargo-label">Total weight</span>
                                                    <div class="form-group col-xs-2" style="width:78px;">
                                                        <input class="form-control" type="number" name="max_weight" placeholder="300">                                                    
                                                    </div>
                                                    <span class="cost-label cargo-label">kg</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row cargo-items">
                                            <div class="col-xs-1">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label class="btn btn-link weather_protection">
                                                        <i class="fa fa-umbrella" aria-hidden="true"></i>
                                                        <input type="checkbox" autocomplete="off" name="weather_protection">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xs-1">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label class="btn btn-link weather_protection">
                                                        <i class="fa fa-glass" aria-hidden="true"></i>
                                                        <input type="checkbox" autocomplete="off" name="weather_protection">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xs-1">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label class="btn btn-link crane">
                                                        <span class="icon crane"></span>
                                                        <input type="checkbox" autocomplete="off" name="crane">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-1">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label class="btn btn-link rear_lift">
                                                        <span class="icon lift"></span>
                                                        <input type="checkbox" autocomplete="off" name="rear_lift">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-1" style="margin-right:1px;">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label class="btn btn-link food_accepted" onclick="toggleTempIcon( this )">
                                                        <span class="icon food"></span>
                                                        <input type="checkbox" autocomplete="off" name="food_accepted">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-1 vehicle-temperature-icon">
                                                <div class="form-group data-toggle" data-toggle="buttons">
                                                    <label class="btn btn-link temp_control" onclick="toggleTempControl( this )">
                                                        <i class="icon temperature"></i>
                                                        <input type="checkbox" autocomplete="off" name="temp_control">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-2 vehicle-temperature-values responsive_input">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="temp_min" placeholder="Min">
                                                    <span class="select-show" name="select-temp-min"></span>
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label vehicle-temperature-values">&#151</span>
                                            <div class="col-xs-2 vehicle-temperature-values">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="temp_max" placeholder="Max">
                                                    <span class="select-show" name="select-temp-max"></span>
                                                </div>
                                            </div>
                                            <span class="cost-label cargo-label vehicle-temperature-values">°C</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane transports" id="t_passenger-tab">
                            <div class="col-xs-12 no-padding">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Passenger Details
                                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                                    </h4>
                                </div>
                                <div class="tabpanel col-xs-12">
                                    <div class="panel-body passenger_content">
                                        <div class="col-xs-3 no-padding ">
                                            <span class="cost-label cargo-label pull-right">Max</span>
                                        </div>
                                        <div class="col-xs-2 input-small-field">
                                            <input class="form-control" type="number" name="max_passengers" placeholder="3" min="0">
                                        </div>
                                        <div class="col-xs-4 no-padding">
                                            <span class="cost-label cargo-label">Passengers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane transports" id="t_other-spec">
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
                                                <h5 class="col-xs-12">Pickup between</h5>
                                                <div class="col-xs-12 input-time-field">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="from_time_start" placeholder="07:00">
                                                    </div>
                                                </div>
                                                <span class="cost-label cargo-label">&#151</span>
                                                <div class="col-xs-12 input-time-field responsive_right">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="from_time_end" placeholder="21:00">
                                                    </div>
                                                </div>
                                                <h5 class="col-xs-12">Loading Time</h5>
                                                <div class="col-xs-12 input-small-field">
                                                    <input class="form-control" type="number" name="loading_time" placeholder="2" min="0">
                                                </div>
                                                <span class="cost-label cargo-label">mins</span>
                                            </div>
                                            <div class="col-xs-6">
                                                <h5 class="col-xs-12">Delivery between</h5>
                                                <div class="col-xs-12 input-time-field">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="to_time_start" placeholder="07:00">
                                                    </div>
                                                </div>
                                                <span class="cost-label cargo-label">&#151</span>
                                                <div class="col-xs-12 input-time-field responsive_right">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="to_time_end" placeholder="21:00">
                                                    </div>
                                                </div>
                                                <h5 class="col-xs-12">Unloading Time</h5>
                                                <div class="col-xs-12 input-small-field">
                                                    <input class="form-control" type="number" name="unloading_time" placeholder="2" min="0">
                                                </div>
                                                <span class="cost-label cargo-label">mins</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane transports" id="t_description-tab">
                            <div class="col-xs-12 no-padding">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Task Description
                                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                                    </h4>
                                </div>
                                <div class="tabpanel col-xs-12">
                                    <div class="panel-body col-xs-12">
                                        <textarea class="form-control" rows="4" name="task_desc" placeholder="Task Description for other users"></textarea>
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
                        <button type="button" class="btn btn-primary btn-block center-block find_route" onclick="closeTaskModal()">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>