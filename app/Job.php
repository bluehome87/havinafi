<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'job_date', 'job_id', 'raw_solution', 'status', 'processing_time', 'completion_time',
        'costs', 'distance', 'no_unassigned', 'no_vehicles', 'transport_time', 'waiting_time'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function routes()
    {
        return $this->hasMany('App\Route');
    }

    public function offers()
    {
        return $this->hasMany('App\Offer');
    }
}
