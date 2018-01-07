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

		//$request['startdate'] = date('Y-m-d H:i:s', strtotime("$request->startdate $request->starttime"));
		//$request['enddate'] = date('Y-m-d H:i:s', strtotime("$request->enddate $request->endtime"));
		//print_r($request->createby);
		$final="";
		$postData = $request->all();
		if ($file = $request->hasFile('fpath')) 
		{
            $file = $request->file('fpath');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '\\assignments\\'.$request->idc;
            $file->move($destinationPath, $filename);
             $final = $destinationPath.'\\'.$filename;        
            //echo($final);
              
           
            //echo($request->fpath);
            
        }
        $final2="";
        $postData = $request->all();
		if ($file = $request->hasFile('foutput')) 
		{
            $file = $request->file('foutput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '\\assignments\\'.$request->idc.'\\master\\';
            $file->move($destinationPath, $filename);
             $final2 = $destinationPath.'\\'.$filename;        
            //echo($final);
              
           
            //echo($request->fpath);
            
        }
		$res = Assignments::create($postData);

		$res->courses()->attach($res->courses_id);
		Assignments::FindOrFail($res->id)->update(['fpath'=>$final,'foutput'=>$final2]);
		

		
		//$asn = Assignments::FindOrFail
		Session::flash('message1','Assignment Added');
		$coursename = Courses::FindOrFail($request->idc);
		$asn = Assignments::where('courses_id',$request->idc)->get();
		return view(' assignments.index',['asn' => $asn,'course'=>$coursename]);

	}
	public function edit($id){
		$asn = Assignments::find($id);

		return view('assignments.edit',['ids'=>$asn]);
    }
   
    public function update(Request $request)
	{
	
		$this->validate($request,[
			'name' => 'required|max:40',
			'fullscore' => 'required|string|min:1',
			'courses_id' => 'required|min:1',
			'fpath' => 'required|min:1'
			
		]);

		$deleteold = Assignments::FindOrFail($request->idc);
		if(file_exists($request->fname))
			unlink($deleteold->fpath);
		$checkregis = $request['allow_send'];
		
		if(!$checkregis)
		{
   			$request['allow_send'] = "0";
		} 
		$request['courses_id'] = $request->courses_id;
		
	//	$request['createby']= $this->user;
       // echo($request['createby']);
		
		/*if(!empty($request->startdate) && !empty($request->starttime))
			$request['startdate'] = date('Y-m-d H:i:s', strtotime("$request->startdate $request->starttime"));
		if(!empty($request->enddate)&& !empty($request->endtime))
			$request['enddate'] = date('Y-m-d H:i:s', strtotime("$request->enddate $request->endtime"));
		*/
		//print_r($request->createby);
		$final =$request->oldpass;
		$postData = $request->all();
		if ($file = $request->hasFile('fpath')) 
		{

            $file = $request->file('fpath');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '\\assignments\\'.$request->idc;
            $file->move($destinationPath, $filename);
             $final = $destinationPath.'\\'.$filename;        
       
           
        }
       
        $final2="";
        $postData = $request->all();
		if ($file = $request->hasFile('foutput')) 
		{
            $file = $request->file('foutput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '\\assignments\\'.$request->idc.'\\master\\';
            $file->move($destinationPath, $filename);
             $final2 = $destinationPath.'\\'.$filename;        
            //echo($final);
              
           
            //echo($request->fpath);
            
        }

		Assignments::find($request->idc)->update($postData);
		if ($file = $request->hasFile('fpath')) 
		{
			
			Assignments::FindOrFail($request->idc)->update(['fpath'=>$final,'foutput'=>$foutput]);
		}
		$idg = $request->courses_id;
		
		$coursename = Courses::find($idg);
		$asn = Assignments::where('courses_id',$idg)->get();
		return view(' assignments.index',['asn' => $asn,'course'=>$coursename]);
	}
	public function drop($id)
	 {
        //update post data
       // $account = Courses::where('courses_id', $id)->firstOrFail()->courses()->detach();
   		$asn = Assignments::FindOrFail($id);
   		$idg = $asn->courses_id;
   		if(file_exists($asn->fpath))
   			unlink($asn->fpath);
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
