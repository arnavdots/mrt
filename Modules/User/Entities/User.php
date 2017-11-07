<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class User extends Model
{
    use SoftDeletes, Sortable;
    
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'mobile', 'is_active','remote_access'];
    // protected $hidden = [];
    // protected $dates = [];
    public $sortable = ['first_name', 'email', 'mobile', 'is_active'];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function RandomAlphaNumericPassword($length = 10)
    {
        $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $clen   = strlen( $chars )-1;
        $id  = '';

        for ($i = 0; $i < $length; $i++) {
                $id .= $chars[mt_rand(0,$clen)];
        }
        return ($id);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function roles()
    {
        return $this->belongsToMany('App\MrtModels\Role');
    }
    public function permissions()
    {
        return $this->belongsToMany('Modules\Permission\Entities\Permission', 'permissions_user');
    }
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
     
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    
}

