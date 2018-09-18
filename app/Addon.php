<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    //
    protected $fillable = [
        'name','price','description'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	 public static $rules = array(
        'name'                           => 'required',
        'description'                    => 'required',
        'price'                          => 'required'
    );
    public static $message = array(
        'name.required'                    => 'Addon Name is required',
        'description.required'             => 'description is required',
         'price'                           => 'required'      
    );
}
