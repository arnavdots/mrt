<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    protected $table = 'permissions_user';
 
    public $timestamps = false;
    protected $fillable = ['permission_id','user_id'];
    
    
   
}
