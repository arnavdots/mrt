<?php

namespace Modules\Enquiry\Entities;

use Illuminate\Database\Eloquent\Model;

class EnquiryStatus extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'enquiry_status';
    
    protected $fillable = ['title'];
}
