<?php

namespace App\Http\Controllers;

use App\Offer;
use App\User;
use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'type' => 'required|exists:vehicle_types,id',
            'max_speed' => 'required|integer',
            'from_city' => 'required|max:255',
            'from_address' => 'required|max:255',
            'from_time' => 'required',
            'to_city' => 'required|max:255',
            'to_address' => 'required|max:255',
            'to_time' => 'required',
            'trunk_length' => 'numeric',
            'trunk_width' => 'numeric',
            'trunk_height' => 'numeric',
            'trunk_volume' => 'numeric',
            'max_weight' => 'integer',
            'cost_eur_task' => 'numeric|min:0',
            'cost_eur_km' => 'required|numeric|min:0',
            'cost_eur_h' => 'required|numeric|min:0',
            'notes' => 'max:1000'
        ]);
    }

    public function create(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $vehicle = new Vehicle($request->all());

        $coordinates_from = $this->getCoordinates($request->from_address, $request->from_city);
        if(!$coordinates_from) {
            $response = array(
                'status' => 'danger',
                'message' => 'Wrong start location, please check the address and city.',
            );

            return \Response::json($response);
        }
        $vehicle->from_lon = $coordinates_from['lon'];
        $vehicle->from_lat = $coordinates_from['lat'];
        $coordinates_to = $this->getCoordinates($request->to_address, $request->to_city);
        if(!$coordinates_to) {
            $response = array(
                'status' => 'danger',
                'message' => 'Wrong end location, please check the address and city.',
            );

            return \Response::json($response);
        }
        $vehicle->to_lon = $coordinates_to['lon'];
        $vehicle->to_lat = $coordinates_to['lat'];
        $vehicle->user_id = Auth::user()->id;
        $vehicle->trunk_volume = $request->trunk_volume;
        $vehicle->package_delivery = $request->package_delivery;
        $vehicle->passenger_delivery = $request->passenger_delivery;
        $vehicle->weather_protection = isset($request->weather_protection) ? 1 : 0;
        $vehicle->food_accepted = isset($request->food_accepted) ? 1 : 0;
        $vehicle->temp_control = isset($request->temp_control) ? 1 : 0;
        $vehicle->crane = isset($request->crane) ? 1 : 0;
        $vehicle->rear_lift = isset($request->rear_lift) ? 1 : 0;

        if($vehicle->save()) {
            $response = array(
                'status' => 'success',
                'message' => 'Vehicle '.$request->name.' successfully created.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t create vehicle, please check all fields and try again.',
            );
        }

        return \Response::json($response);
    }

    public function getInfo($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle_type = VehicleType::find($vehicle->type);
        $vehicle_owner = User::find($vehicle->user_id);
        if($vehicle_owner->id == Auth::user()->id) {
            $is_other_user = 0;
        }
        else {
            $is_other_user = 1;
        }

        if($vehicle) {
            $response = array(
                'status' => 'success',
                'data' => $vehicle,
                'vehicle_type' => $vehicle_type->name,
                'is_other_user' => $is_other_user,
                'owner_name' => $vehicle_owner->name,
                'owner_phone' => $vehicle_owner->phone
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Impossible to edit selected vehicle.',
            );
        }

        return \Response::json($response);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $vehicle = Vehicle::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if(!isset($vehicle)) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t create vehicle, please check all fields and try again.',
            );

            return \Response::json($response);
        }

        if(Offer::where('vehicle_id', $id)->where('status', 2)->count() > 0) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t update selected vehicle because you\'ve already agreed to use it in offer with other user.',
            );

            return \Response::json($response);
        }

        $vehicle->fill($request->all());

        $coordinates_from = $this->getCoordinates($request->from_address, $request->from_city);
        if(!$coordinates_from) {
            $response = array(
                'status' => 'danger',
                'message' => 'Wrong start location, please check the address and city.',
            );

            return \Response::json($response);
        }
        $vehicle->from_lon = $coordinates_from['lon'];
        $vehicle->from_lat = $coordinates_from['lat'];
        $coordinates_to = $this->getCoordinates($request->to_address, $request->to_city);
        if(!$coordinates_to) {
            $response = array(
                'status' => 'danger',
                'message' => 'Wrong end location, please check the address and city.',
            );

            return \Response::json($response);
        }
        $vehicle->to_lon = $coordinates_to['lon'];
        $vehicle->to_lat = $coordinates_to['lat'];
        $vehicle->package_delivery = $request->purpose == 'package_delivery' ? 1 : 0;
        $vehicle->passenger_delivery = $request->purpose == 'passenger_delivery' ? 1 : 0;
        $vehicle->trunk_volume = $request->trunk_length * $request->trunk_width * $request->trunk_height;
        $vehicle->weather_protection = isset($request->weather_protection) ? 1 : 0;
        $vehicle->food_accepted = isset($request->food_accepted) ? 1 : 0;
        $vehicle->temp_control = isset($request->temp_control) ? 1 : 0;
        $vehicle->crane = isset($request->crane) ? 1 : 0;
        $vehicle->rear_lift = isset($request->rear_lift) ? 1 : 0;

        if($vehicle->save()) {
            DB::raw(DB::delete("DELETE FROM `offers` WHERE `vehicle_id` = $id"));

            $response = array(
                'status' => 'success',
                'message' => 'Vehicle '.$request->name.' successfully updated.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t create vehicle, please check all fields and try again.',
            );
        }

        return \Response::json($response);
    }

    public function getList()
    {
        if (Auth::user()) {
            $my_vehicles = Vehicle::where('user_id', Auth::user()->id)->where('is_deleted', 0)->get();
        }

        if(isset($my_vehicles)) {
            $response = array(
                'status' => 'success',
                'data' => $my_vehicles,
            );
        }
        else {
            $response = array(
                'status' => 'danger'
            );
        }

        return \Response::json($response);
    }

    public function delete($id)
    {
        $vehicle = Vehicle::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if(Offer::where('vehicle_id', $id)->where('status', 2)->count() > 0) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t delete selected vehicle because you\'ve already agreed to use it in offer with other user.',
            );

            return \Response::json($response);
        }
        $name = $vehicle->name;
        $vehicle->is_deleted = 1;

        if($vehicle->update()) {
            DB::raw(DB::delete("DELETE FROM `offers` WHERE `vehicle_id` = $id"));

            $response = array(
                'status' => 'success',
                'message' => 'Vehicle '.$name.' successfully deleted.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t delete selected vehicle.',
            );
        }

        return \Response::json($response);
    }

    public function duplicate($id)
    {
        $vehicle = Vehicle::where('id', $id)->where('user_id', Auth::user()->id)->first();

        $new_vehicle = $vehicle->replicate();
        $new_vehicle->name = $new_vehicle->name.' (Copy)';

        if($new_vehicle->push()) {
            $response = array(
                'status' => 'success',
                'message' => 'Vehicle '.$vehicle->name.' successfully cloned.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t clone selected vehicle.',
            );
        }

        return \Response::json($response);
    }

    private function getCoordinates($address, $city)
    {
        $ch = curl_init('http://nominatim.openstreetmap.org/search?q='.urlencode($address).',+'.urlencode($city).'&format=json');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        $json = json_decode($result, true);
        if(empty($json)) {
            return false;
        }

        $lat = $json[0]['lat'];
        $lon = $json[0]['lon'];

        return array('lon' => $lon, 'lat' => $lat);
    }
}
