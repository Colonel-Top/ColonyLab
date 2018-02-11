<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    //
    protected $fillable = ['name','create_by',];
   
  
    public function courses()
    {
        return $this->belongsTo('App\Courses');
    }
   

}
