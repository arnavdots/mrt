<?php

namespace App\MrtModels;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SubModules extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "sub_modules";


    protected $fillable = [
        'Module_id','name', 'slug','status','order'
    ];

  
}
