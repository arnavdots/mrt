<?php

use Illuminate\Database\Seeder;
use App\MrtModels\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator'
        ]);
        Role::create([
            'name' => 'ceo',
            'display_name' => 'CEO'
        ]);
        Role::create([
            'name' => 'upper_management',
            'display_name' => 'Upper Management'
        ]);
        Role::create([
            'name' => 'controller',
            'display_name' => 'Controller'
        ]);
        Role::create([
            'name' => 'manager',
            'display_name' => 'Manager'
        ]);
        Role::create([
            'name' => 'marketing',
            'display_name' => 'Marketing'
        ]);
        Role::create([
            'name' => 'sales_consultant',
            'display_name' => 'Sales Consultant'
        ]);
        Role::create([
            'name' => 'warehouse',
            'display_name' => 'Warehouse'
        ]);
    }
}
