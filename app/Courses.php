<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    //
    protected $fillable = ['coursename','password','createby','allowregister','ider'];
    protected $hidden = [
        'password',
    ];
  
    public function users()
    {
        return $this->belongsToMany('App\User', 'enrollment', 'courses_id', 'users_id');
    }
    public function assignments()
    {
        return $this->hasMany('App\Assignments');
    }

}
