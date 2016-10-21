<?php

namespace App\Http\Controllers;

use App\Job;
use App\Task;
use App\TaskType;
use App\Vehicle;
use App\VehicleType;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function indexUser()
    {
        if (Auth::user()) {
            $my_vehicles = Vehicle::where('user_id', Auth::user()->id)->where('is_deleted', 0)->get();
            $vehicle_types = VehicleType::all();
            $my_tasks = Task::where('user_id', Auth::user()->id)->where('is_deleted', 0)->get();
            $my_jobs = Job::where('user_id', Auth::user()->id)->where('is_deleted', 0)->orderBy('job_date', 'asc')->get();

            $pc = new ProblemController;
            $pc->updateMissingSolutions();

            return view('app', compact('my_vehicles', 'vehicle_types', 'my_tasks', 'my_jobs'));
        }
        else {
            return view('app');
        }
    }
}
