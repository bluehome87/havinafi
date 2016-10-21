<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['user_id_from', 'user_id_to', 'job_id', 'vehicle_id', 'task_id', 'status', 'price'];

    public function job()
    {
        return $this->belongsTo('App\Job');
    }
}
