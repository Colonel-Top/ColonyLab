<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    //
    protected $fillable = [
           'name','language','fullscore','getscore','attempts','fpath','allow_send','createby','courses_id','foutput',
          
	];
   /* protected $hidden = [
        'password',
    ];*/

    public function courses()
    {
        return $this->belongsToMany('App\Courses','enrollment','assignments_id','courses_id');
    }
    public function users()
    {
        return $this->belongsToMany('App\User','assignment_work','enrollments_id','assignments_id');
    }
}
