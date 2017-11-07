<?php

namespace App\MrtModels;

use Illuminate\Database\Eloquent\Model;

class Suburb extends Model {

    public $timestamps = false;
    protected $table = 'suburb';
    public $sortable = ['name'];

}
