<?php

namespace App;


/*use Illuminate\Support\Facades\Cache;
use Stripe\Stripe;*/
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
   
    protected $table = 'plans';
    protected $fillable = [
        'plan_id','plan_type','name','description','price','status','interval','created_at','updated_at','nickname','amount','is_delete'
     ];


  /*  public static function getStripePlans()
    {
        // Set the API Key
        Stripe::setApiKey(User::getStripeKey());

        try {
            // Fetch all the Plans and cache it
            //return Cache::remember('stripe.plans', 60*24, function() {
                return \Stripe\Plan::all()->data;
            //});
        } catch ( \Exception $e ) {
            return false;
        }
    }*/
}