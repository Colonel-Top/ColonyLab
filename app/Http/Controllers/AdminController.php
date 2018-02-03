<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Courses;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursesdata = Courses::where('allowregister','1')->get();
        return view('admin',['courses'=>$coursesdata]);
    }
}
