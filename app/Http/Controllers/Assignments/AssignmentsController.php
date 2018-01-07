<?php
namespace App\Http\Controllers\Assignments;

use App\Assignments;
use App\Courses;
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
    
	public function index($id,Request $request)
	{
		
		
		//$asn = $request->assignments()->courses;
		$coursename = Courses::FindOrFail($id);
		$asn = Assignments::where('courses_id',$id)->get();
		return view(' assignments.index',['asn' => $asn,'course'=>$coursename]);
	}
	public function getUserByName($slug){      
	    $user = User::where('name', $slug)->first();        
	    return $user;
	}
	public function detail($id)
	{
		
		//echo($id);
		$asn = Assignments::FindOrFail($id);
		//echo($asn->fpath);
	//	exit();
		return response()->file($asn->fpath);
    	//return view('assignments.details',['data' => $data]);
	
	}
	
	public function add($id)
	{
		//echo("BULLSHIT");
		return view ('assignments.add',['id'=>$id]);
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
			'name' => 'required|max:40',
			'fullscore' => 'required|string|min:1',
			'fpath' => 'required|min:1',
		
			
		]);
		$checkregis = $request['allow_send'];
		
		if(!$checkregis)
		{
   			$request['allow_send'] = "0";
		} 
		$request['courses_id'] = $request->idc;
		
		
	//	$request['createby']= $this->user;
       // echo($request['createby']);
		if(empty($request['createby']))
    		$request['createby'] = $this->user;

		$request['startdate'] = date('Y-m-d H:i:s', strtotime("$request->startdate $request->starttime"));
		$request['enddate'] = date('Y-m-d H:i:s', strtotime("$request->enddate $request->endtime"));
		//print_r($request->createby);
		
		$postData = $request->all();
		$file = $request->hasFile('fpath');
		
		if($file)
		{
			$request->fpath = $request->fpath->store('storage/uploads/assignments/'.$request->idc,'public');

		}
		$res = Assignments::create($postData);
		$res->courses()->attach($res->id);
		
		

		
		//$asn = Assignments::FindOrFail
		Session::flash('message1','Assignment Added');
		$coursename = Courses::FindOrFail($request->idc);
		$asn = Assignments::where('courses_id',$request->idc)->get();
		return view(' assignments.index',['asn' => $asn,'course'=>$coursename]);

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
	public function drop($id)
	 {
        //update post data
       // $account = Courses::where('courses_id', $id)->firstOrFail()->courses()->detach();
   		$asn = Assignments::FindOrFail($id);
   		$idg = $asn->courses_id;
        $asn->courses()->detach();
        $asn->delete();
       // $courses->delete();
       
        //store status message
        Session::flash('message1', 'Assignment deleted');

        $coursename = Courses::find($idg);
		$asn = Assignments::where('courses_id',$idg)->get();
		return view(' assignments.index',['asn' => $asn,'course'=>$coursename]);
    }
    
    public function request($id)
    {
    //	echo($id);
    	$course = \App\Courses::find($id);
    	return view('assignments.checkowner', ['ids' => $course]);
    }
}
