<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Gallery extends Model
{
    use SoftDeletes, Sortable;
    protected $fillable = ['product_code', 'image', 'is_active'];
    public $sortable = ['product_code', 'image', 'is_active','created_at'];
    
    public function product()
    {
        return $this->belongsTo('Modules\Product\Entities\Product','product_code');
    }
    /**
     * 
     * @param type $query
     * @return type
     */
    public function scopeStatus($query,$active)
    {
        $status = (!empty($active)) ? true : false;
        return $query->where('is_active', $status);        
    }
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are guarded by mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id','_token'
    ];
}
