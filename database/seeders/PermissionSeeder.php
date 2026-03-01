<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Module;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $module = Module::updateOrCreate(['name' => 'Manage Services']);

        $permissions = [
            ['name' => 'View Service Category', 'key' => 'view_service_category'],
            ['name' => 'Create Service Category', 'key' => 'create_service_category'],
            ['name' => 'Edit Service Category', 'key' => 'edit_service_category'],
            ['name' => 'Delete Service Category', 'key' => 'delete_service_category'],
            
            ['name' => 'View Service Sub Category', 'key' => 'view_service_sub_category'],
            ['name' => 'Create Service Sub Category', 'key' => 'create_service_sub_category'],
            ['name' => 'Edit Service Sub Category', 'key' => 'edit_service_sub_category'],
            ['name' => 'Delete Service Sub Category', 'key' => 'delete_service_sub_category'],
            
            ['name' => 'View Service', 'key' => 'view_service'],
            ['name' => 'Create Service', 'key' => 'create_service'],
            ['name' => 'Edit Service', 'key' => 'edit_service'],
            ['name' => 'Delete Service', 'key' => 'delete_service'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['key' => $permission['key']],
                [
                    'name' => $permission['name'],
                    'module_id' => $module->id
                ]
            );
        }
    }
}
