<div class="my-vehicles">
    @if(count($my_vehicles) > 10)
        <div class="row">
            <div class="col-lg-12">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button class="btn btn-info disabled" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                    <input type="text" class="form-control" id="filter-my-vehicles" placeholder="Filter vehicles">
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <ul class="vehicles-list">
            @foreach($my_vehicles as $my_vehicle)
                <li>
                    <div class="col-lg-8" data-toggle="buttons">
                        <label class="btn btn-info btn-xs">
                            <input type="checkbox" name="my_vehicles[{{$my_vehicle->id}}]" autocomplete="off"> {{$my_vehicle->name}}
                        </label>
                    </div>

                    <div class="col-lg-4">
                        <div class="actions">
                            <i class="fa fa-eye text-info" onclick="viewVehicle({{$my_vehicle->id}})"></i>
                            <i class="fa fa-pencil-square-o text-primary" onclick="showEditVehicleBlock({{$my_vehicle->id}})"></i>
                            <i class="fa fa-trash-o text-danger" onclick="deleteVehicle({{$my_vehicle->id}})"></i>
                            <i class="fa fa-clone text-success" onclick="cloneVehicle({{$my_vehicle->id}})"></i>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        @if(count($my_vehicles) < 1)
            <p class="nothing">You don't have any vehicles.</p>
        @else
            <p class="nothing" style="display: none;">You don't have any vehicles.</p>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-success btn-sm" onclick="showCreateVehicleBlock()">Create Vehicle</button>
        </div>
    </div>
</div>