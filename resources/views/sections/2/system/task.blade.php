<div id="task-block" class="col-lg-12 block">
    <h1>Create Task</h1>
    <br>

    <form role="form" method="POST" action="{{ url('/create-task') }}">
        <fieldset>
            {!! csrf_field() !!}
            <input type="hidden" name="total_packages" id="total_packages" value="1">
            <input type="hidden" name="type" id="taskType">

            @if (count($errors) > 0 && Request::is('task'))
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

            <div class="panel-group" id="task-accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="task-general-heading">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#task-accordion" href="#task-general" aria-expanded="true" aria-controls="task-general">
                                Task Type
                            </a>
                        </h4>
                    </div>

                    <div id="task-general" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="task-general-heading">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" type="name" name="name" placeholder="Task name">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="loading_time" placeholder="Duration (min)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" id="carry-form" data-toggle="buttons">
                                        <label id="task_passenger_delivery_control" class="btn btn-default" value="passenger_delivery" name="passenger_delivery" onclick="toggleTaskTypeControl()">
                                            <input type="radio" autocomplete="off"> Passengers
                                        </label>

                                        <label id="task_package_delivery_control" class="btn btn-default" value="package_delivery" name="package_delivery" onclick="toggleTaskTypeControl()">
                                            <input type="radio" autocomplete="off"> Cargo
                                        </label>

                                        <label id="task_one_stop_control" class="btn btn-default" value="one_stop_task" name="one_stop_task" onclick="toggleTaskTypeControl()">
                                            <input type="radio" autocomplete="off"> One-stop
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
                    <div class="panel-heading" role="tab" id="task-from-to-heading">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#task-accordion" href="#task-from-to" aria-expanded="false" aria-controls="task-from-to">
                                Address  Time
                            </a>
                        </h4>
                    </div>

                    <div id="task-from-to" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-from-to-heading">
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
                                </div>

                                <div class="col-lg-6" id="lg-to-address">
                                    <div class="form-group">
                                        <label class="control-label" for="to_address">To</label>

                                        <input class="form-control" type="text" name="to_address" id="to_address" placeholder="Address">
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="to_city" placeholder="City">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="from_time_start" id="from_time_start" placeholder="08:00" step="60">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="from_time_end" id="from_time_end" placeholder="09:00" step="60">
                                    </div>
                                </div>

                                <div class="col-lg-3" id="lg-to-time-start">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="to_time_start" id="to_time_start" placeholder="20:00" step="60">
                                    </div>
                                </div>

                                <div class="col-lg-3" id="lg-to-time-end">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="to_time_end" id="to_time_end" placeholder="21:00" step="60">
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
                                Passengers
                            </a>
                        </h4>
                    </div>

                    <div id="task-passengers" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-passengers-heading">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <label class="control-label" for="passengers">№ of passengers</label>

                                        <input class="form-control" type="number" name="passengers" id="passengers" placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="task-cargo-heading">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#task-accordion" href="#task-cargo" aria-expanded="false" aria-controls="task-cargo">
                                Cargo
                            </a>
                        </h4>
                    </div>

                    <div id="task-cargo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-cargo-heading">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="weight">Total weight (kg)</label>

                                        <input class="form-control" type="number" name="weight" id="weight" placeholder="0">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="total_volume">Total volume (m&#179;)</label>

                                        <input class="form-control" type="number" name="total_volume" id="total_volume" placeholder="0" step="0.01">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group data-toggle" data-toggle="buttons">
                                        <label id="temp_control" class="btn btn-default" onclick="toggleTaskTempControl()">
                                            <input type="checkbox" autocomplete="off" name="temp_control"> Temperature control
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group data-toggle" data-toggle="buttons">
                                        <label id="weather_protection" class="btn btn-default">
                                            <input type="checkbox" autocomplete="off" name="weather_protection"> Weather protection
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group data-toggle" data-toggle="buttons">
                                        <label id="fragile" class="btn btn-default">
                                            <input type="checkbox" autocomplete="off" name="fragile"> Fragile
                                        </label>

                                        <label id="food" class="btn btn-default">
                                            <input type="checkbox" autocomplete="off" name="food"> Food
                                        </label>
                                    </div>
                                </div>

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
                            </div>

                            <div class="row">


                                <div class="col-lg-6" id="task-temperature-values">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input class="form-control" type="number" name="temp_min" id="temp_min" placeholder="Min" step="0.01">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input class="form-control" type="number" name="temp_max" id="temp_max" placeholder="Max" step="0.01">
                                            </div>
                                        </div>
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