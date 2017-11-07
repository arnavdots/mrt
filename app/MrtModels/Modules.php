<?php

namespace App\MrtModels;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Modules extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'icon','selected_icon','status','order'
    ];

    
    public function submodules(){
        return $this->hasMany('App\MrtModels\SubModules', 'module_id');
    }
    

}
