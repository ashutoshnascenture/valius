<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session; 
use Validator;
use App\Ticket;
use App\User;
use App\Role;
use App\Message;
use DB;
use Auth;
use Input;
use Mail;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {    
	    $user = User::find(Auth::user()->id);
	    
        return view('tickets/ticket-form')->with(compact('user','message','tickets','parentId'));;
    }
	
	public function store(Request $request)
	{

		$input = $request->all();
	    $rules = Ticket::$rules;
	
		$validator = Validator::make($input,$rules);
		if ($validator->fails()) 
		{
			return redirect()->back()->withInput($input)->withErrors($validator->errors()); 
		}
		
		$data = [
            'user_id' => $request->input('user_id'),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
			'subject' => $request->input('subject')
        ];
		//echo"<pre>"; print_r($data); die;
		Ticket::create($data);
		$id = \DB::getPdo()->lastInsertId();
		
		 Message::create([
			'users_id' => $request->input('users_id'),
            'message' => $request->input('message'),
			'ticket_id' => $id,
			'parent_id' => $request->input('parent_id'),
			
        ]);
		

		
		// $info = [
            // 'name' => $request->input('name'),
            // 'email' => $request->input('email'),
			// 'phone' => $input['phone'],
            // 'message' => ($request->input('message')),
			
        // ];
	
        // $mail=\Mail::send('emails.mail', $info, function ($message) use($request){ 
		// $message->to($request->input('email'))->subject('Request Query');
		// $message->from('jasmer@nascenture.com','Info');
		
		// });
		
		
		Session::flash('flash_message', 'Request submit successfully');
		Session::flash('alert-class', 'alert-success');
		 return redirect()->back();

	}
	
	public function sendmail($input){
		
		// send email to admin//
		$data = array(
		'fullname' => ucfirst($input['name']),
		'email' => $input['email'],
		'phone' => $input['phone'],
		'message' => $input['message']
		);
		
		Mail::send('emails.mail',  ['data' => $data], function ($m) use ($data) {
			$m->from($data['email'], $data['fullname']);
			$m->to('satishsharma@nascenture.com', 'Satish Sharma')->subject('Request Query');
		});
	}
}
