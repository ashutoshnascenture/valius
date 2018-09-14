<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Message extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
		protected $table = 'messages';
		
     protected $fillable = [
        'message','users_id','ticket_id','parent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function messageUser()
	{
			
			return $this->belongsTo('App\User','users_id');
	}
	

}
