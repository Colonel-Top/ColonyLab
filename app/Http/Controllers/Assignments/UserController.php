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
use Storage;
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
		$asn = \App\Assignments::where([['courses_id',$courses_id],['endtime', '<', Carbon::today()->toDateString()]])->get();
        foreach($asn as $data1)
        {
               // echo($data1->id);
              Assignments::FindOrFail($data1->id)->update(['allow_send'=>'0']);
        }   
        //exit();
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

  
   
       if($asn->allow_send == 0)
       {
           //Session::flash('message1','Error This Assignment time is up !');
            Session::flash('message1','Error This Assignment time is up !');
            dd($asn);
            return redirect()->route('user.assignments.indexmy',$asn->courses_id);
        }

       // echo(Auth::user()->pinid);
		//echo($asn);exit();

		$final ="";
        $filename="";
        $file ="";
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

        //C ZONE


        if($command == "c")
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
            if($requireamount != 0)
                $per_asn = $asn->fullscore/$requireamount;
            else
                $per_asn = 0;
            $sum = 0;
            $time = now();
            $time = str_replace(" ", "-", $time);
            $time = str_replace(":", "-", $time);
            $newfilename = $time.$filename;
            $savefile = $destinationPath.$newfilename;
           // echo($savefile);
          //  echo("<br>");
          //  echo($final);
            $anticname = str_replace(".c","",$newfilename);
            exec("cp $final $savefile");

            $executeq = 'export  PATH=$PATH; gcc -o '.$destinationPath.$anticname.' '.$savefile.' 2> '.$destinationPath.'error-'.$anticname;
           // $executeq = 'gcc -o '.$destinationPath.$anticname.' '.$savefile;
           // $result = exec('sudo -u top59 -S $executeq < ~/.sudopass/secret');
            //$command = 'sudo python '.storage_path().'/ccompiler.py '.$executeq;
            $result = exec($executeq, $output,$return_value);

            //I Dont care return value
            
            unlink($final);

           // echo("<br>");
          //  print_r($executeq);
           /// echo($executeq);
           // echo("<br>");
			//print_r($result);
         //   echo("<br>");
           // print_r($return_value);
           // dd($output);

			//exit();
			
            //$result = shell_exec($executeq);    
			
			$filename = $anticname;
			
            $checkpath = $destinationPath.'error-'.$anticname;
           // dd($checkpath);
           // exit();
            $errorpath = File::get($checkpath);
          //  $classpath = file_exists($destinationPath.$filename.'.class');
           // dd($classpath);

            if(!empty($errorpath))
            {
                
                             
                                
                                $errorpath = File::get($checkpath);
                                $tmper = str_replace("//",  "/", $destinationPath);
                                $showme = str_replace($tmper, "Colonel Engine Compiler:", $errorpath);

                                return view('assignments.error',['errorpath'=>$showme]);
                                
                
            }
         
 
          //  $file->move($destinationPath, $filename);

            //Storage::move('//assignments//'.$asn->id.'//user_upload//'.Auth::user()->pinid.'//'.$filename.'.java', $savefile);
            //move file go to place
            //done

            $inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';

            if (!empty($asn->finput)) 
        {
            /* Checking Injection Zone */
            $injection = '".'.$destinationPath.$filename.' < '.$asn->finput;
            echo($injection);
            echo("<br>");
            $command = 'python '.storage_path().'/cruntime.py '.$injection;
            exec($command, $output,$return_value);
            //dd($return_value);
            echo("<br>");
            print_r($output);
            echo("<br>");
            echo($command);
            if($return_value == 1)
            {
                $getject = $destinationPath.$filename.'.txt';
                unlink($checkpath);
                unlink($getject);
                return  view('assignments.infinity');
            }
            
            $restore = File::get($asn->foutput);
            $getject = $destinationPath.$filename.'.txt';
           // dd($getject);
            $geter = File::get($getject);
            $whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;
            echo($restore);
            echo("<br>");
            echo($geter);
            exit();
            unlink($checkpath);
            unlink($getject);
}
            /* Checking Injection Zone */
        //--------------------------   
        if (!empty($asn->finput2)) 
        {
               
                /* Checking Injection Zone */
            $injection = '".'.$destinationPath.$filename.' < '.$asn->finput2.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/cruntime.py '.$injection;
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
            $injection = '".'.$destinationPath.$filename.' < '.$asn->finput3.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/cruntime.py '.$injection;
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
            $injection = '".'.$destinationPath.$filename.' < '.$asn->finput4.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/cruntime.py '.$injection;
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
            $injection = '".'.$destinationPath.$filename.' < '.$asn->finput5.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/cruntime.py '.$injection;
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
        //unlink($destinationPath.$filename.'.class'); 
        //--------------------------   
         $users_id = Auth::user()->id;
         $coursething = Courses::find($asn->courses_id);
    //     echo($users_id);
        // echo($coursething->id);
        $queryfromenroll = DB::table('enrollment')->select('id')->where([['users_id',$users_id],['courses_id',$coursething->id]])->first();
        $asn->users()->attach($queryfromenroll->id,['scores'=>$sum,'users_ans'=>$savefile,'pinid'=>Auth::user()->pinid,'name'=>Auth::user()->name,'created_at'=>now()]);
                //
                if($per_asn == 0)
                    $sum = "Send Successfully";
        /*$user = $request->user();
        $course = $user->courses;
**/
        $coursething = Courses::find($asn->courses_id);
        return view('assignments.pass',['scores'=>$sum,'course'=>$coursething,'full'=>$asn->fullscore]);

            //Done Compile All
           
        
        }





        //JAVA ZONE
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
        	if($requireamount != 0)
                $per_asn = $asn->fullscore/$requireamount;
            else
                $per_asn = 0;
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
                
                                
                                //$classpath = file_exists($destinationPath.$filename.'.class');
                               
                                if (strpos($errorpath, '\u') !== false) 
                                {

                                  //  dd("come to compile normally");
                                   $executeq2 = 'javac -d '.$destinationPath.' '.$final.' 2> '.$destinationPath.'error-'.$filename;
                                  //  print_r($executeq);
                                    $result2 = shell_exec($executeq2);    
                                    $checkpath2 = $destinationPath.'error-'.$filename;
                                   // dd($checkpath);
                                    $errorpath2= File::get($checkpath2);
                                    $classpath2 = file_exists($destinationPath.$filename.'.class');
                                    if(!empty($errorpath2) && $classpath == 0)
                                    {
                                            unlink($checkpath2);
                                            $execbom = "sed -i '1s/^\xEF\xBB\xBF//' ".$final;
                                            exec($execbom);
                                            $executeq3 = 'javac -encoding UTF8 -d '.$destinationPath.' '.$final.' 2> '.$destinationPath.'error-'.$filename;
                                          //  print_r($executeq);
                                            $result3 = shell_exec($executeq3);    
                                            $checkpath3 = $destinationPath.'error-'.$filename;
                                           // dd($checkpath);
                                            $errorpath3= File::get($checkpath3);
                                            $classpath3 = file_exists($destinationPath.$filename.'.class');
                                            if(!empty($errorpath3) && $classpath == 0)
                                            {
                                                unlink($checkpath3);
                                                $tmper = str_replace("//",  "/", $destinationPath);
                                                $showme = str_replace($tmper, "Colonel Engine Compiler:", $errorpath3);
                                                return view('assignments.error',['errorpath'=>$showme]);
                                            }
                                    }
                                }
                                else
                                {
                                $errorpath = File::get($checkpath);
                                $tmper = str_replace("//",  "/", $destinationPath);
                                $showme = str_replace($tmper, "Colonel Engine Compiler:", $errorpath);
                                return view('assignments.error',['errorpath'=>$showme]);
                                }

                
            }
          
            $time = now();
            $time = str_replace(" ", "-", $time);
            $time = str_replace(":", "-", $time);
            $newfilename = $time.$filename;
            $savefile = $destinationPath.$newfilename.'.java';
           // dd($savefile);
 
            // $file->move($destinationPath, $filename);

            exec("cp $final $savefile");
            unlink($final);
            //Storage::move('//assignments//'.$asn->id.'//user_upload//'.Auth::user()->pinid.'//'.$filename.'.java', $savefile);
            //move file go to place
            //done

			$inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
            if (!empty($asn->finput)) 
        {
            /* Checking Injection Zone */
			$injection = '"java -cp '.$destinationPath.' '.$filename.' < '.$asn->finput.' > '.$destinationPath.$filename.'.txt"';
          //  dd($injection);
            $command = 'python '.storage_path().'/runtime.py '.$injection;
            exec($command, $output,$return_value);
            //dd($return_value);
            if($return_value == 1)
            {
                 $getject = $destinationPath.$filename.'.txt';
                if(file_exists($checkpath))
                    unlink($checkpath);
                if(file_exists($getject))
                    unlink($getject);
                if(file_exists($destinationPath.$filename.'.class'))
                    unlink($destinationPath.$filename.'.class'); 
                return  view('assignments.infinity',['courseid'=>$asn->courses_id]);
            }
        	$restore = File::get($asn->foutput);
        	$getject = $destinationPath.$filename.'.txt';
        	$geter = File::get($getject);
        	$whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;
            unlink($checkpath);
            unlink($getject);
}
            /* Checking Injection Zone */
        //--------------------------   
        if (!empty($asn->finput2)) 
        {
        	   
        		/* Checking Injection Zone */
            $injection = '"java -cp '.$destinationPath.' '.$filename.' < '.$asn->finput2.' > '.$destinationPath.$filename.'.txt"';

            $command = 'python '.storage_path().'/runtime.py '.$injection;
            exec($command, $output,$return_value);
            if($return_value == 1)
            {
                 $getject = $destinationPath.$filename.'.txt';
                if(file_exists($checkpath))
                    unlink($checkpath);
                if(file_exists($getject))
                    unlink($getject);
                if(file_exists($destinationPath.$filename.'.class'))
                    unlink($destinationPath.$filename.'.class'); 
                return  view('assignments.infinity',['courseid'=>$asn->courses_id]);
            }
            
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
            {
                 $getject = $destinationPath.$filename.'.txt';
                if(file_exists($checkpath))
                    unlink($checkpath);
                if(file_exists($getject))
                    unlink($getject);
                if(file_exists($destinationPath.$filename.'.class'))
                    unlink($destinationPath.$filename.'.class'); 
                return  view('assignments.infinity',['courseid'=>$asn->courses_id]);
            }
            
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
            {
                 $getject = $destinationPath.$filename.'.txt';
                if(file_exists($checkpath))
                    unlink($checkpath);
                if(file_exists($getject))
                    unlink($getject);
                if(file_exists($destinationPath.$filename.'.class'))
                    unlink($destinationPath.$filename.'.class'); 
                return  view('assignments.infinity',['courseid'=>$asn->courses_id]);
            }
            
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
            {
                 $getject = $destinationPath.$filename.'.txt';
                if(file_exists($checkpath))
                    unlink($checkpath);
                if(file_exists($getject))
                    unlink($getject);
                if(file_exists($destinationPath.$filename.'.class'))
                    unlink($destinationPath.$filename.'.class'); 
                return  view('assignments.infinity',['courseid'=>$asn->courses_id]);
            }
            
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
        if(file_exists($checkpath))
                    unlink($checkpath);
        if(file_exists($destinationPath.$filename.'.class'))
            unlink($destinationPath.$filename.'.class'); 
        //--------------------------   
         $users_id = Auth::user()->id;
         $coursething = Courses::find($asn->courses_id);
    //     echo($users_id);
        // echo($coursething->id);
        $queryfromenroll = DB::table('enrollment')->select('id')->where([['users_id',$users_id],['courses_id',$coursething->id]])->first();
        $asn->users()->attach($queryfromenroll->id,['scores'=>$sum,'users_ans'=>$savefile,'pinid'=>Auth::user()->pinid,'name'=>Auth::user()->name,'created_at'=>now()]);
                //
                if($per_asn == 0)
                    $sum = "Send Successfully";
        /*$user = $request->user();
        $course = $user->courses;
**/
        $coursething = Courses::find($asn->courses_id);
        return view('assignments.pass',['scores'=>$sum,'course'=>$coursething,'full'=>$asn->fullscore]);

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
		//	Session::flash('message1','Error This Assignment not available to upload anymore !');
			 Session::flash('message1','Error This Assignment time is up !');
            return redirect()->route('user.assignments.indexmy',$asn->courses_id);
		}
       if($asn->allow_send == 1)
       {
           
                            
                                //if($asn->allow_send == 1)
                                    return view('assignments.upload',['asn'=>$asn,'courseid'=>$asn->courses_id]);
                               //FIX THIS
                            
                           
           
        }
        else
        {
             Session::flash('message1','Error This Assignment time is up !');
            return redirect()->route('user.assignments.indexmy',$asn->courses_id);
        }
       
		
	}
	public function detail($id,Response $response)
	{
		
		
		$asn = Assignments::FindOrFail($id);
		$name = $asn->name;
		return response()->file($asn->fpath);
	
	}
}