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
	public function score(Request $request)
	{

	}
public function push(Request $request)
	{
		$asn = Assignments::find($request->id);
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
        	//echo("JAVA");
        	$destinationPath2 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
        	$result = shell_exec('javac -d '.$destinationPath.' '.$final);
			$filename = str_replace(".java","",$filename);
			$inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
			//dd($asn->finput);
			$injection = 'java -cp '.$destinationPath2.' '.$filename.' < '.$asn->finput;
			
        	$result = shell_exec($injection);
        	//dd($result);
        	//$injector = storage_path() . '//assignments//'.$request->idc.'//master//';
        	//dd($result);
        	$restore = File::get($asn->foutput);

        	/*$restore = str_replace("\n\n", '<br>', $restore);
        	$result = str_replace("\n\n", '<br>', $result);
        	$restore = str_replace("\r\n", '<br>', $restore);
        	$result = str_replace("\r\n", '<br>', $result);*/
        	dd($result);
       		//dd($restore);
        	$whatsap = strcmp($restore, $result);
        	dd($whatsap);
        		        	//$result = shell_exec('javac' .$soucejavafile. '2>&1');
        	//$result= shell_exec('java' .$classfile. '2>&1');
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
        dd($result);
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
		return view('assignments.upload',['asn'=>$asn]);
	}
	public function detail($id,Response $response)
	{
		
		
		$asn = Assignments::FindOrFail($id);
		$name = $asn->name;
		return response()->file($asn->fpath);
	
	}
}