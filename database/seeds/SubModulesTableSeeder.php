<?php

use Illuminate\Database\Seeder;
use App\MrtModels\SubModules;

class SubModulesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $submodule = [
            [
                'module_id' => '2',
                'name' => 'Enquiries',
                'slug' => 'enquiries',
                'controller' => 'enquiry',
                'order' => '1'
            ],
            [
                'module_id' => '2',
                'name' => 'Tasks',
                'slug' => 'tasks',
                'controller' => 'task',
                'order' => '2'
            ],
            [
                'module_id' => '2',
                'name' => 'Quotes',
                'slug' => 'quotes',
                'controller' => 'quotes',
                'order' => '3'
            ],
            [
                'module_id' => '2',
                'name' => 'Orders',
                'slug' => 'orders',
                'controller' => 'orders',
                'order' => '4'
            ],
            [
                'module_id' => '8',
                'name' => 'Training',
                'slug' => 'training',
                'controller' => 'training',
                'order' => '1'
            ],
            [
                'module_id' => '8',
                'name' => 'Section',
                'slug' => 'section',
                'controller' => 'section',
                'order' => '2'
            ],
            [
                'module_id' => '8',
                'name' => 'Topic',
                'slug' => 'topic',
                'controller' => 'topic',
                'order' => '3'
            ],
            [
                'module_id' => '4',
                'name' => 'New Product',
                'slug' => 'new_product',
                'controller' => 'stock_control_new_product',
                'order' => '1'
            ],
            [
                'module_id' => '4',
                'name' => 'Existing Product',
                'slug' => 'existing_product',
                'controller' => 'stock_control_existing_product',
                'order' => '2'
            ],
            [
                'module_id' => '4',
                'name' => 'New Order',
                'slug' => 'new_order',
                'controller' => 'stock_control_new_order',
                'order' => '3'
            ],
            [
                'module_id' => '4',
                'name' => 'Receive Order',
                'slug' => 'receive_order',
                'controller' => 'stock_control_receive_order',
                'order' => '4'
            ],
            [
                'module_id' => '4',
                'name' => 'Load Container',
                'slug' => 'load_container',
                'controller' => 'stock_control_load_container',
                'order' => '3'
            ],
        ];

        foreach ($submodule as $key => $value) {
            SubModules::create($value);
        }
    }

}
