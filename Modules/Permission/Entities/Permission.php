<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //protected $table = 'permissions';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name','display_name','description'];
    
    /*
      |--------------------------------------------------------------------------
      | RELATIONS
      |--------------------------------------------------------------------------
    */
    public function permissionUser(){
       return $this->hasMany('App\MrtModels\User', 'permission_user');
    }
   
   /**
     * The User that belong to the Permission.
     */ 
    public function userPermissions()
    {
        return $this->belongsToMany('App\MrtModels\User', 'permissions_user');
    }
    public function permissionUsers(){
       return $this->hasMany('App\MrtModels\User', 'permission_user');
    }
   
}
