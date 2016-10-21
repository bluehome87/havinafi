<div class="row">
    <div class="col-lg-12">
        <div class="my-jobs">
            @if(count($my_jobs) > 1000)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button class="btn btn-info disabled" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                            <input type="text" class="form-control" id="filter-my-jobs" placeholder="Filter jobs">
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <ul class="jobs-list">
                    @foreach($my_jobs as $my_job)
                        <li>
                            <div class="col-lg-7" data-toggle="buttons">
                                <label class="btn btn-info btn-xs">
                                    <input type="checkbox" name="my_jobs[{{$my_job->id}}]" autocomplete="off"> {{$my_job->name}}
                                </label>
                            </div>

                            <div class="col-lg-5">
                                <div class="actions">
                                    <i class="fa fa-car text-info" onclick="viewJobDrivingList({{$my_job->id}})"></i>
                                    <i class="fa fa-list text-info" onclick="viewJobDetails({{$my_job->id}})"></i>
                                    <i class="fa fa-pencil-square-o text-primary" onclick="showEditJobBlock({{$my_job->id}})"></i>
                                    <i class="fa fa-trash-o text-danger" onclick="deleteJob({{$my_job->id}})"></i>
                                    <i class="fa fa-clone text-success" onclick="cloneJob({{$my_job->id}})"></i>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="col-lg-12">
                    @if(count($my_jobs) < 1)
                        <p class="nothing">You don't have any active jobs.</p>
                    @else
                        <p class="nothing" style="display: none;">You don't have any active jobs.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>