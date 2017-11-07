<?php

use Illuminate\Database\Seeder;
use Modules\Permission\Entities\Permission;

class PermissionTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $permission = [
            [
                'name' => 'role-list',
                'display_name' => 'Display Role Listing',
                'controller_name' => 'role',
                'description' => 'See only Listing Of Role',
                'module_id' => '14',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Create Role',
                'controller_name' => 'role',
                'description' => 'Create New Role',
                'module_id' => '14',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'role-edit',
                'display_name' => 'Edit Role',
                'controller_name' => 'role',
                'description' => 'Edit Role',
                'module_id' => '14',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Delete Role',
                'controller_name' => 'role',
                'description' => 'Delete Role',
                'module_id' => '14',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'user-list',
                'display_name' => 'Display User Listing',
                'controller_name' => 'user',
                'description' => 'See only Listing Of User',
                'module_id' => '15',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'user-create',
                'display_name' => 'Create User',
                'controller_name' => 'user',
                'description' => 'Create New User',
                'module_id' => '15',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'user-edit',
                'display_name' => 'Edit User',
                'controller_name' => 'user',
                'description' => 'Edit User',
                'module_id' => '15',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'user-delete',
                'display_name' => 'Delete User',
                'controller_name' => 'user',
                'description' => 'Delete User',
                'module_id' => '15',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'home',
                'display_name' => 'Home',
                'controller_name' => 'home',
                'description' => '',
                'module_id' => '1',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'dashboard',
                'display_name' => 'Dashboard',
                'controller_name' => 'dashboard',
                'description' => '',
                'module_id' => '2',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'stockview',
                'display_name' => 'Stock view',
                'controller_name' => 'stockview',
                'description' => '',
                'module_id' => '3',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'stockcontrol',
                'display_name' => 'Stock Control',
                'controller_name' => 'Stockcontrol',
                'description' => '',
                'module_id' => '4',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'pickup',
                'display_name' => 'Pick up',
                'controller_name' => 'pickup',
                'description' => '',
                'module_id' => '5',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'gallery',
                'display_name' => 'Gallery',
                'controller_name' => 'gallery',
                'description' => '',
                'module_id' => '6',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'warranty',
                'display_name' => 'Warranty',
                'controller_name' => 'warranty',
                'description' => '',
                'module_id' => '7',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'training',
                'display_name' => 'Training',
                'controller_name' => 'training',
                'description' => '',
                'module_id' => '8',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'product',
                'display_name' => 'Product',
                'controller_name' => 'product',
                'description' => '',
                'module_id' => '9',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'quote',
                'display_name' => 'Quote',
                'controller_name' => 'orderquote',
                'description' => '',
                'module_id' => '10',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'marketing',
                'display_name' => 'Marketing',
                'controller_name' => 'marketing',
                'description' => '',
                'module_id' => '11',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'financial',
                'display_name' => 'Financial',
                'controller_name' => 'financial',
                'description' => '',
                'module_id' => '12',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'equipment',
                'display_name' => 'Equipment',
                'controller_name' => 'equipment',
                'description' => '',
                'module_id' => '13',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'enquiries',
                'display_name' => 'Enquiries',
                'controller_name' => 'enquiry',
                'description' => '',
                'module_id' => '2',
                'sub_module_id' => '1'
            ],
            [
                'name' => 'tasks',
                'display_name' => 'Tasks',
                'controller_name' => 'task',
                'description' => '',
                'module_id' => '2',
                'sub_module_id' => '2'
            ],
            [
                'name' => 'quotes',
                'display_name' => 'Quotes',
                'controller_name' => 'quotes',
                'description' => '',
                'module_id' => '2',
                'sub_module_id' => '3'
            ],
            [
                'name' => 'orders',
                'display_name' => 'Orders',
                'controller_name' => 'orders',
                'description' => '',
                'module_id' => '2',
                'sub_module_id' => '4'
            ],
            [
                'name' => 'permission',
                'display_name' => 'Permissions',
                'controller_name' => 'permission',
                'description' => '',
                'module_id' => '16',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'branch',
                'display_name' => 'Branches',
                'controller_name' => 'branch',
                'description' => '',
                'module_id' => '17',
                'sub_module_id' => NULL
            ],
            [
                'name' => 'training',
                'display_name' => 'Training',
                'controller_name' => 'training',
                'description' => '',
                'module_id' => '8',
                'sub_module_id' => '5'
            ],
            [
                'name' => 'section',
                'display_name' => 'Section',
                'controller_name' => 'section',
                'description' => '',
                'module_id' => '8',
                'sub_module_id' => '6'
            ],
            [
                'name' => 'topic',
                'display_name' => 'Topic',
                'controller_name' => 'topic',
                'description' => '',
                'module_id' => '8',
                'sub_module_id' => '7'
            ],
            [
                'name' => 'category',
                'display_name' => 'Category',
                'controller_name' => 'category',
                'description' => '',
                'module_id' => '18',
                'sub_module_id' => NULL
            ],
             [
                'name' => 'new product',
                'display_name' => 'New Product',
                'controller_name' => 'stock_control_new_product',
                'description' => '',
                'module_id' => '4',
                'sub_module_id' => '8'
            ],
            [
                'name' => 'existing product',
                'display_name' => 'Existing Product',
                'controller_name' => 'stock_control_existing_product',
                'description' => '',
                'module_id' => '4',
                'sub_module_id' => '9'
            ],
            [
                'name' => 'new order',
                'display_name' => 'New Order',
                'controller_name' => 'stock_control_new_order',
                'description' => '',
                'module_id' => '4',
                'sub_module_id' => '10'
            ],
            [
                'name' => 'receive order',
                'display_name' => 'Receive Order',
                'controller_name' => 'stock_control_receive_order',
                'description' => '',
                'module_id' => '4',
                'sub_module_id' => '11'
            ],
             [
                'name' => 'load container',
                'display_name' => 'Load Container',
                'controller_name' => 'stock_control_load_container',
                'description' => '',
                'module_id' => '4',
                'sub_module_id' => '12'
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }

}
