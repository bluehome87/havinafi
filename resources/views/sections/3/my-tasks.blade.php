<div class="my-tasks">
    @if(count($my_vehicles) > 10)
        <div class="row">
            <div class="col-lg-12">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button class="btn btn-info disabled" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                    <input type="text" class="form-control" id="filter-my-tasks" placeholder="Filter tasks">
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <ul class="tasks-list">
            @foreach($my_tasks as $my_task)
                <li>
                    <div class="col-lg-8" data-toggle="buttons">
                        <label class="btn btn-info btn-xs">
                            <input type="checkbox" name="my_tasks[{{$my_task->id}}]" autocomplete="off"> {{$my_task->name}}
                        </label>
                    </div>

                    <div class="col-lg-4">
                        <div class="actions">
                            <i class="fa fa-eye text-info" onclick="viewTask({{$my_task->id}})"></i>
                            <i class="fa fa-pencil-square-o text-primary" onclick="showEditTaskBlock({{$my_task->id}})"></i>
                            <i class="fa fa-trash-o text-danger" onclick="deleteTask({{$my_task->id}})"></i>
                            <i class="fa fa-clone text-success" onclick="cloneTask({{$my_task->id}})"></i>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        @if(count($my_tasks) < 1)
            <p class="nothing">You don't have any tasks.</p>
        @else
            <p class="nothing" style="display: none;">You don't have any tasks.</p>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-success btn-sm" onclick="showCreateTaskBlock()">Create Task</button>
        </div>
    </div>
</div>