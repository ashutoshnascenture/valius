<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Ticket extends Authenticatable
{
    use Notifiable;

   
    protected $fillable = [
        'name', 'email', 'phone','message','user_id','subject',
    ];

    
	
	public static $rules = array(          
        'name' => 'required',
        'email' => 'required|email',
		//'phone' => 'required',
        'message'=> 'required', 
    );
    public function messages(){
			
			return $this->hasone('App\Message','ticket_id','user_id');
	    }
	
}
