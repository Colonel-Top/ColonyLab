<?php
namespace App\Http\Controllers\Courses;

use App\User;
use App\Courses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use DB;
use Hash;
class CoursesController extends Controller
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
    
	public function index()
	{
	//	Session::flash('success_msg','Authorized Successfully!');
		$courses = Courses::orderBy('created','desc')->get();


		return view(' courses.index',['courses' => $courses]);
	}
	public function getUserByName($slug){      
	    $user = User::where('name', $slug)->first();        
	    return $user;
	}
	public function details($id)
	{
		try {
			$courses = Courses::findOrFail($id);
			$users = $courses->users;
		} catch (ModelNotFoundException $e) {
			App::error(404, 'Not found');
		}
		return view('courses.details',['course'=> $courses,'users'=>$users]);
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
				Session::flash('message1','Wrong Password / Cannot Authorization');
				return redirect()->back();
			}
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
       // $account = Courses::where('courses_id', $id)->firstOrFail()->courses()->detach();
   		$courses = Courses::find($id);
        $courses->users()->detach();
        $courses->delete();
       // $courses->delete();
       
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
