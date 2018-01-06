<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    //
    protected $fillable = [
           'name','language','fullscore','getscore','attempts','fpath','allowsend'
          
	];
   /* protected $hidden = [
        'password',
    ];*/
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    public function courses()
    {
        return $this->belongsToMany('App\Courses','courses_user');
    }
    public function users()
    {
        return $this->belongsToMany('App\User','courses_user'));
    }
}
