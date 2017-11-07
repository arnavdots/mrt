<?php

namespace Modules\Branch\Entities;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\MrtModels\States;
use App\MrtModels\Suburb;
class Branch extends Model
{
    use Sortable;
	
    protected $table = 'branches';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name','branch_code','address_line_1','address_line_2','suburb_id','state_id','country_id','postcode','is_active','is_deleted'];
   
    public $sortable = ['branches.name', 'branch_code', 'address_line_1', 'postcode'];
    /*
      |--------------------------------------------------------------------------
      | RELATIONS
      |--------------------------------------------------------------------------
     */
    public function users()
    {
         //return $this->belongsToMany('crea');
    }
    
    public function countries()
    {
         return $this->belongsTo('Countries','country_id');
    }
    
    public function states()
    {
         return $this->belongsTo('App\MrtModels\States','state_id');
    }
    
    public function suburb()
    {
         return $this->belongsTo('App\MrtModels\Suburb','suburb_id');
    }
}
