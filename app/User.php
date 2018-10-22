<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Stripe\Subscription;

class User extends Authenticatable
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name','name', 'email', 'password','first_name','last_name','phone','status','remember_token','role_id','company_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	 public static $rules = array(
        'last_name'               => 'required',
        'first_name'              => 'required',
        'email'                   => 'required|email|unique:users',
        'password'                => 'required', 
        'confirm_pass'            => 'required|same:password',
       
    );
    public static $message = array(
        'first_name.required'                    => 'First Name is required',
        'last_name.required'                     => ' Last Name is required',
        'email.required'                         => 'Email is required',
        'password.required'                      => 'Password is required',
        'confirm_pass.required'              => 'Confirm Password is required', 
        'confirm_pass.same'                  => 'Confirm Password should match password', 
        
    );
	 
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function recordUpdate()
    {
        return array(
             'last_name'               => 'required',
             'first_name'              => 'required',
             'email'                   => 'required|email|unique:users',
             'password'                => 'required', 
             'confirm_pass'            => 'required|same:password',
        );
    }
     public function roles()
   {
     return $this->belongsToMany(Role::class);
   }
   public function hasAnyRole($roles)
   {
    if(is_array($roles)){

        foreach ($roles as $role) {

            if ($this->hasRole($role)) {
                return true;
            }
        }
    }
    else{

        if ($this->hasRole($roles)) {

            return true;
        }
    }
    return false;
}
   public function hasRole($role)
   {
     if ($this->roles()->where('name', $role)->first()) {
            return true;
        }

        return false;
  }
}
