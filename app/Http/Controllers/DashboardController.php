<?php

namespace App\Http\Controllers;

use App\User;
use App\Site;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Session;
use Auth;
use DataTables ;
use Hash;

class DashboardController extends Controller
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
    public function index()
    {
         $title = "Dashboard";

        if (Auth::check() && !\Auth::user()->hasRole('admin')) {  
            $user_id = Auth::user()->id;
            $totalSite = Site::where('user_id','=',$user_id)->count();
            $all_sites = Site::with('subscription')->where('user_id','=',$user_id)->get();
            //echo  $totalSite; die;
            Session::put('totalSite', $totalSite);
                    
            return view('dashboard', compact('title','totalSite','all_sites'));
           
        } else {
           return redirect('/admin-dashboard');
        } 
        
    }
    public function  adminDashboard()
    {  
           $title = "Dashboard";
           return view('admindashboard', compact('title'));          
    }
}
