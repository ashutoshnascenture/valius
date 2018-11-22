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
use App\Subscription as Subscriptions;





class AddonsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    { 
    	$paginationNo = $_ENV['PAGINATE_NOUMBER'];
        $addons = DB::table('plans')->where('plan_type','=',4)->paginate($paginationNo);
        return view('addons/index')->with(compact('addons'));
    }
	public function subscribe(Request $request)
	{

		
	}
	
	public function edit($id)
    {
		$addons = DB::table('plans')
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

             if($request->ajax()){
              return response()->json(['error'=>$validator->errors()->all()]);
             } else {
              return redirect()->back()->withInput($input)->withErrors($validator->errors());   
             }
         }

        $stripKey = config('services.stripe.secret');
        \Stripe\Stripe::setApiKey($stripKey);
        $stripeData = \Stripe\Plan::create(array(
                  "amount"    => $request->input('price')*100,
                      "interval"  => "month",
                      "nickname" =>$request->input('name'),
                      "product" => array(
                        "name" => $request->input('name')
                      ),
                      "currency" => "usd"
                    ));
                  $stripJson  = str_replace('Stripe\Plan JSON: ', '', $stripeData);
                  $srtipArray = json_decode($stripJson,true); 
                  if ($srtipArray['interval']=='month') {
                      $interval = 1;
                  } 
                  if ($srtipArray['active']) {
                      $status = 1;
                  } else {
                      $status = 0;
                  }
               $time = Carbon::now();
               $data = [
                'name'        => $request->input('name'),
                'description' => $request->input('description'),
                'status'      => $status,
                'plan_id'     => $srtipArray['id'],
                'interval'    => $interval,
                'nickname'    => $srtipArray['nickname'],
                'amount'      => $srtipArray['amount'],
                'price'       => $request->input('price'),
                'created_at'  => $time,
                'updated_at'  => $time,
                'plan_type'   =>4,
            ];
           $saveAddon = DB::table('plans')->insert($data);
         if ($saveAddon ) {
           if($request->ajax()){
                 $siteID = $request->input('subscription_id');
                 $serviceHtml = $this->servicePopup($siteID);
                 return response()->json(['success'=>'success','html'=>$serviceHtml]);
           }else {
            Session::flash('flash_message', 'Addons  add  successfully');
		        Session::flash('alert-class', 'alert-success');
            return redirect('addons');
         }
         } else {
          if($request->ajax()){
              return response()->json(['error'=>'error']);
          }else {
           Session::flash('flash_message', 'Some problem accured please try again later. ');
           Session::flash('alert-class', 'alert-danger');
           return redirect('addons');
          }

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
		DB::table('plans')->where('id', $id)->update(['is_delete' => $request->get('is_delete')]);  
		Session::flash('flash_message', 'Addons  status successfully update!');
		Session::flash('alert-class', 'alert-success');	
		} 
    return redirect('addons');  
	 }
   public function servicePopup($siteID)
   {
       $subscription_id = base64_decode($siteID); //
       $get_all_subscribed_services = Subscriptions::where('site_id','=',$subscription_id)->pluck('stripe_plan');
       $service_data = DB::table('plans')->whereNotIn('plan_id',$get_all_subscribed_services)->where('plan_type','=',4)->get();
       $returnHTML = view('sites.service-popup')->with('allServices', $service_data)->render();
       return $returnHTML;

   }
}
