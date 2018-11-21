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
use App\Subscription as Subscriptions;
use DB;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use App\Invoices;
class SitesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {  
        $data = $request->all();
        
        $userId = Auth::user()->id;
        $title = "Site Listing";
        $totalSite = Site::count();
       // echo $totalSite;  die;
        if (isset($request->site_search)) {
        $searchKeyword = $request->site_search;
        $all_sites = Site::with('parent.children')->where('name', 'like','%' .$searchKeyword.'%')->paginate(1);
        $totalSite = Site::with('parent.children')->where('name', 'like','%' .$searchKeyword.'%')->count();
        } else {
        $all_sites = Site::with('parent.children')->paginate(2);
        }
        if ($request->ajax()) {
            //echo "<pre>"; print_r($all_sites->toArray()); die; 
            return view('sites.load', ['all_sites' => $all_sites,'totalSite'=>$totalSite])->render();  
        } 
        //echo "<pre>"; print_r($all_sites->toArray()); die; 
        
        return view('sites/index')->with(compact('all_sites','totalSite','title'));
        
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
   
    public function siteDetail(Request $request ,$id)
    {
 
      $title = 'Site Detail';
      $site_id  = base64_decode($id);
      $siteDetail  = Site::with('parent.children')->find($site_id);

      return view('sites/sitedetail',compact('title','siteDetail'));

    }
    public function singlesiteDetail(Request $request ,$id)
    {
        
      $title = 'Site Detail';
      $site_id  = base64_decode($id);
      $siteDetail  = Site::with('parent.children.invoicelistservices.amount')->find($site_id);
     // echo "<pre>"; print_r($siteDetail->toArray()); die;
      return view('sites/singlesitedetail',compact('title','siteDetail'));

    }
    
    public function addServices(Request $request ,$id)
    {
       $title = 'Add Services';
       $subscription_id = base64_decode($id); //
       $get_all_subscribed_services = Subscriptions::where('site_id','=',$subscription_id)->pluck('stripe_plan');
       $service_data = DB::table('plans')->whereNotIn('plan_id',$get_all_subscribed_services)->where('plan_type','=',4)->get();
       return view('sites/addservices',compact('title','service_data','id'));
    }
    public function saveServices(Request $request)
    {
         $subscription_id = base64_decode($request->get('subscription_id')); //
         
         if ($subscription_id) {
             $user_id = Subscriptions::where('id','=',$subscription_id)->pluck('user_id');
             $userDetail = User::find($user_id[0])->pluck('stripe_id');
             //echo $user_id[0]; die;
             $stripKey = config('services.stripe.secret');
             \Stripe\Stripe::setApiKey($stripKey);
             foreach($request->get('services') as $service){
              $subscription = \Stripe\Subscription::create([
                    'customer' =>$userDetail[0],
                    'items' => [['plan' => $service]],
                ]);
                  $plan_detail = DB::table('plans')
                               ->where('plan_id', $service)
                               ->orderBy('id','DESC')
                               ->first();
                 $time = Carbon::now();
                 $stripJson  = str_replace('Stripe\Subscription JSON: ', '', $subscription);
                 $srtipArray = json_decode($stripJson,true);
                // / echo "<pre>" ;print_r($srtipArray['items']['data'][0]['plan']['amount']); die;
                 $service = Subscriptions::create([
                    'user_id'      => $user_id[0],
                    'name'         => $srtipArray['items']['data'][0]['plan']['nickname'],
                    'plan_name'    => $plan_detail->name,
                    'plan_amount'  => $srtipArray['items']['data'][0]['plan']['amount'],
                    'stripe_id'    => $srtipArray['id'],
                    'stripe_plan'  =>$service,
                    'quantity'     =>1,
                    'site_id'      =>$subscription_id,
                    'site_status'  =>0,
                    'created_at'   => $time,
                    'updated_at'   => $time
                  ]);
              
             }
             Session::flash('flash_message', 'Services  submit successfully');
             Session::flash('alert-class', 'alert-success');
             return redirect('sites');
         } else {
          
          return redirect()->back()->withErrors(['Something went wrong please try again!']);
         }
         

    }
    public function addSite(Request $request)
    {
        return view('sites/create');
    }
   
    public function saveSite(Request $request)
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
                $ch = curl_init ( $fetchUrl);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
                $raw=curl_exec($ch);
                curl_close ($ch);
            //$jpeg = file_get_contents($fetchUrl);
               // if (Auth::check() && !\Auth::user()->hasRole('admin')) {
                $subscriptipn_id = Subscriptions::where('user_id','=',$user->id)->first();
                $dir =  public_path('/upload/sites').'/';
                $name = time().uniqid(rand()).'.jpg'; 
                file_put_contents($dir. $name ,$raw);
                $siteSave = Site::create([
                'name'              => $request->get('name'),
                'url'               => $request->get('url'),
                'ftp_host'          => $request->get('ftp_host'),
                'ftp_username'      => $request->get('ftp_username'),
                'site_image'        => $name,
                'ftp_password'      => $request->get('ftp_password'),
                'ftp_password'      => $request->get('ftp_password'),
                'sftp_host'         => $request->get('sftp_host'),
                'sftp_username'     => $request->get('sftp_username'),
                'sftp_password'     => $request->get('sftp_password'),
                'cpanel_host'       => $request->get('cpanel_host'),
                'cpanel_username'   => $request->get('cpanel_username'),
                'created_at'        => $time,
                'updated_at'        => $time,
                'user_id'           => $user->id,
                'subscription_id'   =>$subscriptipn_id->stripe_id,
                'plan_id' =>1
            ]);
         if ($siteSave) {
             if (Session::has('totalSite')) {
              Subscriptions::where('stripe_id', $subscriptipn_id->stripe_id)->update(array('site_status' => 1));
              $totalSite = Site::where('user_id','=',$user->id)->count();
              Session::put('totalSite', $totalSite);
             } 
             Session::flash('flash_message', 'Site detail submit successfully');
             Session::flash('alert-class', 'alert-success');
           return redirect('/dashboard');
         } else {
           return redirect()->back();
         }

    }

   
   public function viewInvoicePdf(Request $request,$invoiceID)
   { 

     $invoiceId= base64_decode($invoiceID); 
     $invoiceDetail = Invoices::with('amount.plan')->find($invoiceId);
     $data['data'] =$invoiceDetail->toArray();  
     $pdf = PDF::loadView('sites.invoice-pdf', $data);
     PDF::setOptions(['defaultFont' => 'sans-serif']);
     return $pdf->stream('Invoice');  
   }
  
   public function servicePopup(Request $request,$siteID)
   {
      // $siteId = base64_decode($siteID);
       $subscription_id = base64_decode($siteID); //
       $get_all_subscribed_services = Subscriptions::where('site_id','=',$subscription_id)->pluck('stripe_plan');
       $service_data = DB::table('plans')->whereNotIn('plan_id',$get_all_subscribed_services)->where('plan_type','=',4)->get();
       $returnHTML = view('sites.service-popup')->with('allServices', $service_data)->render();
       echo $returnHTML; die;

   }
 

}
