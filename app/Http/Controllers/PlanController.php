<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Plan;
use Stripe\Stripe;
use DataTables;
use Validator;
use Session;
use DB;
use Carbon\Carbon;

class PlanController extends Controller
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
        // Get all plans from stripe api
        $plans = DB::table('plans')->where('is_delete','=',1)->get();
        // Check is subscribed
        $is_subscribed = Auth::user()->subscribed('main');

        // If subscribed get the subscription
        $subscription = Auth::user()->subscription('main');

        return view('plans/index')->with(compact('plans', 'is_subscribed', 'subscription'));
    }
	
	public function subscribe(Request $request)
	{

		// Validate request
		$this->validate( $request, [ 'stripeToken' => 'required', 'plan' => 'required'] );

		// User chosen plan
		$pickedPlan = $request->get('plan');
		$pickedPlanName = $request->get('plan_name');

		// Current logged in user
		$user = Auth::user();

		try {
			// check already subscribed and if already subscribed with picked plan
			if( $user->subscribed('main') && ! $user->subscribedToPlan($pickedPlan, 'main') ) {

				// swap if different plan attempt
				$user->subscription('main')->swap($pickedPlan);

			} else {
				// Its new subscription

				// if user has a coupon, create new subscription with coupon applied
				if( $coupon = $request->get('coupon') ) {

					$user->newSubscription( 'main', $pickedPlan)
						->withCoupon($coupon)
						->create($request->get('stripeToken'), [
							'email' => $user->email
						]);

				} else {

					// Create subscription
					$user->newSubscription( 'main', $pickedPlan)->create($request->get('stripeToken'), [
						'email' => $user->email,
						'description' => $user->name
					]);
				}

			}
		} catch (\Exception $e) {
			// Catch any error from Stripe API request and show
			return redirect()->back()->withErrors(['status' => $e->getMessage()]);
		}

		return redirect()->route('plans')->with('status', 'You are now subscribed to ' . $pickedPlanName . ' plan.');
	}
	
	public function edit($id)
    {
		$plans = DB::table('plans')
                ->where('id', $id)
                ->orderBy('id','DESC')
                ->first();
		
		return view('plans/edit')->with(compact('plans'));
	}
	
	
	public function planListing()
    {   
        return view('plans/viewPlan');
    }
	
	
	public function getPlans()
	{    
		$plans = DB::table('plans')
                ->where('status', 1)
                ->orderBy('id','DESC')
                ->paginate(10);
	     
		return view('plans/plans')->with(compact('plans'));

    }
	
	public function create()
    { 
	 return view('plans/create');
		
    } 
	
	public function store(Request $request)
	{  
        $input = $request->all();
        $stripKey = config('services.stripe.secret');
        \Stripe\Stripe::setApiKey($stripKey);
		$validator = Validator::make($request->all(), [
		    'name'  => 'required',
			'description'  => 'required',
			'price'  => 'required'
        ]);
		if ($validator->fails()){
			return redirect()->back()->withInput($input)->withErrors($validator->errors()); 
		}
			$stripeData = \Stripe\Plan::create(array(
					  "amount"    => $request->input('price'),
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
				'updated_at'  => $time
	        ];
		   DB::table('plans')->insert($data);
		   Session::flash('flash_message', 'Plan submit successfully');
		   Session::flash('alert-class', 'alert-success');
		   return redirect('plans/get-plans');

	}
	 
	public function planUpdate(Request $request, $id)
    {	
		$input = $request->all();
		
        //echo "<pre>"; print_r($input); die();
		$validator = Validator::make($request->all(), [
		    'name'  => 'required',
			'description'  => 'required',
			'price'  => 'required'
			
        ]);
	
		if ($validator->fails()){
			return redirect()->back()->withInput($input)->withErrors($validator->errors()); 
		}
		
		DB::table('plans')
            ->where('id', $id)
            ->update(['name' => $request->input('name'),
			          'description' => $request->input('description'),
					  'price' => $request->input('price'),
			    	]);
	    // $user = Plan::find($id);
		// $user->update($input);
		
		
		Session::flash('flash_message', 'Plan updated successfully');
		Session::flash('alert-class', 'alert-success');
		return redirect('plans/get-plans');
	}
	
	public function destroy(Request $request,$id)
    {  
      if($id)
		{
		 /*$palnDetail =  DB::table('plans')->find($id);
		 $stripKey = config('services.stripe.secret');
         \Stripe\Stripe::setApiKey($stripKey);
		 $plan = \Stripe\Plan::retrieve($palnDetail->plan_id);
         $plan->delete();*/
		DB::table('plans')->where('id', $id)->update(['is_delete' => $request->get('is_delete')]);  
		Session::flash('flash_message', 'Plan  status successfully update!');
		Session::flash('alert-class', 'alert-success');
        return redirect('plans/get-plans'); 		
		}
	
		 
	 }
	
    
}
