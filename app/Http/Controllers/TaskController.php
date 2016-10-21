<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Task;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'type' => 'required',
            'from_city' => 'required|max:255',
            'from_address' => 'required|max:255',
            'to_city' => 'required|max:255',
            'to_address' => 'required|max:255',
            'loading_time' => 'integer',
            'unload_time' => 'integer',
            'total_packages' => 'integer',
            'quick_total_volume' => 'numeric',
            'weight' => 'integer',
            'notes' => 'max:1000'
        ]);
    }

    protected function validatorOneStopTask(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'type' => 'required',
            'from_city' => 'required|max:255',
            'from_address' => 'required|max:255',
            'loading_time' => 'integer',
            'total_packages' => 'integer',
            'total_volume' => 'numeric',
            'weight' => 'integer',
            'notes' => 'max:1000'
        ]);
    }

    public function create(Request $request)
    {
        if($request->type == 'one_stop_task') {
            $validator = $this->validatorOneStopTask($request->all());

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
        }
        else {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
        }

        $task = new Task($request->all());

        $coordinates_from = $this->getCoordinates($request->from_address, $request->from_city);
        if(!$coordinates_from) {
            $response = array(
                'status' => 'danger',
                'message' => 'Wrong start location, please check the address and city.',
            );

            return \Response::json($response);
        }
        $task->from_lon = $coordinates_from['lon'];
        $task->from_lat = $coordinates_from['lat'];
        if($request->type == 'one_stop_task') {
            $task->to_city = $request->from_city;
            $task->to_address = $request->from_address;
            $coordinates_to = $this->getCoordinates($request->from_address, $request->from_city);
            if(!$coordinates_to) {
                $response = array(
                    'status' => 'danger',
                    'message' => 'Wrong location, please check the address and city.',
                );

                return \Response::json($response);
            }
        }
        else {
            $coordinates_to = $this->getCoordinates($request->to_address, $request->to_city);
            if(!$coordinates_to) {
                $response = array(
                    'status' => 'danger',
                    'message' => 'Wrong end location, please check the address and city.',
                );

                return \Response::json($response);
            }
        }
        if($request->quick_total_volume > 0) {
            $task->total_volume = $request->quick_total_volume;
        }
        else {
            $task->total_volume = $request->cargo_length * $request->cargo_width * $request->cargo_height;
        }
        $task->unload_time = $request->unload_time;
        $task->cargo_length = $request->cargo_length;
        $task->cargo_width = $request->cargo_width;
        $task->cargo_height = $request->cargo_height;
        $task->to_lon = $coordinates_to['lon'];
        $task->to_lat = $coordinates_to['lat'];
        $task->user_id = Auth::user()->id;
        $task->package_delivery = $request->type == 'package_delivery' ? 1 : 0;
        $task->passenger_delivery = $request->type == 'passenger_delivery' ? 1 : 0;
        $task->one_stop_task = $request->type == 'one_stop_task' ? 1 : 0;
        $task->fragile = isset($request->fragile) ? 1 : 0;
        $task->weather_protection = isset($request->weather_protection) ? 1 : 0;
        $task->food = isset($request->food) ? 1 : 0;
        $task->temp_control = isset($request->temp_control) ? 1 : 0;
        $task->crane = isset($request->crane) ? 1 : 0;
        $task->rear_lift = isset($request->rear_lift) ? 1 : 0;

        if($task->save()) {
            $response = array(
                'status' => 'success',
                'message' => 'Task '.$request->name.' successfully created.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t create task, please check all fields and try again.',
            );
        }

        return \Response::json($response);
    }

    public function getInfo($id)
    {
        $task = Task::find($id);
        $task_owner = User::find($task->user_id);
        if($task_owner->id == Auth::user()->id) {
            $is_other_user = 0;
        }
        else {
            $is_other_user = 1;
        }

        if($task) {
            $response = array(
                'status' => 'success',
                'data' => $task,
                'is_other_user' => $is_other_user,
                'owner_name' => $task_owner->name,
                'owner_phone' => $task_owner->phone
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Impossible to edit selected task.',
            );
        }

        return \Response::json($response);
    }

    public function update(Request $request, $id)
    {
        if($request->type == 'one_stop_task') {
            $validator = $this->validatorOneStopTask($request->all());

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
        }
        else {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
        }

        $task = Task::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if(!isset($task)) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t create task, please check all fields and try again.',
            );

            return \Response::json($response);
        }

        if(Offer::where('task_id', $id)->where('status', 2)->count() > 0) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t update selected task because you\'ve already agreed to use it in offer with other user.',
            );

            return \Response::json($response);
        }

        $task->fill($request->all());

        $coordinates_from = $this->getCoordinates($request->from_address, $request->from_city);
        if(!$coordinates_from) {
            $response = array(
                'status' => 'danger',
                'message' => 'Wrong start location, please check the address and city.',
            );

            return \Response::json($response);
        }
        $task->from_lon = $coordinates_from['lon'];
        $task->from_lat = $coordinates_from['lat'];
        if($request->type == 'one_stop_task') {
            $task->to_city = $request->from_city;
            $task->to_address = $request->from_address;
            $coordinates_to = $this->getCoordinates($request->from_address, $request->from_city);
            if(!$coordinates_to) {
                $response = array(
                    'status' => 'danger',
                    'message' => 'Wrong location, please check the address and city.',
                );

                return \Response::json($response);
            }
        }
        else {
            $coordinates_to = $this->getCoordinates($request->to_address, $request->to_city);
            if(!$coordinates_to) {
                $response = array(
                    'status' => 'danger',
                    'message' => 'Wrong end location, please check the address and city.',
                );

                return \Response::json($response);
            }
        }
        if($request->quick_total_volume > 0) {
            $task->total_volume = $request->quick_total_volume;
        }
        else {
            $task->total_volume = $request->cargo_length * $request->cargo_width * $request->cargo_height;
        }
        $task->unload_time = $request->unload_time;
        $task->cargo_length = $request->cargo_length;
        $task->cargo_width = $request->cargo_width;
        $task->cargo_height = $request->cargo_height;
        $task->to_lon = $coordinates_to['lon'];
        $task->to_lat = $coordinates_to['lat'];
        $task->package_delivery = $request->type == 'package_delivery' ? 1 : 0;
        $task->passenger_delivery = $request->type == 'passenger_delivery' ? 1 : 0;
        $task->one_stop_task = $request->type == 'one_stop_task' ? 1 : 0;
        $task->fragile = isset($request->fragile) ? 1 : 0;
        $task->weather_protection = isset($request->weather_protection) ? 1 : 0;
        $task->food = isset($request->food) ? 1 : 0;
        $task->temp_control = isset($request->temp_control) ? 1 : 0;
        $task->crane = isset($request->crane) ? 1 : 0;
        $task->rear_lift = isset($request->rear_lift) ? 1 : 0;

        if($task->save()) {
            DB::raw(DB::delete("DELETE FROM `offers` WHERE `task_id` = $id"));

            $response = array(
                'status' => 'success',
                'message' => 'Task '.$request->name.' successfully updated.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t create task, please check all fields and try again.',
            );
        }

        return \Response::json($response);
    }

    public function getList()
    {
        if (Auth::user()) {
            $my_tasks = Task::where('user_id', Auth::user()->id)->where('is_deleted', 0)->get();
        }

        if(isset($my_tasks)) {
            $response = array(
                'status' => 'success',
                'data' => $my_tasks,
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
        $task = Task::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if(Offer::where('task_id', $id)->where('status', 2)->count() > 0) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t delete selected task because you\'ve already agreed to use it in offer with other user.',
            );

            return \Response::json($response);
        }

        $name = $task->name;
        $task->is_deleted = 1;

        if($task->update()) {
            DB::raw(DB::delete("DELETE FROM `offers` WHERE `task_id` = $id"));

            $response = array(
                'status' => 'success',
                'message' => 'Task '.$name.' successfully deleted.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t delete selected task.',
            );
        }

        return \Response::json($response);
    }

    public function duplicate($id)
    {
        $task = Task::where('id', $id)->where('user_id', Auth::user()->id)->first();

        $new_task = $task->replicate();

        if($new_task->push()) {
            $response = array(
                'status' => 'success',
                'message' => 'Task '.$task->name.' successfully cloned.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t clone selected task.',
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
