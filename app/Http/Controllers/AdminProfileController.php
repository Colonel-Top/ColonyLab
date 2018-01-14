<?php

namespace App\Http\Controllers;
use App\Courses;
use App\User;
use DB;
use Session;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
class AdminProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Controller
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
        $this->middleware('auth:admin');
    }

   /* public function confirm($user,$id,Request $request)
    {
      $results = DB::table('courses')->select('password')->where('id',$request->ider)->pluck('password');
    $passlala = $results[0];
    
    $hashpass = bcrypt($request->password);
    
    
  
    if (Hash::check($request->password,$passlala))
      {
        Session::flash('message1','Authorized Successfully!');
       
       
             //load form view
            return drop($user);
      }
      else
      {
        //echo("BULLSHIT");
        Session::flash('message1','Wrong Password / Cannot Authorization');
        return redirect()->back();
      }
    }*/
    public function drop($id)
    {
     // echo($id);
      $account = User::where('pinid', $id)->firstOrFail()->courses()->detach();
      //$account->find($id)->courses()->detach();

// delete the record from the account table.
     // $account->delete($id);
      if($account)
      {
        Session::flash('message1','Drop User Successfully!');
        return redirect()->back();
      }
      else
      {
        Session::flash('error','Drop User Faild');
        return redirect()->back();
      }
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
      $user = Auth::user();
    

      return view('profile.adminupdateprofile',['user'=>$user]);

  
    }


     public function update(Request $request)
    {
        $this->validate($request,[
        	'pinid' => 'required|max:40',
            'name' => 'required|max:40',
            'surname' => 'required|max:40',
            'email' => 'required',
        ]);
        $getold = User::where('pinid',$request->pinid)->first();
        
        $hashpass = $getold->password;
        $ids =$request->newid;
        if(empty($request->newid))
        {
            $ids = $request->pinid;
        }
       		if(!empty($request->password) || !empty($request->confirm))
       		{
            if($request->password == $request->confirm)
            {
       			  $request['password'] = bcrypt($request->password);
            }
       		}
          else if(empty($request->password) || empty($request->confirm))
            $request['password'] = $hashpass;
          else
            $request['password'] = $hashpass;
         $postData = $request->all();
         
        User::where('pinid', $request->pinid)->firstOrFail()->update($postData);
         /*
              User::find($request->pinid)->update($postData);*/
              Session::flash('message1','User Profile Updated');

          return redirect('/admin/courses');
        }
}
