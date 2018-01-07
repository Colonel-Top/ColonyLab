<?php
namespace App\Http\Controllers\Assignments;

use App\Assignments;
use App\Courses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Carbon\Carbon;
use DB;
use Hash;
use Response;
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

		$results = DB::table('courses')->select('password')->where('id',$request->ider)->pluck('password');
		$passlala = $results[0];
		
		$hashpass = bcrypt($request->password);
		
		
	
		if (Hash::check($request->password,$passlala))

			{
				Session::flash('message1','Authorized Successfully!');
				 $course = Courses::find($request->ider);
       
       			 //load form view
        		$asn = Assignments::where('courses_id',$id)->get();
		return view(' assignments.index',['asn' => $asn,'course'=>$coursename]);
			}
			else
			{
				Session::flash('message1','Wrong Password / Cannot Authorization');
				return redirect()->back();
			}
		

		
	}
	public function getUserByName($slug){      
	    $user = User::where('name', $slug)->first();        
	    return $user;
	}
	public function detail($id,Response $response)
	{
		
		//echo($id);
		$asn = Assignments::FindOrFail($id);
		//echo($asn->fpath);
	//	exit();
		$name = $asn->name;
		//$response->headers->set('name',$name);

		
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
		$tmpstart = Carbon::parse($request->starttime);
		$tmpend = Carbon::parse($request->endtime);
	
		$request['starttime'] = Carbon::parse($request->starttime);
		$request['endtime'] = Carbon::parse($request->endtime);
		$this->validate($request,[
			'name' => 'required|max:40',
			'fullscore' => 'required|string|min:1',
			'fpath' => 'required|min:1',
		
			
		]);
		$checkregis = $request['allow_send'];
		if(($checkregis) == "on")
		{
   			$request['allow_send'] = "1";
		} 
		else
			$request['allow_send'] = "0";
		
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
            $destinationPath = storage_path() . '//assignments//'.$request->idc;
            $file->move($destinationPath, $filename);
             $final = $destinationPath.'//'.$filename;        
            //echo($final);
              
           
            //echo($request->fpath);
            
        }
        $final2="";
        $postData = $request->all();
		if ($file = $request->hasFile('foutput')) 
		{
            $file = $request->file('foutput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final2 = $destinationPath.'//'.$filename;        
        }
        $final3="";
        $postData = $request->all();
		if ($file = $request->hasFile('finput')) 
		{
            $file = $request->file('finput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final3 = $destinationPath.'//'.$filename;        
            
        }
		$assignment = Assignments::create($postData);
		$assignment->fpath = $final;
		$assignment->foutput = $final2;
		$assignment->finput = $final3;
		$assignment->save();

		
		

		
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
	//	echo($request->allow_send);exit();
		/*$tmp = Assignments::find($request->idc);
		$tmpstart = Carbon::parse($request->starttime);
		$tmpend = Carbon::parse($request->endtime);
		dd($tmpstart);dd($tmpend);exit();
		/*
		if(!empty($tmpstart))
			$request['starttime'] = $tmpstart;
		else
			$request['starttime'] = $tmp->starttime;
		if(!empty($tmpstart))
			$request['endtime'] = $tmpend ;
		else
			$request['endtime'] = $tmp->endtime;
*/
		$this->validate($request,[
			'name' => 'required|max:40',
			'fullscore' => 'required|string|min:1',
			'courses_id' => 'required|min:1',
			//'starttime' => 'required'
			
		]);

		$deleteold = Assignments::FindOrFail($request->idc);
		if(file_exists($request->fname))
			unlink($deleteold->fpath);
		$checkregis = $request['allow_send'];
		
		if(($checkregis) == "on")
		{
   			$request['allow_send'] = "1";
		} 
		else
			$request['allow_send'] = "0";
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
            $destinationPath = storage_path() . '//assignments//'.$request->idc;
            $file->move($destinationPath, $filename);
             $final = $destinationPath.'//'.$filename;        
       
           
        }
       
        $final2="";
        $postData = $request->all();
		if ($file = $request->hasFile('foutput')) 
		{
            $file = $request->file('foutput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final2 = $destinationPath.'//'.$filename;        
            
        }
        $final3="";
        $postData = $request->all();
		if ($file = $request->hasFile('finput')) 
		{
            $file = $request->file('finput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final3 = $destinationPath.'//'.$filename;        
            
        }
		Assignments::find($request->idc)->update($postData);
		if ($file = $request->hasFile('fpath')) 
		{
			Assignments::FindOrFail($request->idc)->update(['fpath'=>$final]);
		}
		if ($file = $request->hasFile('foutput')) 
		{
			Assignments::FindOrFail($request->idc)->update(['foutput'=>$final2]);
		}
		if ($file = $request->hasFile('finput')) 
		{
			Assignments::FindOrFail($request->idc)->update(['finput'=>$final3]);
			//dd($final3);
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
        //$asn->courses()->detach([$id]);
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
