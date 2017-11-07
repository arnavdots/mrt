<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Topic extends Model
{   
    use SoftDeletes, Sortable;
    protected $fillable = ['name','section_id','is_active'];
    protected $sortable = ['name','is_active'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    public function sections()
    {
        return $this->belongsTo('Modules\Training\Entities\Section','section_id');
    }
}
