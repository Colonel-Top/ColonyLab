<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    //
    protected $fillable = ['name','create_by','live'];
   
  
    public function courses()
    {
        return $this->belongsTo('App\Courses');
    }
   

}
