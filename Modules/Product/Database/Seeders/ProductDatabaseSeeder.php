<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductPriceTier;
use Modules\Product\Database\Seeders\ProductPriceTierDatabaseSeeder;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $module = [
            [
                'price_tier' => 'Tier 1',
            ],
            [
                'price_tier' => 'Tier 2',
            ],
            [
                'price_tier' => 'Tier 3',
            ],
            [
                'price_tier' => 'Tier 4',
            ],
            [
                'price_tier' => 'Retail',
            ]
        ];

        foreach($module as $value)
            ProductPriceTier::create($value);
        
         //$this->call("ProductPriceTierDatabaseSeeder");
    }
}
