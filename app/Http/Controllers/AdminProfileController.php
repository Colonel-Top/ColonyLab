<?php

namespace App\Http\Controllers;
use App\Courses;
use App\User;
use DB;
use Session;
use Hash;
use Auth;
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
            'pinid' => 'required|string|max:20|unique:users',
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

public function requestupdate($id)
    {
   //   dd($id);
      $account = User::where('pinid', $id)->firstOrFail();
     // print_r($user);
     // exit();
     // foreach($account as $data)
        //echo($data);
      //exit();
      return view('profile.adminupdateprofile',['user'=>$account]);

  
    }


 public function updater(Request $request)
    {
        $this->validate($request,[
          'pinid' => 'required|max:40',
            'name' => 'required|max:40',
            'surname' => 'required|max:40',
            'email' => 'required',
        ]);
       
      //  $hashpass = bcrypt($request->oldpass);
      //  echo($hashpass);

        //$user = User::where('pinid', $request['pinid']);
        
      //  echo($request);
       $hashpass = User::where('pinid',$request->pinid)->firstOrFail()->password;
      //  echo($passlala);
        //exit();
        if(empty($request->newid))
        {
          $request->newid = $request->pinid;
        }
        //  dd("CHECL");
          if(!empty($request->password) && !empty($request->confirm))
          {
            if($request->password == $request->confirm)
              $hashpass = bcrypt($request->password);
            else
            {
              Session::flash('error','Invalid Password & Confirm not similar');
            return redirect()->back()->withInput($request->only('pinid','name','surname','email'));
            }
          //   echo($hashpass);
          }
        
       
        DB::beginTransaction();
        $test = DB::update('update users set name = ? , surname = ? , email = ? , password = ?, pinid = ? where id = ?', [
          $request->name,$request->surname,$request->email,$hashpass,$request->newid,User::where('pinid',$request->pinid)->firstOrFail()->id
        ]);

    DB::commit();
       /* $user->name = $request->name;
        $user->surname = $request->surname;
        $user->password = $hashpass;
        $user->email = $request->email;
        $user->users()->attach($pinid);*/
    if($test == 1)
    {
      Session::flash('message1','Profile Update Successfully');
          return redirect('/admin/courses');
        }
        else
        {
          //echo($request->name);
          Session::flash('error','Profile Update unsuccessfull contact administrator');
          return redirect()->back()->withInput($request->only('name','surname','email'));
        }
          return redirect('/admin/courses');
        }




     public function update(Request $request)
    {

        $this->validate($request,[
        	'pinid' => 'required|max:40',
            'name' => 'required|max:40',
            'surname' => 'required|max:40',
            'email' => 'required',
        ]);
       
      //  $hashpass = bcrypt($request->oldpass);
      //  echo($hashpass);

//        $user = User::where('pinid', $request['pinid']);
        
      //  echo($request);
      //  dd($request->pinid);
       $hashpass = Auth::user()->password;
       //dd($hashpass);
      //  echo($passlala);
        //exit();
        if(empty($request->newid))
        {
          $request->newid = $request->pinid;
        }
        //  dd("CHECL");
          if(!empty($request->password) && !empty($request->confirm))
          {
            if($request->password == $request->confirm)
              $hashpass = bcrypt($request->password);
            else
            {
              Session::flash('error','Invalid Password & Confirm not similar');
            return redirect()->back()->withInput($request->only('pinid','name','surname','email'));
            }
          //   echo($hashpass);
          }
        
       
        DB::beginTransaction();
        $test = DB::update('update admins set name = ? , surname = ? , email = ? , password = ?, pinid = ? where id = ?', [
          $request->name,$request->surname,$request->email,$hashpass,$request->newid,Auth::user()->id
        ]);

    DB::commit();
       /* $user->name = $request->name;
        $user->surname = $request->surname;
        $user->password = $hashpass;
        $user->email = $request->email;
        $user->users()->attach($pinid);*/
     
    if($test == 1)
    {
        Session::flash('status','Profile Update Successfully');
          return redirect('admin');
        }
        else
        {
          //echo($request->name);
          Session::flash('error','Profile Update unsuccessfull contact administrator');
          return redirect()->back()->withInput($request->only('name','surname','email'));
        }
          return redirect('/admin/courses');
        }
}
