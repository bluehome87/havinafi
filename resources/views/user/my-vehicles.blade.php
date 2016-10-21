<div class="row">
    <div class="col-xs-3 new-vehicle">
        <button type="button" class="btn btn-primary center-block" onclick="showCreateVehicleForm()">New</button>
    </div>

    <div class="col-xs-6 vehicle-selector">
        @if(count($my_vehicles) > 0)
            <select class="selectpicker form-control" data-style="btn-primary" data-live-search="true" data-width="100%" title="Choose a vehicle">
                @foreach($my_vehicles as $my_vehicle)
                    <option name="my_vehicles[{{$my_vehicle->id}}]" value="{{$my_vehicle->id}}">{{$my_vehicle->name}}</option>
                @endforeach
            </select>

            <p class="nothing" style="display: none;">You don't have any vehicles.</p>
        @else
            <p class="nothing">You don't have any vehicles.</p>
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
                <a href="#vehicle-quick-mode" aria-controls="vehicle-quick-mode" role="tab" data-toggle="tab">
                    Quick Mode
                </a>
            </li>

            <li role="presentation" class="active">
                <a href="#vehicle-detailed-mode" aria-controls="vehicle-detailed-mode" role="tab" data-toggle="tab">
                    Detailed Mode
                </a>
            </li>
        </ul>

        <form role="form" method="POST" action="{{ url('/create-vehicle') }}">
            <fieldset>
                {!! csrf_field() !!}
                <input type="hidden" name="purpose" id="vehiclePurpose">

                @if (count($errors) > 0 && Request::is('vehicle'))
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
                    <div role="tabpanel" class="tab-pane" id="vehicle-quick-mode">
                        @include('user.vehicle-quick')
                    </div>

                    <div role="tabpanel" class="tab-pane active" id="vehicle-detailed-mode">
                        @include('user.vehicle-detailed')
                    </div>
                </div>

                <div class="row buttons">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <button id="vehicle-cancel" class="btn btn-danger pull-left" type="button">Cancel</button>
                            <button class="btn btn-primary pull-right" type="submit">Create</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>