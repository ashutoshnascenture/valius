<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //


	 protected $table = 'sites';
     protected $fillable = [
        'user_id','plan_id','ftp_host','ftp_password','ftp_username','sftp_host',
        'sftp_password','sftp_username','url','cpanel_username','cpanel_password','name','url','cpanel_host'
     ];

     public static $rules = array(
        'name'                   => 'required',
        'url'                    => 'required'
    );
    public static $message = array(
        'name.required'                    => 'Site  nameis required',
        'url.required'                     => 'URL is required'        
    );
}
