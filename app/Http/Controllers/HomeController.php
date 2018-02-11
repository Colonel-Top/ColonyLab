<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutlab()
    {
        return view('about');
    }
    public function index()
    {
        // $asninfo = Assignments::FindOrFail($id);
        // $data = DB::table('assignment_work')->select()->where([['assignments_id',$id],['pinid',Auth::user()->pinid]])->get();

        // $blah = Assignments::with('courses.users')->where('id',$asninfo->id)->get();
        // return view('assignments.showcustom',['asninfo'=>$asninfo,'data'=>$data,'userdetails'=>$blah]);
        //$asninfo = Assignments::FindOrFail($id);
       // $data = DB::table('assignment_work')->select()->where('assignments_id',$id)->get();
        
      //  dd($blah);
        Auth::guard('admin')->logout();
        $courses = Auth::user()->courses;
        $now = now();
        $date= $now->format('d-m-Y');
        $time=$now->format('H:i');
        $blah = \App\Assignments::where('allow_send','1')->get();
        $anndata = Auth::user()->courses;
       // $blah = \App\Assignments::where('allow_send','1' )->get();
        return view('home',['asn'=>$blah,'courses'=>$courses,'date'=>$date,'time'=>$time,'anndata'=?$anndata]);
    }
}
