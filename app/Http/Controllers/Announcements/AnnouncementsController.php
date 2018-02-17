<?php
namespace App\Http\Controllers\Courses;

use App\User;
use App\Courses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use DB;
use Hash;
class AnnouncementsController extends Controller
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
    
	public function index()
	{
	//	Session::flash('success_msg','Authorized Successfully!');
		$ann = Announcements::all();


		return view(' announcement.index',['ann' => $ann]);
	}
	public function details($id)
	{
		try {
			$ann = Announcements::findOrFail($id);
			
		} catch (ModelNotFoundException $e) {
			App::error(404, 'Not found');
		}
		return view('announcement.details',['ann'=> $ann]);
	}
	
	public function add()
	{
		return view ('announcement.add');
	}
	 protected function validator(array $data)
    {
    	
        return Validator::make($data, [
           'name' => 'required|max:40',
			'create_by' =>   $this->user,
			
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
			'create_by' => $this->user,
			
		]);
		
		$ann = Announcements::create($request->all());
		
		
		Session::flash('message1','Announcement Added');
		$ann = Announcements::all();


		return view(' announcement.index',['ann' => $ann]);

	}

	public function edit(Request $request){
		
		$results = DB::table('courses')->select('password')->where('id',$request->ider)->pluck('password');
		$passlala = $results[0];
		
		$hashpass = bcrypt($request->password);
		
		
	
		if (Hash::check($request->password,$passlala))
			{
				Session::flash('message1','Authorized Successfully!');
				 $ann = Announcements::find($request->ider);
       
       			 //load form view
        		return view('announcement.edit', ['ann' => $ann]);
			}
			else
			{
				Session::flash('message1','Wrong Password / Cannot Authorization');
				return redirect()->back();
			}
		}
   
    public function update($id,Request $request)
	{
		$this->validate($request,[
			'name' => 'required|max:40',
			'create_by' =>  $this->user,
			
		]);

		

		/*$hashpass = bcrypt($request['password']);
		$request['password'] = $hashpass;*/
		$request['create_by'] = $this->user;
		$postData = $request->all();
		Announcements::find($id)->update($postData);
		
		Session::flash('message1','Announcements Updated');
		return redirect()->intended(route('admin.announcements.index'));

	}
	 public function delete($id)
	 {
        //update post data
       // $account = Courses::where('courses_id', $id)->firstOrFail()->courses()->detach();
   		$courses = Announcements::find($id);
        $courses->courses()->detach();
        $courses->delete();
       // $courses->delete();
       
        //store status message
        Session::flash('message1', 'Announcements deleted');

        return redirect()->route('admin.announcements.index');
    }

}
