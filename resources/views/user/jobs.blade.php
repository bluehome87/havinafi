<div class="row" id="job-new">
    <div class="col-xs-4 col-xs-offset-4 new-job">
        <button type="button" class="btn btn-primary btn-block center-block" onclick="showCreateJobForm()">New</button>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel-group" id="jobs-accordion" role="tablist" aria-multiselectable="false">
            @if(count($my_jobs) > 0)
                @foreach($my_jobs as $my_job)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="job-heading{{$my_job->id}}">
                            <h4 class="panel-title">
                                <a role="button" onclick="viewJobTime({{$my_job->id}},1)" data-toggle="collapse" data-parent="#jobs-accordion" href="#job-collapse{{$my_job->id}}" aria-expanded="false" aria-controls="job-collapse{{$my_job->id}}">
                                    <div class="job-date pull-left">{{$my_job->job_date}}</div>

                                    <div class="job-name">{{$my_job->name}}</div>

                                    <div class="job-actions pull-right">
                                        <i class="fa fa-clone text-success" onclick="cloneJob({{$my_job->id}})"></i>
                                        <i class="fa fa-pencil-square-o text-warning" onclick="showEditJobForm({{$my_job->id}})"></i>
                                        <i class="fa fa-trash-o text-danger" onclick="deleteJob({{$my_job->id}})"></i>
                                    </div>
                                </a>
                            </h4>
                        </div>
                        <div id="job-collapse{{$my_job->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="job-heading{{$my_job->id}}">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 job-details" id="job{{$my_job->id}}-details"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <p class="nothing" style="display: none;">You don't have any transports.</p>
            @else
                <p class="nothing">You don't have any transports.</p>
            @endif
        </div>
    </div>
</div>
<div id="transport_edit_block" class="transport_form active">
    <div class="row" id="job-edit">
        <div class="col-xs-12">
            <form role="form" method="POST" action="{{ url('/optimize-problem') }}">
                <fieldset>
                    {!! csrf_field() !!}
                    <input type="hidden" name="is_own_vehicles" value="0">
                    <input type="hidden" name="is_own_tasks" value="0">
                    <input type="hidden" name="is_other_tasks" value="0">

                    @if (count($errors) > 0 && Request::is('transport'))
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

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel-group" id="job-date-accordion" role="tablist" aria-multiselectable="false">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="job-date-heading">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#jobs-accordion" href="#job-date-collapse" aria-expanded="false" aria-controls="job-date-collapse">
                                                <div class="pull-left"><span class="glyphicon glyphicon-calendar"></span></div>

                                                <div class="job-chosen-date">Choose transport date</div>
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="job-date-collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="job-date-heading">
                                        <div class="panel-body">
                                            <input id="choose-job-date" type="text" name="transjob_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <input class="form-control" type="text" name="transjob_name" placeholder="Name">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="job-choose-vehicles">
                        <div class="col-xs-12">
                            <div class="row">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="col-xs-6">
                                        <a href="#job-own-vehicles" aria-controls="job-own-vehicles" role="tab" data-toggle="tab">
                                            <i class="fa fa-car" aria-hidden="true"></i> Use own vehicles

                                            <button class="btn-link" type="button" onclick="showCreateVehicleForm()">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                    </li>

                                    <li role="presentation" class="col-xs-6">
                                        <a href="#job-find-vehicles" aria-controls="job-find-vehicles" role="tab" data-toggle="tab">
                                            Find me vehicles
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="job-own-vehicles">
                                    @if(count($my_vehicles) > 0)
                                        @foreach($my_vehicles as $my_vehicle)
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="own-vehicles{{$my_vehicle->id}}" name="my_vehicles[{{$my_vehicle->id}}]">
                                                </span>

                                                <span class="form-control" aria-label="own-vehicles{{$my_vehicle->id}}">
                                                    {{$my_vehicle->name}}

                                                    <button class="btn-link pull-right" onclick="showVehiclePopup({{$my_vehicle->id}})" type="button">
                                                        <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        @endforeach

                                        <p class="nothing" style="display: none;">You don't have any vehicles.</p>
                                    @else
                                        <p class="nothing">You don't have any vehicles.</p>
                                    @endif
                                </div>

                                <div role="tabpanel" class="tab-pane" id="job-find-vehicles">
                                    <p>We will find suitable vehicles for you!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="job-choose-tasks">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab">
                                    <h4 class="panel-title">
                                        <div class="pull-left">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        </div>

                                        <input type="text" id="filter-choose-tasks" disabled="disabled" value="Choose tasks" placeholder="Start typing...">

                                        <button class="btn-link" type="button" id="search-toggle" onclick="toggleTasksFilter()">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                        </button>

                                        <button class="btn-link pull-right" type="button" onclick="showCreateTaskForm()">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </h4>
                                </div>

                                <div class="panel-body">
                                    <div class="input-group" id="input-find-tasks">
                                        <span class="input-group-addon label-success">
                                            <input type="checkbox" aria-label="input-find-tasks" name="input_find_tasks">
                                        </span>

                                        <span class="form-control label-success" aria-label="input-find-tasks">
                                            Find new tasks for my transport
                                        </span>
                                    </div>

                                    @if(count($my_tasks) > 0)
                                        @foreach($my_tasks as $my_task)
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="own-tasks{{$my_task->id}}" name="my_tasks[{{$my_task->id}}]">
                                                </span>

                                                <span class="form-control" aria-label="own-tasks{{$my_task->id}}">
                                                    {{$my_task->name}}

                                                    <button class="btn-link pull-right" onclick="showTaskPopup({{$my_task->id}})" type="button">
                                                        <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        @endforeach

                                        <p class="nothing" style="display: none;">You don't have any tasks.</p>
                                    @else
                                        <p class="nothing">You don't have any tasks.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row buttons">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-danger pull-left" type="button" onclick="restoreTransjobsTab()">Cancel</button>
                                <button class="btn btn-warning pull-left" type="button" onclick="clearTransjobsForm()">Clear</button>
                                <button class="btn btn-primary pull-right" type="button" onclick="sendOptimizationRequest()">Create</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>