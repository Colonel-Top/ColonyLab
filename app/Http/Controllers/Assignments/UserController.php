<?php

namespace App\Http\Controllers\Assignments;

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
        
        if(!(($nowY <= $gyear) && ($nowM <= $gmonth) && ($nowD <= $gday) && ($nowH <= $ghour) && ($nowI <= $gmin) && ($nowS <= $gsecond) && ($asn->allow_send == 1)))
            view('assignments.error');

       // echo(Auth::user()->pinid);
		//echo($asn);exit();
		$final ="";
        $filename="";
        $destinationPath = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
        if ($file = $request->hasFile('users_ans')) 
        {
            $file = $request->file('users_ans');
            $filename =$file->getClientOriginalName();
            $destinationPath = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
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
        	$reject = 'gcc '.$final. ' 2>&1';
        //	$reject2 = 'gcc '.$final;
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
        	//echo("JAVA");

        	$destinationPath2 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
        	$result = shell_exec('javac -d '.$destinationPath.' '.$final);
          //  dd($result);
       //     return view('assignments.infinity');


			$filename = str_replace(".java","",$filename);

            $checkpath = $destinationPath2.$filename.'.class';
           dd($checkpath);
            if(!file_exists($checkpath))
                return view('assignments.infinity');

			$inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
			//dd($asn->finput);
			$injection = 'java -cp '.$destinationPath2.' '.$filename.' < '.$asn->finput.' > '.$destinationPath2.$filename.'.txt';
            $result = shell_exec('/bin/bash storage_path() $injection');
            dd($result);exit();
            //shell_exec($injection)
			//dd($injection);
            //INJECTIN ZONE


/*

            $descriptorspec = array(
               0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
               1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
              // 2 => array("file", storage_path(), "a") // stderr is a file to write to
            );
            $maxruntime = 6;
            $cwd = storage_path().'//assignments';
            
            

            //$process_time = time();
           

           // $status_process = (proc_get_status($process));
           
        
       

           // $pid = $status_process['pid'];
            $seconds = $maxsecond*1000000;
            $tick = 0;

            $pid = pcntl_fork();
            if ($pid == -1) 
            {
                die('could not fork');
            } 
            else if ($pid) 
            {
             // we are the parent
                $tick = time();

            } 
            else 
            {
               shell_exec($injection);
                //pcntl_alarm( 600 );
               // pcntl_signal(SIGALARM, term_proc);
                
            }
            
            while(1)
                {
                    $check = pcntl_waitpid($pid, $status, WNOHANG | WUNTRACED);
                    switch($check)
                    {
                    case $pid:
                        echo("PID done ok");
                        exit();
                       //ended successfully
                       //unset($this->children[$pid];
                       break;
                    case 0:
                       //busy, with WNOHANG
                        echo("PID BUSY NOW");
                       if( ( $tick  + $maxruntime ) >= time() /*|| pcntl_wifstopped( $status ))
                       {
                           //Killing Process
                       
                       
                        
                           // echo 'This is a server not using Windows!';
                            if(!posix_kill($pid,SIGKILL))
                           {

                               trigger_error('Failed to kill '.$pid.': '.posix_strerror(posix_get_last_error()), E_USER_WARNING);

                           }
                           else
                           {
                            return view ('assignments.infinity');
                           }
                           //view successfully done
                        
                          
                          // unset($this->children[$pid];
                       }
                       break;
                    case -1:
                    default:
                       trigger_error('Something went terribly wrong with process '.$pid, E_USER_WARNING);
                       // unclear how to proceed: you could try a posix_kill,
                       // simply unsetting it from $this->children[$pid]
                       // or dying here with fatal error. Most likely cause would be 
                       // $pid is not a child of this process.
                       break;

                    }
                }
                echo("All done");
                exit();
                        /*while($tick <= $seconds)
            {
                 if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
                    $status = proc_get_status($process);
                    return exec('taskkill /F /T /PID '.$status['pid']);
                } else {
                    return proc_terminate($process);
                }
            }*//*
            $process = $process = proc_open($injection, $descriptorspec, $pipes, $cwd);
            $pid = (proc_get_status($process));

            $pid = $pid['pid'];
            $output = array();
            $handle =  (proc_get_status($process));
            print_r($handle);
            $handle = $handle['running'];
            print_r("<br>");
            while(!$handle)
            {
                usleep(1000000);
                $tick += 1000000;
                if($tick >= $seconds)
                {
                   // $handle = exec("ps -p $pid", $output);
                    $handle =  (proc_get_status($process));
                    print_r($handle);
                        proc_terminate($process) ;exit();
                        return view('assignments.infinity');
                    
                }
                $handle =  (proc_get_status($process));
                $handle = $handle['running'];
            }
            //posix_getpgid($pid);
           
                */

            


            // INJECTION ZONE
        	//$result = shell_exec($injection);
        	//dd($result);
        	//$injector = storage_path() . '//assignments//'.$request->idc.'//master//';
        	//dd($result);
        	$restore = File::get($asn->foutput);
        	$getject = $destinationPath2.$filename.'.txt';
           // dd($getject);
        	$geter = File::get($getject);
        	//dd($restore);
        	//dd($geter);
        	/*$restore = str_replace("\n\n", '<br>', $restore);
        	$result = str_replace("\n\n", '<br>', $result);
        	$restore = str_replace("\r\n", '<br>', $restore);
        	$result = str_replace("\r\n", '<br>', $result);*/
        	//dd($result);
       		//dd($restore);
        	$whatsap = strcmp($restore, $geter);
            if($whatsap == 0)
                $sum+=$per_asn;

//print_r($whatsap);
            //echo($sum);
        	//dd($whatsap);
        		        	//$result = shell_exec('javac' .$soucejavafile. '2>&1');
        	//$result= shell_exec('java' .$classfile. '2>&1');
    if (!empty($asn->finput2)) 
    {
        	   //--------------------------
        		$destinationPath2 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
	        	$result = shell_exec('javac -d '.$destinationPath.' '.$final);
				$filename = str_replace(".java","",$filename);
				$inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
				$injection = 'java -cp '.$destinationPath2.' '.$filename.' < '.$asn->finput2.' > '.$destinationPath2.$filename.'.txt';
	        	$result = shell_exec($injection);
	        	$getject = $destinationPath2.$filename.'.txt';

	        	$restore = File::get($asn->foutput2);
                $geter = File::get($getject);

	        	$whatsap = strcmp($restore, $geter);
               // echo(" YYY ");
               // print_r($restore);
               // echo(" YYY ");
               // print_r($geter);
               // echo(" YYY ");
               // print_r($whatsap);
                if($whatsap == 0)
                $sum+=$per_asn;
           // echo($sum);
        }
    if (!empty($asn->finput3)) 
    {
            $destinationPath3 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
                $result = shell_exec('javac -d '.$destinationPath.' '.$final);
                $filename = str_replace(".java","",$filename);
                $inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
                $injection = 'java -cp '.$destinationPath3.' '.$filename.' < '.$asn->finput3.' > '.$destinationPath3.$filename.'.txt';
                $result = shell_exec($injection);
                $getject = $destinationPath3.$filename.'.txt';
                $restore = File::get($asn->foutput3);
                $geter = File::get($getject);
                $whatsap = strcmp($restore, $geter);
                if($whatsap == 0)
                $sum+=$per_asn;
           // echo($sum);
    }
            if(!empty($asn->finput4))
            {
                $destinationPath4 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
                $result = shell_exec('javac -d '.$destinationPath.' '.$final);
                $filename = str_replace(".java","",$filename);
                $inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
                $injection = 'java -cp '.$destinationPath4.' '.$filename.' < '.$asn->finput4.' > '.$destinationPath4.$filename.'.txt';
                $result = shell_exec($injection);
                $getject = $destinationPath4.$filename.'.txt';
                $restore = File::get($asn->foutput4);
                $geter = File::get($getject);
                $whatsap = strcmp($restore, $geter);
                if($whatsap == 0)
                $sum+=$per_asn;
            //echo($sum);
            }
            if(!empty($asn->finput5))
            {
                $destinationPath5 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
                $result = shell_exec('javac -d '.$destinationPath.' '.$final);
                $filename = str_replace(".java","",$filename);
                $inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
                $injection = 'java -cp '.$destinationPath5.' '.$filename.' < '.$asn->finput5.' > '.$destinationPath5.$filename.'.txt';
                $result = shell_exec($injection);
                $getject = $destinationPath5.$filename.'.txt';
                $restore = File::get($asn->foutput5);
                $geter = File::get($getject);
                $whatsap = strcmp($restore, $geter);
                if($whatsap == 0)
                $sum+=$per_asn;
            //echo($sum);
            }
                //dd($sum);
            //echo($sum);
        	   //--------------------------
               /* $takeq = DB::table('enrollment')->select('id')->where('courses_id',$asn->courses_id)->first();
                $query = DB::table('assignment_work')->insert([
                    'scores'=>$sum,
                    'users_ans' => $destinationPath.$filename.'java',
                    'assignments_id' => $asn->id,
                    'enrollments_id' => $takeq->id
                ]);*/
                $users_id = Auth::user()->id;
                $asn->users()->attach($users_id,['scores'=>$sum,'users_ans'=>$final,'pinid'=>Auth::user()->pinid,'name'=>Auth::user()->name]);
                //

        /*$user = $request->user();
        $course = $user->courses;
**/
        //$courses_id = $takeq->id;
        $course = Courses::find( $asn->courses_id);
        $course = $course->coursename;
        $asn = \App\Assignments::where('courses_id',$asn->courses_id)->get();
        return view('assignments.main',['asn'=>$asn,'course'=>$course])->with(Session::flash('message1','Upload Assignment Done'));

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