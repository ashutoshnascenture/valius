<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
     protected $table = 'subscriptions';
      protected $fillable = [
                    'user_id',    
                    'name',       
                    'plan_name',  
                    'plan_amount' ,
                    'stripe_id',
                    'stripe_plan',
                    'quantity',
                    'site_id',
                    'site_status',
                    'created_at',
                    'updated_at'   
                    ];
   /* public function parent()
    {
        return $this->belongsTo('App\Subscription', 'id');
    }*/

    public function children()
    {
        return $this->hasMany('App\Subscription', 'site_id');
    }
    
    public function invoicelistservices()
    {

      return $this->hasMany('App\Invoices','subscription_id','stripe_id');
    } 
    public function invoicelist()
    {

      return $this->hasMany('App\Invoices','subscription_id','stripe_id');
    } 
     public function plan()
   {
    return $this->belongsTo('App\Plan','stripe_plan','plan_id');  
    
   } 
   
}
