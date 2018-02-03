<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Courses;
use App\User;
use Carbon\Carbon;
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
        $now = now();
        $date= $now->format('d-m-Y');
        $time=$now->format('H:i');
        $useramount = User::all();
        $useramount = count($useramount);

        $admin = Admin::all();
        $adminamount = count($admin);

        $allamount = $useramount + $adminamount;
        return view('admin',['courses'=>$coursesdata,'date'=>$date,'time'=>$time,'uamount'=>$useramount,'aamount'=>$adminamount,'allamount'=>$allamount,'admindata'=>$admin]);
    }
}
