<div class="row">
    <div class="col-xs-3 new-task">
        <button type="button" class="btn btn-primary center-block" onclick="showCreateTaskForm()">New</button>
    </div>

    <div class="col-xs-6 task-selector">
        @if(count($my_tasks) > 0)
            <select class="selectpicker form-control" data-style="btn-primary" data-live-search="true" data-width="100%" title="Choose a task">
                @foreach($my_tasks as $my_task)
                    <option name="my_tasks[{{$my_task->id}}]" value="{{$my_task->id}}">{{$my_task->name}}</option>
                @endforeach
            </select>

            <p class="nothing" style="display: none;">You don't have any tasks.</p>
        @else
            <p class="nothing">You don't have any tasks.</p>
        @endif
    </div>

    <div class="col-xs-3">
        <div class="actions pull-right">
            <i class="fa fa-clone text-success" onclick="return true;"></i>
            <i class="fa fa-pencil-square-o text-primary" onclick="return true;"></i>
            <i class="fa fa-trash-o text-danger" onclick="return true;"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation">
                <a href="#task-quick-mode" aria-controls="task-quick-mode" role="tab" data-toggle="tab">
                    Quick Mode
                </a>
            </li>

            <li role="presentation" class="active">
                <a href="#task-detailed-mode" aria-controls="task-detailed-mode" role="tab" data-toggle="tab">
                    Detailed Mode
                </a>
            </li>
        </ul>

        <form role="form" method="POST" action="{{ url('/create-task') }}">
            <fieldset>
                {!! csrf_field() !!}
                <input type="hidden" name="type" id="taskPurpose">

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

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="task-quick-mode">
                        @include('user.task-quick')
                    </div>

                    <div role="tabpanel" class="tab-pane active" id="task-detailed-mode">
                        @include('user.task-detailed')
                    </div>
                </div>

                <div class="row buttons">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <button id="task-cancel" class="btn btn-danger pull-left" type="button">Cancel</button>
                            <button class="btn btn-primary pull-right" type="submit">Create</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>