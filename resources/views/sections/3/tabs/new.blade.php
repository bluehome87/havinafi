<div class="row">
    <div class="col-lg-12">
        <form role="form" method="POST" action="{{ url('/new-transjob') }}">
            <fieldset>
                {!! csrf_field() !!}
                <input type="hidden" name="is_own_vehicles" value="0">
                <input type="hidden" name="is_own_tasks" value="0">
                <input type="hidden" name="is_other_tasks" value="0">

                <div class="step step-zero">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input class="form-control input-sm" type="text" name="transjob_name" id="transjob_name" placeholder="Transjob name">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <input class="form-control input-sm" type="date" placeholder="2016.01.01" name="transjob_date" id="transjob_date">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step step-one">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li role="presentation">
                            <a href="#own-vehicles-block" id="own-vehicles-block-button" aria-controls="own-vehicles" role="tab" data-toggle="tab">Use Own Vehicles</a>
                        </li>

                        <li role="presentation">
                            <a href="#find-vehicles-block" id="find-vehicles-block-button"aria-controls="find-vehicles" role="tab" data-toggle="tab">Find Vehicles</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="own-vehicles-block">
                            @include('sections.3.my-vehicles')
                        </div>

                        <div role="tabpanel" class="tab-pane" id="find-vehicles-block">
                            <p>We will find suitable vehicles for you!</p>
                        </div>
                    </div>
                </div>

                <div class="step step-two">
                    <div class="row" id="own-tasks">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                <label class="btn btn-pill" data-toggle="collapse" data-target="#own-tasks-block" aria-expanded="false" aria-controls="own-tasks-block">
                                    <input type="checkbox" autocomplete="off" checked> Do Own Tasks
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="collapse" id="own-tasks-block">
                                @include('sections.3.my-tasks')
                            </div>
                        </div>
                    </div>

                    <div class="row" id="find-tasks">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                <label class="btn btn-pill" data-toggle="collapse" data-target="#other-tasks-block" aria-expanded="false" aria-controls="other-tasks-block">
                                    <input type="checkbox" autocomplete="off" checked> Find Tasks
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="collapse" id="other-tasks-block">
                                <p>We will select them for you!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <button class="btn btn-danger pull-left" onclick="restoreNewJobTab()" id="job-restore-button">Cancel</button>
        <button class="btn btn-primary pull-right" onclick="sendOptimizationRequest()" id="job-create-button">Optimize</button>
        <button class="btn btn-primary pull-right" onclick="updateOptimizationRequest()" id="job-edit-button">Update</button>
    </div>
</div>