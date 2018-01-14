<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Auth;
class AdminLoginController extends Controller
{
  
	public function __construct()
	{
		$this->middleware('guest:admin',['except' => ['logout']]);
	}
    //
    public function showLoginForm()
    {
        if (Auth::check())
         if (Auth::User()->is_active != 'Y')
            Auth::logout();
    	return view('auth.admin-login');
    }
    public function login(Request $request)
    {
    	//Validate the form Data
    	$this->validate($request,[
    		'pinid' => 'required|max:40',
    		'password' => 'required|min:1'
    	]);

    	// Attempt to Log user in

    	if(Auth::guard('admin')->attempt(['pinid'=>$request->pinid,'password' => $request->password],$request->remember))
    	{
    		// if successful then redirect to some place
    		return redirect()->intended(route('admin.dashboard'));
    		//return redirect()->intended('index');
    	}
    	// else if unsuccessful then redirect to back with form data
    	return redirect()->back()->withInput($request->only('noid','remember'));
    	

    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        //$request->session()->invalidate();

        return redirect('/');
    }
}
