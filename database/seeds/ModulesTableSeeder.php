<?php

use Illuminate\Database\Seeder;
use App\MrtModels\Modules;

class ModulesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $module = [
            [
                'name' => 'Home',
                'slug' => 'home',
                'controller' => 'home',
                'icon' => 'home-icon.png',
                'selected_icon' => '',
                'order' => '1'
            ],
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'controller' => 'dashboard',
                'icon' => 'dashboard-icon.png',
                'selected_icon' => '',
                'order' => '2'
            ],
            [
                'name' => 'Stock View',
                'slug' => 'stock_view',
                'controller' => 'stockview',
                'icon' => 'stock-view-icon.png',
                'selected_icon' => '',
                'order' => '3'
            ],
            [
                'name' => 'Stock Control',
                'slug' => 'stock_control',
                'controller' => 'stockcontrol',
                'icon' => 'stock-control-icon.png',
                'selected_icon' => '',
                'order' => '4'
            ],
            [
                'name' => 'Pick up/Fitting',
                'slug' => 'pickup',
                'controller' => 'pickup',
                'icon' => 'pick-up-fitting-icon.png',
                'selected_icon' => '',
                'order' => '5'
            ],
            [
                'name' => 'Gallery',
                'slug' => 'gallery',
                'controller' => 'gallery',
                'icon' => 'gallery-icon.png',
                'selected_icon' => '',
                'order' => '6'
            ],
            [
                'name' => 'Warranty',
                'slug' => 'warranty',
                'controller' => 'warranty',
                'icon' => 'warranty-icon.png',
                'selected_icon' => '',
                'order' => '7'
            ],
            [
                'name' => 'Training',
                'slug' => 'training',
                'controller' => 'training',
                'icon' => 'training-icon.png',
                'selected_icon' => '',
                'order' => '8'
            ],
            [
                'name' => 'Product',
                'slug' => 'product',
                'controller' => 'product',
                'icon' => 'product-icon.png',
                'selected_icon' => '',
                'order' => '9'
            ],
            [
                'name' => 'Order/Quote',
                'slug' => 'order_quote',
                'controller' => 'orderquote',
                'icon' => 'product-icon.png',
                'selected_icon' => '',
                'order' => '10'
            ],
            [
                'name' => 'Marketing',
                'slug' => 'marketing',
                'controller' => 'marketing',
                'icon' => 'marketing-icon.png',
                'selected_icon' => '',
                'order' => '11'
            ],
            [
                'name' => 'Financial',
                'slug' => 'financial',
                'controller' => 'financial',
                'icon' => 'financial-icon.png',
                'selected_icon' => '',
                'order' => '12'
            ],
            [
                'name' => 'Equipment',
                'slug' => 'equipment',
                'controller' => 'equipment',
                'icon' => 'equipment-icon.png',
                'selected_icon' => '',
                'order' => '13'
            ],
            [
                'name' => 'role',
                'slug' => 'role',
                'controller' => 'role',
                'icon' => 'equipment-icon.png',
                'selected_icon' => '',
                'order' => '14',
                'status' => '0'
            ],
            [
                'name' => 'users',
                'slug' => 'users',
                'controller' => 'users',
                'icon' => 'equipment-icon.png',
                'selected_icon' => '',
                'order' => '15',
                'status' => '0'
            ],
            [
                'name' => 'permission',
                'slug' => 'permission',
                'controller' => 'permission',
                'icon' => 'equipment-icon.png',
                'selected_icon' => '',
                'order' => '16',
                'status' => '0'
            ],
            [
                'name' => 'branch',
                'slug' => 'branch',
                'controller' => 'branch',
                'icon' => 'equipment-icon.png',
                'selected_icon' => '',
                'order' => '17',
                'status' => '0'
            ],
            [
                'name' => 'category',
                'slug' => 'category',
                'controller' => 'category',
                'icon' => 'equipment-icon.png',
                'selected_icon' => '',
                'order' => '18',
                'status' => '0'
            ],
        ];

        foreach ($module as $key => $value) {
            Modules::create($value);
        }
    }

}
