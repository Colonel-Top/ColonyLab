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
class UserController extends Controller
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
    public function getcourse()
    {
    	$courses = Auth::user()->courses;
    	return view('remarks.courseselect',['courses'=>$courses]);
    }
	public function allscore($id)
	{
		//PROBLEM SCORE HERE
		// CROSSING SCORES FOR ONLY COURSE

		//$data = Assignments::with('courses.users')->get();
		//dd($data);
		//$data = $data->where('courses_id',$id);
		
		//dd($id);
		$userid = Auth::user()->id;
		$enrollmentdid = DB::table('enrollment')->select('id')->where([['users_id',$userid],['courses_id',$id]])->get();
		$enrollmentid = $enrollmentdid;
		$enrollmentid = ($enrollmentid->first());
		$enrollmentid = ($enrollmentid->id);
	//	echo($enrollmentid);exit();
		$courseinfo = Courses::FindOrFail($id);
		//QUERU WRONG HERE
$data = DB::select("SELECT *,MAX(scores) as mscores FROM `assignment_work` WHERE enrollments_id = $enrollmentid GROUP BY assignments_id,enrollments_id ORder by scores ASC");
		$asn = Assignments::all();
		//dd($data);

		return view('remarks.show',['data'=>$data,'asn'=>$asn,'course'=>$courseinfo]);
    
	}

}
