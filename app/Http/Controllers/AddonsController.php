<?php

namespace App\Http\Controllers;  

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Plan;
use App\Addon;
use Stripe\Stripe;
use DataTables;
use Validator;
use Session;
use DB;
use Carbon\Carbon;
use Config;



class AddonsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    { 
    	$paginationNo =  Config::get('constants.paginate');
        $addons = DB::table('addons')->paginate($paginationNo);
        return view('addons/index')->with(compact('addons'));
    }
	public function subscribe(Request $request)
	{

		
	}
	
	public function edit($id)
    {
		$addons = DB::table('addons')
                ->where('id', $id)
                ->orderBy('id','DESC')
                ->first();
		
		return view('addons/edit')->with(compact('addons'));
	}
	
	
	public function create()
    { 
	 return view('addons/create');
		
    } 
	
	public function store(Request $request)
	{  
		 $rules = Addon::$rules;
         $messages = Addon::$message;
         $input = $request->all();
         $validator = Validator::make($input, $rules, $messages);
         if ($validator->fails()) {
            return redirect()->back()->withInput($input)->withErrors($validator->errors());   
         }
         $saveAddon = Addon::create([
		 	'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price'  => $request->get('price')
        ]);
         if ( $saveAddon ) {
           Session::flash('flash_message', 'Addons  add  successfully');
		   Session::flash('alert-class', 'alert-success');
           return redirect('addons');
         } else {

         	Session::flash('flash_message', 'Some problem accured please try again later. ');
		   Session::flash('alert-class', 'alert-danger');
           return redirect('addons');
         }
         
	}
   
    public function addonUpdate(Request $request, $id)
    {	
		 $rules = Addon::$rules;
         $messages = Addon::$message;
         $input = $request->all();
         $validator = Validator::make($input, $rules, $messages);
         if ($validator->fails()) {
            return redirect()->back()->withInput($input)->withErrors($validator->errors());   
         }
		
		 $saveAddon = DB::table('addons')
            ->where('id', $id)
            ->update(['name' => $request->input('name'),
			          'description' => $request->input('description'),
					  'price' => $request->input('price'),
			    	]);
		
		if ( $saveAddon ) {
           Session::flash('flash_message', 'Addons  update  successfully');
		   Session::flash('alert-class', 'alert-success');
           return redirect('addons');
         } else {

         	Session::flash('flash_message', 'Some problem accured please try again later. ');
		   Session::flash('alert-class', 'alert-danger');
           return redirect('addons');
         }
	}

	public function destroy(Request $request,$id)
    {  
      if($id)
		{
		DB::table('addons')->where('id', $id)->update(['is_delete' => $request->get('is_delete')]);  
		Session::flash('flash_message', 'Addons  status successfully update!');
		Session::flash('alert-class', 'alert-success');
        return redirect('addons'); 		
		}
	
		 
	 }
}
