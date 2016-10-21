<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company_name', 'address', 'phone', 'description', 'is_professional',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function vehicles()
    {
        return $this->hasMany('App\Vehicle');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }
}
