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
        	$allscore = $asn->fullscore;
        	$requireamount = 0;
        	if(!is_null($asn->finput))
        		$requireamount++;
        	if(!is_null($asn->finput2))
        		$requireamount++;
        	if(!is_null($asn->finput3))
        		$requireamount++;
        	if(!is_null($asn->finput4))
        		$requireamount++;
        	if(!is_null($asn->finput5))
        		$requireamount++;
        	$per_asn = $asn->fullscore/$requireamount;
        	$sum = 0;
        	//echo("JAVA");

        	$destinationPath2 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
        	$result = shell_exec('javac -d '.$destinationPath.' '.$final);
			$filename = str_replace(".java","",$filename);
			$inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
			//dd($asn->finput);
			$injection = 'java -cp '.$destinationPath2.' '.$filename.' < '.$asn->finput.' > '.$destinationPath2.$filename.'.txt';
			//dd($injection);

        	$result = shell_exec($injection);
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
        	//dd($whatsap);
        		        	//$result = shell_exec('javac' .$soucejavafile. '2>&1');
        	//$result= shell_exec('java' .$classfile. '2>&1');

        	   //--------------------------
        		$destinationPath2 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
	        	$result = shell_exec('javac -d '.$destinationPath.' '.$final);
				$filename = str_replace(".java","",$filename);
				$inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
				$injection = 'java -cp '.$destinationPath2.' '.$filename.' < '.$asn->finput2.' > '.$destinationPath2.$filename.'.txt';
	        	$result = shell_exec($injection);
	        	$getject = $destinationPath2.$filename.'.txt';
	        	$geter = File::get($asn->foutput2);
	        	$whatsap = strcmp($restore, $geter);
                if($whatsap == 0)
                $sum+=$per_asn;

            $destinationPath3 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
                $result = shell_exec('javac -d '.$destinationPath.' '.$final);
                $filename = str_replace(".java","",$filename);
                $inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
                $injection = 'java -cp '.$destinationPath3.' '.$filename.' < '.$asn->finput3.' > '.$destinationPath3.$filename.'.txt';
                $result = shell_exec($injection);
                $getject = $destinationPath3.$filename.'.txt';
                $geter = File::get($asn->foutput3);
                $whatsap = strcmp($restore, $geter);
                if($whatsap == 0)
                $sum+=$per_asn;
$destinationPath4 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
                $result = shell_exec('javac -d '.$destinationPath.' '.$final);
                $filename = str_replace(".java","",$filename);
                $inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
                $injection = 'java -cp '.$destinationPath4.' '.$filename.' < '.$asn->finput4.' > '.$destinationPath4.$filename.'.txt';
                $result = shell_exec($injection);
                $getject = $destinationPath4.$filename.'.txt';
                $geter = File::get($asn->foutput4);
                $whatsap = strcmp($restore, $geter);
                if($whatsap == 0)
                $sum+=$per_asn;
$destinationPath5 = storage_path() . '//assignments//'.$asn->id.'//user_upload//';
                $result = shell_exec('javac -d '.$destinationPath.' '.$final);
                $filename = str_replace(".java","",$filename);
                $inputpath = storage_path() . '//assignments//'.$request->idc.'//input//';
                $injection = 'java -cp '.$destinationPath5.' '.$filename.' < '.$asn->finput5.' > '.$destinationPath5.$filename.'.txt';
                $result = shell_exec($injection);
                $getject = $destinationPath5.$filename.'.txt';
                $geter = File::get($asn->foutput5);
                $whatsap = strcmp($restore, $geter);
                if($whatsap == 0)
                $sum+=$per_asn;
                //dd($sum);
        	   //--------------------------
               /* $takeq = DB::table('enrollment')->select('id')->where('courses_id',$asn->courses_id)->first();
                $query = DB::table('assignment_work')->insert([
                    'scores'=>$sum,
                    'users_ans' => $destinationPath.$filename.'java',
                    'assignments_id' => $asn->id,
                    'enrollments_id' => $takeq->id
                ]);*/
                $users_id = Auth::user()->id;
                $asn->users()->attach($users_id,['scores'=>$sum,'users_ans'=>$final]);
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
       
		return view('assignments.upload',['asn'=>$asn]);
	}
	public function detail($id,Response $response)
	{
		
		
		$asn = Assignments::FindOrFail($id);
		$name = $asn->name;
		return response()->file($asn->fpath);
	
	}
}