<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Session;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
class UserProfileController extends Controller
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
     * Where to redirect users after registration.
     *
     * @var string
     */
   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
            'noid' => 'required|string|max:10|unique:users',
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
    public function request()
    {
        return view('profile.updateprofile');
    }


     public function update(Request $request)
    {
        $this->validate($request,[
        	'noid' => 'required|max:40',
            'name' => 'required|max:40',
            'surname' => 'required|max:40',
            'oldpass' => 'required|string|min:1',
            'email' => 'required',
        ]);
      
        $hashpass = bcrypt($request['oldpass']);
      //  echo($hashpass);

        //$user = User::where('noid', $request['noid']);
        
      //  echo($request);
        $passSDB = DB::table('users')->select('password')->where('noid',$request->noid)->pluck('password');
        $passlala = $passSDB[0];

       	if (Hash::check($request->oldpass,$passlala) )
       	{
       		if(!empty($request->password) && !empty($request->confirm))
       		{
       			$hashpass = bcrypt($request->password);
       			Session::flash('error','new pass assigner');
       		//	 echo($hashpass);
       		}
       		else if(!empty($request->password)&&empty($request->confirm))
       		{
       			Session::flash('error','Invalid Password & Confirm not similar');
        		return redirect()->back()->withInput($request->only('name','surname','email'));
       		}
       	}
       	else
       	{
       		Session::flash('error','Wrong Current Password');
        	return redirect()->back();
       	}
    
       	DB::beginTransaction();
      	$test = DB::update('update users set name = ? , surname = ? , email = ? , password = ? where noid = ?', [
      		$request->name,$request->surname,$request->email,$hashpass,$request->noid
      	]);

 		DB::commit();
       /* $user->name = $request->name;
        $user->surname = $request->surname;
        $user->password = $hashpass;
        $user->email = $request->email;
        $user->users()->attach($noid);*/
		if($test == 1)
		{
			Session::flash('message1','Profile Update Successfully');
       		return redirect('home');
        }
        else
        {
        	echo($request->name);
        	Session::flash('error','Profile Update unsuccessfull contact administrator');
        	return redirect()->back()->withInput($request->only('name','surname','email'));
        }
		/*$postData = $request->all();
		echo($postData->noid);

		User::find($request->noid)->update($postData);*/
        

    }
}
