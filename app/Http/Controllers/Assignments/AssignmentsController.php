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
	public function show($id)
	{
		
		//echo($id);
		$asninfo = Assignments::FindOrFail($id);
		$data = DB::table('assignment_work')->select()->where('assignments_id',$id)->get();
	//	dd($data);
		//$course = $asninfo->courses();

		//$blah = Assignments::with('courses.users')->where('id',$id)->get();

		/*$blah = \App\User::with('courses.assignments')->where('courses_id'
			,$asninfo->courses_id)->get();
*/
		//	dd($asninfo);
		$blah = Assignments::with('courses.users')->where('id',$asninfo->id)->get();
		//dd($blah);
		/*foreach ($blah as $pr) {
			# code...
		
			echo($pr);
		}	*/
		//exit();

		//print_r($course->users());exit();	
		//$blah = \App\User::all();
		//dd($blah->courses->id);
		return view('assignments.show',['asninfo'=>$asninfo,'data'=>$data,'userdetails'=>$blah]);
	
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
	public function droper($id)
	{
		//dd($id);
		//$users_id = Auth::user()->id;
        $filep = DB::table('assignment_work')->where('id',$id)->delete();
		if($filep)
			return redirect()->back()->with(Session::flash('message1','Delete Assignment Successfully'));
		return redirect()->back()->with(Session::flash('error','Delete Assignment FAILD'));
	}
	public function callmaster1($id)
	{
		$asn = Assignments::FindOrFail($id);
		$name = $asn->finput;
		if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
		return response()->file($name);
	}
	public function callout1($id)
	{
		$asn = Assignments::FindOrFail($id);
		$name = $asn->foutput;
		if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
		return response()->file($name);
	}
	public function callmaster2($id)
	{
		$asn = Assignments::FindOrFail($id);
		$name = $asn->finput2;
		if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
		return response()->file($name);
	}

	public function callout2($id)
	{
		$asn = Assignments::FindOrFail($id);
		$name = $asn->foutput2;
		if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
		return response()->file($name);
	}
	public function callmaster3($id)
    {
        $asn = Assignments::FindOrFail($id);
        $name = $asn->finput3;
        if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
        return response()->file($name);
    }
    public function callout3($id)
    {
        $asn = Assignments::FindOrFail($id);
        $name = $asn->foutput3;
        if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
        return response()->file($name);
    }
    public function callmaster4($id)
    {
        $asn = Assignments::FindOrFail($id);
        $name = $asn->finput4;
        if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
        return response()->file($name);
    }
    public function callout4($id)
    {
        $asn = Assignments::FindOrFail($id);
        $name = $asn->foutput4;
        if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
        return response()->file($name);
    }
    public function callmaster5($id)
    {
        $asn = Assignments::FindOrFail($id);
        $name = $asn->finput5;
        if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
        return response()->file($name);
    }
    public function callout5($id)
    {
        $asn = Assignments::FindOrFail($id);
        $name = $asn->foutput5;
        if(empty($name))
			return redirect()->back()->with(Session::flash('error','There\'s Empty Files'));
        return response()->file($name);
    }
	public function callpath($id)
	{
		
		$filep = DB::table('assignment_work')->select('users_ans')->where('id',$id)->first();
		;
		return response()->file($filep->users_ans);
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
    public function maxscoreshow($id)
    {
    	$asninfo = Assignments::FindOrFail($id);
		$data = DB::table('assignment_work')->select()->where('assignments_id',$id)->get();

	//D OTH IS  FIRST !
/*
Config File: /etc/mysql/my.cnf
sql-mode="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"
		$data = DB::select('Select * from (select * from `assignment_work` order by id ASC, scores ASC) as v group by `pinid`');
*/
/*$data = DB::select('SELECT * FROM `assignment_work` where id IN (SELECT id from `assignment_work` order by id asc , scores asc) GROUP BY `pinid` AND `assignments_id` = :id',['id'=>$id]);
*/
$data = DB::select('SELECT id ,MAX(scores) as scores,name,`pinid`,`users_ans`,`assignments_id`,`enrollments_id`,`created_at`,`updated_at`
FROM
    (SELECT *
    FROM `assignment_work`
    WHERE assignments_id = :id
	ORDER BY scores ASC)
AS employeesub
GROUP BY employeesub.pinid ',['id' => $id]);
	//	dd($data);


		$blah = Assignments::with('courses.users')->where('id',$asninfo->id)->get();
	
		return view('assignments.show',['asninfo'=>$asninfo,'data'=>$data,'userdetails'=>$blah]);
    }
    public function showremark($id)
    {/* // Using the Query Builder
 DB::table('orders')->find(DB::table('orders')->max('id'));

 // Using Eloquent
 $order = Orders::find(DB::table('orders')->max('id'));*/
				//Session::flash('message1','Authorized Successfully!');
				 $course = Courses::find($id);
       			$coursename = $course->name;
       			 //load form view
        		$asn = Assignments::where('courses_id',$id)->get();
		return view(' assignments.mainremark',['asn' => $asn,'course'=>$coursename]);
		//echo($id);
 	/*	$allcourse = Courses::FindOrFail($id);
 		$asninfo = Assignments::where('courses_id',$allcourse->id)->get();
 		//dd($asninfo);
	//	$asninfo = Assignments::FindOrFail($id);
		$data = DB::table('assignment_work')->select()->where('assignments_id',$id)->get();
		$blah = Assignments::with('courses.users')->where('id',$asninfo->id)->get();
		//dd($blah);
		return view('assignments.mainremark',['asninfo'=>$asninfo,'data'=>$data,'userdetails'=>$blah]);*/
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

	public function insert(Request $request)
	{
		//dd($request->courses_id);
		
		
		$this->validate($request,[
			'name' => 'required|max:40',
			'fullscore' => 'required|string|min:1',
			'fpath' => 'required|min:1',
		
			
		]);
		
       // print_r($request->courses_id);exit();
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
     //   $postData = $request->all();
		if ($file = $request->hasFile('foutput')) 
		{
            $file = $request->file('foutput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final2 = $destinationPath.'//'.$filename;        
            
        }
        $final3="";
     //   $postData = $request->all();
		if ($file = $request->hasFile('finput')) 
		{
            $file = $request->file('finput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final3 = $destinationPath.'//'.$filename;        
            
        }

        $final4="";
     //   $postData = $request->all();
		if ($file = $request->hasFile('finput2')) 
		{
            $file = $request->file('finput2');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final4 = $destinationPath.'//'.$filename;        
            
        }
         $final5="";
      //  $postData = $request->all();
		if ($file = $request->hasFile('finput3')) 
		{
            $file = $request->file('finput3');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final5 = $destinationPath.'//'.$filename;        
            
        }
       	$final6="";
       // $postData = $request->all();
		if ($file = $request->hasFile('finput4')) 
		{
            $file = $request->file('finput4');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final6 = $destinationPath.'//'.$filename;        
            
        }
       	$final7="";
       // $postData = $request->all();
		if ($file = $request->hasFile('finput5')) 
		{
            $file = $request->file('finput5');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final7 = $destinationPath.'//'.$filename;        
        }
        $final8="";
        //$postData = $request->all();
		if ($file = $request->hasFile('foutput2')) 
		{
            $file = $request->file('foutput2');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final8 = $destinationPath.'//'.$filename;        
        }
        $final9="";
        //$postData = $request->all();
		if ($file = $request->hasFile('foutput3')) 
		{
            $file = $request->file('foutput3');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final9 = $destinationPath.'//'.$filename;        
        }
        $final10="";
       // $postData = $request->all();
		if ($file = $request->hasFile('foutput4')) 
		{
            $file = $request->file('foutput4');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final10 = $destinationPath.'//'.$filename;        
        }
         $final11="";
        
		if ($file = $request->hasFile('foutput5')) 
		{
            $file = $request->file('foutput5');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final11 = $destinationPath.'//'.$filename;        
        }

        //$postData = $request->all();
		
		//2018-01-06 12:43:45
		
			
		$starttime = $request->SYear.'-'.$request->SMonth.'-'.$request->SDay.' '.$request->SHour.':'.$request->SMinute.':'.$request->SSecond;
		$endtime = $request->EYear.'-'.$request->EMonth.'-'.$request->EDay.' '.$request->EHour.':'.$request->EMinute.':'.$request->ESecond;
		 $starttime = date('Y-m-d H:i:s', strtotime("$starttime"));
		 $endtime = date('Y-m-d H:i:s', strtotime("$endtime"));
		//echo($request->starttime);exit();
	
		$postData = $request->except('SHour','SMinute','SSecond','SDay','SMonth','SYear','EHour','EMonth','EYear','EMinute','ESecond');
		$assignment = Assignments::create($postData);
		$assignment->starttime = $starttime;
		$assignment->endtime = $endtime;
		$assignment->fpath = $final;
		$assignment->foutput = $final2;
		$assignment->finput = $final3;
		$assignment->finput2 = $final4;
		$assignment->finput3 = $final5;
		$assignment->finput4 = $final6;
		$assignment->finput5 = $final7;
		$assignment->foutput2 = $final8;
		$assignment->foutput3 = $final9;
		$assignment->foutput4 = $final10;
		$assignment->foutput5 = $final11;
		if(empty($request->max_attempts))
			$assignment->max_attempts = 0;
		//print_r($assignment);

		$assignment->save();

		
		

		
		//$asn = Assignments::FindOrFail
		Session::flash('message1','Assignment Added');
		$coursename = Courses::FindOrFail($request->courses_id);
		$asn = Assignments::where('courses_id',$request->courses_id)->get();
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
     //   $postData = $request->all();
		if ($file = $request->hasFile('foutput')) 
		{
            $file = $request->file('foutput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final2 = $destinationPath.'//'.$filename;        
            
        }
        $final3="";
     //   $postData = $request->all();
		if ($file = $request->hasFile('finput')) 
		{
            $file = $request->file('finput');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final3 = $destinationPath.'//'.$filename;        
            
        }

        $final4="";
     //   $postData = $request->all();
		if ($file = $request->hasFile('finput2')) 
		{
            $file = $request->file('finput2');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final4 = $destinationPath.'//'.$filename;        
            
        }
         $final5="";
      //  $postData = $request->all();
		if ($file = $request->hasFile('finput3')) 
		{
            $file = $request->file('finput3');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final5 = $destinationPath.'//'.$filename;        
            
        }
       	$final6="";
       // $postData = $request->all();
		if ($file = $request->hasFile('finput4')) 
		{
            $file = $request->file('finput4');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final6 = $destinationPath.'//'.$filename;        
            
        }
       	$final7="";
       // $postData = $request->all();
		if ($file = $request->hasFile('finput5')) 
		{
            $file = $request->file('finput5');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//input//';
            $file->move($destinationPath, $filename);
             $final7 = $destinationPath.'//'.$filename;        
        }
        $final8="";
        //$postData = $request->all();
		if ($file = $request->hasFile('foutput2')) 
		{
            $file = $request->file('foutput2');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final8 = $destinationPath.'//'.$filename;        
        }
        $final9="";
        //$postData = $request->all();
		if ($file = $request->hasFile('foutput3')) 
		{
            $file = $request->file('foutput3');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final9 = $destinationPath.'//'.$filename;        
        }
        $final10="";
       // $postData = $request->all();
		if ($file = $request->hasFile('foutput4')) 
		{
            $file = $request->file('foutput4');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final10 = $destinationPath.'//'.$filename;        
        }
         $final11="";
        
		if ($file = $request->hasFile('foutput5')) 
		{
            $file = $request->file('foutput5');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$request->idc.'//master//';
            $file->move($destinationPath, $filename);
             $final11 = $destinationPath.'//'.$filename;        
        }
        
        
		
		if($request->editdate == "on")
		{
			
		$starttime = $request->SYear.'-'.$request->SMonth.'-'.$request->SDay.' '.$request->SHour.':'.$request->SMinute.':'.$request->SSecond;
		$endtime = $request->EYear.'-'.$request->EMonth.'-'.$request->EDay.' '.$request->EHour.':'.$request->EMinute.':'.$request->ESecond;
		 $request->starttime = date('Y-m-d H:i:s', strtotime("$starttime"));
		 $request->endtime = date('Y-m-d H:i:s', strtotime("$endtime"));
		//echo($request->starttime);exit();
		}
		$postData = $request->except('SHour','SMinute','SSecond','SDay','SMonth','SYear','EHour','EMonth','EYear','EMinute','ESecond');
		
		Assignments::find($request->idc)->update($postData);
		if($request->editdate == "on")
		{
		Assignments::find($request->idc)->update(['starttime'=>$request->starttime]);
		Assignments::find($request->idc)->update(['endtime'=>$request->endtime]);
		}
		if ($file = $request->hasFile('fpath')) 
		{
			Assignments::FindOrFail($request->idc)->update(['fpath'=>$final]);
		}
		if(empty($request->max_attempts))
			Assignments::FindOrFail($request->idc)->update(['max_attempts'=>0]);
		if ($file = $request->hasFile('foutput')) 
			Assignments::FindOrFail($request->idc)->update(['foutput'=>$final2]);
		if ($file = $request->hasFile('finput')) 
			Assignments::FindOrFail($request->idc)->update(['finput'=>$final3]);
		if ($file = $request->hasFile('finput2')) 
			Assignments::FindOrFail($request->idc)->update(['finput2'=>$final4]);
		if ($file = $request->hasFile('finput3')) 
			Assignments::FindOrFail($request->idc)->update(['finput3'=>$final5]);
		if ($file = $request->hasFile('finput4')) 
			Assignments::FindOrFail($request->idc)->update(['finput4'=>$final6]);
		if ($file = $request->hasFile('finput5')) 
			Assignments::FindOrFail($request->idc)->update(['finput5'=>$final7]);
		if ($file = $request->hasFile('foutput2')) 
			Assignments::FindOrFail($request->idc)->update(['foutput2'=>$final8]);
		if ($file = $request->hasFile('foutput3')) 
			Assignments::FindOrFail($request->idc)->update(['foutput3'=>$final9]);
		if ($file = $request->hasFile('foutput4')) 
			Assignments::FindOrFail($request->idc)->update(['foutput4'=>$final10]);
		if ($file = $request->hasFile('foutput5')) 
			Assignments::FindOrFail($request->idc)->update(['foutput5'=>$final11]);
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
        $asn->courses()->dissociate();
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
