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
        if (Auth::check() && !\Auth::user()->hasRole('admin')) {  
           return view('dashboard');
        } else {
           return redirect('/admin-dashboard');
        } 
        
    }
    public function  adminDashboard()
    {
           if (Auth::check() && \Auth::user()->hasRole('admin')) {
           return view('admindashboard');
           } else {
            
            return redirect('/dashboard');
           } 
    }
}
