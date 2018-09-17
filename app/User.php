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
        'first_name'                   => 'required',
        'last_name'                    => 'required',
        'email'                        => 'required|email|unique:users',
        'password'                     => 'required', 
        'confirm_pass'                   => 'required|same:password',    
    );
    public static $message = array(
        'first_name.required'                    => 'First  Name is required',
        'last_name.required'                     => 'Last  Name is required',
        'email.required'                         => 'Email is required',
        'password.required'                      => 'Password is required',
        'confirm_pass.required'                    => 'Confirm Password is required',         
    );
	 
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function recordUpdate()
    {
        return array(
            'first_name'                   => 'required',
            'last_name'                    => 'required',
            'email'                        => 'required|email|unique:users'
        );
    }
}
