<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::truncate();
        Role::truncate();

        Permission::create(['name' => 'manage-categories']);
        Permission::create(['name' => 'manage-products']);
        Permission::create(['name' => 'view-orders']);
        Permission::create(['name' => 'update-orders']);

        $adminRole = Role::create(['name' => 'Admin']);

        $adminRole->givePermissionTo([
            'manage-categories',
            'manage-products',
            'view-orders',
            'update-orders',
        ]);
    }
}
