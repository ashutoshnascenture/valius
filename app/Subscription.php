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
    public function parent()
    {
        return $this->belongsTo('App\Subscription', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Subscription', 'site_id');
    }
    

}
