<?php

namespace App\MrtModels;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'branches';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'branch_code', 'owner_id','address_line_1','address_line_2','suburb_id','state_id','country_id','postcode','is_active','is_deleted'
    ];
}
