<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    //
 protected $table = 'invoices';
  protected $fillable = [
        'invoice_id','subscription_id','cus_id','status','created_at','updated_at'
     ];
    public function amount()
   {
    return $this->belongsTo('App\Subscription','subscription_id','stripe_id');  
    // only  get subscription if site added use site_status.
   } 
   
   



}
