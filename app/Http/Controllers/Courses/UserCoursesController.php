<?php
namespace App\Http\Controllers\Courses;
use App\Courses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use DB;
use Hash;
class UserCoursesController extends Controller
{
	 protected $user;


    /*
     * Is the user signed In?
     *
     * @var \App\User|null
     */




	public function __construct()
    {
        $this->middleware('auth');
        
    	$this->middleware(function ($request, $next) {
            $this->user = Auth::user()->name;

            return $next($request);
        });
    
    }
	public function index()
	{
		$ids = 0;
	//	Session::flash('success_msg','Authorized Successfully!');
		$courses = Courses::orderBy('created','desc')->get();
		$chkid = Auth::user()->noid;
		$amount = DB::table('courses_user')->select('courses_id')->where('user_id',$chkid)->get('courses_id');
		foreach($amount as $data)
		{
		//echo($data->courses_id);
		
			if($data->courses_id)
			{
				$ids = 1;
			}
		}
		//echo($amount);
		
		return view('courses.courselist',['courses' => $courses],['targetc' => $amount]);
	}

	public function details($id)
	{
		$ids = 0;
		$courses = Courses::find($id);
		$chkid = Auth::user()->noid;
		$amount = DB::table('courses_user')->select('courses_id')->where('user_id',$chkid)->get('courses_id');
		foreach($amount as $data)
		{
		//echo($data->courses_id);
		
			if($data->courses_id == $id)
			{
				$ids = 1;
			}
		}
		//echo($ids);
		return view('courses.detailsuser',['courses' => $courses],['noid' => $ids]);
	}
	public function enroll($id,Request $request)
	{
		$results = DB::table('courses')->select('password')->where('id',$request->ider)->pluck('password');
		$passlala = $results[0];
		$allowreg = DB::table('courses')->select('allowregister')->where('id',$request->ider)->pluck('allowregister');
		$allowreg = $allowreg[0];
		$hashpass = bcrypt($request->password);
		
			if (Hash::check($request->password,$passlala) && $allowreg== 1)
			{
				Session::flash('message1','Authorized Enroll Course Successfully!');
				$course = Courses::find($request->ider);
       			
       			$course->users()->attach([Auth::user()->noid]);
       			/*echo($course);
       			 $res = \App\User::with('courses')->get(); 
       			echo($res);*/
 
       			 //load form view
       			$courses = Courses::orderBy('created','desc')->get();
        		return redirect('/user/courses/courselist');

			}
			else if($allowreg ==0)
			{
				Session::flash('message1','Course Registeration is Closed Contact your Course owner');
				return redirect()->back();
			}
			else
			{
				//echo("BULLSHIT");
				Session::flash('message1','Wrong Password / Cannot Authorization');
				return redirect()->back();
			}
		
	}
	public function request($id)
    {
    	$ids = 0;
    	$chkid = Auth::user()->noid;
    	$amount = DB::table('courses_user')->select('courses_id')->where('user_id',$chkid)->get('courses_id');
		foreach($amount as $data)
		{
		//echo($data->courses_id);
		
			if($data->courses_id == $id)
			{
				$ids = 1;
			}
		}
		if($ids == 1)
		{
			Session::flash('error','You already Enroll this Course !');
			return redirect()->back();
		}
    	$course = Courses::find($id);
    	return view('courses.enroll', ['ids' => $course]);
    }

}
