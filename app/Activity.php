<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['route_id', 'task_id', 'completion_time', 'distance', 'transport_time', 'waiting_time'];

    public function route()
    {
        return $this->belongsTo('App\Route');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }
}
