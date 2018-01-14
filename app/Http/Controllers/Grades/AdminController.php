<?php
namespace App\Http\Controllers\Grades;
use App\Courses;
use App\Assignments;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use DB;
use Hash;
class AdminController extends Controller
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
    public function requestmark ($courseid,$userid)
    {
    	//echo($courseid);
    	//echo("<br>");
    	//echo($userid);
    	$userid = User::where('pinid',$userid);
    	$userid = $userid->first()->id;
    	//echo("<br>");
		$enrollmentdid = DB::table('enrollment')->select('id')->where([['users_id',$userid],['courses_id',$courseid]])->get();
		//dd($enrollmentdid);
		$enrollmentid = $enrollmentdid;
		$enrollmentid = ($enrollmentid->first());
		$enrollmentid = ($enrollmentid->id);

	//	echo($enrollmentid);exit();
		$courseinfo = Courses::FindOrFail($id);
		//QUERU WRONG HERE
		$data = DB::select("SELECT *,MAX(scores) as mscores FROM `assignment_work` WHERE enrollments_id = $enrollmentid GROUP BY assignments_id,enrollments_id ORder by scores ASC");
		$asn = Assignments::all();

		return view('remarks.show',['data'=>$data,'asn'=>$asn,'course'=>$courseinfo]);
    }
    public function getcourse()
    {
    	$courses = Auth::user()->courses;
    	return view('remarks.courseselect',['courses'=>$courses]);
    }
    public function selector()
    {
    	return view('remarks.select');
    }
    public function showuser($id)
    {
    	try {
			$courses = Courses::findOrFail($id);
			$users = $courses->users;
		} catch (ModelNotFoundException $e) {
			App::error(404, 'Not found');
		}
		return view('remarks.listuser',['course'=> $courses,'users'=>$users]);
    }
	public function allscore($id,$id2)
	{
		//PROBLEM SCORE HERE
		// CROSSING SCORES FOR ONLY COURSE

		//$data = Assignments::with('courses.users')->get();
		//dd($data);
		//$data = $data->where('courses_id',$id);
		
		//dd($id);
		$userid = $id2;
		$enrollmentdid = DB::table('enrollment')->select('id')->where([['users_id',$userid],['courses_id',$id]])->get();
		$enrollmentid = $enrollmentdid;
		$enrollmentid = ($enrollmentid->first());
		$enrollmentid = ($enrollmentid->id);
	//	echo($enrollmentid);exit();
		
		//QUERU WRONG HERE
$data = DB::select("SELECT *,MAX(scores) as mscores FROM `assignment_work` WHERE enrollments_id = $enrollmentid GROUP BY assignments_id,enrollments_id ORder by scores ASC");
		$asn = Assignments::all();
		dd($data);

		return view('remarks.show',['data'=>$data,'asn'=>$asn]);
    
	}

}
