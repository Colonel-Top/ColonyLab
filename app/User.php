<?php

namespace App;

use App\Courses;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;
class User extends Authenticatable
{
    use Notifiable;
    protected $guard = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname','pinid', 'email', 'password','ider'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'courses_user', 'users_id', 'courses_id');
    }
    public function assignments()
    {
        return $this->belongsToMany('App\Assignments','assignment_work','enrollments_id','assignments_id');
    }

}
