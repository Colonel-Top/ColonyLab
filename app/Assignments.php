<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    //
    protected $fillable = [
           'name','language','fullscore','getscore','attempts','fpath','allow_send','createby','courses_id','foutput','finput','max_attempts','starttime','endtime','mytime1','mytime2','mytime'
          
	];
   /* protected $hidden = [
        'password',
    ];*/

    public function courses()
    {
        return $this->belongsTo('App\Courses');
    }
    public function users()
    {
        return $this->belongsToMany('App\User','assignment_work','assignments_id','enrollments_id');
    }
}
