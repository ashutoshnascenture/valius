<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;
class Role extends Model
{
    //

    public function users()
    {
     return $this->belongsToMany(User::class);
     }
}
