<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model {

    use Sortable;

    /*
      |--------------------------------------------------------------------------
      | GLOBAL VARIABLES
      |--------------------------------------------------------------------------
     */

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'features', 'specifications', 'weight', 'category_id', 'is_active'];
    // protected $hidden = [];
    // protected $dates = [];
    public $sortable = ['name', 'is_active'];

    /*
      |--------------------------------------------------------------------------
      | FUNCTIONS
      |--------------------------------------------------------------------------
     */

    public static function createSlug($str, $delimiter = '-') {

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));

        return $slug;
    }

    /*
      |--------------------------------------------------------------------------
      | RELATIONS
      |--------------------------------------------------------------------------
     */

    public function productdimensions() {
        return $this->hasMany('Modules\Product\Entities\ProductDimensions');
    }

    public function productprice() {
        return $this->belongsToMany('Modules\Product\Entities\ProductPriceTier', 'product_prices');
    }
    
    
    // bom product ids behalf on product code
    public function productbom() {
        return $this->hasMany('Modules\Product\Entities\ProductBom');
    }

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
     
    public static function getAllProductIds($product_code) {
       $id = Product::whereIn('product_code',$product_code)->get()->toArray(); 
       return $id ;
    }
}
