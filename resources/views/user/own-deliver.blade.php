<div id="own_delivery_form" class="transport_form">
    <form role="form" method="POST" action="{{ url('/optimize-problem') }}">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <input class="form-control" type="text" name="transjob_name" placeholder="Name">
                </div>
            </div>
        </div>
        <div class="my_vehicle_block">
            <div class="panel-heading">
                <h4 class="panel-title">CHOOSE VEHICLE(S)
                    <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                </h4>
            </div>
            <div role="tabpanel" class="tab-pane">
                @if(count($my_vehicles) > 0)
                    @foreach($my_vehicles as $my_vehicle)
                        <div class="input-group">
                            <span class="form-control" aria-label="own-vehicles{{$my_vehicle->id}}">
                                @if( $my_vehicle->type == 1 )
                                    <i class="fa fa-bicycle"></i>
                                @elseif( $my_vehicle->type == 2 )
                                    <i class="fa fa-car"></i>
                                @elseif( $my_vehicle->type == 3 )
                                    <i class="fa fa-motorcycle"></i>
                                @elseif( $my_vehicle->type == 4 )
                                    <i class="fa fa-truck"></i>
                                @elseif( $my_vehicle->type == 5 )
                                    <i class="fa fa-truck"></i>
                                @endif
                                <input type="checkbox" class="vehicle_id" data-vehicle-id="{{$my_vehicle->id}}">
                                <span class="record_name">
                                    {{$my_vehicle->name}}
                                </span>
                                <button class="btn-link pull-right" onclick="showVehiclePopup({{$my_vehicle->id}})" type="button">
                                    <i class="fa fa-exclamation-circle"></i>
                                </button>
                            </span>
                        </div>
                    @endforeach

                    <p class="nothing" style="display: none;">You don't have any vehicles.</p>
                @else
                    <p class="nothing">You don't have any vehicles.</p>
                @endif
                    <div class="input-group">
                        <span class="form-control">
                            <a class="add_new_link" href="#" onclick="showCreateVehicleForm()"><i class="fa fa-plus"></i> ADD NEW VEHICLE</a>
                        </span>
                    </div>
            </div>
        </div>
        <div class="my_task_block">
            <div class="panel-heading">
                <h4 class="panel-title">CHOOSE DELIVERY TASK(S)
                    <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                </h4>
            </div>
            <div role="tabpanel" class="tab-pane">
                @if(count($my_tasks) > 0)
                    @foreach($my_tasks as $my_task)
                        <div class="input-group">
                            <span class="form-control" aria-label="own-tasks{{$my_task->id}}">
                                @if( $my_task->passenger_delivery == 1 )
                                    <i class="fa fa-wheelchair"></i>
                                @else
                                    <i class="fa fa-dropbox"></i>
                                @endif
                                <input type="checkbox" aria-label="own-tasks{{$my_task->id}}" name="my_tasks[{{$my_task->id}}]">
                                <span class="record_name">
                                    {{$my_task->name}}
                                </span>
                                <button class="btn-link pull-right" onclick="showTaskPopup({{$my_task->id}})" type="button">
                                    <i class="fa fa-exclamation-circle"></i>
                                </button>
                            </span>
                        </div>
                    @endforeach

                    <p class="nothing" style="display: none;">You don't have any tasks.</p>
                @else
                    <p class="nothing">You don't have any tasks.</p>
                @endif
                    <div class="input-group">
                        <span class="form-control">
                            <a class="add_new_link" href="#" onclick="showCreateTaskForm()"><i class="fa fa-plus"></i> ADD NEW TASK</a>
                        </span>
                    </div>
                <div class="panel-heading">
                    <h4 class="panel-title find_tasks"><i class="fa fa-search"></i> FIND TASKS FROM OTHER USERS
                        <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="panel-default datepicker">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <span>CHOOSE DATE</span>
                    <a class="pull-right" data-toggle="tooltip" title="Tooltip"><i class="fa fa-question-circle"></i></a>
                </h4>
            </div>

            <div id="find_job_accordion" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="job-date-heading">
                <input class="job_datepicker" type="hidden" name="find_job_date">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-xs-offset-3 new-job">
                <button type="button" class="btn btn-primary btn-block center-block find_route">FIND ROUTE</button>
            </div>
        </div>
    </form>
</div>