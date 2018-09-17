<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use App\Plan;
use App\User;
use App\Site;
use Session; 
use Validator;
use Laravel\Cashier\Billable;
use Stripe\Subscription;
use DB;
use Carbon\Carbon;


class SitesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$all_site = Site::get();
    	return view('sites/index');
    	//echo "<pre>"; print_r($all_site); die;
    }

    public function create()
    { 
	 return view('sites/create');
		
    } 
    public function store(Request $request)
	{
		 $rules = Site::$rules;
         $messages = Site::$message;
         $input = $request->all();
        // echo "<pre>"; print_r($request->get('name')); die;
         $validator = Validator::make($input, $rules, $messages);
         if ($validator->fails()) {
            return redirect()->back()->withInput($input)->withErrors($validator->errors());   
         }
          $user = Auth::user(); 
          $time = Carbon::now();
          $siteSave = Site::create([
		 	'name' => $request->get('name'),
            'url' => $request->get('url'),
            'ftp_host'  => $request->get('ftp_host'),
            'ftp_username'    => $request->get('ftp_username'),
            'ftp_password'    => $request->get('ftp_password'),
            'ftp_password'    => $request->get('ftp_password'),
            'sftp_host'       => $request->get('sftp_host'),
            'sftp_username'   => $request->get('sftp_username'),
            'sftp_password'   => $request->get('sftp_password'),
            'cpanel_host'     => $request->get('cpanel_host'),
            'cpanel_username' => $request->get('cpanel_username'),
            'created_at'  => $time,
			'updated_at'  => $time,
			'user_id' => $user->id,
			'plan_id' =>1
        ]);
         if ($siteSave) {
           Session::flash('flash_message', 'Site detail submit successfully');
		   Session::flash('alert-class', 'alert-success');
		   return redirect('sites');
         } else {
           return redirect()->back();
         }
	}
}
