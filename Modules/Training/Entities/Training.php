<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Training extends Model
{   
    use SoftDeletes,Sortable;
    protected $fillable = ['title','description','section_id','topic_id','is_active'];
    protected $sortable = ['title','description', 'is_active'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function topics()
    {
        return $this->belongsTo('Modules\Training\Entities\Topic','topic_id');
    }
    
    public function sections()
    {
        return $this->belongsTo('Modules\Training\Entities\Section','section_id');
    }
    
    
}
