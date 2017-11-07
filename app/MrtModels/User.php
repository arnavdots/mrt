<?php

namespace App\MrtModels;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomPasswordReset;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable {

    use Notifiable, Sortable;

    protected $guard = 'admin';
    // SORTABLE COLUMNS
    public $sortable = ['first_name',
                        'email',
                        'created_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'role_user');
    // }
//    
////    public function permissions(){
////        return $this->belongsToMany(Permission::class, 'user_roles');
////    }
//
//    
//
//    /**
//     * Checks if the user belongs to admin.
//     */
//    public function isAdmin(string $roleSlug)
//    {
//        return $this->roles()->where('slug', $roleSlug)->count() == 1;
//    }
    //Send password reset notification
    public function sendPasswordResetNotification($token) {
        $this->notify(new CustomPasswordReset($token));
    }

    public function roles() {
        return $this->belongsToMany('App\MrtModels\Role');
    }

}
