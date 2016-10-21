<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Job;
use App\Offer;
use App\Route;
use App\Task;
use App\User;
use App\Vehicle;
use App\VehicleType;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class ProblemController extends Controller
{
    private $key;
    private $job_id;
    private $route_id;
    private $vehicles;
    private $vehicle_types;
    private $services;
    private $shipments;
    private $request_array;
    private $other_vehicles;
    private $vehicle_ids;
    private $task_ids;

    public function __construct()
    {
        $this->key = env('GRAPHHOPPER_KEY');
        $this->vehicles = array();
        $this->vehicle_types = array();
        $this->services = array();
        $this->shipments = array();
        $this->request_array = array();
        $this->vehicle_ids = array();
        $this->task_ids = array();
        $this->updateMissingSolutions();
    }

    public function addVehicleToRoute($id)
    {
        $vehicle = Vehicle::find($id);

        if($vehicle && !in_array($vehicle->id, $this->vehicle_ids)) {
            $skills = array();
            $vehicle['weather_protection'] == 1 ? array_push($skills, "weather_protection") : '';
            $vehicle['food_accepted'] == 1 ? array_push($skills, "food_accepted") : '';
            $vehicle['temp_control'] == 1 ? array_push($skills, "temp_control") : '';
            $vehicle['crane'] == 1 ? array_push($skills, "crane") : '';
            $vehicle['rear_lift'] == 1 ? array_push($skills, "rear_lift") : '';

            if ($vehicle['passenger_delivery'] == 1) {
                $capacity = array(intval($vehicle['max_passengers']));
                array_push($skills, "passengers");
            } elseif ($vehicle['package_delivery'] == 1) {
                $capacity = array(intval($vehicle['trunk_volume']), intval($vehicle['max_weight']));
                array_push($skills, "packages");
            } else {
                $capacity = 0;
            }

            $new_vehicle = array(
                'vehicle_id' => '' . $vehicle['id'] . '',
                'type_id' => "type" . $vehicle['id'] . '',
                'start_address' => array(
                    'location_id' => 'vehicle' . $vehicle['id'] . 'start',
                    'lon' => floatval($vehicle['from_lon']),
                    'lat' => floatval($vehicle['from_lat'])
                ),
                'end_address' => array(
                    'location_id' => 'vehicle' . $vehicle['id'] . 'end',
                    'lon' => floatval($vehicle['to_lon']),
                    'lat' => floatval($vehicle['to_lat'])
                ),
                'earliest_start' => strtotime("1970-01-01 " . $vehicle['from_time'] . " UTC"),
                'latest_end' => strtotime("1970-01-01 " . $vehicle['to_time'] . " UTC"),
                'skills' => $skills
            );

            $vehicle_type = array(
                "type_id" => "type" . $vehicle['id'] . '',
                "profile" => VehicleType::find($vehicle['type'])->type,
                "capacity" => $capacity
            );

            array_push($this->vehicles, $new_vehicle);
            array_push($this->vehicle_types, $vehicle_type);
            array_push($this->vehicle_ids, $vehicle['id']);
        }
    }

    public function addTaskToRoute($id)
    {
        $task = Task::find($id);

        if($task && !in_array($task->id, $this->task_ids)) {
            $skills = array();
            $task['weather_protection'] == 1 ? array_push($skills, "weather_protection") : '';
            $task['food'] == 1 ? array_push($skills, "food_accepted") : '';
            $task['temp_control'] == 1 ? array_push($skills, "temp_control") : '';
            $task['crane'] == 1 ? array_push($skills, "crane") : '';
            $task['rear_lift'] == 1 ? array_push($skills, "rear_lift") : '';

            if ($task['passenger_delivery'] == 1 || $task['package_delivery'] == 1) {
                if ($task['passenger_delivery'] == 1) {
                    $capacity = array(intval($task['passengers']));
                    array_push($skills, "passengers");
                } elseif ($task['package_delivery'] == 1) {
                    $capacity = array(intval($task['total_volume']), intval($task['weight']));
                    array_push($skills, "packages");
                } else {
                    $capacity = array(0);
                }

                $new_task = array(
                    'id' => '' . $task['id'] . '',
                    'name' => $task['name'],
                    'pickup' => array(
                        'address' => array(
                            'location_id' => 'task' . $task['id'] . 'start',
                            'lon' => floatval($task['from_lon']),
                            'lat' => floatval($task['from_lat'])
                        ),
                        'duration' => $task['loading_time'] * 60,
                        'time_windows' => array(
                            0 => array(
                                'earliest' => strtotime("1970-01-01 " . $task['from_time_start'] . " UTC"),
                                'latest' => strtotime("1970-01-01 " . $task['from_time_end'] . " UTC"),
                            )
                        )
                    ),
                    'delivery' => array(
                        'address' => array(
                            'location_id' => 'task' . $task['id'] . 'end',
                            'lon' => floatval($task['to_lon']),
                            'lat' => floatval($task['to_lat'])
                        ),
                        'duration' => $task['unload_time'] * 60,
                        'time_windows' => array(
                            0 => array(
                                'earliest' => strtotime("1970-01-01 " . $task['to_time_start'] . " UTC"),
                                'latest' => strtotime("1970-01-01 " . $task['to_time_end'] . " UTC"),
                            )
                        )
                    ),
                    'size' => $capacity,
                    'required_skills' => $skills
                );

                array_push($this->shipments, $new_task);
                array_push($this->task_ids, $task['id']);
            } elseif ($task['one_stop_task'] == 1) {
                $new_task = array(
                    'id' => '' . $task['id'] . '',
                    'name' => $task['name'],
                    'address' => array(
                        'location_id' => 'task' . $task['id'] . 'start',
                        'lon' => floatval($task['from_lon']),
                        'lat' => floatval($task['from_lat'])
                    ),
                    'duration' => $task['loading_time'] * 60,
                    'time_windows' => array(
                        0 => array(
                            'earliest' => strtotime("1970-01-01 " . $task['from_time_start'] . " UTC"),
                            'latest' => strtotime("1970-01-01 " . $task['from_time_end'] . " UTC")
                        )
                    ),
                    'size' => array(0),
                    'required_skills' => $skills
                );

                array_push($this->services, $new_task);
                array_push($this->task_ids, $task['id']);
            }
        }
    }

    public function generateTasksAndVehiclesArrays($request)
    {
        if($request->is_own_vehicles == 1) {
            // add My Vehicles to optimization request
            foreach ($request->my_vehicles as $id => $value) {
                $this->addVehicleToRoute($id);
            }

            $this->other_vehicles = false;
        }
        else {
            // add Other User Vehicles to optimization request
            $jobs = Job::where('is_own_vehicles', 1)->where('user_id', '!=', Auth::user()->id)
                ->where('job_date', $request->transjob_date)->where('is_deleted', 0)->get();

            if(count($jobs) > 0) {
                $this->other_vehicles = true;

                foreach ($jobs as $job) {
                    $offers = Offer::where('user_id_from', '!=', Auth::user()->id)->orWhere('user_id_to', '!=', Auth::user()->id)
                        ->where('job_id', $job->id)->where('status', '!=', 2)->get();

                    foreach($offers as $offer) {
                        $this->addVehicleToRoute($offer->vehicle_id);
                    }
                }
            }
            else {
                $this->other_vehicles = false;
            }
        }

        // add My Tasks to optimization request
        if(isset($request->my_tasks)) {
            foreach ($request->my_tasks as $id => $value) {
                $this->addTaskToRoute($id);
            }
        }

        // add other tasks to optimization request
        if($request->is_other_tasks == 1) {
            $jobs = Job::where('is_own_vehicles', 0)->where('user_id', '!=', Auth::user()->id)
                ->where('job_date', $request->transjob_date)->where('is_deleted', 0)->get();

            if(count($jobs) > 0) {
                foreach($jobs as $job) {
                    $offers = Offer::where('user_id_from', '!=', Auth::user()->id)->where('user_id_to', '!=', Auth::user()->id)
                        ->where('job_id', $job->id)->where('status', '!=', 2)->get();

                    foreach($offers as $offer) {
                        $this->addTaskToRoute($offer->task_id);
                    }
                }
            }
        }
    }

    public function sendProblem(Request $request)
    {
        $this->generateTasksAndVehiclesArrays($request);

        // send optimization request
        if((isset($request->my_tasks) || $request->is_other_tasks == 1) && (isset($request->my_vehicles) || $this->other_vehicles == true)) {
            $request_array['vehicles'] = $this->vehicles;
            $request_array['vehicle_types'] = $this->vehicle_types;
            if (count($this->services) > 0) {
                $request_array['services'] = $this->services;
            }
            if (count($this->shipments) > 0) {
                $request_array['shipments'] = $this->shipments;
            }

            $request_data = json_encode($request_array);

            $ch = curl_init('https://graphhopper.com/api/1/vrp/optimize?key=' . $this->key);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($request_data))
            );

            $result = curl_exec($ch);
            $result_json = json_decode($result, true);
        }
        else {
            $result_json['job_id'] = NULL;
        }

        if($this->saveNewJob($request, $result_json)) {
            $response = array(
                'status' => 'success',
                'message' => 'Transjob '.$request->transjob_name.' successfully created.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t create transjob, please check all fields and try again.',
            );
        }

        $this->updateMissingSolutions();

        return \Response::json($response);
    }

    public function saveNewJob($request, $optimization_result)
    {
        $job = new Job;
        $job->user_id = Auth::user()->id;
        $job->name = $request->transjob_name;
        $job->job_date = $request->transjob_date;
        $job->is_own_vehicles = $request->is_own_vehicles;
        $job->is_own_tasks = $request->is_own_tasks;
        $job->is_other_tasks = $request->is_other_tasks;
        $job->raw_request = serialize($request->request);
        $job->job_id = isset($optimization_result['job_id']) ? $optimization_result['job_id'] : NULL;
        $job->status = isset($optimization_result['job_id']) ? 'processing' : 'pending';

        if($job->save()) {
            $this->savePossibleOfferCombinations($job->id, $request->is_other_tasks, $request->is_own_vehicles, $request);
            return true;
        }
        else {
            return false;
        }
    }

    public function savePossibleOfferCombinations($job_id, $other_tasks, $own_vehicles, $request)
    {
        if(count($this->vehicles) > 0) {
            foreach ($this->vehicles as $veh) {
                $vehicle = Vehicle::find($veh['vehicle_id']);

                foreach ($this->services as $service) {
                    $task = Task::find($service['id']);

                    $offer = new Offer;
                    $offer->user_id_from = Auth::user()->id;

                    if ($vehicle['user_id'] == Auth::user()->id) {
                        $offer->user_id_to = $task['user_id'];
                    } else {
                        $offer->user_id_to = $vehicle['user_id'];
                    }

                    $offer->job_id = $job_id;
                    $offer->vehicle_id = $vehicle['id'];
                    $offer->task_id = $task['id'];
                    if(!Offer::where('user_id_from', Auth::user()->id)->where('user_id_to', $offer->user_id_to)
                        ->where('job_id', $job_id)->where('vehicle_id', $vehicle['id'])->where('task_id', $task['id'])->exists()) {
                        $offer->save();
                    }
                }

                foreach ($this->shipments as $shipment) {
                    $task = Task::find($shipment['id']);

                    $offer = new Offer;
                    $offer->user_id_from = Auth::user()->id;

                    if ($vehicle['user_id'] == Auth::user()->id) {
                        $offer->user_id_to = $task['user_id'];
                    } else {
                        $offer->user_id_to = $vehicle['user_id'];
                    }

                    $offer->job_id = $job_id;
                    $offer->vehicle_id = $vehicle['id'];
                    $offer->task_id = $task['id'];
                    if(!Offer::where('user_id_from', Auth::user()->id)->where('user_id_to', $offer->user_id_to)
                        ->where('job_id', $job_id)->where('vehicle_id', $vehicle['id'])->where('task_id', $task['id'])->exists()) {
                        $offer->save();
                    }
                }

                if($other_tasks == 1) {
                    $offer = new Offer;
                    $offer->user_id_from = Auth::user()->id;
                    $offer->user_id_to = 0;
                    $offer->job_id = $job_id;
                    $offer->vehicle_id = $vehicle['id'];
                    $offer->task_id = 0;
                    if(!Offer::where('user_id_from', Auth::user()->id)->where('user_id_to', $offer->user_id_to)
                        ->where('job_id', $job_id)->where('vehicle_id', $vehicle['id'])->where('task_id', 0)->exists()) {
                        $offer->save();
                    }
                }
            }
        }
        else {
            foreach ($this->services as $service) {
                $task = Task::find($service['id']);

                $offer = new Offer;
                $offer->user_id_from = Auth::user()->id;
                $offer->user_id_to = 0;
                $offer->job_id = $job_id;
                $offer->vehicle_id = 0;
                $offer->task_id = $task['id'];
                if(!Offer::where('user_id_from', Auth::user()->id)->where('user_id_to', $offer->user_id_to)
                    ->where('job_id', $job_id)->where('task_id', $task['id'])->where('vehicle_id', 0)->exists()) {
                    $offer->save();
                }
            }

            foreach ($this->shipments as $shipment) {
                $task = Task::find($shipment['id']);

                $offer = new Offer;
                $offer->user_id_from = Auth::user()->id;
                $offer->user_id_to = 0;
                $offer->job_id = $job_id;
                $offer->vehicle_id = 0;
                $offer->task_id = $task['id'];
                if(!Offer::where('user_id_from', Auth::user()->id)->where('user_id_to', $offer->user_id_to)
                    ->where('job_id', $job_id)->where('task_id', $task['id'])->where('vehicle_id', 0)->exists()) {
                    $offer->save();
                }
            }
        }

        if(!$own_vehicles) {
            foreach ($request->my_tasks as $id => $value) {
                $offer = new Offer;
                $offer->user_id_from = Auth::user()->id;
                $offer->user_id_to = 0;
                $offer->job_id = $job_id;
                $offer->vehicle_id = 0;
                $offer->task_id = $id;
                if(!Offer::where('user_id_from', Auth::user()->id)->where('user_id_to', 0)
                    ->where('job_id', $job_id)->where('vehicle_id', 0)->where('task_id', $id)->exists()) {
                    $offer->save();
                }
            }
        }
    }

    public function updateProblem(Request $request, $problem_id)
    {
        if($this->getJobConfirmedOffers($problem_id)) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t update transjob because it already has confirmed offers.',
            );

            return \Response::json($response);
        }

        if(!Job::where('user_id', Auth::user()->id)->where('id', $problem_id)->exists()) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t update transjob because it doesn\'t exist.',
            );

            return \Response::json($response);
        }

        DB::raw(DB::delete("DELETE FROM `offers` WHERE `job_id` = $problem_id"));

        $this->generateTasksAndVehiclesArrays($request);

        // send optimization request
        if((isset($request->my_tasks) || $request->is_other_tasks == 1) && (isset($request->my_vehicles) || $this->other_vehicles == true)) {
            $request_array['vehicles'] = $this->vehicles;
            $request_array['vehicle_types'] = $this->vehicle_types;
            if (count($this->services) > 0) {
                $request_array['services'] = $this->services;
            }
            if (count($this->shipments) > 0) {
                $request_array['shipments'] = $this->shipments;
            }

            $request_data = json_encode($request_array);

            $ch = curl_init('https://graphhopper.com/api/1/vrp/optimize?key=' . $this->key);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($request_data))
            );

            $result = curl_exec($ch);
            $result_json = json_decode($result, true);
        }
        else {
            $result_json['job_id'] = NULL;
        }

        if($this->updateJob($problem_id, $request, $result_json)) {
            $response = array(
                'status' => 'success',
                'message' => 'Transjob '.$request->transjob_name.' successfully updated.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t update transjob, please check all fields and try again.',
            );
        }

        $this->updateMissingSolutions();

        return \Response::json($response);
    }

    public function getJobConfirmedOffers($job_id)
    {
        $offers = Offer::where('job_id', $job_id)->where('status', '2')->get();

        if(count($offers) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function updateJob($problem_id, $request, $optimization_result)
    {
        $job = Job::find($problem_id);
        $job->user_id = Auth::user()->id;
        $job->name = $request->transjob_name;
        $job->job_date = $request->transjob_date;
        $job->is_own_vehicles = $request->is_own_vehicles;
        $job->is_own_tasks = $request->is_own_tasks;
        $job->is_other_tasks = $request->is_other_tasks;
        $job->raw_request = serialize($request->request);
        $job->job_id = isset($optimization_result['job_id']) ? $optimization_result['job_id'] : NULL;
        $job->raw_solution = NULL;
        $job->status = isset($optimization_result['job_id']) ? 'processing' : 'pending';

        if($job->save()) {
            $this->removeJobDependencies($job->id);
            $this->savePossibleOfferCombinations($job->id, $request->is_other_tasks, $request->is_own_vehicles, $request);
            return true;
        }
        else {
            return false;
        }
    }

    public function removeJobDependencies($job_id)
    {
        DB::raw(DB::delete("DELETE FROM `offers` WHERE `job_id` = $job_id"));

        $routes = Route::where('job_id', $job_id)->get();
        foreach($routes as $route) {
            DB::raw(DB::delete("DELETE FROM `activities` WHERE `route_id` = $route->id"));
        }

        DB::raw(DB::delete("DELETE FROM `routes` WHERE `job_id` = $job_id"));
    }

    public function getSolution($job_id)
    {
        if(isset($job_id) && strlen($job_id) > 2) {
            $ch = curl_init("https://graphhopper.com/api/1/vrp/solution/" . $job_id . "?key=" . $this->key);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            $solution = json_decode($result, true);
        }

        if(isset($solution) && isset($solution['status']) && $solution['status'] == 'finished') {
            return $solution;
        }
        else {
            return NULL;
        }
    }

    public function updateMissingSolutions()
    {
        $jobs = Job::whereNull('raw_solution')->get();

        foreach($jobs as $job) {
            $solution = $this->getSolution($job->job_id);

            if(!empty($solution) && isset($solution['solution'])) {
                $this->job_id = $job->id;
                $job->raw_solution = serialize($solution);
                $job->status = 'finished';
                $job->completion_time = intval($solution['solution']['completion_time']);
                $job->costs = intval($solution['solution']['costs']);
                $job->distance = intval($solution['solution']['distance']);
                $job->no_unassigned = intval($solution['solution']['no_unassigned']);
                $job->no_vehicles = intval($solution['solution']['no_vehicles']);
                $job->transport_time = intval($solution['solution']['transport_time']);
                $job->waiting_time = intval($solution['solution']['waiting_time']);
                $job->update();

                $this->saveSolutionRoutes($solution['solution']['routes']);
            }
        }
    }

    public function saveSolutionRoutes($oe_routes)
    {
        foreach($oe_routes as $oe_route) {
            $route = new Route;
            $route->job_id = $this->job_id;
            $route->vehicle_id = intval($oe_route['vehicle_id']);
            $route->completion_time = intval($oe_route['completion_time']);
            $route->distance = intval($oe_route['distance']);
            $route->transport_time = intval($oe_route['transport_time']);
            $route->waiting_time = intval($oe_route['waiting_time']);
            $route->save();

            $this->route_id = $route->id;

            $this->saveRouteActivities($oe_route['activities'], $oe_route['vehicle_id']);
        }
    }

    public function saveRouteActivities($oe_activities, $vehicle_id)
    {
        foreach($oe_activities as $oe_activity) {
            $activity = new Activity;
            $activity->route_id = $this->route_id;
            $activity->task_id = isset($oe_activity['id']) ? intval($oe_activity['id']) : NULL;
            $activity->type = $oe_activity['type'];
            $activity->arr_time = isset($oe_activity['arr_time']) ? intval($oe_activity['arr_time']) : NULL;
            $activity->distance = intval($oe_activity['distance']);
            $activity->end_time = isset($oe_activity['end_time']) ? intval($oe_activity['end_time']) : NULL;
            $activity->location_id = $oe_activity['location_id'];
            $activity->save();

            if(isset($oe_activity['id'])) {
                $this->updatePossibleOfferCombinations($vehicle_id, $oe_activity['id']);
            }
        }
    }

    public function updatePossibleOfferCombinations($vehicle_id, $task_id)
    {
        $offer = Offer::where('job_id', $this->job_id)->where('vehicle_id', $vehicle_id)->where('task_id', $task_id)
            ->whereRaw('user_id_from != user_id_to')->first();

        if($offer) {
            $offer->status = 1;
            $offer->save();
        }
    }

    public function getJobDrivingList($id)
    {
        $job = Job::find($id);

        if($job) {
            $vehicles = array();
            $total_tasks = 0;
            $routes = Route::where('job_id', $job->id)->with('Vehicle')->get();

            foreach($routes as $route) {
                $points = array();
                $veh_id = $route->vehicle_id;

                $vehicles[$route->vehicle_id]['vehicle_id'] = $route->vehicle_id;
                $vehicles[$route->vehicle_id]['vehicle_name'] = $route->vehicle->name;
                $vehicles[$route->vehicle_id]['vehicle_type'] = $route->vehicle->type;
                $vehicles[$route->vehicle_id]['vehicle_owner_name'] = User::find($route->vehicle->user_id)->name;

                $activities = Activity::where('route_id', $route->id)->get();
                $activities_count = 0;
                foreach($activities as $activity) {
                    switch ($activity->type) {
                        case 'start':
                            $type = "Vehicle start";
                            $start_lat = $route->vehicle->from_lat;
                            $start_lon = $route->vehicle->from_lon;
                            $end_lat = 0;
                            $end_lon = 0;
                            if($job->is_own_vehicles == 1) {
                                array_push($points, $start_lat . '%2C' . $start_lon);
                            }
                            break;
                        case 'pickupShipment':
                            $activities_count++;
                            $type = "pickup";
                            $start_lat = $activity->task->from_lat;
                            $start_lon = $activity->task->from_lon;
                            $end_lat = $activity->task->to_lat;
                            $end_lon = $activity->task->to_lon;
                            array_push($points, $start_lat.'%2C'.$start_lon);
                            array_push($points, $end_lat.'%2C'.$end_lon);
                            break;
                        case 'deliverShipment':
                            $type = "delivery";
                            $start_lat = $activity->task->from_lat;
                            $start_lon = $activity->task->from_lon;
                            $end_lat = $activity->task->to_lat;
                            $end_lon = $activity->task->to_lon;
                            array_push($points, $start_lat.'%2C'.$start_lon);
                            array_push($points, $end_lat.'%2C'.$end_lon);
                            break;
                        case 'service':
                            $activities_count++;
                            $type = "one-stop";
                            $start_lat = $activity->task->from_lat;
                            $start_lon = $activity->task->from_lon;
                            $end_lat = 0;
                            $end_lon = 0;
                            array_push($points, $start_lat.'%2C'.$start_lon);
                            break;
                        case 'end':
                            $type = "Vehicle end";
                            $start_lat = 0;
                            $start_lon = 0;
                            $end_lat = $route->vehicle->to_lat;
                            $end_lon = $route->vehicle->to_lon;
                            if($job->is_own_vehicles == 1) {
                                array_push($points, $end_lat . '%2C' . $end_lon);
                            }
                            break;

                        default:
                            $type = "unknown";
                            $start_lat = 0;
                            $start_lon = 0;
                            $end_lat = 0;
                            $end_lon = 0;
                    }

                    $vehicles[$route->vehicle_id]['activities'][$activity->id] = array(
                        'id' => $activity->id,
                        'arrival' => isset($activity->arr_time) ? gmdate("H:i", $activity->arr_time) : '',
                        'departure' => isset($activity->end_time) ? gmdate("H:i", $activity->end_time) : '',
                        'start_lat' => $start_lat,
                        'start_lon' => $start_lon,
                        'stop_lat' => $end_lat,
                        'stop_lon' => $end_lon,
                        'type' => $type,
                        'task_id' => $activity->task_id,
                        'task_name' => isset($activity->task_id) ? $activity->task->name : ''
                    );
                }

                $route = 'https://graphhopper.com/api/1/route?point=';
                $points_string = implode('&point=', $points);
                $route = $route.$points_string.'&vehicle=car&instructions=false&locale=en&points_encoded=false&key='.$this->key;

                $directions = $this->getRoute($route);

                $vehicles[$veh_id]['directions'] = $directions;
                $vehicles[$veh_id]['activities_count'] = $activities_count;
                $total_tasks += $activities_count;
            }

            $response = array(
                'status' => 'success',
                'data' => json_encode($vehicles),
                'job_info' => json_encode($job),
                'total_tasks' => json_encode($total_tasks)
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Impossible to show selected job.',
            );
        }

        return \Response::json($response);
    }

    public function getJobDetails($id)
    {
        $job = Job::find($id);

        if($job) {
            $vehicles = array();
            $routes = Route::where('job_id', $job->id)->with('Vehicle')->get();

            foreach($routes as $route) {
                $vehicles[$route->vehicle_id]['vehicle_id'] = $route->vehicle_id;
                $vehicles[$route->vehicle_id]['vehicle_name'] = $route->vehicle->name;
                $veh = Vehicle::find($route->vehicle_id);

                $activities = Activity::where('route_id', $route->id)
                    ->whereRaw("(type = 'pickupShipment' OR type = 'deliverShipment' OR type = 'service')")->get();
                foreach($activities as $activity) {
                    $price_offer = 0;
                    //
                    //
                    //
                    // THIS PART TO REMAKE!!!
                    //
                    //
                    //
                    // check if owner of this vehicle is current user; if not then price offer option should be possible
                    if($veh->user_id != Auth::user()->id) {
                        $price_offer = array(
                            'from_user' => Auth::user()->id,
                            'to_user' => $veh->user_id,
                            'activity_id' => $activity->id,
                            'task_id' => $activity->task_id
                        );
                    }
                    //
                    //
                    //

                    if($activity->type == 'deliverShipment') {
                        $vehicles[$route->vehicle_id]['activities'][$activity->id - 1]['delivery'] = gmdate("H:i", $activity->arr_time);
                    }
                    else {
                        $vehicles[$route->vehicle_id]['activities'][$activity->id] = array(
                            'id' => $activity->id,
                            'time' => isset($activity->arr_time) ? gmdate("H:i", $activity->arr_time) : '-',
                            'task_id' => $activity->task_id,
                            'task_name' => $activity->task->name,
                            'pickup' => isset($activity->arr_time) ? gmdate("H:i", $activity->arr_time) : '-',
                            'delivery' => isset($activity->end_time) ? gmdate("H:i", $activity->end_time) : '-',
                            'price_offer' => $price_offer
                        );
                    }
                }
            }

            $response = array(
                'status' => 'success',
                'data' => json_encode($vehicles)
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Impossible to show selected job.',
            );
        }

        return \Response::json($response);
    }

    public function getList()
    {
        if (Auth::user()) {
            $my_jobs = Job::where('user_id', Auth::user()->id)->where('is_deleted', 0)->get();
        }

        if(isset($my_jobs)) {
            $response = array(
                'status' => 'success',
                'data' => $my_jobs,
            );
        }
        else {
            $response = array(
                'status' => 'danger'
            );
        }

        return \Response::json($response);
    }

    public function getEditDetails($id)
    {
        $job = Job::find($id);

        if($job) {
            $req = unserialize($job->raw_request);
            $reflector = new \ReflectionClass($req);
            $classProperty = $reflector->getProperty('parameters');
            $classProperty->setAccessible(true);
            $raw = $classProperty->getValue($req);

            $response = array(
                'status' => 'success',
                'id' => $id,
                'request' => json_encode($raw),
                'name' => $job->name,
                'date' => $job->job_date
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Impossible to show selected job.',
            );
        }

        return \Response::json($response);
    }

    public function delete($id)
    {
        if($this->getJobConfirmedOffers($id)) {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t delete transjob because it already has confirmed offers.',
            );

            return \Response::json($response);
        }

        $job = Job::where('id', $id)->where('user_id', Auth::user()->id)->first();
        $name = $job->name;
        $job->is_deleted = 1;

        if($job->update()) {
            DB::raw(DB::delete("DELETE FROM `offers` WHERE `job_id` = $id"));

            $response = array(
                'status' => 'success',
                'message' => 'Transjob '.$name.' successfully deleted.',
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t delete selected transjob.',
            );
        }

        return \Response::json($response);
    }

    public function duplicate($id)
    {
        $job = Job::where('id', $id)->where('user_id', Auth::user()->id)->first();

        $new_job = $job->replicate();
        $new_job->name = $new_job->name.' (Copy)';

        if($new_job->push()) {
            $this->duplicateJobDependencies($id, $new_job->id);

            $response = array(
                'status' => 'success',
                'message' => 'Transjob '.$job->name.' successfully cloned.',
                'id' => $new_job->id,
            );
        }
        else {
            $response = array(
                'status' => 'danger',
                'message' => 'Can\'t clone selected transjob.',
            );
        }

        return \Response::json($response);
    }

    public function duplicateJobDependencies($job_id, $new_job_id)
    {
        // duplicate job offers
        $offers = Offer::where('job_id', $job_id)->get();
        foreach($offers as $offer) {
            $new_offer = $offer->replicate();
            $new_offer->job_id = $new_job_id;
            $new_offer->status = 0;
            $new_offer->price = NULL;
            $new_offer->push();
        }

        // duplicate job routes
        $routes = Route::where('job_id', $job_id)->get();
        foreach($routes as $route) {
            $new_route = $route->replicate();
            $new_route->job_id = $new_job_id;
            $new_route->push();

            // diplicate route activities
            $activities = Activity::where('route_id', $route->id)->get();
            foreach($activities as $activity) {
                $new_activity = $activity->replicate();
                $new_activity->route_id = $new_route->id;
                $new_activity->push();
            }
        }
    }

    public function getRoute($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $route = json_decode($result, true);

        $coords = $route['paths'][0]['points']['coordinates'];

        $coordinates = array();

        foreach($coords as $coord) {
            array_push($coordinates, array($coord[1], $coord[0]));
        }

        return $coordinates;
    }
}
