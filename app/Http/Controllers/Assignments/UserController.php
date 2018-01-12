<?php

namespace App\Http\Controllers\Assignments;
ini_set('max_execution_time', 300);
use App\Courses;
use App\User;
use App\Assignments;
use File;
use DB;
use Session;
use Hash;
use Response;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
class UserController extends Controller
{
	public function indexmy($id,Request $request)
	{

		/*$user = $request->user();
		$course = $user->courses;
**/
		$courses_id = $id;
		$course = Courses::find($id);
		$course = $course->coursename;
		$asn = \App\Assignments::where('courses_id',$courses_id)->get();

		return view('assignments.main',['asn'=>$asn,'course'=>$course]);
	}
    public function callpath($id)
    {

        $filep = DB::table('assignment_work')->select('users_ans')->where('id',$id)->first();
        return response()->file($filep->users_ans);
    }
	public function score($id,Request $request)
	{
        //$score = DB::table('assignment_work')->where('id',$id)
       
        
       // dd(Auth::user()->pinid);
        $asninfo = Assignments::FindOrFail($id);
        $data = DB::table('assignment_work')->select()->where([['assignments_id',$id],['pinid',Auth::user()->pinid]])->get();

        $blah = Assignments::with('courses.users')->where('id',$asninfo->id)->get();
        return view('assignments.showcustom',['asninfo'=>$asninfo,'data'=>$data,'userdetails'=>$blah]);
    
    

	}



function ExecWaitTimeout($cmd, $timeout=5) {
 
  $descriptorspec = array(
      0 => array("pipe", "r"),
      1 => array("pipe", "w"),
      2 => array("pipe", "w")
  );
  $pipes = array();
 
  $timeout += time();
  $process = proc_open($cmd, $descriptorspec, $pipes);
  if (!is_resource($process)) {
    throw new Exception("proc_open failed on: " . $cmd);
  }
 
  $output = '';
 
  do {
    $timeleft = $timeout - time();
    $read = array($pipes[1]);
    stream_select($read, $write = NULL, $exeptions = NULL, $timeleft, NULL);
 
    if (!empty($read)) {
      $output .= fread($pipes[1], 8192);
    }
  } while (!feof($pipes[1]) && $timeleft > 0);
 
  if ($timeleft <= 0) {
    proc_terminate($process);
    throw new Exception("command timeout on: " . $cmd);
  } else {
    return $output;
  }
}

public function push(Request $request)
	{
        
        $maxsecond = 6;
		$asn = Assignments::find($request->id);
        $ex_s = Carbon::now();

        $get = $asn->endtime;

        $nowY = date('Y', strtotime("$ex_s"));
        $nowM = date('m', strtotime("$ex_s"));
        $nowD = date('d', strtotime("$ex_s"));
        $nowH = date('H', strtotime("$ex_s"));
        $nowI = date('i', strtotime("$ex_s"));
        $nowS = date('s', strtotime("$ex_s"));

        $gyear = date('Y', strtotime("$get"));
        $gmonth = date('m', strtotime("$get"));
        $gday = date('d', strtotime("$get"));
        $ghour = date('H', strtotime("$get"));
        $gmin = date('i', strtotime("$get"));
        $gsecond = date('s', strtotime("$get"));
   
        if($nowY <= $gyear)
       {
            if($nowM <= $gmonth)
                if($nowD <= $gday)
                    if($nowH <= $ghour)
                        if($nowI <= $gmin)
                            if($nowS  <= $gsecond)
                            {
                                if($asn->allow_send == 0)
                                {
                               // Session::flash('message1','This Assignment ok!');
                                 return redirect()->back();}
                            }
           //Session::flash('message1','Error This Assignment already remarks time is up !');
           
        }

       // echo(Auth::user()->pinid);
		//echo($asn);exit();
		$final ="";
        $filename="";
        $destinationPath = storage_path() . '//assignments//'.$asn->id.'//user_upload//'.Auth::user()->pinid.'//';
        if ($file = $request->hasFile('users_ans')) 
        {
            $file = $request->file('users_ans');
            $filename =$file->getClientOriginalName();
            if (strpos($filename, ' ') !== false) {
               return view('courses.large');
            }
           
            $file->move($destinationPath, $filename);
             $final = $destinationPath.$filename;       
            // echo($final) ;
        }
        $reject = "c";
        $reject2 = "c";
        $command = $asn->language;
        //echo("Hi");
       // echo($final);
        //echo($asn->finput);exit();
        if($command == "c")
        {
        	
        //	$reject2 = 'gcc '.$final;
            $allscore = $asn->fullscore;
            $requireamount = 0;
            if(!empty($asn->finput))
                $requireamount++;
            if(!empty($asn->finput2))
                $requireamount++;
            if(!empty($asn->finput3))
                $requireamount++;
            if(!empty($asn->finput4))
                $requireamount++;
            if(!empty($asn->finput5))
                $requireamount++;
            $per_asn = $asn->fullscore/$requireamount;
            $sum = 0;
            $filename = str_replace(".c","",$filename);

            //gcc file.c -o directory/myOutput

            $executeq = 'gcc -o '.$destinationPath.' '.$final.' 2> '.$destinationPath.'error-'.$filename;
           dd($executeq);
            $result = shell_exec($executeq);    
            $checkpath = $destinationPath.'error-'.$filename;
           // dd($checkpath);
            $errorpath = File::get($checkpath);
           //dd($checkpath);
            if(!empty($errorpath))
            {
                str_replace($destinationPath, "Compiler:", $errorpath);
                return view('assignments.error',['errorpath'=>$errorpath]);
            }
            $inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';

            /* Checking Injection Zone */
            $injection = '"java -cp '.$destinationPath.' '.$filename.' < '.$asn->finput.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/runtime.py '.$injection;
            exec($command, $output,$return_value);

            if($return_value == 1)
                return  view('assignments.infinity');
            
            $restore = File::get($asn->foutput);
            $getject = $destinationPath.$filename.'.txt';
            $geter = File::get($getject);
            $whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;
            //unlink($checkpath);
            unlink($getject);
            /* Checking Injection Zone */
        }
        else if($command == "java")
        {

        	$allscore = $asn->fullscore;
        	$requireamount = 0;
        	if(!empty($asn->finput))
        		$requireamount++;
        	if(!empty($asn->finput2))
        		$requireamount++;
        	if(!empty($asn->finput3))
        		$requireamount++;
        	if(!empty($asn->finput4))
        		$requireamount++;
        	if(!empty($asn->finput5))
        		$requireamount++;
        	$per_asn = $asn->fullscore/$requireamount;
        	$sum = 0;
            $filename = str_replace(".java","",$filename);

            $executeq = 'javac -encoding "unicode" -d '.$destinationPath.' '.$final.' 2> '.$destinationPath.'error-'.$filename;
          //  print_r($executeq);
        	$result = shell_exec($executeq);	
            $checkpath = $destinationPath.'error-'.$filename;
           // dd($checkpath);
            $errorpath = File::get($checkpath);
            $classpath = file_exists($destinationPath.$filename.'.class');
           // dd($classpath);
            if(!empty($errorpath) && $classpath == 0)
            {
                
                                $errorpath = File::get($checkpath);
                                //$classpath = file_exists($destinationPath.$filename.'.class');
                                unlink($checkpath);
                                if (strpos($errorpath, '\u') !== false) {
                                   $executeq = 'javac -d '.$destinationPath.' '.$final.' 2> '.$destinationPath.'error-'.$filename;
                                  //  print_r($executeq);
                                    $result = shell_exec($executeq);    
                                    $checkpath = $destinationPath.'error-'.$filename;
                                   // dd($checkpath);
                                    $errorpath = File::get($checkpath);
                                    $classpath = file_exists($destinationPath.$filename.'.class');
                                    unlink($checkpath);
                                    $tmper = str_replace("//",  "/", $destinationPath);
                                    $showme = str_replace($tmper, "Compiler:", $errorpath);
                                    return view('assignments.error',['errorpath'=>$showme]);
                                }
                                $tmper = str_replace("//",  "/", $destinationPath);
                                $showme = str_replace($tmper, "Compiler:", $errorpath);
                                return view('assignments.error',['errorpath'=>$showme]);


                
            }
            echo("ok");
            exit();
            $time = now();
            $time = str_replace(" ", "-", $time);
            $time = str_replace(":", "-", $time);
            $filename = $time.$filename;
            //move file go to place
			$inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';

            /* Checking Injection Zone */
			$injection = '"java -cp '.$destinationPath.' '.$filename.' < '.$asn->finput.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/runtime.py '.$injection;
            exec($command, $output,$return_value);
            //dd($return_value);
            if($return_value == 1)
                return  view('assignments.infinity');
            
        	$restore = File::get($asn->foutput);
        	$getject = $destinationPath.$filename.'.txt';
        	$geter = File::get($getject);
        	$whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;
            unlink($checkpath);
            unlink($getject);

            /* Checking Injection Zone */
        //--------------------------   
        if (!empty($asn->finput2)) 
        {
        	   
        		/* Checking Injection Zone */
            $injection = '"java -cp '.$destinationPath.' '.$filename.' < '.$asn->finput2.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/runtime.py '.$injection;
            exec($command, $output,$return_value);

            if($return_value == 1)
                return  view('assignments.infinity');
            
            $restore = File::get($asn->foutput2);
            $getject = $destinationPath.$filename.'.txt';
            $geter = File::get($getject);
            $whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;
            //unlink($checkpath);
            unlink($getject);
            /* Checking Injection Zone */
        }
        //--------------------------   //--------------------------   
        if (!empty($asn->finput3)) 
        {
               
                /* Checking Injection Zone */
            $injection = '"java -cp '.$destinationPath.' '.$filename.' < '.$asn->finput3.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/runtime.py '.$injection;
            exec($command, $output,$return_value);

            if($return_value == 1)
                return  view('assignments.infinity');
            
            $restore = File::get($asn->foutput3);
            $getject = $destinationPath.$filename.'.txt';
            $geter = File::get($getject);
            $whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;
           // unlink($checkpath);
            unlink($getject);
            /* Checking Injection Zone */
        }
        //--------------------------   
        if (!empty($asn->finput4)) 
        {
               
                /* Checking Injection Zone */
            $injection = '"java -cp '.$destinationPath.' '.$filename.' < '.$asn->finput4.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/runtime.py '.$injection;
            exec($command, $output,$return_value);

            if($return_value == 1)
                return  view('assignments.infinity');
            
            $restore = File::get($asn->foutput4);
            $getject = $destinationPath.$filename.'.txt';
            $geter = File::get($getject);
            $whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;
            //unlink($checkpath);
            unlink($getject);
            /* Checking Injection Zone */
        }
        //--------------------------   
        if (!empty($asn->finput5)) 
        {
               
                /* Checking Injection Zone */
            $injection = '"java -cp '.$destinationPath.' '.$filename.' < '.$asn->finput5.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/runtime.py '.$injection;
            exec($command, $output,$return_value);

            if($return_value == 1)
                return  view('assignments.infinity');
            
            $restore = File::get($asn->foutput5);
            $getject = $destinationPath.$filename.'.txt';
            $geter = File::get($getject);
            $whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;
            //unlink($checkpath);
            unlink($getject);
            /* Checking Injection Zone */
        }
        //--------------------------   
        //--------------------------  
        unlink($destinationPath.$filename.'.class'); 
        //--------------------------   
                $users_id = Auth::user()->id;
                $asn->users()->attach($users_id,['scores'=>$sum,'users_ans'=>$final,'pinid'=>Auth::user()->pinid,'name'=>Auth::user()->name,'created_at'=>now()]);
                //

        /*$user = $request->user();
        $course = $user->courses;
**/
        $coursething = Courses::find($asn->courses_id);
        return view('assignments.pass',['scores'=>$sum,'course'=>$coursething]);

            //Done Compile All
           
        
        }
        else
        {
        	$reject = "python";
        }

       // $result = shell_exec($reject);
       /* $result = exec($reject2,$output,$return);
        var_dump($output);
        var_dump($return);*/
       // echo($reject);
      //  dd($result);
	}
	public function submit($id)
	{

		
		$asn = Assignments::find($id);
		$asnat = $asn->max_attempts;
		if(is_null($asnat))
			$asn->max_attempts = 0;
		if($asn->allow_send == 0)
		{
			Session::flash('message1','Error This Assignment not available to upload anymore !');
			return redirect()->back();
		}
        $get = $asn->endtime;
        $ex_s = Carbon::now();
        $nowY = date('Y', strtotime("$ex_s"));
        $nowM = date('m', strtotime("$ex_s"));
        $nowD = date('d', strtotime("$ex_s"));
        $nowH = date('H', strtotime("$ex_s"));
        $nowI = date('i', strtotime("$ex_s"));
        $nowS = date('s', strtotime("$ex_s"));

        $gyear = date('Y', strtotime("$get"));
        $gmonth = date('m', strtotime("$get"));
        $gday = date('d', strtotime("$get"));
        $ghour = date('H', strtotime("$get"));
        $gmin = date('i', strtotime("$get"));
        $gsecond = date('s', strtotime("$get"));
        //dd($gyear);
       if($nowY <= $gyear)
       {
            if($nowM <= $gmonth)
                if($nowD <= $gday)
                    if($nowH <= $ghour)
                        if($nowI <= $gmin)
                            if($nowS  <= $gsecond)
                            {
                                Session::flash('message1','This Assignment ok!');
                                 return redirect()->back();
                            }
           Session::flash('message1','Error This Assignment already remarks time is up !');
           
        }
        else
        {
             Session::flash('message1','Error This Assignment already remarks time is up !');
            return redirect()->back();
        }
       
		return view('assignments.upload',['asn'=>$asn]);
	}
	public function detail($id,Response $response)
	{
		
		
		$asn = Assignments::FindOrFail($id);
		$name = $asn->name;
		return response()->file($asn->fpath);
	
	}
}