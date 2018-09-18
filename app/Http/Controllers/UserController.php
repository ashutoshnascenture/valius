<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Session;
use Auth;
use DataTables ;
use Hash;
use Config; 

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	 public function create()
    {  
	  
	  
	  return view('users/create');
		
    } 
	
    public function index()
    {
      
	  return view('userManagement/index');
    }
	
	public function getUsers()
    {   
    	$paginationNo =  Config::get('constants.paginate');
	    $users= User::paginate($paginationNo);
	    
		return view('users/index')->with(compact('users'));
    }
	
	public function store(Request $request)
	{  
        $input = $request->all();
		$rules = User::$rules;
		
		$validator = Validator::make($input,$rules);
	
		if ($validator->fails()){
			return redirect()->back()->withInput($input)->withErrors($validator->errors()); 
		}
		$password= $request->password;
	    $passwo = bcrypt($password);
	
		$data = [
		        'name' => $request->input('name'),
				'phone' => $request->input('phone'),
				'email' => $request->input('email'),
			    'password' => $passwo,
				'role_id' => $request->role_id,
				'status' => '1',
				'remember_token' => $request->input('_token'),
	             ];
		//echo"<pre>";print_r($data);die;
		User::create($data);
		
		Session::flash('flash_message', 'users submit successfully');
		Session::flash('alert-class', 'alert-success');
		return redirect('users/get-users');

	}
	
	
	
	public function changePassword(){
    	return view('users/change-password');
    }

    public function resetPassword(Request $request){
    	
    	$input = $request->all();
		
		$validator = Validator::make($input,[
			'current_password' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

		if ($validator->fails()) 
		{
			return redirect()->back()->withInput($input)->withErrors($validator->errors()); 
		}

		$user = User::find(Auth::user()->id);

		if (\Hash::check($input['current_password'], $user->password))
		{
			$password = bcrypt($input['password']);
			$user->password = $password;
			$user->save();
			Session::flash('flash_message', 'Password changed successfully');
			Session::flash('alert-class', 'alert-success');
			return redirect()->back();
		    
		}
		
		Session::flash('flash_message', 'Current password is not correct');
		Session::flash('alert-class', 'alert-danger');
		return redirect()->back();
		
    }
	
	public function accountDetails(){
		 
		$user = User::find(Auth::user()->id);
		
		//echo '<pre>'; print_r($user); die;
		
    	return view('users/account-details')->with(compact('user'));
    }
	
	public function update(Request $request, $id)
    {	

		$input = $request->all();
		$rules = User::recordUpdate();
		$rules['email'] .= ',email,'.$id.',id';
		//$rules['username'] .= ',username,'.$id.',id';
		$validator = Validator::make($input,$rules);
		if ($validator->fails()) 
		{
			return redirect()->back()->withInput($input)->withErrors($validator->errors()); 
		}
		
        $user = User::find($id);
		$user->update($input);

		Session::flash('flash_message', 'User updated successfully');
		Session::flash('alert-class', 'alert-success');
		return redirect()->back();
    	
		
	 	
    }
	public function edit($id)
    {  
		$user = User::find($id);
		
		return view('users/edit')->with(compact('user'));
	}
	
	public function userUpdate(Request $request, $id)
    {	
		$input = $request->all();
		
		$rules = User::$rules;
		
		$rules['email'] .= ',email,'.$id.',id';
		
		$validator = Validator::make($input,$rules);
	
		if ($validator->fails()){
			return redirect()->back()->withInput($input)->withErrors($validator->errors()); 
		}
	
		$password= $request->password;
	    $passwo = bcrypt($password);
	
		 $data = [
		       
		        'name' => $request->input('name'),
				'phone' => $request->input('phone'),
				'email' => $request->input('email'),
			    'password' => $passwo
	             ];
	    $user = User::find($id);
	    
		$user->update($data);
		
		Session::flash('flash_message', 'user updated successfully');
		Session::flash('alert-class', 'alert-success');
		return redirect('users/get-users');
	}
	
	public function destroy(Request $request,$id)
    {  
        if($id)
		{
			 	
			$user = User::find($id);
			$user->delete();
			 
			 	
	        Session::flash('flash_message', 'Data successfully deleted!');
			Session::flash('alert-class', 'alert-success');
			return redirect('users/get-users'); 			
		}
	
		 
	}
	
}
