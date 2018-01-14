<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Admin;
use Auth;
use Session;
use Illuminate\Http\Request;
use Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class AdminRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user()->name;

            return $next($request);
        });
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'pinid' => 'required|string|max:10|unique:admins',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function show()
    {
        return view('auth.adminregister');
    }
    public function addnew(Request $data)
    {
        $this->validate($data,[
            'pinid' => 'required|string|max:10|unique:admins',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $exists = Admin::where('pinid',$data->pinid);
        print_r($data);
        dd($exists);
        if(!is_null($exists))
            return redirect()->back()->with(Session::flash('error','Error This PIN ID already exists'));

        $result = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'surname' => $data['surname'],
            'pinid' => $data['pinid'],
            'password' => bcrypt($data['password']),
        ]);
        if($result)
            Session::flash('status','Register new Administrator Successfully! :)');
        else
            Session::flash('status','Register new Administrator unsuccessfully! :(');
        return redirect()->intended(route('admin.dashboard'));
    }
}
