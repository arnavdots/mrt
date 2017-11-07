<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Section extends Model
{   
    use SoftDeletes, Sortable;
    protected $fillable = ['name','is_active'];
    public $sortable = ['name', 'is_active'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    
}
