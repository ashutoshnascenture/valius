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

    public function index(Request $request)
    {  
        $userId = Auth::user()->id;
        $totalSite = Site::where('user_id','=',$userId)->count();
        if (isset($request->site_search)) {
        $searchKeyword = $request->site_search;
        $all_sites = Site::where('user_id','=',$userId)->where('name', 'like','%' .$searchKeyword.'%')->paginate(1);
        $totalSite = Site::where('user_id','=',$userId)->where('name', 'like','%' .$searchKeyword.'%')->count();
        } else {
        $all_sites = Site::where('user_id','=',$userId)->paginate(2);
        }
        if ($request->ajax()) {
            return view('sites.load', ['all_sites' => $all_sites,'totalSite'=>$totalSite])->render();  
        }
    	return view('sites/index')->with(compact('all_sites','totalSite'));
    	
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
            $url = $request->get('url'); 
            $apikey = "abea9278e8b401e2b998377783d51d050e5ae2575bad";
            $width  = 440;
            $fetchUrl = "https://api.thumbnail.ws/api/".$apikey ."/thumbnail/get?url=".urlencode($url)."&width=".$width;
          //  echo $fetchUrl; die;
            $jpeg = file_get_contents($fetchUrl);
            $dir =  public_path('/upload/sites').'/';
            $name = time().uniqid(rand()).'.jpg'; 
            file_put_contents($dir. $name , $jpeg);
              $siteSave = Site::create([
    		 	'name' => $request->get('name'),
                'url' => $request->get('url'),
                'ftp_host'  => $request->get('ftp_host'),
                'ftp_username'    => $request->get('ftp_username'),
                'site_image'      => $name,
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
