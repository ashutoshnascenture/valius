<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use App\Plan;
use App\User;
use App\Country;
use App\State;
use Session; 
use Validator;
use Laravel\Cashier\Billable;
use Stripe\Subscription;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
           // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $title = 'Plan Listing ';
        $plans = DB::table('plans')->where('is_delete','=',1)->where('plan_type','!=',4)->get();
        return view('home')->with(compact('plans','title')); 
    }

    public function planDetail($planID='')
    {    $title = 'Plan Detail ';
         $planID = base64_decode($planID);
         $plan = DB::table('plans')->find($planID);
         if ($plan) {
          return view('plan-detail')->with(compact('plan','title'));   
         }
         return redirect()->back();
    }
 
    public function  planPayment(Request $request)
    {
         $title = 'Plan Payment';
         $allCountry = Country::get();
         $rules = User::$rules;
         $messages = User::$message;
         $input = $request->all();
         $validator = Validator::make($input, $rules, $messages);
         if ($validator->fails()) {
            return redirect()->back()->withInput($input)->withErrors($validator->errors());   
          }
          $input = $request->all();
          $plan = DB::table('plans')->find($input['palnID']);
          if ($plan) { 

             $userDetail = collect($input);
             if (Session::has('userDetail')) {
                
                Session::forget('userDetail');
                Session::push('userDetail', $userDetail);
             } else {
                  
                Session::push('userDetail', $userDetail);
             }
             
             return view('plan-payment')->with(compact('plan','allCountry','userDetail','title'));  
          } else {
             return redirect()->back();
          }
    }

    public function subscribePlan(Request $request) 
    {
         $data = $request->session()->all();
        $this->validate( $request, [ 'stripeToken' => 'required', 'plan' => 'required'] );
        $pickedPlan = $request->get('plan');
		$pickedPlanName = $request->get('plan_name');
        $pickedPlanAmount = $request->get('plan_amount');
		 User::create([
		 	'name'         => $data['userDetail'][0]['first_name'],
            'first_name'   => $data['userDetail'][0]['first_name'],
            'last_name'    => $data['userDetail'][0]['last_name'],
            'email'        => $data['userDetail'][0]['email'],
            'password'     => Hash::make($data['userDetail'][0]['password']),
            'country_id'   => $request->get('country_id'),
            'state_id'     => $request->get('state_id'),
            'zipcode'      => $request->get('zipcode'),
            'city'         => $request->get('city'),
            'company_name' => $request->get('company_name'),
            'address'      => $request->get('address'),
            'user_type'    => $request->get('user_type'),
        ]);
		$checkUser = Auth::attempt([
		    'email' => $data['userDetail'][0]['email'], 
			'password' => $data['userDetail'][0]['password']
		]);
        Session::forget('userDetail');
		if ( $checkUser ) {
			$user = Auth::user(); 
          try {

			if( $user->subscribed('main') && ! $user->subscribedToPlan($pickedPlan, 'main') ) {
				$user->subscription('main')->swap($pickedPlan);
				
			} else {
                 
				if( $coupon = $request->get('coupon') ) {
                    
				$subscribtion =	$user->newSubscription( 'main', $pickedPlan)
						->withCoupon($coupon)
						->create($request->get('stripeToken'), [
							'email' => $user->email
						]);
                        $subscribtion->plan_name = $pickedPlanName;
                       $subscribtion->plan_amount = $pickedPlanAmount;
                        $subscribtion->save();
						
				} else {
                   
				 $subscribtion =	$user->newSubscription( 'main', $pickedPlan)->create($request->get('stripeToken'), [
						'email' => $user->email,
						'description' => $user->name
					]);
                    $subscribtion->plan_name = $pickedPlanName;
                    $subscribtion->plan_amount = $pickedPlanAmount;
                    $subscribtion->save();
				}

			}
		} catch (\Exception $e) {
            
			 return redirect('/plan-select/'.base64_encode($request->get('planlocalid')))->withErrors(['status' => $e->getMessage()]);
		}
          
         $mailArray = array();
         $mailArray['name'] = $user->first_name."".$user->last_name;
         $mailArray['email'] = $user->email;
         $mailArray['planName'] ='You are now subscribed to ' . $pickedPlanName . ' plan.';
          \Mail::send('emails.send-mail', $mailArray, function($message) use($mailArray)  {
            $message->to($mailArray['email']);
            $message->subject('Confirmation Email');
        });
		return redirect('/dashboard')->with('status', 'You are now subscribed to ' . $pickedPlanName . ' plan.');
		} else {
             
			return redirect('/plan-select/'.base64_encode($request->get('planlocalid')))->withErrors(['status' => 'somthing went wrong please try again']);
		}
    }

    public function getStates(Request $request , $country_id)
    {
          $allStates = State::where('country_id','=',$country_id)->get();
          $returnHTML = view('state')->with('allStates', $allStates)->render();
          echo $returnHTML; die;



    }
}
