<?php
namespace App\Http\Controllers\Assignments;

use App\Assignments;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use DB;
use Hash;
class AssignmentsController extends Controller
{
	 protected $user;


    /*
     * Is the user signed In?
     *
     * @var \App\User|null
     */




	public function __construct()
    {
        $this->middleware('auth:admin');
        
    	$this->middleware(function ($request, $next) {
            $this->user = Auth::user()->name;

            return $next($request);
        });
    
    }
    
	public function index($id)
	{
		
		$asn = \App\User::all();

		echo($asn);
		/*$asn = DB::table('assignment_user')->select('assignment_id')->where('courses_id',$id)->get('assignment_id');
		$pool = array();
		foreach($asn as $assignmentid)
		{
			$pool[] = DB::table('assignments')->select()->where('id',$asn)->get();
		}
		foreach($pool as $res)
		{
			echo($pool);
		}*/
		 
		//return view(' assignment.index',['courses' => $courses]);
	}
	public function getUserByName($slug){      
	    $user = User::where('name', $slug)->first();        
	    return $user;
	}
	public function details($id)
	{
		$courses = Courses::find($id);
		$users = DB::table('courses_user')->select('user_id')->where('courses_id',$id)->get('user_id');
		$block = \App\User::all();
		//echo($users);
		$data=[
'courses'=>$courses,
'users'=>$users,
      ];
     /* foreach($block as $uo)
		echo($uo->id);*/
      return view('courses.details',['data' => $data],['block'=>$block]);
		//return view('courses.details',['courses' => $courses],['alluser' => $users],['all'=>$block]);
		//return view('courses.details', compact('courses', 'users','block'));
	}
	
	public function add()
	{
		return view ('courses.add');
	}
	 protected function validator(array $data)
    {
    	
        return Validator::make($data, [
           'coursename' => 'required|max:40',
			'password' => 'required|string|min:1',
			'createby' =>   $this->user,
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

	public function insert(Request $request)
	{
		
	
		$this->validate($request,[
			'coursename' => 'required|max:40',
			'password' => 'required|string|confirmed|min:1',
			'createby' => $this->user,
			
		]);
		$checkregis = $request['allowregister'];
		if(!$checkregis)
		{
   			$request['allowregister'] = "0";
		} 
		$hashpass = bcrypt($request['password']);
		$request['password'] = $hashpass;
		$request['createby'] = $this->user;
        $postData = $request->all();
		Courses::create($postData);
		Session::flash('message1','Courses Added');
		return redirect()->intended(route('admin.courses.index'));

	}
	public function edit(Request $request){
		
		$results = DB::table('courses')->select('password')->where('id',$request->ider)->pluck('password');
		$passlala = $results[0];
		
		$hashpass = bcrypt($request->password);
		
		
	
		if (Hash::check($request->password,$passlala))
			{
				Session::flash('message1','Authorized Successfully!');
				 $course = Courses::find($request->ider);
       
       			 //load form view
        		return view('courses.edit', ['courses' => $course]);
			}
			else
			{
				//echo("BULLSHIT");
				Session::flash('message1','Wrong Password / Cannot Authorization');
				return redirect()->back();
			}
		/*

		Session::flash('success_msg','Courses Checking');
    
    	$this->validate($request,[
			'password' => 'required|string|min:1',
			
		]);
             $results = DB::select('select * from courses where id = :name', ['name' => $request->id]);

			if ($results && Hash::check($request['password'],$results->password)) 
			{
				Session::flash('success_msg','Courses OK');
				 $course = Courses::find($request['ider']);
       
       			 //load form view
        			//return view('courses.edit', ['courses' => $course]);
				
			}
			else
			{
				echo("BULLSHIT");
				Session::flash('warning','Courses Fuckup');
				//return redirect()->back();
			}

       
        $course = Courses::find($id);
        
        //load form view
        return view('courses.edit', ['courses' => $course]);*/
    }
   
    public function update($id,Request $request)
	{
		$this->validate($request,[
			'coursename' => 'required|max:40',
			'password' => 'required|string|min:1',
			'createby' =>  $this->user,
			
		]);
		$checkregis = $request['allowregister'];
		if(!$checkregis)
		{
   			$request['allowregister'] = "0";
		} 
		
		$hashpass = bcrypt($request['password']);
		$request['password'] = $hashpass;
		$request['createby'] = $this->user;
		$postData = $request->all();
		Courses::find($id)->update($postData);
		Session::flash('message1','Courses Updated');
		return redirect()->intended(route('admin.courses.index'));

	}
	 public function delete($id)
	 {
        //update post data
        Courses::find($id)->delete();
        
        //store status message
        Session::flash('message1', 'Course deleted');

        return redirect()->route('admin.courses.index');
    }
    
    public function request($id)
    {

    	$course = Courses::find($id);
    		return view('courses.checkowner', ['ids' => $course]);
    }
}
