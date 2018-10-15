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
        'last_name','name', 'email', 'password','first_name','last_name','phone','status','remember_token','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	 public static $rules = array(
        'name'                    => 'required',
        'email'                   => 'required|email|unique:users',
        'password'                => 'required', 
        'confirm_password'            => 'required|same:password',
        'phone'                   => 'required',
    );
    public static $message = array(
        'first_name.required'                    => 'Name is required',
        'email.required'                         => 'Email is required',
        'password.required'                      => 'Password is required',
        'confirm_password.required'              => 'Confirm Password is required', 
        'confirm_password.same'                  => 'Confirm Password should match password', 
        'phone.required'                         =>'Phone no is required',
    );
	 
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function recordUpdate()
    {
        return array(
            'first_name'                   => 'required',
            'email'                        => 'required|email|unique:users'
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
