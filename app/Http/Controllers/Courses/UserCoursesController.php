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
	public function index(Request $request)
	{
		$ids = 0;
	//	Session::flash('success_msg','Authorized Successfully!');
		$courses = Courses::orderBy('created','desc')->get();
		$chkid = Auth::user()->noid;

		//$user = Auth::user();
		$user = $request->user();
		$courses = $user->courses;

		$allCourses = Courses::all();



		return view('courses.courselist',[
			
			'allCourses' => $allCourses

		]);
	}
	public function indexmy(Request $request)
	{
		$ids = 0;
	//	Session::flash('success_msg','Authorized Successfully!');
		/*
		$courses = Courses::orderBy('created','desc')->get();
		$chkid = Auth::user()->noid;
		$amount = DB::table('enrollment')->select('courses_id')->where('users_id',$chkid)->get('courses_id');
		*/
		$courses = $request->user()->courses;
		
		
		return view('courses.mycourses',['courses' => $courses]);
	}

	public function details($id)
	{
	
		$courses = Courses::FindOrFail($id);
		$user = $courses->users;
		$register = count($user) ? "1":"0";
		
			return view('courses.detailsuser',['courses' => $courses,'isregis'=>$register]);
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
				
				$course = Courses::find($request->ider);



				$user = $request->user();
				$cc = $user->courses;
				foreach($cc as $singlec)
				{
					$idchk = $cc;
					foreach($idchk as $cid)
					{
						//echo($cid->id);
						//echo($request->ider);
						if($cid->id == $request->ider)	
							return redirect()->back()->with(Session::flash('error','You already Enroll this course !'));
					}
					
				}
				//exit(); 
				$user->courses()->attach($course->id);	
			
       			$courses = Courses::orderBy('created','desc')->get();
       			Session::flash('message1','Authorized Enroll Course Successfully!');
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
    	$amount = DB::table('enrollment')->select('courses_id')->where('users_id',$chkid)->get('courses_id');
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
