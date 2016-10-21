<div class="row">
    <div class="col-xs-8">
        <div class="form-group">
            <input class="form-control" type="text" name="quick_name" placeholder="Name or reg. nr.">
        </div>
    </div>

    <div class="col-xs-4">
        <div class="form-group">
            <select class="form-control" name="quick_max_speed" required>
                <option disabled="" selected="">Max speed</option>
                <option value="80">80km/h</option>
                <option value="90">90km/h</option>
                <option value="100">100km/h</option>
                <option value="110">110km/h</option>
                <option value="120">120km/h</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group data-toggle" id="quick-vehicle-carry-form" data-toggle="buttons">
            <label id="quick_vehicle_passenger_delivery_control" class="btn btn-link col-xs-6" value="passenger_delivery" onclick="toggleVehicleTypeQuickControl()">
                <i class="fa fa-users" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> For Passengers
            </label>

            <label id="quick_vehicle_package_delivery_control" class="btn btn-link col-xs-6" value="package_delivery" onclick="toggleVehicleTypeQuickControl()">
                <i class="fa fa-dropbox" aria-hidden="true"></i>
                <input type="radio" autocomplete="off"> For Cargo
            </label>
        </div>
    </div>

    <div class="col-xs-6">
        <div class="form-group">
            <input class="form-control" type="number" name="quick_max_passengers" id="quick_max_passengers" placeholder="3 seats">
        </div>
    </div>

    <div class="col-xs-6">
        <div class="form-group">
            <input class="form-control" type="number" name="quick_trunk_volume" id="quick_trunk_volume" placeholder="14.4&#13221;" step="0.1">
        </div>
    </div>
</div>

<div class="row quick-location">
    <div class="col-xs-5">
        <div class="form-group">
            <input class="form-control" type="text" name="quick_from_address" id="quick_from_address" placeholder="Address">
        </div>

        <div class="form-group">
            <input class="form-control" type="text" name="quick_from_city" placeholder="City">
        </div>
    </div>

    <span class="glyphicon glyphicon-chevron-right"></span>

    <div class="col-xs-5 col-xs-offset-2">
        <div class="form-group">
            <input class="form-control" type="text" name="quick_to_address" id="quick_to_address" placeholder="Address">
        </div>

        <div class="form-group">
            <input class="form-control" type="text" name="quick_to_city" placeholder="City">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-5 col-xs-offset-7">
        <div class="form-group">
            <button class="btn btn-primary btn-sm" type="button" onclick="setVehicleQuickEndAddress()">
                Same as start address
            </button>
        </div>
    </div>
</div>