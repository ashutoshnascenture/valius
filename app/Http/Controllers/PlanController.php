<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Plan;
use App\User;
use App\Country;
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
        
        
        $plans = DB::table('plans')->where('is_delete','=',1)->get();
        $is_subscribed = Auth::user()->subscribed('main');

        // If subscribed get the subscription
        $title = 'Plan Listin';
        $subscription = Auth::user()->subscription('main');

        return view('plans/index')->with(compact('plans', 'is_subscribed', 'subscription','title'));
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
		
		$paginationNo = $_ENV['PAGINATE_NOUMBER'];
		$plans = DB::table('plans')
                ->where('status', 1)
                ->orderBy('id','DESC')
                ->paginate($paginationNo);
	     
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
			'price'  => 'required',
			'plan_type' =>'required'
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
				'updated_at'  => $time,
				'plan_type'   =>$request->input('plan_type'),
	        ];
		   DB::table('plans')->insert($data);
		   Session::flash('flash_message', 'Plan submit successfully');
		   Session::flash('alert-class', 'alert-success');
		   return redirect('plans/get-plans');

	}
	 
	public function planUpdate(Request $request, $id)
    {	
		$input = $request->all();
		$validator = Validator::make($request->all(), [
		    'name'  => 'required',
			'description'  => 'required',
			'price'  => 'required'
			
        ]);
		if ($validator->fails()){
			return redirect()->back()->withInput($input)->withErrors($validator->errors()); 
		}	
		    $palnDetail = DB::table('plans')->select('plan_id')
						             ->where('id', $id)
						             ->first(); 
            /* $stripKey = config('services.stripe.secret');
            \Stripe\Stripe::setApiKey($stripKey);
			$StripePlan = \Stripe\Plan::retrieve($palnDetail->plan_id);
			$StripePlan->amount = $request->input('price');
			$StripePlan->nickname = $request->input('name');
			$StripePlan->save();*/
		    DB::table('plans') 
            ->where('id', $id)
            ->update(['name' => $request->input('name'),
			          'description' => $request->input('description'),
					  'price' => $request->input('price'),
					  'plan_type'   =>$request->input('plan_type'),
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
	public function updatePayment(Request $request)
	{
		  $title = 'Plan Update';
          $id = Auth::user()->id;
          $user = User::find($id);
          $allCountry = Country::get();
		  return view('plans/updatepayment')->with(compact('user','allCountry','title'));
	}
	public function updateCard(Request $request)
	{
		  $stripeToken = $request->get('stripeToken');
          $userDetail = Auth::user();
         /*$stripKey = config('services.stripe.secret');
         \Stripe\Stripe::setApiKey($stripKey);
          $stripeData = \Stripe\Customer::retrieve($userDetail->stripe_id);
		  $stripJson  = str_replace('Stripe\Customer JSON:', '', $stripeData);
          $srtipArray = json_decode($stripJson,true); 
          echo "<pre>"; print_r($srtipArray); 
          $card = $stripeData->sources->retrieve($srtipArray['default_source']);
          $stripJsonCard  = str_replace('Stripe\Card JSON:', '', $card);
          $srtipArrayCard = json_decode($stripJsonCard,true);
          echo "<pre>"; print_r($srtipArrayCard); die;*/
          $userDetail->updateCard($stripeToken);
          Session::flash('flash_message', 'Card successfully update!');
		  Session::flash('alert-class', 'alert-success');
          return redirect('/dashboard');
        //$card = $customer->cards->retrieve({CARD_ID});
	}
    
}
